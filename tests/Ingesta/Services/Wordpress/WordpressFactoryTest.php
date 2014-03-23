<?php
namespace Ingesta\Services\Wordpress;

use PHPUnit_Framework_TestCase;

class WordpressFactoryTest extends PHPUnit_Framework_TestCase
{
    protected $factory;


    public function setUp()
    {
        $this->factory = new WordpressFactory();
    }


    public function testClassExists()
    {
        $this->assertTrue(class_exists('Ingesta\Services\Wordpress\WordpressFactory'));
        $this->assertNotNull($this->factory);
        $this->assertTrue(is_a($this->factory, 'Ingesta\Services\Wordpress\WordpressFactory'));
    }


    public function testGetClientReturnsWordpressClient()
    {
        $client = $this->factory->getWordpressClient('http://techcrunch.com/xmlrpc.php');
        $this->assertNotNull($client);
        $this->assertTrue(is_a($client, 'Ingesta\Services\Wordpress\Wordpress'));
    }
}
