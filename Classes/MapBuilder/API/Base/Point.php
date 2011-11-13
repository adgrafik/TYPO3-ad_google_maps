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
class Tx_AdGoogleMaps_MapBuilder_API_Base_Point {

	/**
	 * @var integer
	 */
	protected $x;

	/**
	 * @var integer
	 */
	protected $y;

	/**
	 * Constructor.
	 * 
	 * @param integer $x
	 * @param integer $y
	 */
	public function __construct($x = NULL, $y = NULL) {
		$this->x = (integer) $x;
		$this->y = (integer) $y;
	}

	/**
	 * Sets this x.
	 *
	 * @param integer $x
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Base_Point
	 */
	public function setX($x) {
		$this->x = (integer) $x;
		return $this;
	}

	/**
	 * Returns this x.
	 *
	 * @return integer
	 */
	public function getX() {
		return (integer) $this->x;
	}

	/**
	 * Sets this y.
	 *
	 * @param integer $y
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Base_Point
	 */
	public function setY($y) {
		$this->y = (integer) $y;
		return $this;
	}

	/**
	 * Returns this y.
	 *
	 * @return integer
	 */
	public function getY() {
		return (integer) $this->y;
	}

	/**
	 * Returns the marker image as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrint() {
		return (($this->x > 0 || $this->y > 0) ? sprintf('new google.maps.Point(%d, %d)', $this->x, $this->y) : 'null');
	}

	/**
	 * Returns the marker image as JavaScript string.
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getPrint();
	}

}

?>