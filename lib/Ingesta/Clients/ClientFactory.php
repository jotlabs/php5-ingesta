<?php
namespace Ingesta\Clients;

use Ingesta\Utils\FactoryBase;
use Ingesta\Clients\Http\HttpBase;
use Ingesta\Clients\Http\MockHttp;
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


    public function getHttpClient($clientType = null)
    {
        $client = $this->getBaseHttpClient();

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


    protected function getBaseHttpClient()
    {
        $client = null;

        if (!$this->isOfflineMode && $this->isOnline && !$this->isTestMode) {
            $httpClient = new HttpBase();

        } else {
            $httpClient = new MockHttp();

        }

        return $httpClient;
    }


    protected function init()
    {
        $this->isOnline = $this->getOnlineState();
    }


    protected function getOnlineState()
    {
        $onlineState = true;

        // Do a DNS lookup
        $domain = 'example.com.';
        $ipAddr = gethostbyname($domain);
        $onlineState = ($domain !== $ipAddr);

        // Shell exec a ping
        //$output = shell_exec('ping -c1 -t1 8.8.8.8');
        //print_r($output);
        //if (preg_match("/([0-9\.]+)% packet loss/", $output, $matches)) {
        //    $loss = floatval($matches[1]);
        //    $onlineState = ($loss < 40.00);
        //}

        if (!$onlineState) {
            echo "[-WARN-] DNS resolution failed. Setting Ingesta to offline mode\n";
        }
        return $onlineState;
    }
}
