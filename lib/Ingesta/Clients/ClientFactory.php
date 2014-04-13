<?php
namespace Ingesta\Clients;

use Ingesta\Utils\FactoryBase;
use Ingesta\Clients\Http\HttpBase;
use Ingesta\Clients\Http\CacheHttp;

class ClientFactory extends FactoryBase
{
    const CACHE_HTTP_CLIENT = 'CachedHttpClient';

    protected $isTestMode   = false;
    protected $isOfflineMode = false;

    // TODO: should do an offline check.


    public function setTestMode($isTestMode)
    {
        $this->isTestMode = $isTestMode;
    }


    public function setOfflineMode($isOfflineMode)
    {
        $this->isOfflineMode = $isOfflineMode;
    }


    public function getHttpClient($clientType)
    {
        $client = new HttpBase();

        switch ($clientType) {
            case self::CACHE_HTTP_CLIENT:
                // Decorate the existing HTTP client
                $client = new CacheHttp($client, '/tmp/http-cache/');
                break;
            default:
                break;
        }

        return $client;
    }


    public function getXmlRpcClient($clientType)
    {
        $client = null;
        return $client;
    }
}
