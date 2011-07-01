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
 * @subpackage GoogleMapsAPI\ControlOptions\Navigation
 * @scope prototype
 * @entity
 * @api
 */
class Tx_AdGoogleMaps_Api_ControlOptions_Navigation extends Tx_AdGoogleMaps_Api_ControlOptions_AbstractControlOptions {

	/**
	 * NavigationControlStyle
	 */
	const STYLE_DEFAULT = 'google.maps.NavigationControlStyle.DEFAULT';
	const STYLE_ANDROID = 'google.maps.NavigationControlStyle.ANDROID';
	const STYLE_SMALL = 'google.maps.NavigationControlStyle.SMALL';
	const STYLE_ZOOM_PAN = 'google.maps.NavigationControlStyle.ZOOM_PAN';

	/**
	 * @var string
	 * @javaScriptHelper quoteValue = FALSE
	 */
	protected $style;

	/*
	 * Constructor.
	 * 
	 * @param string $position
	 * @param string $style
	 */
	public function __construct($position = NULL, $style = NULL) {
		$this->setPosition($position === NULL ? self::POSITION_TOP_LEFT : $position);
		$this->setStyle($style === NULL ? self::STYLE_DEFAULT : $style);
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
		return ($this->position !== self::POSITION_TOP_LEFT || $this->style !== self::STYLE_DEFAULT);
	}

}

?>