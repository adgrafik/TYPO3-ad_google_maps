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
 * Tool class for BackEnd. 
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_AdGoogleMaps_Tools_BackEnd {

	/**
	 * @var array
	 */
	protected static $extensionConfiguration;

	/**
	 * Returns relative path by given directory and file name.
	 *
	 * @param string $uploadDirectory
	 * @param string $fileName
	 * @return string
	 */
	public static function getRelativeUploadPathAndFileName($uploadDirectory, $fileName) {
		if (!$fileName) return NULL; // Nothing to do if file name is empty or NULL.
		return self::getAbsoluteUploadPath($uploadDirectory) . $fileName;
	}

	/**
	 * Returns absolute path by given directory name.
	 *
	 * @param string $uploadDirectory
	 * @param string $defaultDirectory
	 * @return string
	 */
	public static function getAbsoluteUploadPath($uploadDirectory, $defaultDirectory = 'uploads/tx_adgooglemaps/') {
		$extensionConfiguration = self::getExtensionConfiguration();
		$path = $defaultDirectory;
		if ($extensionConfiguration !== FALSE && array_key_exists($uploadDirectory, $extensionConfiguration['uploadDirectories']) === TRUE) {
			$path = $extensionConfiguration['uploadDirectories'][$uploadDirectory];
		}
		$path = str_replace(PATH_site, '', t3lib_div::getFileAbsFileName($path));
		return $path . ((strrpos($path, '/') === strlen($path) - 1) ? '' : '/');
	}

	/**
	 * Returns the TCA settings.
	 *
	 * @return mixed
	 */
	public static function getExtensionConfiguration() {
		if (self::$extensionConfiguration === NULL) {
			// Check if the extension configurations are set.
			if (array_key_exists('ad_google_maps', $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']) === FALSE) {
				return FALSE;
			}
			self::$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ad_google_maps']);
			self::$extensionConfiguration = Tx_Extbase_Utility_TypoScript::convertTypoScriptArrayToPlainArray(self::$extensionConfiguration);
		}
		return self::$extensionConfiguration;
	}

}

?>