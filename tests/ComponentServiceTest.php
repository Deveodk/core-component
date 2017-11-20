<?php

namespace DeveoDK\Test;

use DeveoDK\Core\Component\Services\ComponentServiceProvider;
use Mockery;
use Orchestra\Testbench\TestCase;

class ComponentServiceTest extends TestCase
{
    /** @var ComponentServiceProvider */
    protected $componentServiceProvider;

    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();
        $this->componentServiceProvider = new ComponentServiceProvider($this->app);
    }

    /**
     * Test that the config is successfully returned
     * @test
     */
    public function canGetConfig()
    {
        $config = $this->componentServiceProvider->getConfig();

        $this->assertNotEquals(null, $config);
    }

    /**
     * Test that the bundle namespace is returned correctly
     * @test
     */
    public function canGetBundleNamespaces()
    {
        $namespaces = $this->componentServiceProvider->getBundleNamespaces('Controllers');

        $this->assertEquals(1, count($namespaces));
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
