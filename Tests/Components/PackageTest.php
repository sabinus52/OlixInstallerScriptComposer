<?php
/**
 *
 * TESTS : Fonctions basiques sur les paquets Composer
 *
 *
 * @package Olix
 * @subpackage InstallerScriptComposer
 * @author Olivier
 *
 */

namespace Olix\InstallerScriptComposer\Tests\Components;

use Olix\InstallerScriptComposer\Components\Package;


class PackageTest extends \PHPUnit_Framework_TestCase {


	/**
	 * Tests the getComponentName function.
	 *
	 * @dataProvider providerGetComponentName
	 */
	public function testGetComponentName ($expected, $prettyName, array $extra = array())
	{
		$package = new Package();
		$result = $package->getComponentName($prettyName, $extra);
	
		$this->assertEquals($expected, $result);
	}
	
	public function providerGetComponentName ()
	{
		$tests = array();
		
		$tests[] = array(
			'test',
			'sabinus52/test'
		);
		
		$tests[] = array(
			'test',
			'test'
		);
		
		$tests[] = array(
			'toto',
			'sabinus52/test',
			array('name' => "toto")
		);
		
		return $tests;
	}
}