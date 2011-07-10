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
class Tx_AdGoogleMaps_Api_Map_Map {

	/**
	 * @var Tx_AdGoogleMaps_JsonClassEncoder_JsonEncoderInterface
	 * @jsonClassEncoder ignoreProperty
	 */
	protected $jsonEncoder;

	/**
	 * @var string
	 * @jsonClassEncoder ignoreProperty
	 */
	protected $canvas;

	/**
	 * @var string
	 * @jsonClassEncoder quoteValue = FALSE
	 */
	protected $mapTypeId;

	/**
	 * @var string
	 * @jsonClassEncoder ignorePropertyIfValueIs = ''
	 */
	protected $backgroundColor;

	/**
	 * @var Tx_AdGoogleMaps_Api_Base_LatLng
	 * @jsonClassEncoder useGetterMethod = getPrint
	 */
	protected $center;

	/**
	 * @var integer
	 * @jsonClassEncoder ignorePropertyIfValueIs = 0
	 */
	protected $zoom;

	/**
	 * @var integer
	 * @jsonClassEncoder ignorePropertyIfValueIs = 0
	 */
	protected $minZoom;

	/**
	 * @var integer
	 * @jsonClassEncoder ignorePropertyIfValueIs = 0
	 */
	protected $maxZoom;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs = FALSE
	 */
	protected $noClear;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs = FALSE
	 */
	protected $disableDefaultUi;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs = FALSE
	 */
	protected $mapTypeControl;

	/**
	 * @var Tx_AdGoogleMaps_Api_Control_MapType
	 * @jsonClassEncoder ignorePropertyIfValueIs = 'null'
	 */
	protected $mapTypeControls;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs = FALSE
	 */
	protected $rotateControl;

	/**
	 * @var Tx_AdGoogleMaps_Api_Control_Rotate
	 * @jsonClassEncoder ignorePropertyIfValueIs = 'null'
	 */
	protected $rotateControls;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs = FALSE
	 */
	protected $scaleControl;

	/**
	 * @var Tx_AdGoogleMaps_Api_Control_Scale
	 * @jsonClassEncoder ignorePropertyIfValueIs = 'null'
	 */
	protected $scaleControls;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs = FALSE
	 */
	protected $panControl;

	/**
	 * @var Tx_AdGoogleMaps_Api_Control_Pan
	 * @jsonClassEncoder ignorePropertyIfValueIs = 'null'
	 */
	protected $panControls;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs = FALSE
	 */
	protected $zoomControl;

	/**
	 * @var Tx_AdGoogleMaps_Api_Control_Zoom
	 * @jsonClassEncoder ignorePropertyIfValueIs = 'null'
	 */
	protected $zoomControls;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs = FALSE
	 */
	protected $overviewMapControl;

	/**
	 * @var Tx_AdGoogleMaps_Api_Control_OverviewMap
	 * @jsonClassEncoder ignorePropertyIfValueIs = 'null'
	 */
	protected $overviewMapControls;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs = FALSE
	 */
	protected $streetViewControl;

	/**
	 * @var Tx_AdGoogleMaps_Api_Control_StreetView
	 * @jsonClassEncoder ignorePropertyIfValueIs = 'null'
	 */
	protected $streetViewControls;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs = TRUE
	 */
	protected $disableDoubleClickZoom;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs = TRUE
	 */
	protected $scrollwheel;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs = TRUE
	 */
	protected $draggable;

	/**
	 * @var string
	 * @jsonClassEncoder ignorePropertyIfValueIs = ''
	 */
	protected $draggableCursor;

	/**
	 * @var string
	 * @jsonClassEncoder ignorePropertyIfValueIs = ''
	 */
	protected $draggingCursor;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs = TRUE
	 */
	protected $keyboardShortcuts;

