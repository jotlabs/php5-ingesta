<?php
namespace Ingesta;

class Utils {
    private static $__libDir;

    /******************************************************************
    * PSR-0 Autoloader
    *
    * Do not use if you are using Composer to autoload dependencies.
    ******************************************************************/
    public static function autoload($className) {
        $fileName  = self::$__libDir;
        $classPath = str_replace('\\', '/', ltrim($className, '\\'));
        $classPath = str_replace('_',  '/', $classPath);
        $fileName .= $classPath . '.php';

        if (file_exists($fileName)) {
            require $fileName;
        }
    }

    public static function registerAutoloader() {
        $classFile = str_replace('\\', '/', __CLASS__ . '.php');
        self::$__libDir = str_replace($classFile, '', __FILE__);
        spl_autoload_register(__NAMESPACE__ . "\\Utils::autoload");
    }

}

?>
