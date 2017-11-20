<?php

namespace DeveoDK\Test;

use DeveoDK\Core\Component\Routes\RouteServiceProvider;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\TrimStrings;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Mockery;
use Orchestra\Testbench\TestCase;

class RouteTest extends TestCase
{
    /** @var Mockery\MockInterface */
    protected $routeServiceProvider;

    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();
        $this->routeServiceProvider = Mockery::mock(RouteServiceProvider::class);
    }

    /**
     * Test that the illuminate router instance is returned correctly
     * @test
     */
    public function routerIsConstructed()
    {
        $router = $this->routeServiceProvider->router();

        $this->assertEquals(true, $router instanceof Router);
    }

    /**
     * Remove mocked classes from memory
     */
    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * Check that routes are included correct
     * @test
     */
    public function routesAreMappedCorrect()
    {
        $provider = new RouteServiceProvider($this->app);

        $route = Mockery::mock(RouteServiceProvider::class);

        $provider->map($route->router());

        $routeCount = $this->app['router']->getRoutes()->count();

        $this->assertEquals(4, $routeCount);
    }

    /**
     * Checks that protected routes have the correct middleware
     * @test
     */
    public function protectedRoutesHaveCorrectMiddleware()
    {
        $provider = new RouteServiceProvider($this->app);

        $route = Mockery::mock(RouteServiceProvider::class);

        $provider->map($route->router());

        /** @var Router $router */
        $router = $this->app['router'];

        $routes = $router->getRoutes()->getIterator();

        $protectedRoutesCount = 0;
        $protectedMiddlewareCount = 0;

        /** @var Route $route */
        foreach ($routes as $route) {
            if ($route->getPrefix() === '/protected') {
                $protectedRoutesCount++;
            }

            if ($route->middleware()[0] === TrimStrings::class) {
                $protectedMiddlewareCount++;
            }
        }

        $this->assertEquals($protectedRoutesCount, $protectedMiddlewareCount);
    }

    /**
     * Checks that public_routes have the correct middleware
     * @test
     */
    public function publicRoutesHaveCorrectMiddleware()
    {
        $provider = new RouteServiceProvider($this->app);

        $route = Mockery::mock(RouteServiceProvider::class);

        $provider->map($route->router());

        /** @var Router $router */
        $router = $this->app['router'];

        $routes = $router->getRoutes()->getIterator();

        $publicRoutesCount = 0;
        $publicMiddlewareCount = 0;

        /** @var Route $route */
        foreach ($routes as $route) {
            if ($route->getPrefix() === null) {
                $publicRoutesCount++;
            }

            if ($route->middleware()[0] === ConvertEmptyStringsToNull::class) {
                $publicMiddlewareCount++;
            }
        }

        $this->assertEquals($publicRoutesCount, $publicMiddlewareCount);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('core.component', [
            'protection_middleware' => [
                TrimStrings::class,
            ],
            'middleware' => [
                ConvertEmptyStringsToNull::class
            ],
            'namespaces' => [
                'Tests' => base_path() . '/../../../../tests',
            ]
        ]);
    }
}
