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
 * GoogleMaps class.
 *
 * @scope prototype
 * @api
 */
class Tx_AdGoogleMaps_Plugin_GoogleMaps {

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @var integer
	 */
	protected $mapId;

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
	protected $geocodeUrl;

	/**
	 * @var Tx_AdGoogleMaps_Plugin_Options
	 */
	protected $pluginOptions;

	/**
	 * @var boolean
	 */
	protected $searchControl;

	/*
	 * Constructs this map.
	 */
	public function __construct() {
		// Get extension settings.
		if (($settings = Tx_AdGoogleMaps_Utility_BackEnd::getTypoScriptSetup($GLOBALS['TSFE']->id, 'tx_adgooglemaps')) === FALSE) {
			$flashMessages = t3lib_div::makeInstance('t3lib_FlashMessage', 'Add static Template "ad: Google Maps (ad_google_maps)" to your template.', 'tx_adgooglemaps: Invalid extension configuration', t3lib_FlashMessage::ERROR);
			return t3lib_FlashMessageQueue::addMessage($flashMessages);
		}
		$this->settings = $settings['plugin'];

		$this->pluginOptions = t3lib_div::makeInstance('Tx_AdGoogleMaps_Plugin_Options');

		// Set required plugin settings.
		$this->geocodeUrl = $this->settings['geocodeUrl'];

		Tx_AdGoogleMaps_Utility_FrontEnd::includeFrontEndResources('Tx_AdGoogleMaps_Plugin_GoogleMaps');
	}

	/**
	 * Sets this mapId.
	 *
	 * @param integer $mapId
	 * @return Tx_AdGoogleMaps_Plugin_GoogleMaps
	 */
	public function setMapId($mapId) {
		$this->mapId = (integer) $mapId;
		return $this;
	}

	/**
	 * Returns this mapId.
	 *
	 * @return integer
	 */
	public function getMapId() {
		return (integer) $this->mapId;
	}

	/**
	 * Sets this width.
	 *
	 * @param integer $width
	 * @return Tx_AdGoogleMaps_Plugin_GoogleMaps
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
	 * @return Tx_AdGoogleMaps_Plugin_GoogleMaps
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
	 * Sets this geocodeUrl.
	 *
	 * @param string $geocodeUrl
	 * @return Tx_AdGoogleMaps_Plugin_GoogleMaps
	 */
	public function setGeocodeUrl($geocodeUrl) {
		$this->geocodeUrl = $geocodeUrl;
		return $this;
	}

	/**
	 * Returns this geocodeUrl.
	 *
	 * @return string
	 */
	public function getGeocodeUrl() {
		return $this->geocodeUrl;
	}

	/**
	 * Sets this pluginOptions.
	 *
	 * @param Tx_AdGoogleMaps_Plugin_Options $pluginOptions
	 * @return Tx_AdGoogleMaps_Plugin_GoogleMaps
	 */
	public function setPluginOptions(Tx_AdGoogleMaps_Plugin_Options $pluginOptions) {
		$this->pluginOptions = $pluginOptions;
		return $this;
	}

	/**
	 * Returns this pluginOptions.
	 *
	 * @return Tx_AdGoogleMaps_Plugin_Options
	 */
	public function getPluginOptions() {
		return $this->pluginOptions;
	}

	/**
	 * Sets this searchControl
	 *
	 * @param boolean $searchControl
	 * @return Tx_AdGoogleMaps_Plugin_GoogleMaps
	 */
	public function setSearchControl($searchControl) {
		$this->searchControl = (boolean) $searchControl;
		return $this;
	}

	/**
	 * Returns this searchControl
	 *
	 * @return boolean
	 */
	public function isSearchControl() {
		return (boolean) $this->searchControl;
	}

	/**
	 * Returns this canvas ID.
	 *
	 * @return string
	 */
	public function getCanvasId() {
		return str_replace('###UID###', $this->mapId, $this->pluginOptions->getCanvasId());
	}

