<?php
/**
 *
 * Fonctions de copie sur le système de fichiers
 *
 *
 * @package Olix
 * @subpackage InstallerScriptComposer
 * @author Olivier
 *
 */

namespace Olix\InstallerScriptComposer\Components;


class FilesystemCopy extends Filesystem {


	/**
	 * Copie des fichiers d'un package en fonction des patterns définis dans la config "extra/olix"
	 * 
	 * @param string $sourceDir      : Dossier source ~ dossier d'installation du package
	 * @param string $destinationDir : Dossier de destination où seront copiés les fichiers
	 * @param array  $extra          : Configuration de l'extra Olix
	 */
	public function copyPackageFiles ($sourceDir, $destinationDir, array $extra)
	{
		$this->installPackageFiles($sourceDir, $destinationDir, $extra, false);
	}


	/**
	 * Lien symbolique des fichiers d'un package en fonction des patterns définis dans la config "extra/olix"
	 *
	 * @param string $sourceDir      : Dossier source ~ dossier d'installation du package
	 * @param string $destinationDir : Dossier de destination où seront copiés les fichiers
	 * @param array  $extra          : Configuration de l'extra Olix
	 */
	public function symlinkPackageFiles ($sourceDir, $destinationDir, array $extra)
	{
		$this->installPackageFiles($sourceDir, $destinationDir, $extra, true);
	}


	/**
	 * Installation des fichiers d'un package en fonction des patterns définis dans la config "extra/olix"
	 *
	 * @param string $sourceDir      : Dossier source ~ dossier d'installation du package
	 * @param string $destinationDir : Dossier de destination où seront copiés les fichiers
	 * @param array  $extra          : Configuration de l'extra Olix
	 * @param bool   $symlink        : Si on fait un lien symbolique à la place de la copie
	 */
	protected function installPackageFiles ($sourceDir, $destinationDir, array $extra, $symlink = false)
	{
		$patterns = isset($extra['files']) ? $extra['files'] : array('**');
	
		// Pour chaque pattern de fichier à copier
		foreach ($patterns as $pattern) {
	
			foreach ($this->recursiveGlobFiles($sourceDir.DIRECTORY_SEPARATOR.$pattern) as $fileSource) {
	
				$fileDestination = $destinationDir.DIRECTORY_SEPARATOR.str_replace($sourceDir.DIRECTORY_SEPARATOR, '', $fileSource);
				$this->ensureDirectoryExists(dirname($fileDestination));
	
				if ($symlink)
					$this->symlink($fileSource, $fileDestination);
				else
					$this->copy($fileSource, $fileDestination);
	
			}
		}
	}

}