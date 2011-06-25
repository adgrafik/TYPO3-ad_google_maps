<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010 Arno Dudek <webmaster@adgrafik.at>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Controller.
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
abstract class Tx_AdGoogleMaps_Controller_AbstractController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * @var integer
	 */
	protected static $mapUid;

	/**
	 * @var Tx_AdGoogleMaps_Domain_Model_Map
	 */
	protected static $map;

	/**
	 * @var Tx_Extbase_Persistence_QueryResultInterface
	 */
	protected static $categories;

	/**
	 * @var Tx_AdGoogleMaps_MapManager_Manager
	 */
	protected static $mapManager;

	/**
	 * Returns the map uid of the tt_content plugin form.
	 *
	 * @return integer
	 */
	protected function initializeIndexAction() {
		$error = NULL;

		if (array_key_exists('flexform', $this->settings) === FALSE) {
			$error = Tx_Extbase_Utility_Localization::translate('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang.xml:Tx_AdGoogleMaps_Controller.error.settingsNotFound', 'ad_google_maps', array('ad: Google Maps'));
		}

		// Get map.
		self::$mapUid = (integer) $this->settings['flexform']['mapUid'];
		$mapRepository = $this->objectManager->get('Tx_AdGoogleMaps_Domain_Repository_MapRepository');
		self::$map = $mapRepository->findByUid(self::$mapUid);
		if (self::$map instanceof Tx_AdGoogleMaps_Domain_Model_Map === FALSE) {
			$this->flashMessageContainer->add(
				$error = Tx_Extbase_Utility_Localization::translate('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang.xml:Tx_AdGoogleMaps_Controller.error.mapNotFound', 'ad_google_maps', array($this->mapUid))
			);
		}

		if ($error !== NULL) {
			$this->actionMethodName = 'rejectAction';
			$this->flashMessageContainer->add($error);
			return;
		}

		// Use categoriesCpsTcaTree field if the extension cps_tcatree is loaded.
		if (t3lib_extMgm::isLoaded('cps_tcatree') === TRUE) {
			$this->settings['flexform']['categories'] = $this->settings['flexform']['categoriesCpsTcaTree'];
		}

		// Get categories.
		$uids = explode(',', $this->settings['flexform']['categories']);
		$categoryRepository = $this->objectManager->get('Tx_AdGoogleMaps_Domain_Repository_CategoryRepository');
		self::$categories = $categoryRepository->findByUids($uids);

		// Build map.
		self::$mapManager = $this->objectManager->create('Tx_AdGoogleMaps_MapManager_Manager');
		self::$mapManager->build($this->getMap(), $this->getCategories(), $this->settings);
/*
		// Load this settings and get debug mode.
		$debug = false;
		if (($settings = Tx_AdGoogleMaps_Utility_BackEnd::getTypoScriptSetup('tx_adgooglemaps')) !== NULL) {
			$debug = (boolean) $settings['mapBuilder']['debug'];
		}
		$jsonClassEncoder = $this->objectManager->get('Tx_AdGoogleMaps_JsonClassEncoder_JsonEncoder');
		$result = $jsonClassEncoder->setDebug($debug);
		$result = $jsonClassEncoder->encode(self::$mapManager->getGoogleMapsPlugin()->getPluginOptions());

print_r($result);
exit;
*/
	}

	/**
	 * Rejects the action if an error occurred.
	 *
	 * @return integer
	 */
	protected function rejectAction() {
		return;
	}

	/**
	 * Returns this mapUid
	 *
	 * @return integer
	 */
	protected function getMapUid() {
		return self::$mapUid;
	}

	/**
	 * Returns this map
	 *
	 * @return Tx_AdGoogleMaps_Domain_Model_Map
	 */
	protected function getMap() {
		return clone self::$map;
	}

	/**
	 * Returns this categories
	 *
	 * @return Tx_Extbase_Persistence_QueryResultInterface
	 */
	protected function getCategories() {
		return clone self::$categories;
	}

	/**
	 * Returns this mapManager
	 *
	 * @return Tx_AdGoogleMaps_MapManager_Manager
	 */
	protected function getMapManager() {
		return self::$mapManager;
	}

}

?>