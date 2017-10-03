<?php

namespace DeveoDK\Core\Components\Views;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\FileViewFinder;
use InvalidArgumentException;
use DeveoDK\Core\Components\Services\ComponentServiceProvider;

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
        foreach ($paths as $path) {
            foreach ($this->getPossibleBundleViewFiles($name, $path) as $file) {
                if ($this->files->exists($viewPath = $path.'/'.$file)) {
                    return $viewPath;
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
            if ($this->isBundle($path)) {
                $name = str_replace($this->getBundleName($name).'.', '', $name);
            }

            return str_replace('.', '/', $name).'.'.$extension;
        }, $this->extensions);
    }

    /**
     * @param $key
     * @return bool|string
     */
    protected function getBundleName($key)
    {
        $pathsArray = explode('.', rtrim($key, '/'));

        // Return the bundle name from path array
        return strtolower(implode(array_slice($pathsArray, -2, 1)));
    }

    /**
     * @param $path
     * @return bool
     */
    protected function isBundle($path)
    {
        $config = $this->componentService->getConfig();

        $namespaces = $config['namespaces'];

        foreach ($namespaces as $namespace) {
            if (preg_match('@('.$namespace.')@', $path)) {
                return true;
            }
        }

        return false;
    }
}
