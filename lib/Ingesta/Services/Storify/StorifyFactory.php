<?php
namespace Ingesta\Services\Storify;

use Ingesta\Utils\FactoryBase;
use Ingesta\Utils\UrlTemplate;
use Ingesta\Clients\ClientFactory;
use Ingesta\Services\Storify\Storify;

class StorifyFactory extends FactoryBase
{
    protected $isTestMode = false;
    protected $mockHttpClient;

    public function getStorifyClient()
    {
        $httpClient  = $this->getHttpClient();
        $urlTemplate = $this->getUrlTemplate();

        $client = new Storify($httpClient, $urlTemplate);

        return $client;
    }


    public function setTestMode($isTestMode)
    {
        $this->isTestMode = $isTestMode;
    }


    public function setMockHttpClient($mockHttpClient)
    {
        $this->mockHttpClient = $mockHttpClient;
    }


    protected function getHttpClient()
    {
        $httpClient = null;

        if ($this->isTestMode && $this->mockHttpClient) {
            $httpClient = $this->mockHttpClient;

        } else {
            $factory    = ClientFactory::getInstance();
            $httpClient = $factory->getHttpClient();

        }

        return $httpClient;
    }


    protected function getUrlTemplate()
    {
        $urlTemplate = new UrlTemplate();
        return $urlTemplate;
    }
}
