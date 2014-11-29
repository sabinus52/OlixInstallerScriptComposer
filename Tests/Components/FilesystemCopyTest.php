<?php
/**
 *
 * TESTS : Fonctions de copie sur le système de fichiers
 *
 *
 * @package Olix
 * @subpackage InstallerScriptComposer
 * @author Olivier
 *
 */

namespace Olix\InstallerScriptComposer\Tests\Components;

use Olix\InstallerScriptComposer\Components\FilesystemCopy;


class FilesystemCopyTest extends \PHPUnit_Framework_TestCase
{

	const PATH_TEST = 'src/Olix/AssetsInstallerBundle/Tests/Resources';


	public function setUp ()
	{
		$this->filesystem = new FilesystemCopy();
		
		$this->sourceDir = self::PATH_TEST;
		$this->destinationDir = realpath(sys_get_temp_dir()).DIRECTORY_SEPARATOR.'olix-installer';
	
		$this->filesystem->remove($this->destinationDir);
		$this->filesystem->ensureDirectoryExists($this->destinationDir);
	}


	protected function tearDown()
	{
		$this->filesystem->remove($this->destinationDir);
	}


	/**
	 * Test des copies des fichiers
	 *
	 * @dataProvider providerCopyPackageFiles
	 */
	public function testCopyPackageFiles ($package, $files)
	{
		$fs = new FilesystemCopy();
		$fs->copyPackageFiles($this->sourceDir, $this->destinationDir, $package['extra']['olix']);
		
		foreach ($files as $file) {
			$this->assertFileExists($this->destinationDir.'/' . $file, sprintf('Failed to find the destination file: %s', $file));
		}
	}

	public function providerCopyPackageFiles ()
	{
		$package = array(
			'name' => 'sabinus52/onefile',
			'version' => '1.2.3',
			'is-root' => true,
			'extra' => array(
				'olix' => array(
					'files' => array(
						'css/test1.css',
					),
				),
			),
		);
		$tests[] = array($package, array(
				'css/test1.css',
		));

		$package = array(
			'name' => 'sabinus52/allcss',
			'version' => '1.2.3',
			'is-root' => true,
			'extra' => array(
				'olix' => array(
					'files' => array(
						'css/*.css',
						'test.css'
					),
				),
			),
		);
		$tests[] = array($package, array(
				'css/test1.css',
				'css/test2.css',
				'test.css',
		));

		$package = array(
			'name' => 'sabinus52/allcss',
			'version' => '1.2.3',
			'is-root' => true,
			'extra' => array(
				'olix' => array(
					'files' => array(
						'css/*.css',
						'test-not-exist.css'
					),
				),
			),
		);
		$tests[] = array($package, array(
				'css/test1.css',
				'css/test2.css'
		));

		$package = array(
			'name' => 'sabinus52/cssandjs',
			'version' => '1.2.3',
			'is-root' => true,
			'extra' => array(
				'olix' => array(
					'files' => array(
						'css/*',
						'js/*'
					),
				),
			),
		);
		$tests[] = array($package, array(
				'css/test1.css',
				'css/test2.css',
				'js/test1.js',
				'js/test2.js'
		));

		$package = array(
			'name' => 'sabinus52/all',
			'version' => '1.2.3',
			'is-root' => true,
			'extra' => array(
				'olix' => array()
			),
		);
		$tests[] = array($package, array(
				'css/images/test1.png',
				'css/images/test2.png',
				'css/test1.css',
				'css/test2.css',
				'js/test1.js',
				'js/test2.js',
				'test.css',
				'test.js',
				'test.png',
		));

		return $tests;
	}

}
