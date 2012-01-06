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
class Tx_AdGoogleMaps_Service_JSONConverter_PropertyProcessor_IgnorePropertyIfValueIs extends Tx_AdGoogleMaps_Service_JSONConverter_PropertyProcessor_AbstractPropertyProcessor {

	/**
	 * Render the property value.
	 *
	 * @param array $parameters
	 * @param mixed $object
	 * @param array $property
	 * @return mixed
	 */
	public function parseProperty(array $parameters, $object, &$property) {
		// If required parameters not set, nothing else to too.
		if (count($parameters) === 0) {
			return ;
		}

		// Get comparable property of object if set.
		if (strpos($parameters[0], '$') === 0) {
			$propertyName = substr($parameters[0], 1);
			$propertyValue = Tx_AdGoogleMaps_Utility_BackEnd::getPropertyValue($object, $propertyName);
			array_shift($parameters);
		} else {
			$propertyValue = $property['value'];
		}

		// Get compare value of object if set, else use the second parameter.
		if (strpos($parameters[0], '$') === 0) {
			$compareValue = Tx_AdGoogleMaps_Utility_BackEnd::getPropertyValue($object, $parameters[0]);
		} else {
			$compareValue = $parameters[0];
		}

		$ignoreProperty = ($propertyValue == $compareValue);
		$this->setIgnoreProperty($ignoreProperty);
	}

}

?>