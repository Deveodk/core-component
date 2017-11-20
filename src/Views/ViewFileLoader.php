<?php

namespace DeveoDK\Core\Component\Views;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\FileViewFinder;
use InvalidArgumentException;
use DeveoDK\Core\Component\Services\ComponentServiceProvider;

class ViewFileLoader extends FileViewFinder
{
    /** @var ComponentServiceProvider */
    protected $componentService;

    public function __construct(Filesystem $files, array $paths, array $extensions = null)
    {
        $this->componentService = app(ComponentServiceProvider::class);
        parent::__construct($files, $paths, $extensions);
    }

    /**
     * @param string $name
     * @param array $paths
     * @return string
     */
    protected function findInPaths($name, $paths)
    {
        if (!is_array($paths)) {
            throw new InvalidArgumentException("Paths must be array");
        }

        foreach ($paths as $path) {
            // if not core component bundle
            if (!$this->isBundle($name)) {
                foreach ($this->getPossibleNonBundleViewFiles($name, $path) as $file) {
                    if ($this->files->exists($viewPath = $path.'/'.$file)) {
                        return $viewPath;
                    }
                }
            }

            // if core component bundle
            if ($this->isBundle($name)) {
                if ($this->getBundleNameFromPath($path) !== $this->getBundleName($name)) {
                    continue;
                }

                foreach ($this->getPossibleBundleViewFiles($name, $path) as $file) {
                    if ($this->files->exists($viewPath = $path.$file)) {
                        return $viewPath;
                    }
                }
            }
        }

        throw new InvalidArgumentException("View [$name] not found.");
    }

    /**
     * @param string $name
     * @param string $path
     * @return array
     */
    protected function getPossibleBundleViewFiles($name, $path)
    {
        return array_map(function ($extension) use ($name, $path) {
            return str_replace($this->getBundleName($name) . ':', '/', $name).'.'.$extension;
        }, $this->extensions);
    }

    /**
     * @param string $name
     * @param $path
     * @return array
     */
    protected function getPossibleNonBundleViewFiles($name, $path)
    {
        return array_map(function ($extension) use ($name, $path) {
            return str_replace('.', '/', $name).'.'.$extension;
        }, $this->extensions);
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
