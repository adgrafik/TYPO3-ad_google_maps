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
 * Model: Map.
 * Nearly the same like the Google Maps API
 * @see http://code.google.com/apis/maps/documentation/javascript/reference.html
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 * @api
 */
class Tx_AdGoogleMaps_Domain_Model_Map extends Tx_AdGoogleMaps_Domain_Model_AbstractEntity {

	/**
	 * Center type
	 */
	const CENTER_TYPE_DEFAULT = 0;
	const CENTER_TYPE_BOUNDS = 1;

	/**
	 * InfoWindowBehaviour
	 */
	const INFO_WINDOW_BEHAVIOUR_BY_MAP = 1;
	const INFO_WINDOW_BEHAVIOUR_BY_LAYER = 2;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $templates;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_Category>
	 * @lazy
	 */
	protected $categories;

	/**
	 * @var string
	 */
	protected $mapTypeId;

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
	protected $backgroundColor;

	/**
	 * @var integer
	 */
	protected $minZoom;

	/**
	 * @var integer
	 */
	protected $maxZoom;

	/**
	 * @var boolean
	 */
	protected $noClear;

	/**
	 * @var integer
	 */
	protected $centerType;

	/**
	 * @var string
	 */
	protected $center;

	/**
	 * @var integer
	 */
	protected $zoom;

	/**
	 * @var boolean
	 */
	protected $useMarkerCluster;

	/**
	 * @var boolean
	 */
	protected $disableDefaultUi;

	/**
	 * @var boolean
	 */
	protected $mapTypeControl;

	/**
	 * @var string
	 */
	protected $mapTypeControlsMapTypeIds;

	/**
	 * @var string
	 */
	protected $mapTypeControlsPosition;

	/**
	 * @var string
	 */
	protected $mapTypeControlsStyle;

	/**
	 * @var boolean
	 */
	protected $rotateControl;

	/**
	 * @var string
	 */
	protected $rotateControlsPosition;

	/**
	 * @var boolean
	 */
	protected $scaleControl;

	/**
	 * @var string
	 */
	protected $scaleControlsPosition;

	/**
	 * @var string
	 */
	protected $scaleControlsStyle;

	/**
	 * @var boolean
	 */
	protected $panControl;

	/**
	 * @var string
	 */
	protected $panControlsPosition;

	/**
	 * @var boolean
	 */
	protected $zoomControl;

	/**
	 * @var string
	 */
	protected $zoomControlsPosition;

	/**
	 * @var string
	 */
	protected $zoomControlsStyle;

	/**
	 * @var boolean
	 */
	protected $overviewMapControl;

	/**
	 * @var boolean
	 */
	protected $overviewMapControlsIsOpened;

	/**
	 * @var boolean
	 */
	protected $streetViewControl;

	/**
	 * @var string
	 */
	protected $streetViewControlsPosition;

	/**
	 * @var boolean
	 */
	protected $disableDoubleClickZoom;

	/**
	 * @var boolean
	 */
	protected $scrollwheel;

	/**
	 * @var boolean
	 */
	protected $draggable;

	/**
	 * @var string
	 */
	protected $draggableCursor;

	/**
	 * @var string
	 */
	protected $draggingCursor;

	/**
	 * @var boolean
	 */
	protected $keyboardShortcuts;

	/**
	 * @var integer
	 */
	protected $infoWindowPlacingType;

	/**
	 * @var string
	 */
	protected $infoWindowPosition;

	/**
	 * @var string
	 */
	protected $infoWindowObjectNumber;

	/**
	 * @var boolean
	 */
	protected $infoWindowCloseAllOnMapClick;

	/**
	 * @var integer
	 */
	protected $infoWindowBehaviour;

	/**
	 * @var boolean
	 */
	protected $infoWindowKeepOpen;

	/**
	 * @var boolean
	 */
	protected $infoWindowCloseOnClick;

	/**
	 * @var boolean
	 */
	protected $infoWindowDisableAutoPan;

	/**
	 * @var integer
	 */
	protected $infoWindowMaxWidth;

	/**
	 * @var integer
	 */
	protected $infoWindowPixelOffsetWidth;

	/**
	 * @var integer
	 */
	protected $infoWindowPixelOffsetHeight;

