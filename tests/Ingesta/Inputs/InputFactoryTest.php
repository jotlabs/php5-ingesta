<?php
namespace Ingesta\Inputs;

use PHPUnit_Framework_TestCase;

class InputFactoryTest extends PHPUnit_Framework_TestCase
{
    protected $factory;


    public function setUp()
    {
        $this->factory = InputFactory::getInstance();
    }


    public function testClassExists()
    {
        $this->assertTrue(class_exists('Ingesta\Inputs\InputFactory'));
        $this->assertNotNull($this->factory);
        $this->assertTrue(is_a($this->factory, 'Ingesta\Inputs\InputFactory'));
    }


    public function testGetServiceReturnsWordpressClient()
    {
        $client = $this->factory->getService((object) array(
            'type' => InputFactory::WORDPRESS_API,
            'username' => 'unittest',
            'password' => 'qwerty123',
            'url' => 'http://example.com/'
        ));

        $this->assertNotNull($client);
        $this->assertTrue(is_a($client, 'Ingesta\Services\Wordpress\Wordpress'));
    }


    public function testGetServiceReturnsInstagramClient()
    {
        $client = $this->factory->getService((object) array(
            'type' => InputFactory::INSTAGRAM_API,
            'clientId' => 'unittest'
        ));

        $this->assertNotNull($client);
        $this->assertTrue(is_a($client, 'Ingesta\Services\Instagram\Instagram'));
    }
}
