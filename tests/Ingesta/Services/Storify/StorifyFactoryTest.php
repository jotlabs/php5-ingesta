<?php
namespace Ingesta\Services\Storify;

use PHPUnit_Framework_TestCase;

class StorifyFactoryTest extends PHPUnit_Framework_TestCase
{
    protected $factory;


    public function setUp()
    {
        $this->factory = StorifyFactory::getInstance();
    }


    public function testClassExists()
    {
        $this->assertTrue(class_exists('Ingesta\Services\Storify\StorifyFactory'));
        $this->assertNotNull($this->factory);
        $this->assertTrue(is_a($this->factory, 'Ingesta\Services\Storify\StorifyFactory'));
    }


    public function testGetClientReturnsWordpressClient()
    {
        $client = $this->factory->getStorifyClient();
        $this->assertNotNull($client);
        $this->assertTrue(is_a($client, 'Ingesta\Services\Storify\Storify'));
    }
}
