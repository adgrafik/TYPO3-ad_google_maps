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
class Tx_AdGoogleMaps_Service_JSONConverter_Converter implements t3lib_Singleton {

	/**
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	protected $reflectionService;

	/**
	 * @var array
	 */
	protected $defaultPropertyProcessors = array(
		'ignorePropertyIfValueIs' => array( NULL ),
	);

	/**
	 * @var boolean
	 */
	protected $debug;

	/**
	 * Injects this object manager.
	 *
	 * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
	 * @return void
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * Injects the reflection service.
	 *
	 * @param Tx_Extbase_Reflection_Service $reflectionService
	 * @return void
	 */
	public function injectReflectionService(Tx_Extbase_Reflection_Service $reflectionService) {
		$this->reflectionService = $reflectionService;
	}

	/**
	 * Sets this defaultPropertyProcessors.
	 *
	 * @param array $defaultPropertyProcessors
	 * @return void
	 */
	public function setDefaultPropertyProcessors(array $defaultPropertyProcessors) {
		$this->defaultPropertyProcessors = $defaultPropertyProcessors;
	}

	/**
	 * Gets this defaultPropertyProcessors.
	 *
	 * @return array
	 */
	public function getDefaultPropertyProcessors() {
		return $this->defaultPropertyProcessors;
	}

	/**
	 * Sets this debug.
	 *
	 * @param boolean $debug
	 * @return void
	 */
	public function setDebug($debug) {
		$this->debug = (boolean) $debug;
	}

	/**
	 * Gets this debug.
	 *
	 * @return boolean
	 */
	public function isDebug() {
		return (boolean) $this->debug;
	}

	/**
	 * Return class as JSON object.
	 *
	 * @param mixed $object
	 * @param array $propertyProcessors
	 * @param integer $level
	 * @return string
	 * @throw Tx_AdGoogleMaps_Service_JSONConverter_Exception_ResloverNotFound
	 */
	public function encode($object, $propertyProcessors = array(), $level = 0) {
		$json = array();
		$classReflection = $this->objectManager->create('Tx_Extbase_Reflection_ClassReflection', $object);

		foreach ($classReflection->getProperties() as $propertyReflection) {
			$propertyName = $propertyReflection->getName();
			$property = array(
				'type' => 'string',
				'name' => $propertyName,
				'value' => $this->getPropertyValue($object, $propertyName),
			);
			if ($propertyReflection->isTaggedWith('var')) {
				$tagValues = $propertyReflection->getTagValues('var');
				$property['type'] = $tagValues[0];
			}

			$allPropertyProcessors = $this->resolvePropertyProcessors($propertyProcessors, $property['type'], $propertyReflection);

			if (is_array($property['value']) === TRUE || $property['value'] instanceof ArrayAccess === TRUE) {
				$property['value'] = $this->encodeArray($property['value'], $allPropertyProcessors, $level + 1);
			} else {
				$ignoreProperty = $this->executePropertyProcessors($level, $allPropertyProcessors, $object, $property);
				if ($ignoreProperty === TRUE) {
					continue;
				}
			}

			$json[] = sprintf('\'%s\': %s', $property['name'], $property['value']);
		}

		if ($this->isDebug() === TRUE) {
			return '{' . LF . str_repeat(TAB, $level + 1) . implode(',' . LF . str_repeat(TAB, $level + 1), $json) . LF . str_repeat(TAB, $level) . '}';
		} else {
			return '{' . implode(',', $json) . '}';
		}
	}

	/**
	 * Return array as JSON format.
	 *
	 * @param array $propertyProcessors
	 * @return string
	 */
	public function encodeArray($array, $propertyProcessors, $level = 0) {
		$json = array();
		foreach ($array as $key => $value) {
			if (is_array($value) === TRUE || $value instanceof ArrayAccess === TRUE) {
				$value = $this->encodeArray($value, $propertyProcessors, $level + 1);
			}

			// Process property value resolvers.
			$property = array(
				'type' => gettype($value),
				'name' => NULL,
				'value' => &$value,
			);
			$ignoreProperty = $this->executePropertyProcessors($level, $propertyProcessors, $array, $property);
			if ($ignoreProperty === TRUE) {
				continue;
			}

			$json[] = $value;
		}

		if ($this->isDebug() === TRUE) {
			return '[' . LF . str_repeat(TAB, $level + 1) . implode(',' . LF . str_repeat(TAB, $level + 1), $json) . LF . str_repeat(TAB, $level) . ']';
		} else {
			return '[' . implode(', ', $json) . ']';
		}
	}

