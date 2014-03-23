<?php
namespace Ingesta\Services\Wordpress;

use Ingesta\Clients\XmlRpc\ZendXmlRpcClient;

class WordpressFactory
{

    public function getWordpressClient($apiEndpoint)
    {
        $client    = $this->initXmlRpcClient($apiEndpoint);
        $wordpress = new Wordpress($client);
        return $wordpress;
    }


    protected function initXmlRpcClient($apiEndpoint)
    {
        // TODO: Refactor this into an XmlRpcFactory
        $client = new ZendXmlRpcClient($apiEndpoint);
        return $client;
    }
}