	/**
	 * @var string
	 */
	protected $searchMarker;

	/**
	 * @var integer
	 */
	protected $searchMarkerWidth;

	/**
	 * @var integer
	 */
	protected $searchMarkerHeight;

	/**
	 * @var integer
	 */
	protected $searchMarkerOriginX;

	/**
	 * @var integer
	 */
	protected $searchMarkerOriginY;

	/**
	 * @var integer
	 */
	protected $searchMarkerAnchorX;

	/**
	 * @var integer
	 */
	protected $searchMarkerAnchorY;

	/**
	 * @var integer
	 */
	protected $searchMarkerScaledWidth;

	/**
	 * @var integer
	 */
	protected $searchMarkerScaledHeight;

	/*
	 * Initialize this map.
	 * 
	 * @return void
	 */
	public function initializeObject() {
		parent::initializeObject();
		// Set default values.
		$this->categories = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Sets this title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns this title
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->getPropertyValue('title', 'map');
	}

	/**
	 * Sets this templates
	 *
	 * @param string $templates
	 * @return void
	 */
	public function setTemplates($templates) {
		$this->templates = $templates;
	}

	/**
	 * Returns this templates
	 *
	 * @return string
	 */
	public function getTemplates() {
		return $this->getPropertyValue('templates', 'map');
	}

	/**
	 * Sets this categories
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_Category> $categories
	 * @return void
	 */
	public function setCategories(Tx_Extbase_Persistence_ObjectStorage $categories) {
		$this->categories = $categories;
	}

	/**
	 * Returns this categories
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_Category>
	 */
	public function getCategories() {
		if ($this->categories instanceof Tx_Extbase_Persistence_LazyLoadingProxy) {
			$this->categories->_loadRealInstance();
		}
		return $this->categories;
	}

	/**
	 * Sets this mapTypeId
	 *
	 * @param string $mapTypeId
	 * @return void
	 */
	public function setMapTypeId($mapTypeId) {
		$this->mapTypeId = $mapTypeId;
	}

	/**
	 * Returns this mapTypeId
	 *
	 * @return string
	 */
	public function getMapTypeId() {
		return $this->getPropertyValue('mapTypeId', 'map');
	}

	/**
	 * Sets this width
	 *
	 * @param integer $width
	 * @return void
	 */
	public function setWidth($width) {
		$this->width = (integer) $width;
	}

	/**
	 * Returns this width
	 *
	 * @return integer
	 */
	public function getWidth() {
		return (integer) $this->getPropertyValue('width', 'map');
	}

	/**
	 * Sets this height
	 *
	 * @param integer $height
	 * @return void
	 */
	public function setHeight($height) {
		$this->height = (integer) $height;
	}

	/**
	 * Returns this height
	 *
	 * @return integer
	 */
	public function getHeight() {
		return (integer) $this->getPropertyValue('height', 'map');
	}

	/**
	 * Sets this backgroundColor
	 *
	 * @param string $backgroundColor
	 * @return void
	 */
	public function setBackgroundColor($backgroundColor) {
		$this->backgroundColor = $backgroundColor;
	}

	/**
	 * Returns this backgroundColor
	 *
	 * @return string
	 */
	public function getBackgroundColor() {
		return $this->getPropertyValue('backgroundColor', 'map');
	}

	/**
	 * Sets this minZoom.
	 *
	 * @param integer $minZoom
	 * @return void
	 */
	public function setMinZoom($minZoom) {
		$this->minZoom = (integer) $minZoom;
	}

	/**
	 * Returns this minZoom.
	 *
	 * @return integer
	 */
	public function getMinZoom() {
		return (integer) $this->getPropertyValue('minZoom', 'map');
	}

	/**
	 * Sets this maxZoom.
	 *
	 * @param integer $maxZoom
	 * @return void
	 */
	public function setMaxZoom($maxZoom) {
		$this->maxZoom = (integer) $maxZoom;
	}

	/**
	 * Returns this maxZoom.
	 *
	 * @return integer
	 */
	public function getMaxZoom() {
		return (integer) $this->getPropertyValue('maxZoom', 'map');
	}

