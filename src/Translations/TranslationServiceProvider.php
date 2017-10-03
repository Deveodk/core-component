<?php

namespace DeveoDK\Core\Components\Translations;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Translation\TranslationServiceProvider as BaseTranslationProvider;
use DeveoDK\Core\Components\Services\ComponentServiceProvider;

class TranslationServiceProvider extends BaseTranslationProvider
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
     * Register the translation line loader.
     *
     * @return void
     */
    protected function registerLoader()
    {
        $paths = $this->componentService->getBundleNamespaces('Translations');

        $paths = array_merge($paths, [''.base_path() . DIRECTORY_SEPARATOR .'resources/lang']);

        $this->app->singleton('translation.loader', function ($app) use ($paths) {
            return new ComponentFileLoader($app['files'], $paths);
        });
    }
}
