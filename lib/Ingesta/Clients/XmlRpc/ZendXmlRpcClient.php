<?php
namespace Ingesta\Clients\XmlRpc;

use Ingesta\Clients\XmlRpc;
use Zend\XmlRpc\Client as XmlRpcClient;

class ZendXmlRpcClient implements XmlRpc
{
    protected $client;
    protected $apiEndpoint;


    public function __construct($apiEndpoint)
    {
        $this->apiEndpoint = $apiEndpoint;
        $this->initClient();
    }


    public function callMethod($method, $params = null)
    {
        $response = $this->client->call($method, $params);
        return $response;
    }


    protected function initClient()
    {
        $this->client = new XmlRpcClient($this->apiEndpoint);
    }
}
