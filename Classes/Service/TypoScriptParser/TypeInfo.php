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
class Tx_AdGoogleMaps_Service_TypoScriptParser_TypeInfo {

	/**
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @var Tx_Extbase_Reflection_Service
	 */
	protected $reflectionService;

	/**
	 * @var Tx_AdGoogleMaps_Service_TypoScriptParser_Parser
	 */
	protected $typoScriptParser;

	/**
	 * @var mixed
	 */
	protected $object;

	/**
	 * @var string
	 */
	protected $propertyName;

	/**
	 * @var array
	 */
	protected $typeInfo;

	/**
	 * Constructor.
	 * 
	 * @param Tx_AdGoogleMaps_Service_TypoScriptParser_Parser $typoScriptParser
	 */
	public function __construct(Tx_AdGoogleMaps_Service_TypoScriptParser_Parser $typoScriptParser) {
		$this->typoScriptParser = $typoScriptParser;
	}

	/**
	 * Injects this objectManager.
	 *
	 * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
	 * @return void
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
#		$this->objectManager = $objectManager;
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
	 * Append part to this settingPath.
	 *
	 * @param string $settingPath
	 * @return void
	 */
	public function getClassName() {
		return is_object($this->object) ? get_class($this->object) : $this->object;
	}

	/**
	 * Returns this type.
	 *
	 * @return string
	 */
	public function getTypeInfo() {
		return $this->typeInfo;
	}

	/**
	 * Returns this type.
	 *
	 * @return string
	 */
	public function getType() {
		return $this->typeInfo['type'];
	}

	/**
	 * Returns FALSE if parameter allows not NULL values and is not optional.
	 *
	 * @return boolean
	 */
	public function parameterAllowsNull() {
		return ($this->typeInfo['optional'] || $this->typeInfo['allowsNull']);
	}

	/**
	 * Returns FALSE if parameter is not optional.
	 *
	 * @return boolean
	 */
	public function parameterIsOptional() {
		return $this->typeInfo['optional'];
	}

	/**
	 * Returns FALSE if parameter has no default value.
	 *
	 * @return boolean
	 */
	public function parameterHasDefaultValue() {
		return isset($this->typeInfo['defaultValue']);
	}

	/**
	 * Returns the parameters default value.
	 *
	 * @return mixed
	 */
	public function getParametersDefaultValue() {
		return $this->typeInfo['defaultValue'];
	}

	/**
	 * Returns this elementType.
	 *
	 * @return string
	 */
	public function getElementType() {
		return $this->typeInfo['elementType'];
	}

	/**
	 * Get defaults for objects if set and delete default settings.
	 *
	 * @return array
	 */
	public function getPropertyValue() {
		return Tx_AdGoogleMaps_Utility_BackEnd::getPropertyValue($this->object, $this->propertyName);
	}

	/**
	 * Parse given settings array with the stdWrap-function recursively.
	 *
	 * @param string $parameterName
	 * @param object $parameterInfo
	 * @param mixed $settings
	 * @return Tx_AdGoogleMaps_Service_TypoScriptParser_TypeInfo
	 * @throws Tx_AdGoogleMaps_Exception
	 */
	public function parseParameterType($parameterName, $parameterInfo, &$settings) {
#print_r('parseParameterType: '.LF);
#print_r('- $parameterName: '.print_r($parameterName, true).LF);
#print_r('- $settings: '.print_r($settings, true).LF);
		$this->propertyName = $parameterName;
		$this->typeInfo = $parameterInfo;

		$this->mergeTypeWithSettings($this->typeInfo['type'], $settings);
#print_r('- $parameterInfo: '.print_r($parameterInfo, true).LF);

		return $this;
	}

	/**
	 * Parse given settings array with the stdWrap-function recursively.
	 *
	 * @param object $object
	 * @param string $propertyName
	 * @param mixed $settings
	 * @return Tx_AdGoogleMaps_Service_TypoScriptParser_TypeInfo
	 * @throws Tx_AdGoogleMaps_Exception
	 */
	public function parsePropertyType($object, $propertyName, &$settings) {

		$className = get_class($object);
		$this->object = $object;
		$this->propertyName = $propertyName;

		$declaration = $this->reflectionService->getPropertyTagValues($className, $this->propertyName, 'var');
		$declaration = (count($declaration) > 0) 
			? $declaration[0] 
			: 'string';

		$this->mergeTypeWithSettings($declaration, $settings);

		try {
			$this->typeInfo = Tx_Extbase_Utility_TypeHandling::parseType($declaration);
		} catch (Exception $exception) {
			throw new Tx_AdGoogleMaps_Exception(sprintf('%s<br />Setting path: %s', $exception->getMessage(), $this->typoScriptParser->getSettingPath()), 1321178913);
		}

		// If elementType is set, than this property is an object storage. So sort settings by key.
		if ($this->typeInfo['elementType']) {
			ksort($settings);
		}

		return $this;
	}

	/**
	 * If TypoScript node value is a class name override the property type.
	 *
	 * @param string $type
	 * @param mixed $settings
	 */
	protected function mergeTypeWithSettings(&$type, &$settings) {

		// If TypoScript node value is a class name override the property type.
		if (isset($settings['_typoScriptNodeValue']) && class_exists($settings['_typoScriptNodeValue'])) {
			$type = $settings['_typoScriptNodeValue'];
			unset($settings['_typoScriptNodeValue']);
		}
	}

}

?>