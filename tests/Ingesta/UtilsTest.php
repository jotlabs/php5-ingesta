<?php

class UtilsTest extends PHPUnit_Framework_TestCase {

    public function testHasAutoloadMethods() {
        $this->assertTrue(is_callable('\Ingesta\Utils::registerAutoloader'));
        $this->assertTrue(is_callable('\Ingesta\Utils::autoload'));
    }

    public function testClassNameToFilePathExists() {
        $this->assertTrue(is_callable('\Ingesta\Utils::classNameToFilePath'));
    }

    public function testClassNameToFilePath() {
        $tests = array(
            'TestClass' => 'TestClass.php',
            'Test_Class' => 'Test/Class.php',
            'Test\Class' => 'Test/Class.php',
            '\Test\Class' => 'Test/Class.php',
            '\Test_Path\Class_Name' => 'Test_Path/Class/Name.php',
            '\\\\Test_Path_Alt\Class_Name_Alt' => 'Test_Path_Alt/Class/Name/Alt.php'
        );

        foreach($tests as $input => $output) {
            $this->assertEquals(
                    $output,
                    \Ingesta\Utils::classNameToFilePath($input)
            );
        }

    }
}

?>
