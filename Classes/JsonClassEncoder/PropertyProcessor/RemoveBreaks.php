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
class Tx_AdGoogleMaps_JsonClassEncoder_PropertyProcessor_RemoveBreaks extends Tx_AdGoogleMaps_JsonClassEncoder_PropertyProcessor_AbstractPropertyProcessor {

	/**
	 * Render the property value.
	 *
	 * @param string $optionValue
	 * @param mixed $object
	 * @param string $propertyType
	 * @param string $propertyName
	 * @param mixed $propertyValue
	 * @return mixed
	 */
	public function getPropertyValue($optionValue, $object, $propertyType, $propertyName, $propertyValue) {
		if ($this->getBooleanValue($optionValue) === TRUE) {
			// Remove breaks.
			$propertyValue = str_replace(array(LF, CR, CRLF), '', $propertyValue);
		}
		return $propertyValue;
	}

}

?>