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
 * Class for backend tools. 
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_AdGoogleMaps_Utility_FrontEnd extends Tx_AdGoogleMaps_Utility_BackEnd {

	/**
	 * @var boolean
	 */
	protected static $debugMode;

	/**
	 * @var array
	 */
	protected static $compressor;

	/**
	 * @var array
	 */
	protected static $loadedFrontEndResources = array();

	/**
	 * Load header data like TypoScript and CSS into the page.
	 *
	 * @return void
	 */
	public static function includeFrontEndResources($configurationKey) {
		if (array_key_exists($configurationKey, self::$loadedFrontEndResources) === FALSE && ($settings = Tx_AdGoogleMaps_Utility_BackEnd::getTypoScriptSetup($GLOBALS['TSFE']->id, 'tx_adgooglemaps')) !== FALSE) {
			if (array_key_exists($configurationKey, $settings['plugin']['includeFrontEndResources']) !== FALSE) {
				if (self::$compressor === NULL) {
					self::$compressor = t3lib_div::makeInstance('t3lib_Compressor');
				}
				$resources = Tx_Extbase_Utility_TypoScript::convertPlainArrayToTypoScriptArray($settings['plugin']['includeFrontEndResources'][$configurationKey]);
				foreach ($resources as $type => $value) {
					if (in_array($type, array('includeCSS.', 'cssInline.', 'includeJSlibs.', 'includeJSFooterlibs.', 'includeJS.', 'includeJSFooter.', 'jsInline.', 'jsFooterInline.')) === TRUE) {
						foreach ($value as $key => $configuration) {
							$GLOBALS['TSFE']->pSetup[$type][$key] = $configuration;
						}
					}
				}
				self::$loadedFrontEndResources[$configurationKey] = TRUE;
			}
		}
	}

}

?>