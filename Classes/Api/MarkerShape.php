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
 * @subpackage GoogleMapsAPI\MarkerImage
 * @scope prototype
 * @entity
 * @api
 */
class Tx_AdGoogleMaps_Api_MarkerShape {

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var array
	 */
	protected $coords;

	/*
	 * Constructor.
	 * 
	 * @param string $type
	 * @param array $coords
	 */
	public function __construct($type, $coords) {
		$this->type = $type;
		$this->coords = $coords;
	}

	/**
	 * Sets this type.
	 *
	 * @param string $type
	 * @return Tx_AdGoogleMaps_Api_MarkerShape
	 * @throw Tx_AdGoogleMaps_Exception
	 */
	public function setType($type) {
		if (in_array($shape, array('', 'circle', 'poly', 'rect')) === FALSE) {
			throw new Tx_AdGoogleMaps_Exception('Invalid parameter value for Tx_AdGoogleMaps_Api_MarkerShape::setType(), "' . $type . '" given', 1294069168);
		}
		$this->type = $type;
		return $this;
	}

	/**
	 * Returns this type.
	 *
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Sets this coords.
	 *
	 * @param array $coords
	 * @return Tx_AdGoogleMaps_Api_MarkerShape
	 */
	public function setCoords($coords) {
		$this->coords = $coords;
		return $this;
	}

	/**
	 * Returns this coords.
	 *
	 * @return array
	 */
	public function getCoords() {
		return $this->coords;
	}

	/**
	 * Returns the marker image as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrint() {
		return (($this->type !== '' && count($this->coords) > 0) ? sprintf('{ \'type\': \'%s\' }', $this->type, '[' . implode('], [', $this->coords) . ']') : 'null');
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