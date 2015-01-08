<?php
namespace Ingesta\Services\Facebook;

use PHPUnit_Framework_TestCase;
use Ingesta\Services\Facebook\FacebookFactory;

class FacebookFactoryTest extends PHPUnit_Framework_TestCase
{
    protected $factory;

    public function setUp()
    {
        $this->factory = FacebookFactory::getInstance();
    }


    public function testClassExists()
    {
        $this->assertTrue(class_exists('Ingesta\Services\Facebook\FacebookFactory'));
        $this->assertNotNull($this->factory);
        $this->assertTrue(is_a($this->factory, 'Ingesta\Services\Facebook\FacebookFactory'));
    }

    public function testGetClientReturnsFacebookClient()
    {
        $client = $this->factory->getFacebookClient(null, null);
        $this->assertNotNull($client);
        $this->assertTrue(is_a($client, 'Ingesta\Services\Facebook\Facebook'));
    }
}
