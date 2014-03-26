<?php
namespace Ingesta\Services\Wordpress;

use Ingesta\Clients\XmlRpc\ZendXmlRpcClient;
use Ingesta\Clients\XmlRpc\MockXmlRpcClient;

class WordpressFactory
{
    protected $isTestMode = false;
    protected $mockClient;


    public function getWordpressClient($apiEndpoint, $credentials = null)
    {
        $client = null;

        if ($this->isTestMode) {
            $client = $this->initMockClient($apiEndpoint);

        } else {
            $client = $this->initXmlRpcClient($apiEndpoint);

        }

        $wordpress = new Wordpress($client);
        $wordpress->setCredentials($credentials);

        return $wordpress;
    }


    public function setTestMode($isTestMode)
    {
        $this->isTestMode = $isTestMode;
    }


    public function setMockClient($mockClient)
    {
        if ($this->isTestMode) {
            $this->mockClient = $mockClient;
        }
    }


    protected function initXmlRpcClient($apiEndpoint)
    {
        // TODO: Refactor this into an XmlRpcFactory
        $client = new ZendXmlRpcClient($apiEndpoint);
        return $client;
    }


    protected function initMockClient($apiEndpoint)
    {
        if ($this->mockClient) {
            $client = $this->mockClient;

        } else {
            $client = new MockXmlRpcClient($apiEndpoint);

        }

        return $client;
    }
}