	/**
	 * Sets this noClear
	 *
	 * @param boolean $noClear
	 * @return void
	 */
	public function setNoClear($noClear) {
		$this->noClear = (boolean) $noClear;
	}

	/**
	 * Returns this noClear
	 *
	 * @return boolean
	 */
	public function isNoClear() {
		return (boolean) $this->getPropertyValue('noClear', 'map');
	}

	/**
	 * Sets this centerType
	 *
	 * @param integer $centerType
	 * @return void
	 */
	public function setCenterType($centerType) {
		$this->centerType = (integer) $centerType;
	}

	/**
	 * Returns this centerType
	 *
	 * @return integer
	 */
	public function getCenterType() {
		return (integer) $this->getPropertyValue('centerType', 'map');
	}

	/**
	 * Sets this center
	 *
	 * @param string $center
	 * @return void
	 */
	public function setCenter($center) {
		$this->center = $center;
	}

	/**
	 * Returns this center
	 *
	 * @return string
	 */
	public function getCenter() {
		return $this->getPropertyValue('center', 'map');
	}

	/**
	 * Sets this zoom.
	 *
	 * @param integer $zoom
	 * @return void
	 */
	public function setZoom($zoom) {
		$this->zoom = (integer) $zoom;
	}

	/**
	 * Returns this zoom.
	 *
	 * @return integer
	 */
	public function getZoom() {
		return (integer) $this->getPropertyValue('zoom', 'map');
	}

	/**
	 * Sets this useMarkerCluster.
	 *
	 * @param boolean $useMarkerCluster
	 * @return void
	 */
	public function setUseMarkerCluster($useMarkerCluster) {
		$this->useMarkerCluster = (boolean) $useMarkerCluster;
	}

	/**
	 * Returns this useMarkerCluster.
	 *
	 * @return boolean
	 */
	public function isUseMarkerCluster() {
		return (boolean) $this->getPropertyValue('useMarkerCluster', 'map');
	}

	/**
	 * Sets this disableDefaultUi
	 *
	 * @param boolean $disableDefaultUi
	 * @return void
	 */
	public function setDisableDefaultUi($disableDefaultUi) {
		$this->disableDefaultUi = (boolean) $disableDefaultUi;
	}

	/**
	 * Returns this disableDefaultUi
	 *
	 * @return boolean
	 */
	public function isDisableDefaultUi() {
		return (boolean) $this->getPropertyValue('disableDefaultUi', 'map');
	}

	/**
	 * Sets this mapTypeControl
	 *
	 * @param boolean $mapTypeControl
	 * @return void
	 */
	public function setMapTypeControl($mapTypeControl) {
		$this->mapTypeControl = (boolean) $mapTypeControl;
	}

	/**
	 * Returns this mapTypeControl
	 *
	 * @return boolean
	 */
	public function hasMapTypeControl() {
		return (boolean) $this->getPropertyValue('mapTypeControl', 'map');
	}

	/**
	 * Sets this mapTypeControlsMapTypeIds
	 *
	 * @param string $mapTypeControlsMapTypeIds
	 * @return void
	 */
	public function setMapTypeControlsMapTypeIds($mapTypeControlsMapTypeIds) {
		$this->mapTypeControlsMapTypeIds = $mapTypeControlsMapTypeIds;
	}

	/**
	 * Returns this mapTypeControlsMapTypeIds
	 *
	 * @return string
	 */
	public function getMapTypeControlsMapTypeIds() {
		return $this->getPropertyValue('mapTypeControlsMapTypeIds', 'map');
	}

	/**
	 * Sets this mapTypeControlsPosition
	 *
	 * @param string $mapTypeControlsPosition
	 * @return void
	 */
	public function setMapTypeControlsPosition($mapTypeControlsPosition) {
		$this->mapTypeControlsPosition = $mapTypeControlsPosition;
	}

	/**
	 * Returns this mapTypeControlsPosition
	 *
	 * @return string
	 */
	public function getMapTypeControlsPosition() {
		return $this->getPropertyValue('mapTypeControlsPosition', 'map');
	}

	/**
	 * Sets this mapTypeControlsStyle
	 *
	 * @param string $mapTypeControlsStyle
	 * @return void
	 */
	public function setMapTypeControlsStyle($mapTypeControlsStyle) {
		$this->mapTypeControlsStyle = $mapTypeControlsStyle;
	}

