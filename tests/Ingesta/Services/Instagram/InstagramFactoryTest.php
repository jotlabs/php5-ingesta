<?php
namespace Ingesta\Services\Instagram;

use PHPUnit_Framework_TestCase;

class InstagramFactoryTest extends PHPUnit_Framework_TestCase
{
    protected $factory;


    public function setUp()
    {
        $this->factory = InstagramFactory::getInstance();
    }


    public function testClassExists()
    {
        $this->assertTrue(class_exists('Ingesta\Services\Instagram\InstagramFactory'));
        $this->assertNotNull($this->factory);
        $this->assertTrue(is_a($this->factory, 'Ingesta\Services\Instagram\InstagramFactory'));
    }


    public function testGetClientReturnsInstagramClient()
    {
        $client = $this->factory->getInstagramClient('QWERTY');
        $this->assertNotNull($client);
        $this->assertTrue(is_a($client, 'Ingesta\Services\Instagram\Instagram'));
    }
}
