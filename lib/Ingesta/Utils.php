<?php
namespace Ingesta;

class Utils {
    public static $libDir;

    /******************************************************************
    * PSR-0 Autoloader
    *
    * Do not use if you are using Composer to autoload dependencies.
    ******************************************************************/
    public static function autoload($className) {
        $fileName  = self::$libDir;
        $classPath = str_replace('\\', '/', ltrim($className, '\\'));
        $classPath = str_replace('_',  '/', $classPath);
        $fileName .= $classPath . '.php';

        if (file_exists($fileName)) {
            require $fileName;
        }
    }
    // Previous autoload version
    public static function autoloadXX($className) {
        $thisClass = str_replace(__NAMESPACE__ . '\\', '', __CLASS__);
        $baseDir   = __DIR__;

        $classLen  = strlen($thisClass);
        if (substr($baseDir, -$classLen) === $thisClass) {
            $baseDir = substr($baseDir, 0, -$classLen);
        }

        $className = ltrim($className, '\\');
        $fileName  = $baseDir;
        $namespace = '';
        
        $lastNsPos = strripos($className, '\\');
        if ($lastNsPos) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace)
                    . DIRECTORY_SEPARATOR;
        }

        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className)
                . '.php';

        if (file_exists($fileName)) {
            require $fileName;
        }
    }


    public static function registerAutoloader() {
        $classFile = str_replace('\\', '/', __CLASS__ . '.php');
        self::$libDir = str_replace($classFile, '', __FILE__);
        spl_autoload_register(__NAMESPACE__ . "\\Utils::autoload");
    }

}

?>