	/**
	 * Returns this mapTypeControlsStyle
	 *
	 * @return string
	 */
	public function getMapTypeControlsStyle() {
		return $this->getPropertyValue('mapTypeControlsStyle', 'map');
	}

	/**
	 * Sets this rotateControl
	 *
	 * @param boolean $rotateControl
	 * @return void
	 */
	public function setRotateControl($rotateControl) {
		$this->rotateControl = (boolean) $rotateControl;
	}

	/**
	 * Returns this rotateControl
	 *
	 * @return boolean
	 */
	public function hasRotateControl() {
		return (boolean) $this->getPropertyValue('rotateControl', 'map');
	}

	/**
	 * Sets this rotateControlsPosition
	 *
	 * @param string $rotateControlsPosition
	 * @return void
	 */
	public function setRotateControlsPosition($rotateControlsPosition) {
		$this->rotateControlsPosition = $rotateControlsPosition;
	}

	/**
	 * Returns this rotateControlsPosition
	 *
	 * @return string
	 */
	public function getRotateControlsPosition() {
		return $this->getPropertyValue('rotateControlsPosition', 'map');
	}

	/**
	 * Sets this scaleControl
	 *
	 * @param boolean $scaleControl
	 * @return void
	 */
	public function setScaleControl($scaleControl) {
		$this->scaleControl = (boolean) $scaleControl;
	}

	/**
	 * Returns this scaleControl
	 *
	 * @return boolean
	 */
	public function hasScaleControl() {
		return (boolean) $this->getPropertyValue('scaleControl', 'map');
	}

	/**
	 * Sets this scaleControlsPosition
	 *
	 * @param string $scaleControlsPosition
	 * @return void
	 */
	public function setScaleControlsPosition($scaleControlsPosition) {
		$this->scaleControlsPosition = $scaleControlsPosition;
	}

	/**
	 * Returns this scaleControlsPosition
	 *
	 * @return string
	 */
	public function getScaleControlsPosition() {
		return $this->getPropertyValue('scaleControlsPosition', 'map');
	}

	/**
	 * Sets this scaleControlsStyle
	 *
	 * @param string $scaleControlsStyle
	 * @return void
	 */
	public function setScaleControlsStyle($scaleControlsStyle) {
		$this->scaleControlsStyle = $scaleControlsStyle;
	}

	/**
	 * Returns this scaleControlsStyle
	 *
	 * @return string
	 */
	public function getScaleControlsStyle() {
		return $this->getPropertyValue('scaleControlsStyle', 'map');
	}

	/**
	 * Sets this panControl
	 *
	 * @param boolean $panControl
	 * @return void
	 */
	public function setPanControl($panControl) {
		$this->panControl = (boolean) $panControl;
	}

	/**
	 * Returns this panControl
	 *
	 * @return boolean
	 */
	public function hasPanControl() {
		return (boolean) $this->getPropertyValue('panControl', 'map');
	}

	/**
	 * Sets this panControlsPosition
	 *
	 * @param string $panControlsPosition
	 * @return void
	 */
	public function setPanControlsPosition($panControlsPosition) {
		$this->panControlsPosition = $panControlsPosition;
	}

	/**
	 * Returns this panControlsPosition
	 *
	 * @return string
	 */
	public function getPanControlsPosition() {
		return $this->getPropertyValue('panControlsPosition', 'map');
	}

	/**
	 * Sets this zoomControl
	 *
	 * @param boolean $zoomControl
	 * @return void
	 */
	public function setZoomControl($zoomControl) {
		$this->zoomControl = (boolean) $zoomControl;
	}

	/**
	 * Returns this zoomControl
	 *
	 * @return boolean
	 */
	public function hasZoomControl() {
		return (boolean) $this->getPropertyValue('zoomControl', 'map');
	}

	/**
	 * Sets this zoomControlsPosition
	 *
	 * @param string $zoomControlsPosition
	 * @return void
	 */
	public function setZoomControlsPosition($zoomControlsPosition) {
		$this->zoomControlsPosition = $zoomControlsPosition;
	}

