<?php

namespace DeveoDK\Core\Component;

use Illuminate\Support\ServiceProvider;
use DeveoDK\Core\Component\Routes\RouteServiceProvider;
use DeveoDK\Core\Component\Translations\TranslationServiceProvider;
use DeveoDK\Core\Component\Views\ViewServiceProvider;

class ComponentServiceProvider extends ServiceProvider
{
    /**
     * Register service providers
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/component.php', 'core.component');
        $this->registerRouteProvider();
        $this->registerTranslationProvider();
        $this->registerViewProvider();
    }

    /*
     * Application boot method
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/component.php' => config_path('core/component.php'),
        ]);
    }

    protected function registerViewProvider()
    {
        $this->app->register(
            ViewServiceProvider::class
        );
    }

    /**
     * Register route service provider
     */
    protected function registerRouteProvider()
    {
        $this->app->register(
            RouteServiceProvider::class
        );
    }

    /**
     * Register translation service provider
     */
    protected function registerTranslationProvider()
    {
        $this->app->register(
            TranslationServiceProvider::class
        );
    }
}
