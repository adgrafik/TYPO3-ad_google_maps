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

	/**
	 * Return class properties as JSON object.
	 *
	 * @param mixed $object
	 * @param boolean $forceObject
	 * @return string
	 */
	public static function getClassAsJsonObject($object, $level = 0) {
		$jsonObject = array();

		$classReflection = t3lib_div::makeInstance('Tx_Extbase_Reflection_ClassReflection', $object);
		foreach ($classReflection->getProperties() as $propertyReflection) {

			// Get property name
			$propertyName = $propertyReflection->getName();

			// Get property value.
			$propertyValue = NULL;
			if (is_callable(array($object, 'get' . ucfirst($propertyName)))) {
				$propertyValue = call_user_func(array($object, 'get' . ucfirst($propertyName)));
			} else if (is_callable(array($object, 'is' . ucfirst($propertyName)))) {
				$propertyValue = call_user_func(array($object, 'is' . ucfirst($propertyName)));
			} else if (is_callable(array($object, 'has' . ucfirst($propertyName)))) {
				$propertyValue = call_user_func(array($object, 'has' . ucfirst($propertyName)));
			} else if (array_key_exists($propertyName, get_object_vars($object))) {
				$propertyValue = $object->$propertyName;
			}

			// Get property type.
			$propertyType = 'string'; // Set string as default.
			if ($propertyReflection->isTaggedWith('var')) {
				$propertyType = $propertyReflection->getTagValues('var');
				$propertyType = $propertyType[0];
			}

			// Get property json settings.
			$jsonProperties = array();
			$quoteValue = TRUE;
			$quoteArrayValuesRecursively = FALSE;
			$setNullValue = FALSE;
			$dontSetIfValueIs = NULL;
			$getFunction = NULL;
			$wrapValue = NULL;
			$postFunction = NULL;
			if ($propertyReflection->isTaggedWith('javaScriptHelper') === TRUE) {
				$javaScriptHelper = $propertyReflection->getTagValues('javaScriptHelper');
				$jsonProperties = t3lib_div::trimExplode(';', $javaScriptHelper[0]);
				foreach ($jsonProperties as $javaScriptHelper) {
					list($key, $value) = t3lib_div::trimExplode('=', $javaScriptHelper);
					switch ($key) {
						case 'dontSetValue':
							if ((boolean) $value === TRUE || strtolower($value) === 'true')
								continue 3;
						break;

						case 'dontSetIfValueIs':
							$dontSetIfValueIs = $value;
						break;

						case 'quoteValue':
							$quoteValue = eval('return (boolean) ' . $value . ';');
						break;

						case 'quoteArrayValuesRecursively':
							$quoteArrayValuesRecursively = eval('return (boolean) ' . $value . ';');
						break;

						case 'setNullValue':
							$setNullValue = eval('return (boolean) ' . $value . ';');
						break;

						case 'getFunction':
							$getFunction = $value;
						break;

						case 'wrap':
							$wrapValue = t3lib_div::trimExplode('|', $value);
						break;

						case 'postFunction':
							$postFunction = $value;
						break;
					}
				}
			}

			if (is_array($propertyValue) === TRUE || $propertyValue instanceof ArrayAccess === TRUE) {
				$propertyValue = self::getArrayAsJsonArray($propertyValue, $quoteArrayValuesRecursively, $level + 1);
			} else if (is_object($propertyValue) === TRUE) {
				if ($getFunction !== NULL && is_callable(array($propertyValue, $getFunction))) {
					$propertyValue = call_user_func(array($propertyValue, $getFunction));
				} else {
					$propertyValue = self::getClassAsJsonObject($propertyValue, $level + 1);
				}
			}

			// Continue with next property if value is NULL and should not set.
			if ($propertyValue === NULL && $setNullValue === FALSE || $propertyValue == eval('return ' . $dontSetIfValueIs . ';'))
				continue;

			// Do special values.
			switch ($propertyType) {
				case 'string':
					$propertyValue = ($quoteValue === TRUE ? '\'' . $propertyValue . '\'' : $propertyValue);
				break;

				case 'boolean':
					$propertyValue = ((boolean) $propertyValue === TRUE ? 'true' : 'false');
				break;
			}
				
			$jsonObject[] = '\'' . $propertyName . '\': ' . $propertyValue;

			// Do post function
			if ($postFunction !== NULL && is_callable(array($object, $postFunction))) {
				$propertyValue = call_user_func(array($object, $postFunction));
			}
		}

		// Load this settings and get debug mode.
		if (self::$debugMode === NULL && ($settings = Tx_AdGoogleMaps_Utility_BackEnd::getTypoScriptSetup($GLOBALS['TSFE']->id, 'tx_adgooglemaps')) !== FALSE) {
			self::$debugMode = (boolean) $settings['plugin']['debugMode'];
		}

		if (self::$debugMode === TRUE) {
			return '{ ' . LF . str_repeat(TAB, $level + 1) . implode(',' . LF . str_repeat(TAB, $level + 1), $jsonObject) . LF . str_repeat(TAB, $level) . ' }';
		} else {
			return '{ ' . implode(', ', $jsonObject) . ' }';
		}
	}

	/**
	 * Return class properties in JSON format.
	 *
	 * @param array $array
	 * @return string
	 */
	public static function getArrayAsJsonArray($array, $quoteArrayValuesRecursively = FALSE, $level = 0) {
		$jsonString = array();
		foreach ($array as $key => $value) {
			switch (TRUE) {
				case (is_array($value) === TRUE || $value instanceof ArrayAccess === TRUE):
					$jsonString[] = self::getArrayAsJsonArray($value, $level + 1);
				break;

				case (is_object($value) === TRUE):
					$jsonString[] = self::getClassAsJsonObject($value, $level + 1);
				break;

				case (is_bool($value) === TRUE):
					$jsonString[] = ($value === TRUE ? 'true' : 'false');
				break;

				case (is_numeric($value) === TRUE):
					$jsonString[] = $value;
				break;

				default:
					$jsonString[] = ($quoteArrayValuesRecursively === TRUE ? '\'' . $value . '\'' : $value);
				break;
			}
		}

		if (self::$debugMode === TRUE) {
			return '[ ' . LF . str_repeat(TAB, $level + 1) . implode(', ', $jsonString) . LF . str_repeat(TAB, $level) . ' ]';
		} else {
			return '[' . implode(', ', $jsonString) . ']';
		}
	}

}

?>