	/**
	 * Returns this zoomControlsPosition
	 *
	 * @return string
	 */
	public function getZoomControlsPosition() {
		return $this->getPropertyValue('zoomControlsPosition', 'map');
	}

	/**
	 * Sets this zoomControlsStyle
	 *
	 * @param string $zoomControlsStyle
	 * @return void
	 */
	public function setZoomControlsStyle($zoomControlsStyle) {
		$this->zoomControlsStyle = $zoomControlsStyle;
	}

	/**
	 * Returns this zoomControlsStyle
	 *
	 * @return string
	 */
	public function getZoomControlsStyle() {
		return $this->getPropertyValue('zoomControlsStyle', 'map');
	}

	/**
	 * Sets this overviewMapControl
	 *
	 * @param boolean $overviewMapControl
	 * @return void
	 */
	public function setOverviewMapControl($overviewMapControl) {
		$this->overviewMapControl = (boolean) $overviewMapControl;
	}

	/**
	 * Returns this overviewMapControl
	 *
	 * @return boolean
	 */
	public function hasOverviewMapControl() {
		return (boolean) $this->getPropertyValue('overviewMapControl', 'map');
	}

	/**
	 * Sets this overviewMapControlsIsOpened
	 *
	 * @param string $overviewMapControlsIsOpened
	 * @return void
	 */
	public function setOverviewMapControlsIsOpened($overviewMapControlsIsOpened) {
		$this->overviewMapControlsIsOpened = $overviewMapControlsIsOpened;
	}

	/**
	 * Returns this overviewMapControlsIsOpened
	 *
	 * @return string
	 */
	public function getOverviewMapControlsIsOpened() {
		return $this->getPropertyValue('overviewMapControlsIsOpened', 'map');
	}

	/**
	 * Sets this streetViewControl
	 *
	 * @param boolean $streetViewControl
	 * @return void
	 */
	public function setStreetViewControl($streetViewControl) {
		$this->streetViewControl = (boolean) $streetViewControl;
	}

	/**
	 * Returns this streetViewControl
	 *
	 * @return boolean
	 */
	public function hasStreetViewControl() {
		return (boolean) $this->getPropertyValue('streetViewControl', 'map');
	}

	/**
	 * Sets this streetViewControlsPosition
	 *
	 * @param string $streetViewControlsPosition
	 * @return void
	 */
	public function setStreetViewControlsPosition($streetViewControlsPosition) {
		$this->streetViewControlsPosition = $streetViewControlsPosition;
	}

	/**
	 * Returns this scaleControlsPosition
	 *
	 * @return string
	 */
	public function getStreetViewControlsPosition() {
		return $this->getPropertyValue('streetViewControlsPosition', 'map');
	}

	/**
	 * Sets this disableDoubleClickZoom
	 *
	 * @param boolean $disableDoubleClickZoom
	 * @return void
	 */
	public function setDisableDoubleClickZoom($disableDoubleClickZoom) {
		$this->disableDoubleClickZoom = (boolean) $disableDoubleClickZoom;
	}

	/**
	 * Returns this disableDoubleClickZoom
	 *
	 * @return boolean
	 */
	public function isDisableDoubleClickZoom() {
		return (boolean) $this->getPropertyValue('disableDoubleClickZoom', 'map');
	}

	/**
	 * Sets this scrollwheel
	 *
	 * @param boolean $scrollwheel
	 * @return void
	 */
	public function setScrollwheel($scrollwheel) {
		$this->scrollwheel = (boolean) $scrollwheel;
	}

	/**
	 * Returns this scrollwheel
	 *
	 * @return boolean
	 */
	public function hasScrollwheel() {
		return (boolean) $this->getPropertyValue('scrollwheel', 'map');
	}

	/**
	 * Sets this draggable
	 *
	 * @param boolean $draggable
	 * @return void
	 */
	public function setDraggable($draggable) {
		$this->draggable = (boolean) $draggable;
	}

	/**
	 * Returns this draggable
	 *
	 * @return boolean
	 */
	public function isDraggable() {
		return (boolean) $this->getPropertyValue('draggable', 'map');
	}

	/**
	 * Sets this draggableCursor
	 *
	 * @param string $draggableCursor
	 * @return void
	 */
	public function setDraggableCursor($draggableCursor) {
		$this->draggableCursor = $draggableCursor;
	}

