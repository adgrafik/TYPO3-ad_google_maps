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
class Tx_AdGoogleMaps_Controller_GoogleMapsController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * @var Tx_AdGoogleMaps_Domain_Repository_MapRepository
	 */
	protected $mapRepository;
	
	/**
	 * Index action
	 *
	 * @return string The rendered view
	 */
	public function indexAction() {
		if (!array_key_exists('map', $this->settings)) {
			$this->flashMessageContainer->add('Add static TypoScript "ad: Google Maps" to your template.');
			return;
		}

		$this->mapRepository = t3lib_div::makeInstance('Tx_AdGoogleMaps_Domain_Repository_MapRepository');

		// Merge TypoScript settings with FlexForm values. FlexForm values overrides TypoScript settings.
		if (array_key_exists('flexform', $this->settings)) {
			$this->settings = Tx_Extbase_Utility_Arrays::arrayMergeRecursiveOverrule($this->settings, $this->settings['flexform']);
		}

		if (!array_key_exists('uid', $this->settings['map'])) {
			$this->flashMessageContainer->add('No map defined.');
			return;
		}
		// Create map.
		$map = $this->mapRepository->findByUid($this->settings['map']['uid']);
		if ($map instanceof Tx_AdGoogleMaps_Domain_Model_Map === FALSE) {
			$this->flashMessageContainer->add('No map found. Define Storage PID (plugin.tx_adgooglemaps.persistence.storagePid) in the constant editor.');
			return;
		}
		$googleMapsPluginAdapter = t3lib_div::makeInstance('Tx_AdGoogleMaps_PluginAdapter_MapBuilder', $map, $this->settings);
		$googleMapsPluginAdapter->buildMap();

		$this->view->assign('googleMapsPlugin', $googleMapsPluginAdapter->getGoogleMapsPlugin());
		$this->view->assign('map', $googleMapsPluginAdapter->getMap());
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ad_googlemaps/Classes/Controller/GoogleMapsController.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ad_googlemaps/Classes/Controller/GoogleMapsController.php']);
}
?>