	/**
	 * Resolve the property processors.
	 *
	 * @param array $propertyProcessors
	 * @param string $propertyType
	 * @param Tx_Extbase_Reflection_PropertyReflection $propertyReflection
	 * @return boolean
	 */
	protected function resolvePropertyProcessors(array $propertyProcessors, $propertyType, Tx_Extbase_Reflection_PropertyReflection $propertyReflection) {
		// Add default option processors to string values.
		$propertyProcessors = $this->getDefaultPropertyProcessors();
		if ($propertyType === 'string') {
			$propertyProcessors['removeBreaks'] = array(TRUE);
			$propertyProcessors['escapeSlashes'] = array(TRUE);
			$propertyProcessors['quoteValue'] = array(TRUE);
		}

		// Get json parsers.
		if ($propertyReflection->isTaggedWith('jsonConverter') === TRUE) {

			$processors = $propertyReflection->getTagValues('jsonConverter');
			foreach ($processors as $option) {
				preg_match('/^([a-z]*)(\s*\(\s*(.*)\s*\))?$/i', $option, $matches);
				$propertyProcessorName = $matches[1];
				$propertyProcessorParameters = array();

				if (array_key_exists(3, $matches) === TRUE) {
					$propertyProcessorParameters = Tx_Extbase_Utility_Arrays::trimExplode(',', $matches[3]);
				}

				// Do reserved values.
				foreach ($propertyProcessorParameters as &$propertyProcessorParameter) {
					switch ($propertyProcessorParameter) {
						case 'NULL':
							$propertyProcessorParameter = NULL;
						break;
						case 'TRUE':
							$propertyProcessorParameter = TRUE;
						break;
						case 'FALSE':
							$propertyProcessorParameter = FALSE;
						break;
					}
				}

				$propertyProcessors[$propertyProcessorName] = $propertyProcessorParameters;
			}
		}

		return $propertyProcessors;
	}

	/**
	 * Processing the property values.
	 *
	 * @param integer $level
	 * @param array $propertyProcessors
	 * @param mixed $object
	 * @param array $property
	 * @return boolean
	 * @throw Tx_AdGoogleMaps_Service_JSONConverter_Exception_ResloverNotFound
	 */
	protected function executePropertyProcessors($level, $propertyProcessors, $object, &$property) {
		foreach ($propertyProcessors as $optionName => $optionValue) {
			// Try default property processor.
			$processorClassName = 'Tx_AdGoogleMaps_Service_JSONConverter_PropertyProcessor_' . ucfirst($optionName);
			if (class_exists($processorClassName) === FALSE) {
				// Try custom property processor.
				$processorClassName = $optionName;
				if (class_exists($processorClassName) === FALSE) {
					throw new Tx_AdGoogleMaps_Service_JSONConverter_Exception_ResloverNotFound(sprintf('Reslover "%s" not found.', $processorClassName), 1308921991);
				}
			}

			$optionProcessor = $this->objectManager->create($processorClassName);
			$optionProcessor->parseProperty($optionValue, $object, $property);
			if ($optionProcessor->isIgnoreProperty() === TRUE) {
				return TRUE;
			}
		}

		if (is_object($property['value']) === TRUE) {
			// Parse recursive if property value is an object.
			$property['value'] = $this->encode($property['value'], $propertyProcessors, $level + 1);
		}

		// Post process values.
		switch ($property['type']) {
			case 'boolean':
				$property['value'] = ($property['value'] === TRUE ? 'true' : 'false');
			break;
		}

		return FALSE;
	}

	/**
	 * Returns the value of given object and property name.
	 *
	 * @param mixed $object
	 * @param string $propertyName
	 * @return string
	 */
	protected function getPropertyValue($object, $propertyName) {
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
		return $propertyValue;
	}

}

?>