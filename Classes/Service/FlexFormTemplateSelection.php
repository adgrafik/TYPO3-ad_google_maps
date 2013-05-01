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
 * Loads the templates from TS-Setup.
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class tx_AdGoogleMaps_Service_FlexFormTemplateSelection {

	/**
	 * Returns template selection for the flexform.
	 * 
	 * @param array $config
	 * @return array
	 */
	public function getItems($config) {
		if (($settings = Tx_AdGoogleMaps_Utility_BackEnd::getTypoScriptSetup($config['row']['pid'], 'tx_adgooglemaps')) === FALSE || array_key_exists('flexform', $settings) === FALSE) {
			if (array_key_exists('form_type', $config['config']) === TRUE) {	// Throws error only once.
				Tx_AdGoogleMaps_Utility_BackEnd::addFlashMessage('Could not read settings. Perhaps the static template "ad: Google Maps" missing in the page template.');
			}
			return $config;
		}
		foreach ($settings['flexform']['templateController'] as $templateKey => $templateController) {
			$config['items'][] = array(
				0 => Tx_Extbase_Utility_Localization::translate($templateController['label'], $templateController['extensionName']),
				1 => $templateKey,
			);
		}
		return $config;
	}

}

?>