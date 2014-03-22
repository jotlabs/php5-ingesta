<?php
namespace Ingesta;

use PHPUnit_Framework_TestCase;

class IngestaTest extends PHPUnit_Framework_TestCase
{

	public function testClassExists()
	{
		$this->assertTrue(class_exists('Ingesta\Ingesta'));
	}

    public function testHasVersion()
    {
        $this->assertTrue(is_string(Ingesta::VERSION));
    }
}
