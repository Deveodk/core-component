<?php

namespace DeveoDK\Core\Component\Translations;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;

class TranslationFileLoader extends FileLoader
{
    /** @var array */
    protected $paths;

    /**
     * DistributedFileLoader constructor.
     * @param Filesystem $files
     * @param array $paths
     */
    public function __construct(Filesystem $files, $paths = [])
    {
        $this->paths = $paths;
        parent::__construct($files, '');
    }

    /**
     * Load a locale from a given path.
     *
     * @param  string  $path
     * @param  string  $locale
     * @param  string  $group
     * @return array
     */
    protected function loadPath($path, $locale, $group)
    {
        foreach ($this->paths as $path) {
            if (!$this->isBundle($group)) {
                if ($this->files->exists($full = "{$path}/{$locale}/{$group}.php")) {
                    return $this->files->getRequire($full);
                }

                continue;
            }

            if ($this->isBundle($group)) {
                $bundle = $this->getBundleName($group);
                $group = str_replace(strtolower($bundle). ':', '', $group);

                if ($this->files->exists($full = "{$path}/{$locale}/{$group}.php")) {
                    return $this->files->getRequire($full);
                }
            }
        }

        return [];
    }

    /**
     * @param $name
     * @return bool|string
     */
    protected function getBundleName($name)
    {
        $pathsArray = explode(':', rtrim($name));

        // Return the bundle name from path array
        return strtolower(implode(array_slice($pathsArray, -2, 1)));
    }

    /**
     * @param $path
     * @return bool|string
     */
    protected function getBundleNameFromPath($path)
    {
        $pathsArray = explode('/', rtrim($path));

        // Return the bundle name from path array
        return strtolower(implode(array_slice($pathsArray, -2, 1)));
    }

    /**
     * @param $name
     * @return bool
     */
    protected function isBundle($name)
    {
        return str_contains($name, ':');
    }
}
