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
 */
class Tx_AdGoogleMaps_MapBuilder_Options {

	/**
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 * @jsonClassEncoder ignoreProperty
	 */
	protected $objectManager;

	/**
	 * @var Tx_AdGoogleMaps_Utility_FrontEnd
	 * @jsonClassEncoder ignoreProperty
	 */
	protected $frontEndUtility;

	/**
	 * @var Tx_AdGoogleMaps_JsonClassEncoder_JsonEncoderInterface
	 * @jsonClassEncoder ignoreProperty
	 */
	protected $jsonEncoder;

	/**
	 * Alias of $this->mapOptions->canvas
	 * @var string
	 */
	protected $canvasId;

	/**
	 * @var Tx_AdGoogleMaps_MapBuilder_MapBuilder
	 */
	protected $mapBuilder;

	/**
	 * @var Tx_AdGoogleMaps_MapBuilder_Options_MapOptions
	 */
	protected $mapOptions;

	/**
	 * @var Tx_AdGoogleMaps_MapBuilder_Options_MapControl
	 */
	protected $mapControl;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_MapBuilder_Options_Layer_LayerInterface>
	 */
	protected $layers;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_MapBuilder_Options_Overlay_OverlayInterface>
	 */
	protected $overlays;

	/*
	 * Constructor.
	 * 
	 * @param Tx_AdGoogleMaps_MapBuilder_MapBuilder $mapBuilder
	 */
	public function __construct(Tx_AdGoogleMaps_MapBuilder_MapBuilder $mapBuilder) {
		$this->mapBuilder = $mapBuilder;
	}

	/**
	 * Injects this objectManager.
	 *
	 * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
	 * @return void
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * Injects this jsonEncoder.
	 *
	 * @param Tx_AdGoogleMaps_Utility_FrontEnd $frontEndUtility
	 * @return void
	 */
	public function injectFrontEndUtility(Tx_AdGoogleMaps_Utility_FrontEnd $frontEndUtility) {
		$this->frontEndUtility = $frontEndUtility;
	}

	/**
	 * Injects this jsonEncoder.
	 *
	 * @param Tx_AdGoogleMaps_JsonClassEncoder_JsonEncoderInterface $jsonEncoder
	 * @return void
	 */
	public function injectJsonEncoder(Tx_AdGoogleMaps_JsonClassEncoder_JsonEncoderInterface $jsonEncoder) {
		$this->jsonEncoder = $jsonEncoder;
	}

	/*
	 * Initialize this objectManager.
	 *
	 * @return void
	 */
	public function initializeObject() {
		// Set default values.
		$this->mapOptions = $this->objectManager->create('Tx_AdGoogleMaps_MapBuilder_Options_MapOptions');
		$this->mapControl = $this->objectManager->create('Tx_AdGoogleMaps_MapBuilder_Options_MapControl');
		$this->layers = $this->objectManager->create('Tx_Extbase_Persistence_ObjectStorage');
	}

	/**
	 * Alias of $this->mapOptions->setCanvas(). Sets this canvasId.
	 *
	 * @param string $canvasId
	 * @return Tx_AdGoogleMaps_MapBuilder_Options
	 */
	public function setCanvasId($canvasId) {
		$this->mapOptions->setCanvas($canvasId);
		return $this;
	}

	/**
	 * Alias of $this->mapOptions->getCanvas(). Returns this canvasId.
	 *
	 * @return string
	 */
	public function getCanvasId() {
		if ($this->mapBuilder->getIdentifier() === NULL) {
			return str_replace('###UID###', '', $this->mapOptions->getCanvas());
		} else {
			return str_replace('###UID###', '_Uid_' . $this->mapBuilder->getIdentifier(), $this->mapOptions->getCanvas());
		}
	}

	/**
	 * Sets this mapOptions.
	 *
	 * @param Tx_AdGoogleMaps_MapBuilder_Options_MapOptions $mapOptions
	 * @return Tx_AdGoogleMaps_MapBuilder_Options
	 */
	public function setMapOptions(Tx_AdGoogleMaps_MapBuilder_Options_MapOptions $mapOptions) {
		$this->mapOptions = $mapOptions;
		return $this;
	}

	/**
	 * Returns this mapOptions.
	 *
	 * @return Tx_AdGoogleMaps_MapBuilder_Options_MapOptions
	 */
	public function getMapOptions() {
		return $this->mapOptions;
	}

	/**
	 * Sets this mapControl.
	 *
	 * @param Tx_AdGoogleMaps_MapBuilder_Options_MapControl $mapControl
	 * @return Tx_AdGoogleMaps_MapBuilder_Options
	 */
	public function setMapControl(Tx_AdGoogleMaps_MapBuilder_Options_MapControl $mapControl) {
		$this->mapControl = $mapControl;
		return $this;
	}

	/**
	 * Returns this mapControl.
	 *
	 * @return Tx_AdGoogleMaps_MapBuilder_Options_MapControl
	 */
	public function getMapControl() {
		return $this->mapControl;
	}

	/**
	 * Sets this layers.
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_MapBuilder_Options_Layer_LayerInterface> $layers
	 * @return Tx_AdGoogleMaps_MapBuilder_Options
	 */
	public function setLayers($layers) {
		$this->layers = $layers;
		return $this;
	}

	/**
	 * Add a layerOption to this layers.
	 *
	 * @param Tx_AdGoogleMaps_MapBuilder_Options_Layer_LayerInterface $layerOption
	 * @return Tx_AdGoogleMaps_MapBuilder_Options
	 */
	public function addLayer(Tx_AdGoogleMaps_MapBuilder_Options_Layer_LayerInterface $layer) {
		$this->layers->attach($layer);
		return $this;
	}

	/**
	 * Returns this layers.
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_MapBuilder_Options_Layer_LayerInterface>
	 */
	public function getLayers() {
		return $this->layers;
	}

	/**
	 * Returns this overlays.
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_MapBuilder_Options_Overlay_OverlayInterface>
	 */
	public function getOverlays() {
		return $this->overlays;
	}

	/**
	 * Returns the map as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrint() {
		if ($this->mapControl->isUseMarkerCluster() === TRUE) {
			$this->frontEndUtility->includeFrontEndResources('Tx_AdGoogleMaps_MapBuilder_Options');
		}
		return $this->jsonEncoder->encode($this);
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