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
 * @package Extbase
 * @subpackage GoogleMapsAPI\LatLng
 * @scope prototype
 * @entity
 * @api
 */
class Tx_AdGoogleMaps_Api_LatLng {

	/**
	 * Coordinates preg pattern.
	 */
	const COORDINATES_POINT_PATTERN = '/^-?\d+\.?\d*$/';
	const COORDINATES_SINGLE_PATTERN = '/^-?\d+\.?\d*\s*,\s*-?\d+\.?\d*$/';
	const COORDINATES_ARRAY_PATTERN = '/^(-?\d+\.?\d*\s*,\s*-?\d+\.?\d*\n?)*/';

	/**
	 * @var float
	 */
	protected $latitude;

	/**
	 * @var float
	 */
	protected $longitude;

	/**
	 * Returns TRUE if given coordinate string is valid.
	 *
	 * @param string $coordinate
	 * @return boolean
	 */
	public static function isValidPoint($coordinate) {
		return (preg_match(self::COORDINATES_POINT_PATTERN, $coordinate) !== 0);
	}

	/**
	 * Returns TRUE if given coordinate string is valid.
	 *
	 * @param string $coordinate
	 * @return boolean
	 */
	public static function isValidCoordinate($coordinate) {
		return (preg_match(self::COORDINATES_SINGLE_PATTERN, $coordinate) !== 0);
	}

	/**
	 * Returns TRUE if given coordinates array string is valid.
	 *
	 * @param string $coordinates
	 * @return boolean
	 */
	public static function isValidCoordinatesArray($coordinates) {
		return (preg_match(self::COORDINATES_ARRAY_PATTERN, $coordinates) !== 0);
	}

	/*
	 * Constructor.
	 * Use first parameter as a comma seperated location like "('48.209206,16.372778')", 
	 * or use both parameters like "(48.209206, 16.372778)". 
	 * 
	 * @param mixed $latitude
	 * @param float $longitude
	 */
	public function __construct($latitude, $longitude = NULL) {
		$this->setLatLng($latitude, $longitude);
	}

	/**
	 * Sets this latitude.
	 *
	 * @param float $latitude
	 * @return void
	 */
	public function setLatitude($latitude) {
		$this->latitude = (float) $latitude;
	}

	/**
	 * Returns this latitude.
	 *
	 * @return float
	 */
	public function getLatitude() {
		return (float) $this->latitude;
	}

	/**
	 * Sets this longitude.
	 *
	 * @param float $longitude
	 * @return void
	 */
	public function setLongitude($longitude) {
		$this->longitude = (float) $longitude;
	}

	/**
	 * Returns this longitude.
	 *
	 * @return float
	 */
	public function getLongitude() {
		return (float) $this->longitude;
	}

	/**
	 * Sets this latitude and longitude.
	 *
	 * @param mixed $latitude
	 * @param float $longitude
	 * @return void
	 */
	public function setLatLng($latitude, $longitude = NULL) {
		if ($longitude === NULL) {
			if (self::isValidCoordinate($latitude) === FALSE) {
				throw new Tx_AdGoogleMaps_Exception('Invalid property value for Tx_AdGoogleMaps_Api_LatLng::setLatLng ("' . $latitude . '") given.', 1294069148);
			}
			@list($latitude, $longitude) = t3lib_div::trimExplode(',', $latitude);
		} else if (self::isValidPoint($latitude) === FALSE || self::isValidPoint($longitude) === FALSE) {
			throw new Tx_AdGoogleMaps_Exception('Invalid property value for Tx_AdGoogleMaps_Api_LatLng::setLatLng ("' . $latitude . ', ' . $longitude . '") given.', 1294069149);
		}
		$this->latitude = (float) $latitude;
		$this->longitude = (float) $longitude;
	}

	/**
	 * Returns the LatLng as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrint() {
		return sprintf('new google.maps.LatLng(%f, %f)', $this->latitude, $this->longitude);
	}

	/**
	 * Returns the LatLng as JavaScript string.
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getPrint();
	}

}

?>