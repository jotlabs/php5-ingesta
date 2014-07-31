<?php
namespace Ingesta\Utils;

use Ingesta\Clients\ClientFactory;
use Ingesta\Utils\UrlTemplate;

class FactoryBase
{
    protected static $INSTANCES = array();


    public static function getInstance()
    {
        $className = get_called_class();

        if (!array_key_exists($className, self::$INSTANCES)) {
            $class = new $className();
            $class->init();
            self::$INSTANCES[$className] = $class;
        }

        return self::$INSTANCES[$className];
    }


    protected function init()
    {
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
