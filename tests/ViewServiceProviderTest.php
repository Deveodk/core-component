<?php

namespace DeveoDK\Test;

use DeveoDK\Core\Component\Views\ViewFileLoader;
use DeveoDK\Core\Component\Views\ViewServiceProvider;
use Illuminate\View\View;
use Mockery;
use Orchestra\Testbench\TestCase;

class ViewServiceProviderTest extends TestCase
{
    /** @var ViewServiceProvider */
    protected $viewServiceProvider;

    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();
        $this->viewServiceProvider = app(ViewServiceProvider::class);
    }

    /**
     * Test that the views are registered correct
     * @test
     */
    public function canRegisterViewsCorrect()
    {
        $this->viewServiceProvider->register();

        $registeredViewPaths = $this->app['config']['view.paths'];

        $this->assertEquals(true, in_array('Tests/Bundle/Views', $registeredViewPaths));
    }

    /**
     * Test that the view finder is registered correct
     * @test
     */
    public function canRegisterViewFinderCorrect()
    {
        $this->viewServiceProvider->registerViewFinder();

        // Register provider into IOC
        $this->app->register(ViewServiceProvider::class);

        /** @var View $viewFinder */
        $viewFinder = $this->app['view.finder'];

        $this->assertEquals(ViewFileLoader::class, get_class($viewFinder));
    }

    /**
     * Remove mocked classes from memory
     */
    public function tearDown()
    {
        Mockery::close();
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
                'Tests' => 'tests',
            ]
        ]);
    }
}
