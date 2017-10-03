<?php

namespace DeveoDK\Core\Components\Views;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\View\ViewServiceProvider as BaseViewServiceProvider;
use DeveoDK\Core\Components\Services\ComponentServiceProvider;

class ViewServiceProvider extends BaseViewServiceProvider
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
     * Register views in the application container
     * @return void
     */
    public function register()
    {
        $paths = $this->componentService->getBundleNamespaces('Views');

        $paths = array_merge($paths, [''.base_path() . DIRECTORY_SEPARATOR .'resources/views']);

        $this->app['config']['view.paths'] = $paths;

        parent::register();
    }

    /**
     * Register views in IOC
     */
    public function registerViewFinder()
    {
        $this->app->bind('view.finder', function ($app) {
            return new ViewFileLoader($app['files'], $app['config']['view.paths']);
        });
    }
}
