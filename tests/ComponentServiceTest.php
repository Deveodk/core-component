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
        $this->componentServiceProvider = app(ComponentServiceProvider::class);
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

        $this->assertEquals(true, in_array('Tests/Bundle/Controllers', $namespaces));
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
