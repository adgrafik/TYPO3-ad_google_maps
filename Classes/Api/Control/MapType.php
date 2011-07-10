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
class Tx_AdGoogleMaps_Api_Control_MapType extends Tx_AdGoogleMaps_Api_Control_AbstractControl {

	/**
	 * MapTypeId
	 */
	const MAPTYPEID_HYBRID = 'google.maps.MapTypeId.HYBRID';
	const MAPTYPEID_ROADMAP = 'google.maps.MapTypeId.ROADMAP';
	const MAPTYPEID_SATELLITE = 'google.maps.MapTypeId.SATELLITE';
	const MAPTYPEID_TERRAIN = 'google.maps.MapTypeId.TERRAIN';

	/**
	 * MapTypeControlStyle
	 */
	const STYLE_DEFAULT = 'google.maps.MapTypeControlStyle.DEFAULT';
	const STYLE_DROPDOWN_MENU = 'google.maps.MapTypeControlStyle.DROPDOWN_MENU';
	const STYLE_HORIZONTAL_BAR = 'google.maps.MapTypeControlStyle.HORIZONTAL_BAR';

	/**
	 * @var array
	 * @jsonClassEncoder quoteValue = FALSE
	 */
	protected $mapTypeIds;

	/**
	 * @var string
	 * @jsonClassEncoder quoteValue = FALSE
	 */
	protected $style;

	/*
	 * Constructor.
	 * 
	 * @param string $mapTypeIds
	 * @param string $position
	 * @param string $style
	 */
	public function __construct($mapTypeIds = NULL, $position = NULL, $style = NULL) {
		$this->setMapTypeIds($mapTypeIds === NULL ? self::STYLE_DEFAULT : $mapTypeIds);
		$this->setPosition($position === NULL ? self::POSITION_TOP_RIGHT : $position);
		$this->setStyle($style === NULL ? self::STYLE_DEFAULT : $style);
	}

	/**
	 * Sets this mapTypeIds.
	 *
	 * @param mixed $mapTypeIds
	 * @return void
	 */
	public function setMapTypeIds($mapTypeIds) {
		if (is_array($mapTypeIds) === FALSE) {
			$mapTypeIds = t3lib_div::trimExplode(',', $mapTypeIds);
		}
		$this->mapTypeIds = $mapTypeIds;
	}

	/**
	 * Returns this mapTypeIds.
	 *
	 * @return array
	 */
	public function getMapTypeIds() {
		return $this->mapTypeIds;
	}

	/**
	 * Sets this style.
	 *
	 * @param string $style
	 * @return void
	 */
	public function setStyle($style) {
		$this->style = $style;
	}

	/**
	 * Returns this style.
	 *
	 * @return string
	 */
	public function getStyle() {
		return $this->style;
	}

	/**
	 * Returns TRUE if one of the option have not a default value.
	 *
	 * @return string
	 */
	public function hasOptions() {
		return (count($this->mapTypeIds) || $this->position !== self::POSITION_TOP_RIGHT || $this->style !== self::STYLE_DEFAULT);
	}

}

?>