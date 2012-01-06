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
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_AdGoogleMaps_Service_TypoScriptParser_Parser {

	/**
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @var Tx_Extbase_Reflection_Service
	 */
	protected $reflectionService;

	/**
	 * @var Tx_AdGoogleMaps_Utility_FrontEnd
	 */
	protected $frontEndUtility;

	/**
	 * @var tslib_cObj
	 */
	protected $contentObject;

	/**
	 * @var array
	 */
	protected $settingPath;

	/**
	 * @var array
	 */
	protected $data;

	/**
	 * @var string
	 */
	protected $table;

	/**
	 * Constructor.
	 * 
	 * @param array $data
	 * @param string $tableName
	 */
	public function __construct(array $data = array(), $tableName = '') {
		$this->data = $data;
		$this->tableName = $tableName;
	}

	/**
	 * Injects this objectManager.
	 *
	 * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
	 * @return void
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * Injects this reflectionService.
	 *
	 * @param Tx_Extbase_Reflection_Service $reflectionService
	 * @return void
	 */
	public function injectReflectionService(Tx_Extbase_Reflection_Service $reflectionService) {
		$this->reflectionService = $reflectionService;
	}

	/**
	 * Injects this frontEndUtility.
	 *
	 * @param Tx_AdGoogleMaps_Utility_FrontEnd $frontEndUtility
	 * @return void
	 */
	public function injectFrontEndUtility(Tx_AdGoogleMaps_Utility_FrontEnd $frontEndUtility) {
		$this->frontEndUtility = $frontEndUtility;
	}

	/**
	 * Injects this content object.
	 *
	 * @param tslib_cObj $contentObject
	 * @return void
	 */
	public function injectContentObject(tslib_cObj $contentObject) {
		$this->contentObject = $contentObject;
	}

	/**
	 * Append part to this settingPath.
	 *
	 * @param string $settingPath
	 * @return Tx_AdGoogleMaps_Service_TypoScriptParser_Parser
	 */
	public function setSettingPath($settingPath) {
		$this->settingPath[] = $settingPath;
		return $this;
	}

	/**
	 * Parse given settings array with the stdWrap-function recursively.
	 *
	 * @param mixed $object
	 * @param mixed $settings
	 * @return void
	 * @throws Tx_AdGoogleMaps_Exception
	 */
	public function objectInjection($object, $settings) {

		if (!is_object($object)) {
			throw new Tx_AdGoogleMaps_Exception(sprintf('First Argument must be an object, "%s" given in "Tx_AdGoogleMaps_Utility_FrontEnd->objectInjection()". Setting path: %s', gettype($object), $this->getSettingPath()), 1321778968);
		}

#print_r('objectTypoScriptInjection: '.$this->getSettingPath().LF);
		$propertyNames = $this->reflectionService->getClassPropertyNames(get_class($object));
		foreach ($propertyNames as $propertyName) {

			// Merge with settings, settings overrule data. If no settings or data set, nothing else to do.
			if (isset($settings[$propertyName])) {
				$propertySettings = $settings[$propertyName];
			} else if (isset($this->data[$propertyName])) {
				$propertySettings = $this->data[$propertyName];
			} else {
				continue;
			}

			$typeInfo = $this->objectManager->create('Tx_AdGoogleMaps_Service_TypoScriptParser_TypeInfo', $this)
				->parsePropertyType($object, $propertyName, $settings[$propertyName]);

			$propertyValue = $this->parseValue($typeInfo, $propertyName, $propertySettings);

			Tx_AdGoogleMaps_Utility_BackEnd::setPropertyValue($object, $propertyName, $propertyValue);
		}
	}

	/**
	 * Parse value.
	 *
	 * @param array $typeInfo
	 * @param string $propertyName
	 * @param mixed $settings
	 * @return mixed
	 * @throws Tx_AdGoogleMaps_Exception
	 */
	protected function parseValue($typeInfo, $propertyName, &$settings) {

		$this->appendSettingPath($propertyName);

#print_r('parseValue: '.$this->getSettingPath().LF);
		$type = $typeInfo->getType();
#print_r('- $type: '.$type.LF);
		$propertyValue = NULL;

		switch (TRUE) {

			case $type == 'array':
			case ($type == 'ArrayObject'):
				$propertyValue = $this->parseArrayValue($settings);
				break;

			case ($type == 'SplObjectStorage'):
			case ($type == 'Tx_Extbase_Persistence_ObjectStorage'):
				$propertyValue = $this->parseObjectStorageValue($typeInfo, $settings);
				break;

			case class_exists($type):
				$propertyValue = $this->instanceObject($type, $settings);
				break;

			default:
				$propertyValue = $this->frontEndUtility->parseSdtWrap($settings, $this->data, $this->table);
				break;
		}

		$this->popSettingPath();

		return $propertyValue;
	}

	/**
	 * Parse given settings array with the stdWrap-function.
	 *
	 * @param mixed $settings
	 * @return array
	 */
	protected function parseArrayValue(&$settings) {

#print_r('parseArrayValue: '.$this->getSettingPath().LF);
		$splitChar = $this->getSplitChar($settings);

		if (isset($settings['_typoScriptNodeValue'])) {
			$value = $this->frontEndUtility->parseSdtWrap($settings, $this->data, $this->tableName);
		} else {
			$value = $settings;
		}

		// Property value can now be an array or a string. If it's a string split by the split char.
		if (!is_array($value)) {
			$value = Tx_Extbase_Utility_Arrays::trimExplode($splitChar, $value);
		}

		return $value;
	}

	/**
	 * Parse given settings array with the stdWrap-function recursively.
	 *
	 * @param array $typeInfo
	 * @param mixed $settings
	 * @return mixed
	 */
	protected function parseObjectStorageValue($typeInfo, &$settings) {

#print_r('parseObjectStorageValue: '.$this->getSettingPath().LF);
		if (isset($settings['defaults'])) {
			$defaults = $settings['defaults'];
			unset($settings['defaults']);
		}

		// Return NULL if there are no objects to instantiate.
		if (!count($settings)) {
			return NULL;
		}

		// Create object storage only if property is NULL.
		$propertyValue = $typeInfo->getPropertyValue();
		if ($propertyValue === NULL) {
			$className = $typeInfo->getType();
			$propertyValue = $this->objectManager->create($className);
		}

		$elementClassName = $typeInfo->getElementType();

		foreach ($settings as $key => $objectSettings) {

			$this->appendSettingPath($key);

			$className = $this->getClassName($objectSettings, $elementClassName);

			// Merge default settings with object settings.
			if (isset($defaults[$className])) {
				$objectSettings = Tx_Extbase_Utility_Arrays::arrayMergeRecursiveOverrule($defaults[$className], $objectSettings);
			}

#print_r('- foreach $settings: '.$this->getSettingPath().LF);
#print_r('- $objectSettings: '.print_r($objectSettings, true).LF);
			// If object already exists parse it with objectInjection else instance it.
			$object = $this->instanceObject($className, $objectSettings);
			if (isset($propertyValue[$object]) && is_object($propertyValue[$object])) {
				$this->objectInjection($propertyValue[$object], $objectSettings);
			} else {
				$propertyValue->attach($object);
			}

			unset($settings[$key]);
			$this->popSettingPath();
		}

#print_r('- $propertyValue: '.print_r($propertyValue, true).LF);
		return $propertyValue;
	}

	/**
	 * Returns the type of given property name. Default is string if no type found.
	 *
	 * @param string $className
	 * @param mixed $settings
	 * @return mixed
	 */
	protected function instanceObject($className, &$settings) {

#print_r('instanceObject: '.$this->getSettingPath().LF);
		$className = $this->getClassName($settings, $className);
#print_r('- $className: '.$className.LF);

		$parameters = array(
			$className,
		);

		// If a constructor exists get parameter values.
		$parameterInfos = method_exists($className, '__construct') 
			? $this->reflectionService->getMethodParameters($className, '__construct') 
			: array();

		foreach ($parameterInfos as $parameterName => $parameterInfo) {

			$typeInfo = $this->objectManager->create('Tx_AdGoogleMaps_Service_TypoScriptParser_TypeInfo', $this)
				->parseParameterType($parameterName, $parameterInfo, $settings[$parameterName]);
			// If parameter is required and no configuration found throw exception.
			if (!$typeInfo->parameterIsOptional() && !$typeInfo->parameterAllowsNull() && !isset($settings[$parameterName])) {
				throw new Tx_AdGoogleMaps_Exception(sprintf('Required parameter "%s" of "%s::__construct()" not defined in the settings. Setting path: %s', $parameterName, $className, $this->getSettingPath()), 1321196285);
			}

			$parameterValue = $this->parseValue($typeInfo, $parameterName, $settings[$parameterName]);
			if ($parameterValue === NULL) {
				if (!$typeInfo->parameterAllowsNull()) {
					throw new Tx_AdGoogleMaps_Exception(sprintf('Parameter "%s" of "%s::__construct()" don\'t allow NULL values. Setting path: %s', $parameterName, $className, $this->getSettingPath()), 1321196309);
				} else if ($typeInfo->parameterHasDefaultValue()) {
					$parameterValue = $typeInfo->getParametersDefaultValue();
				}
			}

			// Unset parameter configuration after get value to prevent double parsing with object TypoScript injection.
			unset($settings[$parameterName]);

			$parameters[] = $parameterValue;
		}

#print_r('- $parameters: '.print_r($parameters, true).LF);
		$propertyValue = call_user_func_array(array($this->objectManager, 'create'), $parameters);

		if (is_object($propertyValue)) {
			$this->objectInjection($propertyValue, $settings);
		}

		return $propertyValue;
	}

	/**
	 * Parse given settings array with the stdWrap-function recursively.
	 *
	 * @param array $settings
	 * @return array
	 */
	public function parseSettingsWithSdtWrap(array $settings) {

		// Merge data with settings overrule settings.
		$settings = Tx_Extbase_Utility_Arrays::arrayMergeRecursiveOverrule($settings, $this->data);
		foreach ($settings as $key => $value) {
			if (is_array($value)) {
				if (array_key_exists('_typoScriptNodeValue', $value)) {
					$settings[$key] = $this->frontEndUtility->parseSdtWrap($value, $this->data, $this->table);
				} else {
					$settings[$key] = $this->parseSettingsWithSdtWrap($value);
				}
			}
		}

		return $settings;

	}

	/**
	 * If TypoScript node value is a class name override the property type.
	 *
	 * @param mixed $settings
	 * @param string $default
	 * @return string
	 */
	protected function getClassName(&$settings, $default = '') {

		if (isset($settings['_typoScriptNodeValue']) && class_exists($settings['_typoScriptNodeValue'])) {
			$className = $settings['_typoScriptNodeValue'];
			unset($settings['_typoScriptNodeValue']);
		} else {
			$className = $default;
		}

		return $className;
	}

	/**
	 * Returns the split char.
	 *
	 * @param mixed $settings
	 * @return string
	 */
	protected function getSplitChar(&$settings) {

		$splitChar = ',';
		// Check if another split char is set.
		if (is_array($settings) && array_key_exists('splitChar', $settings)) {
			$splitChar = $settings['splitChar'];
			unset($settings['splitChar']);
		}

		return $splitChar;
	}

	/**
	 * Append part to this settingPath.
	 *
	 * @param string $settingPath
	 * @return void
	 */
	protected function appendSettingPath($settingPath) {
		if ($settingPath !== '') {
			$this->settingPath[] = $settingPath;
		}
	}

	/**
	 * Pops the last part of this settingPath.
	 *
	 * @return void
	 */
	protected function popSettingPath() {
		array_pop($this->settingPath);
	}

	/**
	 * Returns this settingPath.
	 *
	 * @return array
	 */
	protected function getSettingPath() {
		return implode('.', $this->settingPath);
	}

}

?>