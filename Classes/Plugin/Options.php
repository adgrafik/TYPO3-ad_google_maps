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
class Tx_AdGoogleMaps_Plugin_Options {

	/**
	 * @var string
	 * @javaScriptHelper 
	 */
	protected $canvasId;

	/**
	 * @var Tx_AdGoogleMaps_Api_Map
	 * @javaScriptHelper
	 */
	protected $mapOptions;

	/**
	 * @var Tx_AdGoogleMaps_Plugin_Options_MapControl
	 * @javaScriptHelper 
	 */
	protected $mapControl;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Plugin_Options_Layer_LayerInterface>
	 * @javaScriptHelper 
	 */
	protected $layerOptions;

	/*
	 * Constructs this map.
	 */
	public function __construct() {
		$this->mapOptions = t3lib_div::makeInstance('Tx_AdGoogleMaps_Api_Map', NULL);
		$this->mapControl = t3lib_div::makeInstance('Tx_AdGoogleMaps_Plugin_Options_MapControl');
		$this->layerOptions = t3lib_div::makeInstance('Tx_Extbase_Persistence_ObjectStorage');
	}

	/**
	 * Sets this canvasId.
	 *
	 * @param string $canvasId
	 * @return Tx_AdGoogleMaps_Plugin_Options
	 */
	public function setCanvasId($canvasId) {
		$this->canvasId = $canvasId;
		return $this;
	}

	/**
	 * Returns this canvasId.
	 *
	 * @return string
	 */
	public function getCanvasId() {
		return $this->canvasId;
	}

	/**
	 * Sets this mapOptions.
	 *
	 * @param Tx_AdGoogleMaps_Api_Map $mapOptions
	 * @return Tx_AdGoogleMaps_Plugin_Options
	 */
	public function setMapOptions(Tx_AdGoogleMaps_Api_Map $mapOptions) {
		$this->mapOptions = $mapOptions;
		return $this;
	}

	/**
	 * Returns this mapOptions.
	 *
	 * @return Tx_AdGoogleMaps_Api_Map
	 */
	public function getMapOptions() {
		return $this->mapOptions;
	}

	/**
	 * Sets this mapControl.
	 *
	 * @param Tx_AdGoogleMaps_Plugin_Options_MapControl $mapControl
	 * @return Tx_AdGoogleMaps_Plugin_Options
	 */
	public function setMapControl(Tx_AdGoogleMaps_Plugin_Options_MapControl $mapControl) {
		$this->mapControl = $mapControl;
		return $this;
	}

	/**
	 * Returns this mapControl.
	 *
	 * @return Tx_AdGoogleMaps_Plugin_Options_MapControl
	 */
	public function getMapControl() {
		return $this->mapControl;
	}

	/**
	 * Sets this layers.
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Plugin_Options_Layer_LayerInterface> $layers
	 * @return Tx_AdGoogleMaps_Plugin_Options
	 */
	public function setLayerOptions($layers) {
		$this->layers = $layers;
		return $this;
	}

	/**
	 * Add a layerOption to this layerOptions.
	 *
	 * @param Tx_AdGoogleMaps_Plugin_Options_Layer_LayerInterface $layerOption
	 * @return Tx_AdGoogleMaps_Plugin_Options
	 */
	public function addLayerOptions(Tx_AdGoogleMaps_Plugin_Options_Layer_LayerInterface $layerOptions) {
		$this->layerOptions->attach($layerOptions);
		return $this;
	}

	/**
	 * Returns this layerOptions.
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Plugin_Options_Layer_LayerInterface>
	 */
	public function getLayerOptions() {
		return $this->layerOptions;
	}

	/**
	 * Returns the map as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrint() {
		if ($this->mapControl->isUseMarkerCluster() === TRUE) {
			Tx_AdGoogleMaps_Utility_FrontEnd::includeFrontEndResources('Tx_AdGoogleMaps_Plugin_Options');
		}
		return Tx_AdGoogleMaps_Utility_FrontEnd::getClassAsJsonObject($this);
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