<?php
/**
 *
 * Fonctions sur les packages Composer
 *
 *
 * @package Olix
 * @subpackage InstallerScriptComposer
 * @author Olivier
 *
 */

namespace Olix\InstallerScriptComposer\Components;

use Composer\Script\CommandEvent;
use Composer\Package\Loader\ArrayLoader;


class Package {


	/**
	 * Retourne la liste des packages Composer installés en fonction du type
	 * 
	 * @param CommandEvent $event
	 * @param string       $typePackage : Nom du type de package à rechercher
	 * @return array
	 */
	public static function getAvailablePackage (CommandEvent $event, $typePackage = null)
	{
		$availablePackages = array();
	
		// Récupère tous les packages.
		$allPackages = array();
		$locker = $event->getComposer()->getLocker();
		if (isset($locker)) {
			$lockData = $locker->getLockData();
			$allPackages = isset($lockData['packages']) ? $lockData['packages'] : array();
	
			// Fusionne si des packages de dev existent
			$devPackages = isset($lockData['packages-dev']) ? $lockData['packages-dev'] : array();
			foreach ($devPackages as $package) {
				$allPackages[] = $package;
			}
		}
	
		if ( $typePackage != null ) {
			// Récupère que les packages avec le type $namePackage
			foreach ($allPackages as $package) {
				if (isset($package['type']) && $package['type'] === $typePackage) {
					$availablePackages[] = $package;
				}
			}
		}
	
		return  $availablePackages;
	}


	/**
	 * Retourne le chemin où est installé le package Composer
	 * 
	 * @param CommandEvent $event
	 * @param array        $package : Package Composer
	 * @return string
	 */
	public static function getVendorDir (CommandEvent $event, array $package)
	{
		if ( isset($package['is-root']) && $package['is-root'] === true ) {
			return getcwd();
		}
		$installManager = $event->getComposer()->getInstallationManager();
		$loader = new ArrayLoader();
		return $installManager->getInstallPath($loader->load($package));
	}


	/**
	 * Retourne le nom simplifié du composant (custom package)
	 * 
	 * @param string $prettyName : Nom du package
	 * @param array  $extra      : Configuration extra du composant
	 * @return string
	 */
	public static function getComponentName ($prettyName, array $extra = array())
	{
		if (strpos($prettyName, '/') !== false) {
			list(, $name) = explode('/', $prettyName);
		} else {
			$name = $prettyName;
		}
	
		if (isset($extra['name']))
			$name = $extra['name'];
	
		return $name;
	}

}