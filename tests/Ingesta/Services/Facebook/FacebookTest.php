<?php
namespace Ingesta\Services\Facebook;

use PHPUnit_Framework_TestCase;
use Ingesta\Services\Facebook\Facebook;

class FacebookTest extends PHPUnit_Framework_TestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = new Facebook(null);
    }


    public function testClassExists()
    {
        $this->assertTrue(class_exists('Ingesta\Services\Facebook\Facebook'));
        $this->assertNotNull($this->client);
        $this->assertTrue(is_a($this->client, 'Ingesta\Services\Facebook\Facebook'));
        $this->assertTrue(is_a($this->client, 'Ingesta\Inputs\InputGetter'));
    }
}
