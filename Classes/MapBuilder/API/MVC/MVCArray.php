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
 * Google Maps API class.
 * Nearly the same like the Google Maps API
 * @see http://code.google.com/apis/maps/documentation/javascript/reference.html
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @package AdGoogleMaps
 */
class Tx_AdGoogleMaps_MapBuilder_API_MVC_MVCArray {

	/**
	 * @var array
	 * @jsonClassEncoder ignoreProperty
	 */
	protected $items;

	/**
	 * Constructor.
	 * 
	 * @param mixed $items
	 * @throw Tx_AdGoogleMaps_Exception
	 */
	public function __construct($items = NULL) {
		if ($items !== NULL) {
			if (is_array($items) === FALSE && $items instanceof ArrayAccess === FALSE) {
				throw new Tx_AdGoogleMaps_Exception(sprintf('Type of items must be an array, "%s" given.', gettype($items)), 1310390365);
			}

			foreach ($items as $key => $value) {
				$this->items[$key] = $value;
			}
		}
	}

	/**
	 * Returns the MVCArray as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrint() {
		$items = array();
		foreach ($this->items as $value) {
			$items[] = $value;
		}
		return ($items > 0 ? sprintf('new google.maps.MVCArray(%s)', '[ ' . implode(', ', $items) . ' ]') : 'null');
	}

	/**
	 * Returns the MVCArray as JavaScript string.
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getPrint();
	}

}

?>