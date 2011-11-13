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
class Tx_AdGoogleMaps_MapBuilder_API_Overlay_MarkerImage {

	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @var Tx_AdGoogleMaps_MapBuilder_API_Base_Size
	 */
	protected $size;

	/**
	 * @var Tx_AdGoogleMaps_MapBuilder_API_Base_Point
	 */
	protected $origin;

	/**
	 * @var Tx_AdGoogleMaps_MapBuilder_API_Base_Point
	 */
	protected $anchor;

	/**
	 * @var Tx_AdGoogleMaps_MapBuilder_API_Base_Size
	 */
	protected $scaledSize;

	/**
	 * Constructor.
	 * 
	 * @param string $url
	 * @param Tx_AdGoogleMaps_MapBuilder_API_Base_Size $size
	 * @param Tx_AdGoogleMaps_MapBuilder_API_Base_Point $origin
	 * @param Tx_AdGoogleMaps_MapBuilder_API_Base_Point $anchor
	 * @param Tx_AdGoogleMaps_MapBuilder_API_Base_Size $scaledSize
	 */
	public function __construct($url, Tx_AdGoogleMaps_MapBuilder_API_Base_Size $size = NULL, Tx_AdGoogleMaps_MapBuilder_API_Base_Point $origin = NULL, Tx_AdGoogleMaps_MapBuilder_API_Base_Point $anchor = NULL, Tx_AdGoogleMaps_MapBuilder_API_Base_Size $scaledSize = NULL) {
		$this->url = $url;
		$this->size = $size;
		$this->origin = $origin;
		$this->anchor = $anchor;
		$this->scaledSize = $scaledSize;
	}

	/**
	 * Sets this url.
	 *
	 * @param string $url
	 * @return void
	 */
	public function setUrl($url) {
		$this->url = $url;
	}

	/**
	 * Returns this url.
	 *
	 * @return string
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * Sets this size.
	 *
	 * @param Tx_AdGoogleMaps_MapBuilder_API_Base_Size $size
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_MarkerImage
	 */
	public function setSize(Tx_AdGoogleMaps_MapBuilder_API_Base_Size $size) {
		$this->size = $size;
		return $this;
	}

	/**
	 * Returns this size.
	 *
	 * @return integer
	 */
	public function getSize() {
		return $this->size;
	}

	/**
	 * Sets this origin.
	 *
	 * @param Tx_AdGoogleMaps_MapBuilder_API_Base_Point $origin
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_MarkerImage
	 */
	public function setOrigin(Tx_AdGoogleMaps_MapBuilder_API_Base_Point $origin) {
		$this->origin = $origin;
		return $this;
	}

	/**
	 * Returns this origin.
	 *
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Base_Point
	 */
	public function getOrigin() {
		return $this->origin;
	}

	/**
	 * Sets this anchor.
	 *
	 * @param Tx_AdGoogleMaps_MapBuilder_API_Base_Point $anchor
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_MarkerImage
	 */
	public function setAnchor(Tx_AdGoogleMaps_MapBuilder_API_Base_Point $anchor) {
		$this->anchor = $anchor;
		return $this;
	}

	/**
	 * Returns this anchor.
	 *
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Base_Point
	 */
	public function getAnchor() {
		return $this->anchor;
	}

	/**
	 * Sets this scaledSize.
	 *
	 * @param Tx_AdGoogleMaps_MapBuilder_API_Base_Size $scaledSize
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_MarkerImage
	 */
	public function setScaledSize($scaledSize) {
		$this->scaledSize = $scaledSize;
		return $this;
	}

	/**
	 * Returns this scaledSize.
	 *
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Base_Size
	 */
	public function getScaledSize() {
		return $this->scaledSize;
	}

	/**
	 * Returns the marker image as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrint() {
		$url = ($this->url === NULL ? 'null' : $this->url);
		$size = ($this->size === NULL ? 'null' : $this->size);
		$origin = ($this->origin === NULL ? 'null' : $this->origin);
		$anchor = ($this->anchor === NULL ? 'null' : $this->anchor);
		$scaledSize = ($this->scaledSize === NULL ? 'null' : $this->scaledSize);
		return ($this->url !== '' ? sprintf('new google.maps.MarkerImage(\'%s\', %s, %s, %s, %s)', $url, $size, $origin, $anchor, $scaledSize) : 'null');
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