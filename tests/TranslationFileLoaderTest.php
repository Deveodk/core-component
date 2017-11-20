<?php

namespace DeveoDK\Test;

use DeveoDK\Core\Component\Translations\TranslationFileLoader;
use DeveoDK\Core\Component\Translations\TranslationServiceProvider;
use Mockery;
use Orchestra\Testbench\TestCase;

class TranslationFileLoaderTest extends TestCase
{
    /** @var TranslationFileLoader */
    protected $translationFileLoader;

    /** @var TranslationServiceProvider */
    protected $translationServiceProvider;

    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();
        $this->translationFileLoader = app(TranslationFileLoader::class);
        $this->translationServiceProvider = app(TranslationServiceProvider::class);
    }

    /**
     * Test that the TranslationFileLoader can find the bundled translation
     * @test
     */
    public function canFindBundleTranslation()
    {
        $this->translationServiceProvider->register();
        $this->translationServiceProvider->registerLoader();

        // Register provider into IOC
        $this->app->register(TranslationServiceProvider::class);

        $this->assertEquals(trans('bundle:test.hallo'), 'this is a loaded translation');
    }

    /**
     * Test that the TranslationFileLoader can find the normal(Resources) translation
     * @test
     */
    public function canFindNormalTranslation()
    {
        $this->translationServiceProvider->register();
        $this->translationServiceProvider->registerLoader();

        // Register provider into IOC
        $this->app->register(TranslationServiceProvider::class);

        // Test that the other condition is run in the TranslationFileLoader
        $this->assertEquals(trans('bundle.test.hallo'), 'bundle.test.hallo');
    }

    /**
     * Setup core.component test config
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('core.component', [
            'protection_middleware' => [],
            'middleware' => [],
            'namespaces' => [
                'Tests' => base_path() . '/../../../../tests',
            ]
        ]);
    }

    /**
     * Remove mocked classes from memory
     */
    public function tearDown()
    {
        Mockery::close();
    }
}
