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
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @package AdGoogleMaps
 */
class Tx_AdGoogleMaps_Api_Base_LatLngArray {

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Api_Base_LatLng>
	 */
	protected $latLngArray;

	/*
	 * Constructor.
	 * $latLngArray can be 
	 * - a Tx_Extbase_Persistence_ObjectStorage of Tx_AdGoogleMaps_Api_Base_LatLng objects, 
	 * - or an array like "array('48.209206,16.372778', '48.209206,16.372778')". 
	 * 
	 * @param mixed $latLngArray
	 */
	public function __construct($latLngArray = NULL) {
		if ($latLngArray === NULL) return;
		$this->setLatLngArray($latLngArray);
	}

	/**
	 * Sets this latLngArray.
	 *
	 * @param mixed $latLngArray
	 * @return void
	 */
	public function setLatLngArray($latLngArray) {
		if ($latLngArray instanceof Tx_Extbase_Persistence_ObjectStorage) {
			$this->latLngArray = $latLngArray;
		} else if (is_array($latLngArray)) {
			$this->latLngArray = new Tx_Extbase_Persistence_ObjectStorage();
			foreach ($latLngArray as $latLng) {
				$this->addLatLng($latLng);
			}
		} else {
			throw new Tx_AdGoogleMaps_Exception('Invalid property value for Tx_AdGoogleMaps_Api_Base_LatLngArray::setLatLngArray().', 1294069158);
		}
	}

	/**
	 * Returns this latLngArray.
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Api_Base_LatLng>
	 */
	public function getLatLngArray() {
		return $this->latLngArray;
	}

	/**
	 * Adds a latLng to this latLngArray.
	 *
	 * @param mixed $latLng
	 * @return void
	 */
	public function addLatLng($latLng) {
		return $this->latLngArray->attach(new Tx_AdGoogleMaps_Api_Base_LatLng($latLng));
	}

	/**
	 * Removes a latLng of this latLngArray.
	 *
	 * @param Tx_AdGoogleMaps_Api_Base_LatLng $latLng
	 * @return void
	 */
	public function removeLatLng(Tx_AdGoogleMaps_Api_Base_LatLng $latLng) {
		return $this->latLngArray->detach($latLng);
	}

	/**
	 * Returns the MVCArray as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrint() {
		$latLngs = array();
		foreach ($this->latLngArray as $latLng) {
			$latLngs[] = (string) $latLng;
		}
		return (count($latLngs) > 0 ? sprintf('new google.maps.MVCArray(%s)', '[ ' . implode(', ', $latLngs) . ' ]') : 'null');
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