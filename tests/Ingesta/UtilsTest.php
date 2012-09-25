<?php

class UtilsTest extends PHPUnit_Framework_TestCase {

    public function testHasAutoloadMethods() {
        $this->assertTrue(is_callable('\Ingesta\Utils::registerAutoloader'));
        $this->assertTrue(is_callable('\Ingesta\Utils::autoload'));
    }
}

?>