	/*
	 * Constructs this map.
	 * 
	 * @param string $canvas
	 * @param array $options
	 */
	public function __construct($canvas, $options = array()) {
		$this->canvas = $canvas;

		foreach ($options as $propertyName => $propertyValue) {
			$setterName = 'set' . ucfirst($propertyName);
			if (is_callable(array($this, $setterName))) {
				call_user_func(array($this, $setterName));
			}
		}
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

	/**
	 * Sets this canvas.
	 *
	 * @param string $canvas
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setCanvas($canvas) {
		$this->canvas = $canvas;
		return $this;
	}

	/**
	 * Returns this canvas.
	 *
	 * @return string
	 */
	public function getCanvas() {
		return $this->canvas;
	}

	/**
	 * Sets this mapTypeId.
	 *
	 * @param string $mapTypeId
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setMapTypeId($mapTypeId) {
		$this->mapTypeId = $mapTypeId;
		return $this;
	}

	/**
	 * Returns this mapTypeId.
	 *
	 * @return string
	 */
	public function getMapTypeId() {
		return $this->mapTypeId;
	}

	/**
	 * Sets this center.
	 x_AdGoogleMapsApi_Base_LatLng $center
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setCenter(Tx_AdGoogleMaps_Api_Base_LatLng $center) {
		$this->center = $center;
		return $this;
	}

	/**
	 * Returns this center.
	 *
	 * @return Tx_AdGoogleMaps_Api_Base_LatLng
	 */
	public function getCenter() {
		return $this->center;
	}

	/**
	 * Sets this zoom.
	 *
	 * @param integer $zoom
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setZoom($zoom) {
		$this->zoom = (integer) $zoom;
		return $this;
	}

	/**
	 * Returns this zoom.
	 *
	 * @return integer
	 */
	public function getZoom() {
		return (integer) $this->zoom;
	}

	/**
	 * Sets this minZoom.
	 *
	 * @param integer $minZoom
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setMinZoom($minZoom) {
		$this->minZoom = (integer) $minZoom;
		return $this;
	}

	/**
	 * Returns this minZoom.
	 *
	 * @return integer
	 */
	public function getMinZoom() {
		return (integer) $this->minZoom;
	}

	/**
	 * Sets this maxZoom.
	 *
	 * @param integer $maxZoom
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setMaxZoom($maxZoom) {
		$this->maxZoom = (integer) $maxZoom;
		return $this;
	}

	/**
	 * Returns this maxZoom.
	 *
	 * @return integer
	 */
	public function getMaxZoom() {
		return (integer) $this->maxZoom;
	}

	/**
	 * Sets this backgroundColor.
	 *
	 * @param string $backgroundColor
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setBackgroundColor($backgroundColor) {
		$this->backgroundColor = $backgroundColor;
		return $this;
	}

	/**
	 * Returns this backgroundColor.
	 *
	 * @return string
	 */
	public function getBackgroundColor() {
		return $this->backgroundColor;
	}

	/**
	 * Sets this noClear.
	 *
	 * @param boolean $noClear
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setNoClear($noClear) {
		$this->noClear = (boolean) $noClear;
		return $this;
	}

	/**
	 * Returns this noClear.
	 *
	 * @return boolean
	 */
	public function isNoClear() {
		return (boolean) $this->noClear;
	}

	/**
	 * Sets this disableDefaultUi.
	 *
	 * @param boolean $disableDefaultUi
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setDisableDefaultUi($disableDefaultUi) {
		$this->disableDefaultUi = (boolean) $disableDefaultUi;
		return $this;
	}

	/**
	 * Returns this disableDefaultUi.
	 *
	 * @return boolean
	 */
	public function isDisableDefaultUi() {
		return (boolean) $this->disableDefaultUi;
	}

	/**
	 * Sets this mapTypeControl.
	 *
	 * @param boolean $mapTypeControl
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setMapTypeControl($mapTypeControl) {
		$this->mapTypeControl = (boolean) $mapTypeControl;
		return $this;
	}

	/**
	 * Returns this mapTypeControl.
	 *
	 * @return boolean
	 */
	public function hasMapTypeControl() {
		return (boolean) $this->mapTypeControl;
	}

	/**
	 * Sets this mapTypeControls.
	 *
	 * @param Tx_AdGoogleMaps_Api_Control_MapType $mapTypeControls
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setMapTypeControls(Tx_AdGoogleMaps_Api_Control_MapType $mapTypeControls) {
		$this->mapTypeControls = $mapTypeControls;
		return $this;
	}

	/**
	 * Returns this mapTypeControls.
	 *
	 * @return Tx_AdGoogleMaps_Api_Control_MapType
	 */
	public function getMapTypeControls() {
		return $this->mapTypeControls;
	}

	/**
	 * Sets this rotateControl.
	 *
	 * @param boolean $rotateControl
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setRotateControl($rotateControl) {
		$this->rotateControl = (boolean) $rotateControl;
		return $this;
	}

	/**
	 * Returns this rotateControl.
	 *
	 * @return boolean
	 */
	public function hasRotateControl() {
		return (boolean) $this->rotateControl;
	}

	/**
	 * Sets this rotateControls.
	 *
	 * @param Tx_AdGoogleMaps_Api_Control_Rotate $rotateControls
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setRotateControls(Tx_AdGoogleMaps_Api_Control_Rotate $rotateControls) {
		$this->rotateControls = $rotateControls;
		return $this;
	}

	/**
	 * Returns this rotateControls.
	 *
	 * @return Tx_AdGoogleMaps_Api_Control_Rotate
	 */
	public function getRotateControls() {
		return $this->rotateControls;
	}

	/**
	 * Sets this scaleControl.
	 *
	 * @param boolean $scaleControl
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setScaleControl($scaleControl) {
		$this->scaleControl = (boolean) $scaleControl;
		return $this;
	}

	/**
	 * Returns this scaleControl.
	 *
	 * @return boolean
	 */
	public function hasScaleControl() {
		return (boolean) $this->scaleControl;
	}

	/**
	 * Sets this scaleControls.
	 *
	 * @param Tx_AdGoogleMaps_Api_Control_Scale $scaleControls
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setScaleControls(Tx_AdGoogleMaps_Api_Control_Scale $scaleControls) {
		$this->scaleControls = $scaleControls;
		return $this;
	}

	/**
	 * Returns this scaleControls.
	 *
	 * @return Tx_AdGoogleMaps_Api_Control_Scale
	 */
	public function getScaleControls() {
		return $this->scaleControls;
	}

	/**
	 * Sets this panControl.
	 *
	 * @param boolean $panControl
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setPanControl($panControl) {
		$this->panControl = (boolean) $panControl;
		return $this;
	}

	/**
	 * Returns this panControl.
	 *
	 * @return boolean
	 */
	public function hasPanControl() {
		return (boolean) $this->panControl;
	}

	/**
	 * Sets this panControls.
	 *
	 * @param Tx_AdGoogleMaps_Api_Control_Pan $panControls
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setPanControls(Tx_AdGoogleMaps_Api_Control_Pan $panControls) {
		$this->panControls = $panControls;
		return $this;
	}

	/**
	 * Returns this panControls.
	 *
	 * @return Tx_AdGoogleMaps_Api_Control_Pan
	 */
	public function getPanControls() {
		return $this->panControls;
	}

	/**
	 * Sets this zoomControl.
	 *
	 * @param boolean $zoomControl
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setZoomControl($zoomControl) {
		$this->zoomControl = (boolean) $zoomControl;
		return $this;
	}

	/**
	 * Returns this zoomControl.
	 *
	 * @return boolean
	 */
	public function hasZoomControl() {
		return (boolean) $this->zoomControl;
	}

	/**
	 * Sets this zoomControls.
	 *
	 * @param Tx_AdGoogleMaps_Api_Control_Zoom $zoomControls
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setZoomControls(Tx_AdGoogleMaps_Api_Control_Zoom $zoomControls) {
		$this->zoomControls = $zoomControls;
		return $this;
	}

	/**
	 * Returns this zoomControls.
	 *
	 * @return Tx_AdGoogleMaps_Api_Control_Zoom
	 */
	public function getZoomControls() {
		return $this->zoomControls;
	}

	/**
	 * Sets this overviewMapControl.
	 *
	 * @param boolean $overviewMapControl
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setOverviewMapControl($overviewMapControl) {
		$this->overviewMapControl = (boolean) $overviewMapControl;
		return $this;
	}

	/**
	 * Returns this overviewMapControl.
	 *
	 * @return boolean
	 */
	public function hasOverviewMapControl() {
		return (boolean) $this->overviewMapControl;
	}

	/**
	 * Sets this overviewMapControls.
	 *
	 * @param Tx_AdGoogleMaps_Api_Control_OverviewMap $overviewMapControls
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setOverviewMapControls(Tx_AdGoogleMaps_Api_Control_OverviewMap $overviewMapControls) {
		$this->overviewMapControls = $overviewMapControls;
		return $this;
	}

	/**
	 * Returns this overviewMapControls.
	 *
	 * @return Tx_AdGoogleMaps_Api_Control_OverviewMap
	 */
	public function getOverviewMapControls() {
		return $this->overviewMapControls;
	}

	/**
	 * Sets this streetViewControl.
	 *
	 * @param boolean $streetViewControl
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setStreetViewControl($streetViewControl) {
		$this->streetViewControl = (boolean) $streetViewControl;
		return $this;
	}

	/**
	 * Returns this streetViewControl.
	 *
	 * @return boolean
	 */
	public function hasStreetViewControl() {
		return (boolean) $this->streetViewControl;
	}

	/**
	 * Sets this streetViewControls.
	 *
	 * @param Tx_AdGoogleMaps_Api_Control_StreetView $streetViewControls
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setStreetViewControls(Tx_AdGoogleMaps_Api_Control_StreetView $streetViewControls) {
		$this->streetViewControls = $streetViewControls;
		return $this;
	}

	/**
	 * Returns this streetViewControls.
	 *
	 * @return Tx_AdGoogleMaps_Api_Control_StreetView
	 */
	public function getStreetViewControls() {
		return $this->streetViewControls;
	}

	/**
	 * Sets this disableDoubleClickZoom.
	 *
	 * @param boolean $disableDoubleClickZoom
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setDisableDoubleClickZoom($disableDoubleClickZoom) {
		$this->disableDoubleClickZoom = (boolean) $disableDoubleClickZoom;
		return $this;
	}

	/**
	 * Returns this disableDoubleClickZoom.
	 *
	 * @return boolean
	 */
	public function isDisableDoubleClickZoom() {
		return (boolean) $this->disableDoubleClickZoom;
	}

	/**
	 * Sets this scrollwheel.
	 *
	 * @param boolean $scrollwheel
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setScrollwheel($scrollwheel) {
		$this->scrollwheel = (boolean) $scrollwheel;
		return $this;
	}

	/**
	 * Returns this scrollwheel.
	 *
	 * @return boolean
	 */
	public function hasScrollwheel() {
		return (boolean) $this->scrollwheel;
	}

	/**
	 * Sets this draggable.
	 *
	 * @param boolean $draggable
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setDraggable($draggable) {
		$this->draggable = (boolean) $draggable;
		return $this;
	}

	/**
	 * Returns this draggable.
	 *
	 * @return boolean
	 */
	public function isDraggable() {
		return (boolean) $this->draggable;
	}

	/**
	 * Sets this draggableCursor.
	 *
	 * @param string $draggableCursor
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setDraggableCursor($draggableCursor) {
		$this->draggableCursor = $draggableCursor;
		return $this;
	}

	/**
	 * Returns this draggableCursor.
	 *
	 * @return string
	 */
	public function getDraggableCursor() {
		return $this->draggableCursor;
	}

	/**
	 * Sets this draggingCursor.
	 *
	 * @param string $draggingCursor
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setDraggingCursor($draggingCursor) {
		$this->draggingCursor = $draggingCursor;
		return $this;
	}

	/**
	 * Returns this draggingCursor.
	 *
	 * @return string
	 */
	public function getDraggingCursor() {
		return $this->draggingCursor;
	}

	/**
	 * Sets this keyboardShortcuts.
	 *
	 * @param boolean $keyboardShortcuts
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 */
	public function setKeyboardShortcuts($keyboardShortcuts) {
		$this->keyboardShortcuts = (boolean) $keyboardShortcuts;
		return $this;
	}

	/**
	 * Returns this keyboardShortcuts.
	 *
	 * @return boolean
	 */
	public function hasKeyboardShortcuts() {
		return (boolean) $this->keyboardShortcuts;
	}

	/**
	 * Returns the map options as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrintOptions() {
		return $this->jsonEncoder->encode($this);
	}

	/**
	 * Returns the map as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrint() {
		return sprintf('new google.maps.Map(document.getElementById(\'%s\'), %s)', $this->canvas, $this->jsonEncoder->encode($this));
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