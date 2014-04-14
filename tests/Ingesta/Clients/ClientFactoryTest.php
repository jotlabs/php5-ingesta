<?php
namespace Ingesta\Clients;

use PHPUnit_Framework_TestCase;

class ClientFactoryTest extends PHPUnit_Framework_TestCase
{
    protected $factory;


    public function setUp()
    {
        $this->factory = ClientFactory::getInstance();
        $this->factory->setTestMode(true);
    }


    public function testClassExists()
    {
        $this->assertTrue(class_exists('Ingesta\Clients\ClientFactory'));
        $this->assertNotNull($this->factory);
        $this->assertTrue(is_a($this->factory, 'Ingesta\Clients\ClientFactory'));
    }


    public function testGetHttpReturnsMockHttpClient()
    {
        $client = $this->factory->getHttpClient(null);
        $this->assertNotNull($client);
        $this->assertTrue(is_a($client, 'Ingesta\Clients\Http'));
        $this->assertTrue(is_a($client, 'Ingesta\Clients\Http\MockHttp'));
    }

    public function testGetCachedHttpReturnsCacheHttpClient()
    {
        $client = $this->factory->getHttpClient(ClientFactory::CACHE_HTTP_CLIENT);
        $this->assertNotNull($client);
        $this->assertTrue(is_a($client, 'Ingesta\Clients\Http'));
        $this->assertTrue(is_a($client, 'Ingesta\Clients\Http\CacheHttp'));
    }
}
