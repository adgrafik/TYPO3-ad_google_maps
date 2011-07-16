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
class Tx_AdGoogleMaps_Api_Base_Bounds {

	/**
	 * @var Tx_AdGoogleMaps_Api_Base_LatLng
	 */
	protected $southWest;

	/**
	 * @var Tx_AdGoogleMaps_Api_Base_LatLng
	 */
	protected $northEast;

	/*
	 * Constructor.
	 * 
	 * @param mixed $southWest
	 * @param float $northEast
	 */
	public function __construct($southWest = NULL, $northEast = NULL) {
		$this->southWest = $southWest;
		$this->northEast = $northEast;
	}

	/**
	 * Sets this southWest.
	 *
	 * @param Tx_AdGoogleMaps_Api_Base_LatLng $southWest
	 * @return void
	 */
	public function setSouthWest(Tx_AdGoogleMaps_Api_Base_LatLng $southWest) {
		$this->southWest = $southWest;
	}

	/**
	 * Returns this southWest.
	 *
	 * @return Tx_AdGoogleMaps_Api_Base_LatLng
	 */
	public function getSouthWest() {
		return $this->southWest;
	}

	/**
	 * Sets this northEast.
	 *
	 * @param Tx_AdGoogleMaps_Api_Base_LatLng $northEast
	 * @return void
	 */
	public function setNorthEast(Tx_AdGoogleMaps_Api_Base_LatLng $northEast) {
		$this->northEast = $northEast;
	}

	/**
	 * Returns this northEast.
	 *
	 * @return Tx_AdGoogleMaps_Api_Base_LatLng
	 */
	public function getNorthEast() {
		return $this->northEast;
	}

	/**
	 * Extend google maps bound with given lat lng.
	 * 
	 * @param Tx_AdGoogleMaps_Api_Base_LatLng $latLng
	 * @return void
	 */
	public function extend(Tx_AdGoogleMaps_Api_Base_LatLng $latLng) {
		if ($this->southWest === NULL) {
			$this->southWest = clone $latLng;
			$this->northEast = clone $latLng;
		}
		if ($latLng->getLatitude()  > $this->southWest->getLatitude())  $this->southWest->setLatitude($latLng->getLatitude());
		if ($latLng->getLongitude() < $this->southWest->getLongitude()) $this->southWest->setLongitude($latLng->getLongitude());
		if ($latLng->getLatitude()  < $this->northEast->getLatitude())  $this->northEast->setLatitude($latLng->getLatitude());
		if ($latLng->getLongitude() > $this->northEast->getLongitude()) $this->northEast->setLongitude($latLng->getLongitude());
	}

	/**
	 * Returns the LatLngBounds as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrint() {
		$southWest = (string) $this->southWest;
		$northEast = (string) $this->northEast;
		return (($southWest !== 'null' && $northEast !== 'null') ? sprintf('new google.maps.LatLngBounds(%s, %s)', $southWest, $northEast) : 'null');
	}

	/**
	 * Returns the LatLngBounds as JavaScript string.
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getPrint();
	}

}

?>