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
 * @subpackage AdGoogleMapsApi\ControlOptions\AbstractControlOptions
 * @scope prototype
 * @entity
 * @api
 */
abstract class Tx_AdGoogleMaps_Api_ControlOptions_AbstractControlOptions {

	/**
	 * ControlPosition
	 */
	const POSITION_TOP_CENTER = 'google.maps.ControlPosition.TOP_CENTER';
	const POSITION_TOP_RIGHT = 'google.maps.ControlPosition.TOP_RIGHT';
	const POSITION_RIGHT_CENTER = 'google.maps.ControlPosition.RIGHT_CENTER';
	const POSITION_BOTTOM_RIGHT = 'google.maps.ControlPosition.BOTTOM_RIGHT';
	const POSITION_BOTTOM_CENTER = 'google.maps.ControlPosition.BOTTOM_CENTER';
	const POSITION_BOTTOM_LEFT = 'google.maps.ControlPosition.BOTTOM_LEFT';
	const POSITION_LEFT_CENTER = 'google.maps.ControlPosition.LEFT_CENTER';
	const POSITION_TOP_LEFT = 'google.maps.ControlPosition.TOP_LEFT';

	/**
	 * @var string
	 * @jsonClassEncoder quoteValue = FALSE
	 */
	protected $position;

	/**
	 * Sets this position.
	 *
	 * @param string $position
	 * @return void
	 */
	public function setPosition($position) {
		$this->position = $position;
	}

	/**
	 * Returns this position.
	 *
	 * @return string
	 */
	public function getPosition() {
		return $this->position;
	}

}

?>