	/**
	 * Returns this draggableCursor
	 *
	 * @return string
	 */
	public function getDraggableCursor() {
		return Tx_AdGoogleMaps_Utility_BackEnd::getRelativeUploadPathAndFileName('ad_google_maps', 'mouseCursor', $this->getPropertyValue('draggableCursor', 'map'));
	}

	/**
	 * Sets this draggingCursor
	 *
	 * @param string $draggingCursor
	 * @return void
	 */
	public function setDraggingCursor($draggingCursor) {
		$this->draggingCursor = $draggingCursor;
	}

	/**
	 * Returns this draggingCursor
	 *
	 * @return string
	 */
	public function getDraggingCursor() {
		return Tx_AdGoogleMaps_Utility_BackEnd::getRelativeUploadPathAndFileName('ad_google_maps', 'mouseCursor', $this->getPropertyValue('draggingCursor', 'map'));
	}

	/**
	 * Sets this keyboardShortcuts
	 *
	 * @param boolean $keyboardShortcuts
	 * @return void
	 */
	public function setKeyboardShortcuts($keyboardShortcuts) {
		$this->keyboardShortcuts = (boolean) $keyboardShortcuts;
	}

	/**
	 * Returns this keyboardShortcuts
	 *
	 * @return boolean
	 */
	public function hasKeyboardShortcuts() {
		return (boolean) $this->getPropertyValue('keyboardShortcuts', 'map');
	}

	/**
	 * Sets this infoWindowPlacingType
	 *
	 * @param integer $infoWindowPlacingType
	 * @return void
	 */
	public function setInfoWindowPlacingType($infoWindowPlacingType) {
		$this->infoWindowPlacingType = (integer) $infoWindowPlacingType;
	}

	/**
	 * Returns this infoWindowPlacingType
	 *
	 * @return integer
	 */
	public function getInfoWindowPlacingType() {
		return (integer) $this->getPropertyValue('infoWindowPlacingType', 'map');
	}

	/**
	 * Sets this infoWindowPosition
	 *
	 * @param string $infoWindowPosition
	 * @return void
	 */
	public function setInfoWindowPosition($infoWindowPosition) {
		$this->infoWindowPosition = $infoWindowPosition;
	}

	/**
	 * Returns this infoWindowPosition
	 *
	 * @return string
	 */
	public function getInfoWindowPosition() {
		return $this->getPropertyValue('infoWindowPosition', 'map');
	}

	/**
	 * Sets this infoWindowObjectNumber
	 *
	 * @param string $infoWindowObjectNumber
	 * @return void
	 */
	public function setInfoWindowObjectNumber($infoWindowObjectNumber) {
		$this->infoWindowObjectNumber = $infoWindowObjectNumber;
	}

	/**
	 * Returns this infoWindowObjectNumber
	 *
	 * @return string
	 */
	public function getInfoWindowObjectNumber() {
		return $this->getPropertyValue('infoWindowObjectNumber', 'map');
	}

	/**
	 * Sets this infoWindowCloseAllOnMapClick
	 *
	 * @param boolean $infoWindowCloseAllOnMapClick
	 * @return void
	 */
	public function setInfoWindowCloseAllOnMapClick($infoWindowCloseAllOnMapClick) {
		$this->infoWindowCloseAllOnMapClick = (boolean) $infoWindowCloseAllOnMapClick;
	}

	/**
	 * Returns this infoWindowCloseAllOnMapClick
	 *
	 * @return boolean
	 */
	public function isInfoWindowCloseAllOnMapClick() {
		return (boolean) $this->getPropertyValue('infoWindowCloseAllOnMapClick', 'map');
	}

	/**
	 * Sets this infoWindowBehaviour
	 *
	 * @param integer $infoWindowBehaviour
	 * @return void
	 */
	public function setInfoWindowBehaviour($infoWindowBehaviour) {
		$this->infoWindowBehaviour = (integer) $infoWindowBehaviour;
	}

	/**
	 * Returns this infoWindowBehaviour
	 *
	 * @return integer
	 */
	public function getInfoWindowBehaviour() {
		return (integer) $this->getPropertyValue('infoWindowBehaviour', 'map');
	}

