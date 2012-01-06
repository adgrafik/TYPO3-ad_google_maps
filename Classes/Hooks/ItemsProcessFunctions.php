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
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_AdGoogleMaps_Hooks_ItemsProcessFunctions {

	/**
	 * Returns template selection for the flexform.
	 * 
	 * @param array $config
	 * @return array
	 */
	public function getFlexFormTemplateControllerItems($config) {

		if (!($settings = Tx_AdGoogleMaps_Utility_BackEnd::getTypoScriptSetup($config['row']['pid'], 'tx_adgooglemaps')) || !isset($settings['TCAConfiguration']['flexform'])) {
			if (isset($config['config']['form_type'])) {	// Throws error only once.
				Tx_AdGoogleMaps_Utility_BackEnd::addFlashMessage('Could not read settings. Perhaps the static template "ad: Google Maps (ad_google_maps)" missing in the page template.');
			}
			return $config;
		}

		foreach ($settings['TCAConfiguration']['flexform']['controllers'] as $templateKey => $templateController) {

			$label = (isset($templateController['label']) 
				? Tx_Extbase_Utility_Localization::translate($templateController['label'], $templateController['extensionName']) 
				: $templateKey
			);

			$value = '';
			if (isset($templateController['switchableControllerActions'])) {
				$controllersAndActionNames = array();
				foreach ($templateController['switchableControllerActions'] as $controllerName => $controllers) {
					foreach ($controllers as $actionName) {
						$controllersAndActionNames[] = $controllerName . '->' . $actionName;
					}
				}
				$value .= implode(';', $controllersAndActionNames);
			} else {
				$value = $templateController['controller'] . '->' . $templateController['action'];
			}

			$config['items'][] = array(
				0 => $label,
				1 => $value,
			);
		}

		return $config;
	}

}

?>