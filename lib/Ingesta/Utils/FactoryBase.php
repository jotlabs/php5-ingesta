<?php
namespace Ingesta\Utils;

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
}
