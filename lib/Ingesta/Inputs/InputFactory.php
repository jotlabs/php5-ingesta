<?php
namespace Ingesta\Services;

use Ingesta\Services\Wordpress\WordpressFactory;
use Ingesta\Services\Wordpress\Credentials;

class InputFactory
{
    const WORDPRESS_API = 'wordpress';

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


    public function getInput($inputArgs)
    {
        $service = $this->getService($inputArgs);
        $input   = $service->getInput($inputArgs);
        return $input;
    }


    public function getService($input)
    {
        $service = null;
        $serviceName = $input->type;

        switch ($serviceName) {
            case self::WORDPRESS_API:
                $service = $this->getWordpressApi($input);
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
}