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
abstract class Tx_AdGoogleMaps_Service_JSONConverter_PropertyProcessor_AbstractPropertyProcessor implements Tx_AdGoogleMaps_Service_JSONConverter_PropertyProcessor_PropertyProcessorInterface {

	/**
	 * @var boolean
	 */
	protected $ignoreProperty;

	/**
	 * Initialize this object.
	 *
	 * @return void
	 */
	public function initializeObject() {
		$this->setIgnoreProperty(FALSE);
	}

	/**
	 * Render the property value.
	 *
	 * @param array $parameters
	 * @param mixed $object
	 * @param array $property
	 * @return mixed
	 */
	abstract public function parseProperty(array $parameters, $object, &$property);

	/**
	 * Sets this ignoreProperty.
	 *
	 * @param boolean $ignoreProperty
	 * @return void
	 */
	public function setIgnoreProperty($ignoreProperty) {
		$this->ignoreProperty = (boolean) $ignoreProperty;
	}

	/**
	 * Returns this ignoreProperty.
	 *
	 * @return boolean
	 */
	public function isIgnoreProperty() {
		return (boolean) $this->ignoreProperty;
	}

}

?>