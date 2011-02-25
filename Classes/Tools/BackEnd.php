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
	public static function getRelativeUploadPathAndFileName($extensionKey, $uploadDirectory, $fileName) {
		if (!$fileName) return NULL; // Nothing to do if file name is empty or NULL.
		return self::getAbsoluteUploadPath($extensionKey, $uploadDirectory) . $fileName;
	}

	/**
	 * Returns absolute path by given directory name.
	 *
	 * @param string $extensionKey
	 * @param string $uploadDirectory
	 * @param string $defaultDirectory
	 * @return string
	 */
	public static function getAbsoluteUploadPath($extensionKey, $uploadDirectory, $defaultDirectory = 'uploads/tx_adgooglemaps/') {
		$extensionConfiguration = self::getExtensionConfiguration($extensionKey);
		$path = $defaultDirectory;
		if ($extensionConfiguration !== FALSE && array_key_exists($uploadDirectory, $extensionConfiguration['uploadDirectories']) === TRUE) {
			$path = $extensionConfiguration['uploadDirectories'][$uploadDirectory];
		}
		$path = str_replace(PATH_site, '', t3lib_div::getFileAbsFileName($path));
		return $path . ((strrpos($path, '/') === strlen($path) - 1) ? '' : '/');
	}

	/**
	 * @return string
	 */
	public static function getExtensionConfigurationValue($key) {
		$extensionConfiguration = self::getExtensionConfiguration('ad_google_maps');
		switch ($key) {
			case 'prependTranslationInfo':
				return (($extensionConfiguration !== FALSE && $extensionConfiguration['l10n']['prependTranslationInfo'] === '1') ? 'prefixLangTitle' : '');
			break;
			case 'excludeProperties':
				return (($extensionConfiguration !== FALSE && $extensionConfiguration['l10n']['excludeProperties'] === 'all') ? 'exclude' : '');
			break;
			case 'excludeProperties':
				return (($extensionConfiguration !== FALSE && $extensionConfiguration['l10n']['excludeProperties'] !== 'none') ? 'exclude' : '');
			break;
			case 'hideNewLocalizations':
				return (($extensionConfiguration !== FALSE && $extensionConfiguration['l10n']['hideNewLocalizations'] === '1') ? 'mergeIfNotBlank' : '');
			break;
		}
	}

	/**
	 * Returns the TCA settings.
	 *
	 * @param string $extensionKey
	 * @return mixed
	 */
	public static function getExtensionConfiguration($extensionKey) {
		if (self::$extensionConfiguration === NULL) {
			// Check if the extension configurations are set.
			if (array_key_exists('ad_google_maps', $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']) === FALSE) {
				return FALSE;
			}
		}
		if (is_array(self::$extensionConfiguration) === FALSE || array_key_exists($extensionKey, self::$extensionConfiguration) === FALSE) {
			self::$extensionConfiguration[$extensionKey] = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extensionKey]);
			if (self::$extensionConfiguration[$extensionKey] !== FALSE) {
				self::$extensionConfiguration[$extensionKey] = Tx_Extbase_Utility_TypoScript::convertTypoScriptArrayToPlainArray(self::$extensionConfiguration[$extensionKey]);
			}
		}
		return self::$extensionConfiguration[$extensionKey];
	}

}

?>