<?php
namespace Ingesta\Services\Wordpress;

use PHPUnit_Framework_TestCase;

class WordpressTest extends PHPUnit_Framework_TestCase
{
    protected $wordpress;


    public function setUp()
    {
        $factory = new WordpressFactory();
        //$factory->setUnitTestMode(true);

        $this->wordpress = $factory->getWordpressClient('http://techcrunch.com/xmlrpc.php');
    }


    public function testClassExists()
    {
        $this->assertTrue(class_exists('Ingesta\Services\Wordpress\Wordpress'));
        $this->assertNotNull($this->wordpress);
        $this->assertTrue(is_a($this->wordpress, 'Ingesta\Services\Wordpress\Wordpress'));
    }
}
