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
class Tx_AdGoogleMaps_MapBuilder_API_Overlay_InfoWindow extends Tx_AdGoogleMaps_MapBuilder_API_Overlay_AbstractOverlay {
	
	/**
	 * @var Tx_AdGoogleMaps_MapBuilder_API_Base_LatLng
	 * @jsonClassEncoder useGetterMethod( getPrint )
	 * @jsonClassEncoder ignorePropertyIfValueIs( 'null' )
	 */
	protected $position;

	/**
	 * @var string
	 * @jsonClassEncoder
	 */
	protected $content;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs( FALSE )
	 */
	protected $disableAutoPan;

	/**
	 * @var integer
	 * @jsonClassEncoder ignorePropertyIfValueIs( 0 )
	 */
	protected $maxWidth;

	/**
	 * @var Tx_AdGoogleMaps_MapBuilder_API_Base_Size
	 * @jsonClassEncoder useGetterMethod( getPrint )
	 * @jsonClassEncoder ignorePropertyIfValueIs( 'null' )
	 */
	protected $pixelOffset;

	/**
	 * @var integer
	 * @jsonClassEncoder ignorePropertyIfValueIs( 0 )
	 */
	protected $zindex;

	/**
	 * Constructor.
	 * 
	 * @param array $options
	 * @throws Tx_AdGoogleMaps_MapBuilder_API_Exception
	 */
	public function __construct(array $options = array()) {
		$this->mergeOptionsWithObject($options);

		// Check required attibutes.
		if ($this->content === NULL) {
			throw new Tx_AdGoogleMaps_MapBuilder_API_Exception(sprintf('Required attribute "%s" not set.', 'content'), 1311314743);
		}
	}

	/**
	 * Sets this position.
	 *
	 * @param Tx_AdGoogleMaps_MapBuilder_API_Base_LatLng $position
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_InfoWindow
	 */
	public function setPosition(Tx_AdGoogleMaps_MapBuilder_API_Base_LatLng $position) {
		$this->position = $position;
		return $this;
	}

	/**
	 * Returns this position.
	 *
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Base_LatLng
	 */
	public function getPosition() {
		return $this->position;
	}

	/**
	 * Sets this content.
	 *
	 * @param string $content
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_InfoWindow
	 */
	public function setContent($content) {
		$this->content = $content;
		return $this;
	}

	/**
	 * Returns this content.
	 *
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Sets this disableAutoPan.
	 *
	 * @param boolean $disableAutoPan
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_InfoWindow
	 */
	public function setDisableAutoPan($disableAutoPan) {
		$this->disableAutoPan = (boolean) $disableAutoPan;
		return $this;
	}

	/**
	 * Returns this disableAutoPan.
	 *
	 * @return boolean
	 */
	public function isDisableAutoPan() {
		return (boolean) $this->disableAutoPan;
	}

	/**
	 * Sets this maxWidth.
	 *
	 * @param integer $maxWidth
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_InfoWindow
	 */
	public function setMaxWidth($maxWidth) {
		$this->maxWidth = (integer) $maxWidth;
		return $this;
	}

	/**
	 * Returns this maxWidth.
	 *
	 * @return integer
	 */
	public function getMaxWidth() {
		return (integer) $this->maxWidth;
	}

	/**
	 * Sets this pixelOffset.
	 *
	 * @param Tx_AdGoogleMaps_MapBuilder_API_Base_Size $pixelOffset
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_InfoWindow
	 */
	public function setPixelOffset(Tx_AdGoogleMaps_MapBuilder_API_Base_Size $pixelOffset) {
		$this->pixelOffset = $pixelOffset;
		return $this;
	}

	/**
	 * Returns this pixelOffset.
	 *
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Base_Size
	 */
	public function getPixelOffset() {
		return $this->pixelOffset;
	}

	/**
	 * Sets this zindex.
	 *
	 * @param integer $zindex
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_InfoWindow
	 */
	public function setZindex($zindex) {
		$this->zindex = (integer) $zindex;
		return $this;
	}

	/**
	 * Returns this zindex.
	 *
	 * @return integer
	 */
	public function getZindex() {
		return (integer) $this->zindex;
	}

	/**
	 * Returns the info window as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrint() {
		return 'new google.maps.InfoWindow(' . $this->getPrintOptions() . ')';
	}

}

?>