	/**
	 * Returns the plugin object options identifier as string.
	 *
	 * @return string
	 */
	public function getPluginOptionsObjectIdentifier() {
		return $this->mapId ? 'Tx_AdGoogleMaps_Plugin_Options_Uid' . $this->mapId : 'Tx_AdGoogleMaps_Plugin_Options';
	}

	/**
	 * Returns the plugin object identifier as string.
	 *
	 * @return string
	 */
	public function getPluginMapObjectIdentifier() {
		return $this->mapId ? 'Tx_AdGoogleMaps_Plugin_Map_Uid' . $this->mapId : 'Tx_AdGoogleMaps_Plugin_Map';
	}

	/**
	 * Returns the initialize function as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrintPluginInitializeFunction() {
		return $this->getPluginMapObjectIdentifier() . ' = new Tx_AdGoogleMaps_Plugin(' . $this->getPluginOptionsObjectIdentifier() . ');';
	}

	/**
	 * Returns this plugin as URL.
	 *
	 * @return string
	 */
	public function getPrintPluginFile() {
		self::$pluginNotLoaded = FALSE;
		return $this->pluginFile;
	}

	/**
	 * Returns this markerClusterUrl as URL.
	 *
	 * @return string
	 */
	public function getPrintMarkerClusterUrl() {
		self::$markerClusterNotLoaded = FALSE;
		return $this->markerClusterUrl;
	}

	/**
	 * Returns this canvas as HTML-DIV-Element.
	 *
	 * @return string
	 */
	public function getPrintCanvas() {
		$size = array();
		if ($this->height) $size[] = 'height: ' . $this->height . 'px';
		if ($this->width)  $size[] = 'width: ' . $this->width . 'px';
		$style = (count($size) ? ' style="' . implode('; ', t3lib_div::removeArrayEntryByValue($size, NULL)) . ';"' : '');
		return '<div id="' . $this->getCanvasId() . '"' . $style . '></div>';
	}

	/**
	 * Returns the plugin options as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrintOptions() {
		return $this->pluginOptions;
	}

	/**
	 * Returns plugin options as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrint() {
		return $this->getPluginOptionsObjectIdentifier() . ' = ' . $this->getPrintOptions() . ';' . LF . $this->getPrintPluginInitializeFunction();
	}

	/**
	 * Returns the address coordinate string. Returns NULL if no address found.
	 * 
	 * @param string $addressQuery
	 * @return string
	 */
	public function getCoordinatesByAddress($addressQuery) {
		$coordinate = NULL;
		$geocodeUrl = $this->getGeocodeUrl();
		$geocodeUrl .= '?sensor=false&address=' . urlencode(str_replace(LF, ', ', $addressQuery));
		$geocodeResult = t3lib_div::getURL($geocodeUrl);
		$geocodeResult = json_decode($geocodeResult);
		if ($geocodeResult !== NULL && strtolower($geocodeResult->status) === 'ok') {
			$coordinate = $geocodeResult->results[0]->geometry->location->lat . ',' . $geocodeResult->results[0]->geometry->location->lng;
		}
		return $coordinate;
	}

	/**
	 * Returns the address LatLng object. Returns NULL if no address found.
	 * 
	 * @param string $addressQuery
	 * @return Tx_AdGoogleMaps_Api_LatLng
	 */
	public function getLatLngByAddress($addressQuery) {
		$latLng = NULL;
		$geocodeUrl = $this->getGeocodeUrl();
		$geocodeUrl .= '?sensor=false&address=' . urlencode(str_replace(LF, ', ', $addressQuery));
		$geocodeResult = t3lib_div::getURL($geocodeUrl);
		$geocodeResult = json_decode($geocodeResult);
		if ($geocodeResult !== NULL && strtolower($geocodeResult->status) === 'ok') {
			$coordinates = new Tx_AdGoogleMaps_Api_LatLng($geocodeResult->results[0]->geometry->location->lat, $geocodeResult->results[0]->geometry->location->lng);
		}
		return $latLng;
	}

	/**
	 * Returns the map as JavaScript string.
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getPrint();
	}

}

?>