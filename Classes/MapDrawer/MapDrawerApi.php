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
 * The TCA service MapDrawer. 
 *
 * @package Extbase
 * @subpackage GoogleMaps\MapDrawer
 * @scope prototype
 * @entity
 * @api
 */
class tx_AdGoogleMaps_MapDrawer_MapDrawerApi {

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * User function for Google Maps database fields. 
	 *
	 * @param array $currentField
	 * @param t3lib_TCEforms $formObject
	 * @return void
	 */
	public function tx_draw($currentField, $formObject) {
		$TSCpid = current($formObject->getTSCpid('tx_adgooglemaps_domain_model_layer', $currentField['row']['uid'], $currentField['row']['pid']));
		// Load this settings and check if TypoScript setup is set.
		if (($settings = Tx_AdGoogleMaps_Utility_BackEnd::getTypoScriptSetup($TSCpid, 'tx_adgooglemaps')) === FALSE || array_key_exists('mapDrawer', $settings) === FALSE) {
			return Tx_AdGoogleMaps_Utility_BackEnd::addFlashMessage('Add static TypoScript "ad: Google Maps Api" to your template.');
		}
		$this->settings = $settings['mapDrawer'];

		// Check table configuration.
		if (array_key_exists($currentField['table'], $this->settings['tables']) === FALSE) {
			return Tx_AdGoogleMaps_Utility_BackEnd::addFlashMessage('MapDrawer found no configuration for current table "' . $currentField['table'] . '".<br />See: plugin.tx_adgooglemaps.settings.mapDrawer.tables.*');
		}

		$tableSettings = $this->settings['tables'][$currentField['table']];

		// If typeField is not a column in the table, than it will be a record type.
		if (array_key_exists($tableSettings['typeField'], $currentField['row'])) {
			$recordType = $currentField['row'][$tableSettings['typeField']];
		} else if (array_key_exists($tableSettings['typeField'], $tableSettings['recordTypes'])) {
			$recordType = $tableSettings['typeField'];
		} else {
			return Tx_AdGoogleMaps_Utility_BackEnd::addFlashMessage('MapDrawer found no record type configuration for current table "' . $currentField['table'] . '".<br />See: plugin.tx_adgooglemaps.settings.mapDrawer.tables.typeField');
		}
		$recordTypeConfiguration = $tableSettings['recordTypes'][$recordType];

		// Return if no record type is set. Needed for layers without coordinates like KML.
		if (class_exists($recordTypeConfiguration['className']) === FALSE) {
			Tx_AdGoogleMaps_Utility_BackEnd::addFlashMessage('MapDrawer found no record type configuration for current type "' . $recordType . '".<br />See: plugin.tx_adgooglemaps.settings.mapDrawer.tables.recordTypes');
			return Tx_Extbase_Utility_Localization::translate('LLL:EXT:ad_google_maps/Resources/Private/Language/MapDrawer/locallang.xml:tx_adgooglemaps_mapdrawer.none', 'ad_google_maps');
		}

		// Add JavaScript Files to the form.
		$this->addJavaScriptFilesToForm($formObject);

		// Create MapDrawer processor.
		try {
			$mapDrawer = t3lib_div::makeInstance($recordTypeConfiguration['className'], $currentField, $formObject, $recordTypeConfiguration);
			$mapDrawer->draw();
			return $mapDrawer->render();
		} catch (Tx_AdGoogleMaps_MapDrawer_Exception $exception) {
			Tx_AdGoogleMaps_Utility_BackEnd::addFlashMessage($exception->getMessage());
			return;
		}
	}

	/**
	 * Adds the JavaScriptFiles to the form.
	 *
	 * @param t3lib_TCEforms $formObject
	 * @param integer $recordTypeConfiguration
	 * @return void
	 */
	protected function addJavaScriptFilesToForm($formObject) {
		// Add JavaScript Google Maps API to form.
		$GLOBALS['TBE_TEMPLATE']->getPageRenderer()->addJsFile($this->settings['apiUrl'], 'text/javascript', FALSE);
		// Add MapDrawer JavaScript file to form.
		$mapDrawerJavaScriptFile = Tx_AdGoogleMaps_Utility_BackEnd::getRelativePathAndFileName($this->settings['apiJavaScriptFile'], '../');
		$formObject->loadJavascriptLib($mapDrawerJavaScriptFile);
	}

}

?>