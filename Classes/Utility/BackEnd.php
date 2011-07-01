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
class Tx_AdGoogleMaps_Utility_BackEnd {

	/**
	 * @var array
	 */
	protected static $extensionConfiguration;

	/**
	 * @var array
	 */
	protected static $typoScriptCache;

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
	 * Load settings and check if TypoScript setup is set.
	 *
	 * @return mixed Returns the settings, else FALSE if no settings found.
	 */
	public static function getTypoScriptSetup($pageId, $extensionKey) {
		if (self::$typoScriptCache === NULL || isset(self::$typoScriptCache[$pageId][$extensionKey]) === FALSE) {
			$pageObj = t3lib_div::makeInstance('t3lib_pageSelect');
			$rootline = $pageObj->getRootLine($pageId);
			$TSObj = t3lib_div::makeInstance('t3lib_tsparser_ext');
			$TSObj->tt_track = 0;
			$TSObj->init();
			$TSObj->runThroughTemplates($rootline);
			$TSObj->generateConfig();

			if (array_key_exists($extensionKey . '.', $TSObj->setup['plugin.']) === TRUE && array_key_exists('settings.', $TSObj->setup['plugin.'][$extensionKey . '.']) === TRUE) {
				self::$typoScriptCache[$pageId][$extensionKey] = Tx_Extbase_Utility_TypoScript::convertTypoScriptArrayToPlainArray($TSObj->setup['plugin.'][$extensionKey . '.']['settings.']);
			} else {
				self::$typoScriptCache[$pageId][$extensionKey] = FALSE;
			}
		}

		return self::$typoScriptCache[$pageId][$extensionKey];

		// TODO: No "easy" way to get TypoScript setup in Backend with the configuration manager. Only root templates will be parsed.
/*		$configurationManager = t3lib_div::makeInstance('Tx_Extbase_Configuration_BackendConfigurationManager');
		if (method_exists($configurationManager, 'loadTypoScriptSetup')) { // extbase < 1.3.0beta1
			$typoScriptSetup = Tx_Extbase_Utility_TypoScript::convertTypoScriptArrayToPlainArray($configurationManager->loadTypoScriptSetup());
		} else if (method_exists($configurationManager, 'getTypoScriptSetup')) { // extbase >= 1.3.0beta1
			$typoScriptSetup = Tx_Extbase_Utility_TypoScript::convertTypoScriptArrayToPlainArray($configurationManager->getTypoScriptSetup());
		}
		if (array_key_exists($extensionKey, $typoScriptSetup['plugin']) === TRUE && array_key_exists('settings', $typoScriptSetup['plugin'][$extensionKey]) === TRUE) {
			return $typoScriptSetup['plugin'][$extensionKey]['settings'];
		}
		return FALSE;*/
	}

	/**
	 * Adds the flash message on errors.
	 *
	 * @param string $message
	 * @param string $title
	 * @param integer $severity
	 * @return void
	 */
	public static function addFlashMessage($message, $title = 'tx_adgooglemaps: Invalid extension configuration', $severity = t3lib_FlashMessage::ERROR) {
		$flashMessages = t3lib_div::makeInstance('t3lib_FlashMessage', $message, $title, $severity);
		t3lib_FlashMessageQueue::addMessage($flashMessages);
	}

	/**
	 * Adds the flash message on errors.
	 *
	 * @param string $message
	 * @param string $title
	 * @param integer $severity
	 * @return void
	 */
	public static function getFlashMessage($message, $title = 'tx_adgooglemaps: Invalid extension configuration', $severity = t3lib_FlashMessage::ERROR) {
		$flashMessages = t3lib_div::makeInstance('t3lib_FlashMessage', $message, $title, $severity);
		return $flashMessages->render();
	}

	/**
	 * Renders the given template via fluid rendering engine.
	 * 
	 * @param string $templateSource
	 * @param array $templateData
	 * @return string
	 */
	public static function renderTemplate($templateSource, array $templateData) {
		$templateParser = Tx_Fluid_Compatibility_TemplateParserBuilder::build();

		if ($templateSource) {
			$content = $templateParser->parse($templateSource);
			$variableContainer = t3lib_div::makeInstance('Tx_Fluid_Core_ViewHelper_TemplateVariableContainer', $templateData);
			$renderingContext = t3lib_div::makeInstance('Tx_Fluid_Core_Rendering_RenderingContext');
			$renderingContext->setTemplateVariableContainer($variableContainer);
			$viewHelperVariableContainer = t3lib_div::makeInstance('Tx_Fluid_Core_ViewHelper_ViewHelperVariableContainer');
			$renderingContext->setViewHelperVariableContainer($viewHelperVariableContainer);

			return $content->render($renderingContext);
		}
	}

	/**
	 * Reslove path prepend with "EXT:" and return it.
	 *
	 * @param string $fileName
	 * @param string $prefix
	 * @return string
	 */
	public static function getRelativePathAndFileName($fileName, $prefix = '') {
		return $prefix . str_replace(PATH_site, '', t3lib_div::getFileAbsFileName($fileName));
	}

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

}

?>