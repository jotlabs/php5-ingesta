<?php
namespace Ingesta\Clients\XmlRpc;

use Ingesta\Clients\XmlRpc;

class MockXmlRpcClient implements XmlRpc
{
    protected $apiEndpoint;

    protected $methodResponses;

    public function __construct($apiEndpoint)
    {
        $this->apiEndpoint = $apiEndpoint;
        $this->methodResponses = array(
            'demo.sayHello' => "Hello from mock xmlrpc client."
        );
    }


    public function callMethod($method, $params = null)
    {
        if (array_key_exists($method, $this->methodResponses)) {
            $response = $this->methodResponses[$method];
        }
        return $response;
    }


    public function addMethodResponse($method, $response)
    {
        $this->methodResponse[$method] = $response;
    }
}
