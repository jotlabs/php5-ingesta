<?php
namespace Ingesta\Services\Instagram;

use Ingesta\Clients\ClientFactory;
use Ingesta\Utils\FactoryBase;
use Ingesta\Utils\UrlTemplate;

class InstagramFactory extends FactoryBase
{


    public function getInstagramClient()
    {
        $httpClient  = $this->getHttpClient();
        $urlTemplate = $this->getUrlTemplate();
    }


    protected function getHttpClient()
    {
        $factory    = ClientFactory::getInstance();
        $httpClient = $factory->getHttpClient();
        return $httpClient;
    }


    protected function getUrlTemplate()
    {
        $urlTemplate = new UrlTemplate();
        return $urlTemplate;
    }
}
