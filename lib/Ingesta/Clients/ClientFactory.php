<?php
namespace Ingesta\Clients;

use Ingesta\Utils\FactoryBase;
use Ingesta\Clients\Http\HttpBase;
use Ingesta\Clients\Http\CacheHttp;

class ClientFactory extends FactoryBase
{
    const OFFLINE_CONNECTION_TIMEOUT = 10;
    const CACHE_HTTP_CLIENT = 'CachedHttpClient';

    protected $isTestMode    = false;
    protected $isOfflineMode = false;
    protected $isOnline      = true;

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


    protected function init()
    {
        $this->isOnline = $this->getOnlineState();
    }


    protected function getOnlineState()
    {
        $domain = 'example.com.';
        $ipAddr = gethostbyname($domain);
        $onlineState = ($domain !== $ipAddr);

        if (!$onlineState) {
            echo "[-WARN-] DNS resolution failed. Setting Ingesta to offline mode\n";
        }
        return $onlineState;
    }
}
