<?php
namespace Ingesta\Processors\Adapters;

use PHPUnit_Framework_TestCase;
use Ingesta\Services\Wordpress\Credentials;

class MethodCallAdapterTest extends PHPUnit_Framework_TestCase
{

    public static function uppercase($text)
    {
        return uppercase($text);
    }


    public function testSimpleMethodReturnsCorrectValue()
    {
        $adapter = new MethodCallAdapter('strlen');

        $output = $adapter->process('A text string');
        $this->assertNotNull($output);
        $this->assertTrue(is_integer($output));
        $this->assertEquals(13, $output);
    }


    public function testMethodExtraParametersReturnsCorrectResult()
    {
        $adapter = new MethodCallAdapter('strpos', array('text'));

        $output = $adapter->process('A text string');
        $this->assertNotNull($output);
        $this->assertTrue(is_integer($output));
        $this->assertEquals(2, $output);
    }


    public function testStaticMethodRetunsCorrectResult()
    {
    }


    public function testClassMethodReturnsCorrectResult()
    {
        $credentials = new Credentials('UserName', 'PassWord');
        $adapter     = new MethodCallAdapter(array($credentials, 'getUserName'));

        $output = $adapter->process('A text string');
        $this->assertNotNull($output);
        $this->assertTrue(is_string($output));
        $this->assertEquals('UserName', $output);
    }
}
