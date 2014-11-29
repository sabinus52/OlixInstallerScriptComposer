<?php
/**
 * 
 * Script d'execution par Composer suite à une mise à jour
 * 
 * 
 * @package Olix
 * @subpackage InstallerScriptComposer
 * @author Olivier
 *
 */

namespace Olix\InstallerScriptComposer;

use Sensio\Bundle\DistributionBundle\Composer\ScriptHandler as SymfonyScriptHandler;
use Olix\InstallerScriptComposer\Components\FilesystemCopy;
use Olix\InstallerScriptComposer\Components\Package;
use Composer\Script\CommandEvent;



class OlixComposerScriptHandler extends SymfonyScriptHandler {


	/**
	 * Installe les ressources web dans un dossier web public
	 * 
	 * @param CommandEvent $event
	 */
	public static function installOlixAssets (CommandEvent $event)
	{
		$options = self::getOptions($event);
		$symlink = isset($options['symfony-assets-install']) && $options['symfony-assets-install'] == 'symlink' ? true : false;
		
		// Verifie si les noms des dossiers "web" ont été déclarés
		$webDir = $options['symfony-web-dir'];
		$publicDir = (isset($options['olix-assets-dir'])) ? $options['olix-assets-dir'] : 'public';
		
		if ( !self::hasDirectory($event, 'symfony-web-dir', $webDir, 'install Olix assets' )) {
			$event->getIO()->write(sprintf('<error>The directory "%s" declared in parameter "symfony-web-dir" in not exist.</error>', $webDir));
			return;
		}
		
		$event->getIO()->write(sprintf('Installing assets for <fg=magenta>Olix</fg=magenta> into <comment>%s</comment>', $webDir.DIRECTORY_SEPARATOR.$publicDir));
		
		// Crée le dossier web/public
		$fs = new FilesystemCopy();
		$fs->remove($webDir.DIRECTORY_SEPARATOR.$publicDir);
		$fs->ensureDirectoryExists($webDir.DIRECTORY_SEPARATOR.$publicDir);
		
		// Traite les packages de type "olix-asset"
		$packages = Package::getAvailablePackage($event, 'olix-asset');
		foreach ($packages as $package) {
		
			// Récupération des infos pour chaque package
			$name = isset($package['name']) ? $package['name'] : 'assets';
			$extra = isset($package['extra']['olix']) ? $package['extra']['olix'] : array();
			$installDir = Package::getVendorDir($event, $package);
			$destinationDir = $webDir.DIRECTORY_SEPARATOR.$publicDir.DIRECTORY_SEPARATOR.Package::getComponentName($name, $extra);
			$event->getIO()->write(sprintf("Copy assets of package <info>%s</info> into <comment>%s</comment>", $name, $destinationDir));
		
			if ($symlink)
				$fs->symlinkPackageFiles($installDir, $destinationDir, $extra);
			else
				$fs->copyPackageFiles($installDir, $destinationDir, $extra);
		
		}
	
	}


}