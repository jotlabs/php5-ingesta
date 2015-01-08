<?php
namespace Ingesta\Services\Facebook;

use Facebook;
use Ingesta\Utils\FactoryBase;

class FacebookFactory extends FactoryBase
{


    public function getFacebookClient($appId, $secret)
    {
        $openGraphClient = $this->getOpenGraphClient($appId, $secret);
        $client = new \Ingesta\Services\Facebook\Facebook($openGraphClient);

        return $client;
    }


    protected function getOpenGraphClient($appId, $secret)
    {
        $openGraphClient = null;

        if ($appId && $secret) {
            $openGraphClient = new Facebook(array(
                'appId' => $appId,
                'secret' => $secret
            ));
        }

        return $openGraphClient;
    }
}
