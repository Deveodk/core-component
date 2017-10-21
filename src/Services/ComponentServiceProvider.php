<?php

namespace DeveoDK\Core\Component\Services;

use Illuminate\Contracts\Foundation\Application;

class ComponentServiceProvider
{
    /** @var Application */
    protected $app;

    /**
     * ComponentService constructor.
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->app = $application;
    }

    /**
     * Get configuration
     * @return array
     */
    public function getConfig()
    {
        return config('core.component');
    }

    /**
     * @param string $directory
     * @return array
     */
    public function getBundleNamespaces(string $directory)
    {
        $config = $this->getConfig();
        $paths = [];

        foreach ($config['namespaces'] as $namespace) {
            $pathTest = sprintf(
                '%s%s*%s%s*',
                $namespace,
                DIRECTORY_SEPARATOR,
                DIRECTORY_SEPARATOR,
                $directory
            );

            $components = glob($pathTest, GLOB_ONLYDIR);

            foreach ($components as $component) {
                if (!is_dir($component)) {
                    continue;
                }

                array_push($paths, $component);
            }
        }

        return $paths;
    }
}
