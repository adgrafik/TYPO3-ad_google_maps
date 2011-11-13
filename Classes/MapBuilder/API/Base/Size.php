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
class Tx_AdGoogleMaps_MapBuilder_API_Base_Size {

	/**
	 * @var integer
	 */
	protected $width;

	/**
	 * @var integer
	 */
	protected $height;

	/**
	 * @var string
	 */
	protected $widthUnit;

	/**
	 * @var string
	 */
	protected $heightUnit;

	/**
	 * Constructor.
	 * 
	 * @param integer $width
	 * @param integer $height
	 * @param string $widthUnit
	 * @param string $heightUnit
	 */
	public function __construct($width = NULL, $height = NULL, $widthUnit = '', $heightUnit = '') {
		$this->width = (integer) $width;
		$this->height = (integer) $height;
		$this->widthUnit = $widthUnit;
		$this->heightUnit = $heightUnit;
	}

	/**
	 * Sets this width.
	 *
	 * @param integer $width
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Base_Size
	 */
	public function setWidth($width) {
		$this->width = (integer) $width;
		return $this;
	}

	/**
	 * Returns this width.
	 *
	 * @return integer
	 */
	public function getWidth() {
		return (integer) $this->width;
	}

	/**
	 * Sets this height.
	 *
	 * @param integer $height
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Base_Size
	 */
	public function setHeight($height) {
		$this->height = (integer) $height;
		return $this;
	}

	/**
	 * Returns this height.
	 *
	 * @return integer
	 */
	public function getHeight() {
		return (integer) $this->height;
	}

	/**
	 * Sets this widthUnit.
	 *
	 * @param string $widthUnit
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Base_Size
	 */
	public function setWidthUnit($widthUnit) {
		$this->widthUnit = $widthUnit;
		return $this;
	}

	/**
	 * Returns this widthUnit.
	 *
	 * @return string
	 */
	public function getWidthUnit() {
		return $this->widthUnit;
	}

	/**
	 * Sets this heightUnit.
	 *
	 * @param string $heightUnit
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Base_Size
	 */
	public function setHeightUnit($heightUnit) {
		$this->heightUnit = $heightUnit;
		return $this;
	}

	/**
	 * Returns this heightUnit.
	 *
	 * @return string
	 */
	public function getHeightUnit() {
		return $this->heightUnit;
	}

	/**
	 * Returns the marker image as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrint() {
		if ($this->width > 0 || $this->height > 0) {
			if ($this->widthUnit !== '' || $this->heightUnit !== '') {
				return sprintf('new google.maps.Size(%d, %d, \'%s\', \'%s\')', $this->width, $this->height, $this->widthUnit, $this->heightUnit);
			} else {
				return sprintf('new google.maps.Size(%d, %d)', $this->width, $this->height);
			}
		} else {
			return 'null';
		}
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