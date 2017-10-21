<?php

namespace DeveoDK\Core\Component\Translations;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;

class ComponentFileLoader extends FileLoader
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
        $bundle = $this->getBundle($group);

        foreach ($this->paths as $path) {
            if ($bundle) {
                $group = str_replace(strtolower($bundle).DIRECTORY_SEPARATOR, '', $group);

                if ($this->files->exists($full = "{$path}/{$locale}/{$group}.php")) {
                    return $this->files->getRequire($full);
                }
            }

            // Include non bundled translation files
            if ($this->files->exists($full = "{$path}/{$locale}/{$group}.php")) {
                return $this->files->getRequire($full);
            }
        }

        return [];
    }

    /**
     * @param $key
     * @return bool|string
     */
    protected function getBundle($key)
    {
        if (!str_contains($key, '/')) {
            return false;
        }

        $pathsArray = explode('/', rtrim($key, '/'));

        // Return the bundle name from path array
        return ucfirst(implode(array_slice($pathsArray, -2, 1)));
    }
}
