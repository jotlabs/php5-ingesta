<?php
namespace Ingesta\Inputs;

use Ingesta\Services\Wordpress\Credentials;
use Ingesta\Services\Wordpress\WordpressFactory;
use Ingesta\Services\Instagram\InstagramFactory;
use Ingesta\Services\Storify\StorifyFactory;

class InputFactory
{
    const WORDPRESS_API = 'wordpress';
    const INSTAGRAM_API = 'instagram';
    const STORIFY_API   = 'storify';

    protected static $INSTANCE;


    protected function __construct()
    {
    }


    public static function getInstance()
    {
        if (!self::$INSTANCE) {
            self::$INSTANCE = new InputFactory();
        }

        return self::$INSTANCE;
    }


    public function getReader($inputArgs)
    {
        $reader = $this->getService($inputArgs);
        return $reader;
    }


    public function getService($input)
    {
        $service = null;
        $serviceName = $input->type;

        switch ($serviceName) {
            case self::WORDPRESS_API:
                $service = $this->getWordpressApi($input);
                break;
            case self::INSTAGRAM_API:
                $service = $this->getInstagramApi($input);
                break;
            case self::STORIFY_API:
                $service = $this->getStorifyApi($input);
                break;
        }

        return $service;
    }


    protected function getWordpressApi($input)
    {
        $factory     = WordpressFactory::getInstance();
        $credentials = new Credentials($input->username, $input->password);
        $wordpress   = $factory->getWordpressClient($input->url, $credentials);
        return $wordpress;
    }


    protected function getInstagramApi($input)
    {
        $factory     = InstagramFactory::getInstance();
        $instagram   = $factory->getInstagramClient($input->clientId);
        return $instagram;
    }


    protected function getStorifyApi($input)
    {
        $factory     = StorifyFactory::getInstance();
        $storify     = $factory->getStorifyClient();
        return $storify;
    }
}
