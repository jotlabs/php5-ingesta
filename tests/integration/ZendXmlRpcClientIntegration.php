<?php
namespace Ingesta\Integration;

use PHPUnit_Framework_TestCase;
use Ingesta\Clients\XmlRpc\ZendXmlRpcClient;

class ZendXmlRpcClientIntegration extends PHPUnit_Framework_TestCase
{
    const API_ENDPOINT = 'http://techcrunch.com/xmlrpc.php';

    protected $client;

    public function setUp()
    {
        $this->client = new ZendXmlRpcClient(self::API_ENDPOINT);
    }


    public function testClassExists()
    {
        $this->assertTrue(class_exists('Ingesta\Clients\XmlRpc\ZendXmlRpcClient'));
        $this->assertNotNull($this->client);
        $this->assertTrue(is_a($this->client, 'Ingesta\Clients\XmlRpc'));
        $this->assertTrue(is_a($this->client, 'Ingesta\Clients\XmlRpc\ZendXmlRpcClient'));
    }


    public function testSayHello()
    {
        $response = $this->client->callMethod('demo.sayHello');
        $this->assertNotNull($response);
        $this->assertEquals('Hello!', $response);
    }


    public function testAddTwoNumbers()
    {
        $params = array(17, 25);
        $response = $this->client->callMethod('demo.addTwoNumbers', $params);
        $this->assertEquals(42, $response);
    }
}
