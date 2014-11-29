<?php
/**
 *
 * TESTS : Fonctions basiques sur le système de fichiers
 *
 *
 * @package Olix
 * @subpackage InstallerScriptComposer
 * @author Olivier
 *
 */

namespace Olix\InstallerScriptComposer\Tests\Components;

use Olix\InstallerScriptComposer\Components\Filesystem;


class FilesystemTest extends \PHPUnit_Framework_TestCase
{

	const PATH_TEST = 'src/Olix/AssetsInstallerBundle/Tests/Resources';


	/**
	 * Tests the recursiveGlob function.
	 *
	 * @dataProvider providerRecursiveGlob
	 */
	public function testRecursiveGlob ($expected, $pattern, $flags = 0)
	{
		$fs = new Filesystem();
		$result = $fs->recursiveGlob($pattern, $flags);
	
		sort($expected);
		sort($result);
		$this->assertEquals($expected, $result);
	}

	public function providerRecursiveGlob ()
	{
		$tests = array();
		
		$tests[] = array(
			array(
				self::PATH_TEST.'/test.png',
			),
			self::PATH_TEST.'/test.png',
		);
	
		$tests[] = array(
			array(
				self::PATH_TEST.'/css',
				self::PATH_TEST.'/js',
				self::PATH_TEST.'/test.css',
				self::PATH_TEST.'/test.js',
				self::PATH_TEST.'/test.png',
			),
			self::PATH_TEST.'/*',
		);
	
		$tests[] = array(
			array(
				self::PATH_TEST.'/test.css',
				self::PATH_TEST.'/test.js',
				self::PATH_TEST.'/test.png',
			),
			self::PATH_TEST.'/test.*',
		);
	
		$tests[] = array(
			array(
				self::PATH_TEST.'/js/test1.js',
				self::PATH_TEST.'/js/test2.js',
			),
			self::PATH_TEST.'/js/*.js',
		);
	
		$tests[] = array(
			array(
				self::PATH_TEST.'/css',
				self::PATH_TEST.'/css/images',
				self::PATH_TEST.'/css/images/test1.png',
				self::PATH_TEST.'/css/images/test2.png',
				self::PATH_TEST.'/css/test1.css',
				self::PATH_TEST.'/css/test2.css',
				self::PATH_TEST.'/js',
				self::PATH_TEST.'/js/test1.js',
				self::PATH_TEST.'/js/test2.js',
				self::PATH_TEST.'/test.css',
				self::PATH_TEST.'/test.js',
				self::PATH_TEST.'/test.png',
			),
			self::PATH_TEST.'/**',
		);
	
		return $tests;
	}



	/**
	 * Tests the recursiveGlobFiles function.
	 *
	 * @dataProvider providerRecursiveGlobFiles
	 */
	public function testRecursiveGlobFiles($expected, $pattern, $flags = 0)
	{
		$fs = new Filesystem();
		$result = $fs->recursiveGlobFiles($pattern, $flags);
	
		sort($expected);
		sort($result);
	
		$this->assertEquals($expected, $result);
	}

	public function providerRecursiveGlobFiles()
	{
		$tests = array();
		
		$tests[] = array(
			array(
				self::PATH_TEST.'/test.png',
			),
			self::PATH_TEST.'/test.png',
		);
	
		$tests[] = array(
			array(
				self::PATH_TEST.'/test.css',
				self::PATH_TEST.'/test.js',
				self::PATH_TEST.'/test.png',
			),
			self::PATH_TEST.'/*',
		);
	
		$tests[] = array(
			array(
				self::PATH_TEST.'/test.css',
				self::PATH_TEST.'/test.js',
				self::PATH_TEST.'/test.png',
			),
			self::PATH_TEST.'/test.*',
		);
	
		$tests[] = array(
			array(
				self::PATH_TEST.'/js/test1.js',
				self::PATH_TEST.'/js/test2.js',
			),
			self::PATH_TEST.'/js/*.js',
		);
	
		$tests[] = array(
			array(
				self::PATH_TEST.'/test.css',
				self::PATH_TEST.'/test.js',
				self::PATH_TEST.'/test.png',
			),
			self::PATH_TEST.'/*test*',
		);
	
		$tests[] = array(
			array(
				self::PATH_TEST.'/css/images/test1.png',
				self::PATH_TEST.'/css/images/test2.png',
				self::PATH_TEST.'/test.png',
				),
			self::PATH_TEST.'/**test*.png',
		);
	
		$tests[] = array(
			array(
					self::PATH_TEST.'/css/test1.css',
					self::PATH_TEST.'/css/test2.css',
					self::PATH_TEST.'/test.css',
			),
			self::PATH_TEST.'/**css*',
		);
	
		$tests[] = array(
			array(
					self::PATH_TEST.'/css/images/test1.png',
					self::PATH_TEST.'/css/images/test2.png',
					self::PATH_TEST.'/css/test1.css',
					self::PATH_TEST.'/css/test2.css',
					self::PATH_TEST.'/js/test1.js',
					self::PATH_TEST.'/js/test2.js',
					self::PATH_TEST.'/test.css',
					self::PATH_TEST.'/test.js',
					self::PATH_TEST.'/test.png',
			),
			self::PATH_TEST.'/**',
		);
	
		return $tests;
	}
}
