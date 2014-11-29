<?php
/**
 *
 * Fonctions basiques sur le système de fichiers
 *
 *
 * @package Olix
 * @subpackage InstallerScriptComposer
 * @author Olivier
 *
 */

namespace Olix\InstallerScriptComposer\Components;

use Symfony\Component\Filesystem\Filesystem as BaseFilesystem;



class Filesystem extends BaseFilesystem {


	/**
	 * Crée le dossier s'il n'existe pas
	 * 
	 * @param string $directory : Dossier à créer
	 * @throws \RuntimeException
	 */
	public function ensureDirectoryExists ($directory)
	{
		if (!is_dir($directory)) {
		
			if (file_exists($directory)) {
				throw new \RuntimeException($directory.' exists and is not a directory.');
			}
		
			if (!@mkdir($directory, 0777, true)) {
				throw new \RuntimeException($directory.' does not exist and could not be created.');
			}
		
		}
	}


	/**
	 * Performs a recursive-enabled glob search with the given pattern.
	 *
	 * @param string $pattern
	 *   The pattern passed to glob(). If the pattern contains "**", then it
	 *   a recursive search will be used.
	 * @param int $flags
	 *   Flags to pass into glob().
	 *
	 * @return mixed
	 *  An array of files that match the recursive pattern given.
	 */
	public function recursiveGlob($pattern, $flags = 0)
	{
		// Perform the glob search.
		$files = glob($pattern, $flags);
	
		// Check if this is to be recursive.
		if (strpos($pattern, '**') !== FALSE) {
			foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
				$files = array_merge($files, $this->recursiveGlob($dir.'/'.basename($pattern), $flags));
			}
		}
	
		return $files;
	}


	/**
	 * Performs a recursive glob search for files with the given pattern.
	 *
	 * @param string $pattern
	 *   The pattern passed to glob().
	 * @param int $flags
	 *   Flags to pass into glob().
	 *
	 * @return mixed
	 *  An array of files that match the recursive pattern given.
	 */
	public function recursiveGlobFiles($pattern, $flags = 0)
	{
		$files = $this->recursiveGlob($pattern, $flags);
	
		return array_filter($files, 'is_file');
	}

}