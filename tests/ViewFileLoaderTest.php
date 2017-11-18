<?php

namespace DeveoDK\Test;

use DeveoDK\Core\Component\Views\ViewFileLoader;
use DeveoDK\Core\Component\Views\ViewServiceProvider;
use Orchestra\Testbench\TestCase;

class ViewFileLoaderTest extends TestCase
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
     * Test that the viewFileLoader can find the correct paths
     * @test
     */
    public function canFindInPaths()
    {
        $this->viewServiceProvider->register();
        $this->viewServiceProvider->registerViewFinder();

        // Register provider into IOC
        $this->app->register(ViewServiceProvider::class);

        $paths = $this->app['config']['view.paths'];

        $fileLoader = new ViewFileLoader($this->app['files'], $this->app['config']['view.paths']);

        $class = new \ReflectionClass($fileLoader);
        $method = $class->getMethod('findInPaths');
        $method->setAccessible(true);

        var_dump($method->invokeArgs($fileLoader, ['bundle:hallo', $paths]));

        $this->assertEquals(
            'Tests/Bundle/Views/hallo.blade.php',
            $method->invokeArgs($fileLoader, ['bundle:hallo', $paths])
        );
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
