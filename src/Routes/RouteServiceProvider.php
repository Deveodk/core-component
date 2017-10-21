<?php

namespace DeveoDK\Core\Component\Routes;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseRouteServiceProvider;
use DeveoDK\Core\Component\Services\ComponentServiceProvider;

class RouteServiceProvider extends BaseRouteServiceProvider
{
    /** @var ComponentServiceProvider */
    protected $componentService;

    /**
     * TranslationProvider constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->componentService = app(ComponentServiceProvider::class);
        parent::__construct($app);
    }

    /**
     * @return Router
     */
    protected function router()
    {
        /** @var Router $router */
        $router = app(Router::class);
        return $router;
    }

    /**
     * Define the routes for the application.
     *
     * @param  Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $config = $this->componentService->getConfig();

        $protectedMiddleware = $config['protection_middleware'];

        $middleware = $config['middleware'];

        $highLevelParts = array_map(function ($namespace) {
            return glob(sprintf('%s%s*', $namespace, DIRECTORY_SEPARATOR), GLOB_ONLYDIR);
        }, $config['namespaces']);

        foreach ($highLevelParts as $part => $partComponents) {
            foreach ($partComponents as $componentRoot) {
                $component = substr($componentRoot, strrpos($componentRoot, DIRECTORY_SEPARATOR) + 1);

                $namespace = sprintf(
                    '%s\\%s\\Controllers',
                    $part,
                    $component
                );

                $fileNames = [
                    'routes' => true,
                    'routes_public' => false,
                ];

                foreach ($fileNames as $fileName => $protected) {
                    $path = sprintf('%s/%s.php', $componentRoot, $fileName);

                    if (!file_exists($path)) {
                        continue;
                    }

                    $router->group([
                        'middleware' => $protected ? $protectedMiddleware : $middleware,
                        'namespace'  => $namespace,
                    ], $path);
                }
            }
        }
    }
}