	/**
	 * Sets this infoWindowKeepOpen
	 *
	 * @param boolean $infoWindowKeepOpen
	 * @return void
	 */
	public function setInfoWindowKeepOpen($infoWindowKeepOpen) {
		$this->infoWindowKeepOpen = (boolean) $infoWindowKeepOpen;
	}

	/**
	 * Returns this infoWindowKeepOpen
	 *
	 * @return boolean
	 */
	public function isInfoWindowKeepOpen() {
		return (boolean) $this->getPropertyValue('infoWindowKeepOpen', 'map');
	}

	/**
	 * Sets this infoWindowCloseOnClick
	 *
	 * @param boolean $infoWindowCloseOnClick
	 * @return void
	 */
	public function setInfoWindowCloseOnClick($infoWindowCloseOnClick) {
		$this->infoWindowCloseOnClick = (boolean) $infoWindowCloseOnClick;
	}

	/**
	 * Returns this infoWindowCloseOnClick
	 *
	 * @return boolean
	 */
	public function isInfoWindowCloseOnClick() {
		return (boolean) $this->getPropertyValue('infoWindowCloseOnClick', 'map');
	}

	/**
	 * Sets this infoWindowDisableAutoPan
	 *
	 * @param boolean $infoWindowDisableAutoPan
	 * @return void
	 */
	public function setInfoWindowDisableAutoPan($infoWindowDisableAutoPan) {
		$this->infoWindowDisableAutoPan = (boolean) $infoWindowDisableAutoPan;
	}

	/**
	 * Returns this infoWindowDisableAutoPan
	 *
	 * @return boolean
	 */
	public function isInfoWindowDisableAutoPan() {
		return (boolean) $this->getPropertyValue('infoWindowDisableAutoPan', 'map');
	}

	/**
	 * Sets this infoWindowMaxWidth
	 *
	 * @param integer $infoWindowMaxWidth
	 * @return void
	 */
	public function setInfoWindowMaxWidth($infoWindowMaxWidth) {
		$this->infoWindowMaxWidth = $infoWindowMaxWidth;
	}

	/**
	 * Returns this infoWindowMaxWidth
	 *
	 * @return integer
	 */
	public function getInfoWindowMaxWidth() {
		return (integer) $this->getPropertyValue('infoWindowMaxWidth', 'map');
	}

	/**
	 * Sets this infoWindowPixelOffsetWidth
	 *
	 * @param integer $infoWindowPixelOffsetWidth
	 * @return void
	 */
	public function setInfoWindowPixelOffsetWidth($infoWindowPixelOffsetWidth) {
		$this->infoWindowPixelOffsetWidth = $infoWindowPixelOffsetWidth;
	}

	/**
	 * Returns this infoWindowPixelOffsetWidth
	 *
	 * @return integer
	 */
	public function getInfoWindowPixelOffsetWidth() {
		return (integer) $this->getPropertyValue('infoWindowPixelOffsetWidth', 'map');
	}

	/**
	 * Sets this infoWindowPixelOffsetHeight
	 *
	 * @param integer $infoWindowPixelOffsetHeight
	 * @return void
	 */
	public function setInfoWindowPixelOffsetHeight($infoWindowPixelOffsetHeight) {
		$this->infoWindowPixelOffsetHeight = $infoWindowPixelOffsetHeight;
	}

	/**
	 * Returns this infoWindowPixelOffsetHeight
	 *
	 * @return integer
	 */
	public function getInfoWindowPixelOffsetHeight() {
		return (integer) $this->getPropertyValue('infoWindowPixelOffsetHeight', 'map');
	}

	/**
	 * Sets this searchMarker
	 *
	 * @param string $searchMarker
	 * @return void
	 */
	public function setSearchMarker($searchMarker) {
		$this->searchMarker = $searchMarker;
	}

	/**
	 * Returns this searchMarker
	 *
	 * @return string
	 */
	public function getSearchMarker() {
		return Tx_AdGoogleMaps_Utility_BackEnd::getRelativeUploadPathAndFileName('ad_google_maps', 'markerIcons', $this->getPropertyValue('searchMarker', 'map'));
	}

