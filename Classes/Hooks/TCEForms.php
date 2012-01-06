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
 * Loads the template forms from TS-Setup.
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_AdGoogleMaps_Service_Hooks_TCEForms {

	/**
	 * Returns template form for the flexform.
	 * 
	 * @param string
	 * @param string
	 * @param array
	 * @param array
	 * @return void
	 */
	public function getSingleField_beforeRender($table, $field, $row, &$PA) {
		if ($table === 'tt_content' && $field === 'pi_flexform' && array_key_exists('ds', $PA['fieldConf']['config'])) {
			if (($settings = Tx_AdGoogleMaps_Utility_BackEnd::getTypoScriptSetup($row['pid'], 'tx_adgooglemaps')) === FALSE || array_key_exists('TCAConfiguration', $settings) === FALSE) {
				Tx_AdGoogleMaps_Utility_BackEnd::addFlashMessage('Could not read settings. Perhaps the static template "ad: Google Maps (ad_google_maps)" missing in the page template.');
				return;
			}
			// Get TypoScript FlexForm file content.
			$templateFlexformDS = '';
			ksort($settings['TCAConfiguration']['flexform']['templateSheeds']);
			foreach ($settings['TCAConfiguration']['flexform']['templateSheeds'] as $fileResource) {
				$templateFlexformDS .= t3lib_div::getURL(t3lib_div::getFileAbsFileName($fileResource));
			}
			// Get content FlexForm content.
			$flexformDS = t3lib_div::getURL(t3lib_div::getFileAbsFileName(str_replace('FILE:', '', $PA['fieldConf']['config']['ds']['adgooglemaps_pi1,list'])));
			// Replace templateSettingSheets in FlexForm with TypoScript FlexForm files.
			$PA['fieldConf']['config']['ds']['adgooglemaps_pi1,list'] = str_replace('<!-- ###templateSheets### -->', $templateFlexformDS, $flexformDS);
		}
	}

}

?>