	/**
	 * Sets this searchMarkerWidth
	 *
	 * @param integer $searchMarkerWidth
	 * @return void
	 */
	public function setSearchMarkerWidth($searchMarkerWidth) {
		$this->searchMarkerWidth = $searchMarkerWidth;
	}

	/**
	 * Returns this searchMarkerWidth
	 *
	 * @return integer
	 */
	public function getSearchMarkerWidth() {
		return (integer) $this->getPropertyValue('searchMarkerWidth', 'map');
	}

	/**
	 * Sets this searchMarkerHeight
	 *
	 * @param integer $searchMarkerHeight
	 * @return void
	 */
	public function setSearchMarkerHeight($searchMarkerHeight) {
		$this->searchMarkerHeight = $searchMarkerHeight;
	}

	/**
	 * Returns this searchMarkerHeight
	 *
	 * @return integer
	 */
	public function getSearchMarkerHeight() {
		return (integer) $this->getPropertyValue('searchMarkerHeight', 'map');
	}

	/**
	 * Sets this searchMarkerOriginX
	 *
	 * @param integer $searchMarkerOriginX
	 * @return void
	 */
	public function setSearchMarkerOriginX($searchMarkerOriginX) {
		$this->searchMarkerOriginX = $searchMarkerOriginX;
	}

	/**
	 * Returns this searchMarkerOriginX
	 *
	 * @return integer
	 */
	public function getSearchMarkerOriginX() {
		return (integer) $this->getPropertyValue('searchMarkerOriginX', 'map');
	}

	/**
	 * Sets this searchMarkerOriginY
	 *
	 * @param integer $searchMarkerOriginY
	 * @return void
	 */
	public function setSearchMarkerOriginY($searchMarkerOriginY) {
		$this->searchMarkerOriginY = $searchMarkerOriginY;
	}

	/**
	 * Returns this searchMarkerOriginY
	 *
	 * @return integer
	 */
	public function getSearchMarkerOriginY() {
		return (integer) $this->getPropertyValue('searchMarkerOriginY', 'map');
	}

	/**
	 * Sets this searchMarkerAnchorX
	 *
	 * @param integer $searchMarkerAnchorX
	 * @return void
	 */
	public function setSearchMarkerAnchorX($searchMarkerAnchorX) {
		$this->searchMarkerAnchorX = $searchMarkerAnchorX;
	}

	/**
	 * Returns this searchMarkerAnchorX
	 *
	 * @return integer
	 */
	public function getSearchMarkerAnchorX() {
		return (integer) $this->getPropertyValue('searchMarkerAnchorX', 'map');
	}

	/**
	 * Sets this searchMarkerAnchorY
	 *
	 * @param integer $searchMarkerAnchorY
	 * @return void
	 */
	public function setSearchMarkerAnchorY($searchMarkerAnchorY) {
		$this->searchMarkerAnchorY = $searchMarkerAnchorY;
	}

	/**
	 * Returns this searchMarkerAnchorY
	 *
	 * @return integer
	 */
	public function getSearchMarkerAnchorY() {
		return (integer) $this->getPropertyValue('searchMarkerAnchorY', 'map');
	}

	/**
	 * Sets this searchMarkerScaledWidth
	 *
	 * @param integer $searchMarkerScaledWidth
	 * @return void
	 */
	public function setSearchMarkerScaledWidth($searchMarkerScaledWidth) {
		$this->searchMarkerScaledWidth = $searchMarkerScaledWidth;
	}

	/**
	 * Returns this searchMarkerScaledWidth
	 *
	 * @return integer
	 */
	public function getSearchMarkerScaledWidth() {
		return (integer) $this->getPropertyValue('searchMarkerScaledWidth', 'map');
	}

	/**
	 * Sets this searchMarkerScaledHeight
	 *
	 * @param integer $searchMarkerScaledHeight
	 * @return void
	 */
	public function setSearchMarkerScaledHeight($searchMarkerScaledHeight) {
		$this->searchMarkerScaledHeight = $searchMarkerScaledHeight;
	}

	/**
	 * Returns this searchMarkerScaledHeight
	 *
	 * @return integer
	 */
	public function getSearchMarkerScaledHeight() {
		return (integer) $this->getPropertyValue('searchMarkerScaledHeight', 'map');
	}

}

?>