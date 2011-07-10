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
 * Model: Layer.
 * Nearly the same like the Google Maps API
 * @see http://code.google.com/apis/maps/documentation/javascript/reference.html
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 * @api
 */
class Tx_AdGoogleMaps_Domain_Model_Layer_Marker extends Tx_AdGoogleMaps_Domain_Model_Layer {

	/**
	 * @var boolean
	 */
	protected $visible;

	/**
	 * @var boolean
	 */
	protected $clickable;

	/**
	 * @var boolean
	 */
	protected $draggable;

	/**
	 * @var boolean
	 */
	protected $raiseOnDrag;

	/**
	 * @var boolean
	 */
	protected $optimized;

	/**
	 * @var string
	 */
	protected $animation;

	/**
	 * @var integer
	 */
	protected $zindex;

	/**
	 * @var string
	 */
	protected $markerTitle;

	/**
	 * @var string
	 */
	protected $markerTitleObjectNumber;

	/**
	 * @var string
	 */
	protected $icon;

	/**
	 * @var string
	 */
	protected $iconObjectNumber;

	/**
	 * @var integer
	 */
	protected $iconWidth;

	/**
	 * @var integer
	 */
	protected $iconHeight;

	/**
	 * @var integer
	 */
	protected $iconOriginX;

	/**
	 * @var integer
	 */
	protected $iconOriginY;

	/**
	 * @var integer
	 */
	protected $iconAnchorX;

	/**
	 * @var integer
	 */
	protected $iconAnchorY;

	/**
	 * @var integer
	 */
	protected $iconScaledWidth;

	/**
	 * @var integer
	 */
	protected $iconScaledHeight;

	/**
	 * @var string
	 */
	protected $shadow;

	/**
	 * @var string
	 */
	protected $shadowObjectNumber;

	/**
	 * @var integer
	 */
	protected $shadowWidth;

	/**
	 * @var integer
	 */
	protected $shadowHeight;

	/**
	 * @var integer
	 */
	protected $shadowOriginX;

	/**
	 * @var integer
	 */
	protected $shadowOriginY;

	/**
	 * @var integer
	 */
	protected $shadowAnchorX;

	/**
	 * @var integer
	 */
	protected $shadowAnchorY;

	/**
	 * @var integer
	 */
	protected $shadowScaledWidth;

	/**
	 * @var integer
	 */
	protected $shadowScaledHeight;

	/**
	 * @var boolean
	 */
	protected $flat;

	/**
	 * @var string
	 */
	protected $shapeType;

	/**
	 * @var string
	 */
	protected $shapeCoords;

	/**
	 * @var string
	 */
	protected $mouseCursor;

	/**
	 * @var integer
	 */
	protected $infoWindow;

	/**
	 * @var string
	 */
	protected $infoWindowObjectNumber;

	/**
	 * @var array
	 */
	protected $infoWindowRenderConfiguration;

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
	 * @var integer
	 */
	protected $infoWindowZindex;

	/**
	 * @var array
	 */
	protected $infoWindowOptions;

	/*
	 * Initialize this layer.
	 * 
	 * @return void
	 */
	public function initializeObject() {
		parent::initializeObject();
	}

	/**
	 * Sets this visible
	 *
	 * @param boolean $visible
	 * @return void
	 */
	public function setVisible($visible) {
		$this->visible = (boolean) $visible;
	}

	/**
	 * Returns this visible
	 *
	 * @return boolean
	 */
	public function isVisible() {
		return (boolean) $this->getPropertyValue('visible', 'layer');
	}

	/**
	 * Sets this clickable
	 *
	 * @param boolean $clickable
	 * @return void
	 */
	public function setClickable($clickable) {
		$this->clickable = (boolean) $clickable;
	}

	/**
	 * Returns this clickable
	 *
	 * @return boolean
	 */
	public function isClickable() {
		return (boolean) $this->getPropertyValue('clickable', 'layer');
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
		return (boolean) $this->getPropertyValue('draggable', 'layer');
	}

	/**
	 * Sets this raiseOnDrag
	 *
	 * @param boolean $raiseOnDrag
	 * @return void
	 */
	public function setRaiseOnDrag($raiseOnDrag) {
		$this->raiseOnDrag = (boolean) $raiseOnDrag;
	}

	/**
	 * Returns this raiseOnDrag
	 *
	 * @return boolean
	 */
	public function isRaiseOnDrag() {
		return (boolean) ($this->isDraggable() === TRUE && (boolean) $this->getPropertyValue('raiseOnDrag', 'layer') === TRUE);
	}

	/**
	 * Sets this optimized
	 *
	 * @param boolean $optimized
	 * @return void
	 */
	public function setOptimized($optimized) {
		$this->optimized = (boolean) $optimized;
	}

	/**
	 * Returns this optimized
	 *
	 * @return boolean
	 */
	public function isOptimized() {
		return (boolean) $this->getPropertyValue('optimized', 'layer');
	}

	/**
	 * Sets this animation.
	 *
	 * @param string $animation
	 * @return void
	 */
	public function setAnimation($animation) {
		$this->animation = $animation;
	}

	/**
	 * Returns this animation.
	 *
	 * @return string
	 */
	public function getAnimation() {
		return $this->getPropertyValue('animation', 'layer');
	}

	/**
	 * Sets this zindex
	 *
	 * @param integer $zindex
	 * @return void
	 */
	public function setZindex($zindex) {
		$this->zindex = $zindex;
	}

	/**
	 * Returns this zindex
	 *
	 * @return integer
	 */
	public function getZindex() {
		return (integer) $this->getPropertyValue('zindex', 'layer');
	}

	/**
	 * Sets this markerTitle
	 *
	 * @param string $markerTitle
	 * @return void
	 */
	public function setMarkerTitle($markerTitle) {
		$this->markerTitle = $markerTitle;
	}

	/**
	 * Returns this markerTitle
	 *
	 * @return string
	 */
	public function getMarkerTitle() {
		return $this->getPropertyValue('markerTitle', 'layer');
	}

	/**
	 * Sets this markerTitleObjectNumber
	 *
	 * @param string $markerTitleObjectNumber
	 * @return void
	 */
	public function setMarkerTitleObjectNumber($markerTitleObjectNumber) {
		$this->markerTitleObjectNumber = $markerTitleObjectNumber;
	}

	/**
	 * Returns this markerTitleObjectNumber
	 *
	 * @return string
	 */
	public function getMarkerTitleObjectNumber() {
		return $this->getPropertyValue('markerTitleObjectNumber', 'layer');
	}

	/**
	 * Sets this icon
	 *
	 * @param string $icon
	 * @return void
	 */
	public function setIcon($icon) {
		$this->icon = $icon;
	}

	/**
	 * Returns this icon
	 *
	 * @return string
	 */
	public function getIcon() {
		return $this->getPropertyValue('icon', 'layer');
	}

	/**
	 * Sets this iconObjectNumber
	 *
	 * @param string $iconObjectNumber
	 * @return void
	 */
	public function setIconObjectNumber($iconObjectNumber) {
		$this->iconObjectNumber = $iconObjectNumber;
	}

	/**
	 * Returns this iconObjectNumber
	 *
	 * @return string
	 */
	public function getIconObjectNumber() {
		return $this->getPropertyValue('iconObjectNumber', 'layer');
	}

	/**
	 * Sets this iconWidth
	 *
	 * @param integer $iconWidth
	 * @return void
	 */
	public function setIconWidth($iconWidth) {
		$this->iconWidth = (integer) $iconWidth;
	}

	/**
	 * Returns this iconWidth
	 *
	 * @return integer
	 */
	public function getIconWidth() {
		return (integer) $this->getPropertyValue('iconWidth', 'layer');
	}

	/**
	 * Sets this iconHeight
	 *
	 * @param integer $iconHeight
	 * @return void
	 */
	public function setIconHeight($iconHeight) {
		$this->iconHeight = (integer) $iconHeight;
	}

	/**
	 * Returns this iconHeight
	 *
	 * @return integer
	 */
	public function getIconHeight() {
		return (integer) $this->getPropertyValue('iconHeight', 'layer');
	}

	/**
	 * Sets this iconOriginX
	 *
	 * @param integer $iconOriginX
	 * @return void
	 */
	public function setIconOriginX($iconOriginX) {
		$this->iconOriginX = (integer) $iconOriginX;
	}

	/**
	 * Returns this iconOriginX
	 *
	 * @return integer
	 */
	public function getIconOriginX() {
		return (integer) $this->getPropertyValue('iconOriginX', 'layer');
	}

	/**
	 * Sets this iconOriginY
	 *
	 * @param integer $iconOriginY
	 * @return void
	 */
	public function setIconOriginY($iconOriginY) {
		$this->iconOriginY = (integer) $iconOriginY;
	}

	/**
	 * Returns this iconOriginY
	 *
	 * @return integer
	 */
	public function getIconOriginY() {
		return (integer) $this->getPropertyValue('iconOriginY', 'layer');
	}

	/**
	 * Sets this iconAnchorX
	 *
	 * @param integer $iconAnchorX
	 * @return void
	 */
	public function setIconAnchorX($iconAnchorX) {
		$this->iconAnchorX = (integer) $iconAnchorX;
	}

	/**
	 * Returns this iconAnchorX
	 *
	 * @return integer
	 */
	public function getIconAnchorX() {
		return (integer) $this->getPropertyValue('iconAnchorX', 'layer');
	}

	/**
	 * Sets this iconAnchorY
	 *
	 * @param integer $iconAnchorY
	 * @return void
	 */
	public function setIconAnchorY($iconAnchorY) {
		$this->iconAnchorY = (integer) $iconAnchorY;
	}

	/**
	 * Returns this iconAnchorY
	 *
	 * @return integer
	 */
	public function getIconAnchorY() {
		return (integer) $this->getPropertyValue('iconAnchorY', 'layer');
	}

	/**
	 * Sets this iconScaledWidth
	 *
	 * @param integer $iconScaledWidth
	 * @return void
	 */
	public function setIconScaledWidth($iconScaledWidth) {
		$this->iconScaledWidth = (integer) $iconScaledWidth;
	}

	/**
	 * Returns this iconScaledWidth
	 *
	 * @return integer
	 */
	public function getIconScaledWidth() {
		return (integer) $this->getPropertyValue('iconScaledWidth', 'layer');
	}

	/**
	 * Sets this iconScaledHeight
	 *
	 * @param integer $iconScaledHeight
	 * @return void
	 */
	public function setIconScaledHeight($iconScaledHeight) {
		$this->iconScaledHeight = (integer) $iconScaledHeight;
	}

	/**
	 * Returns this iconScaledHeight
	 *
	 * @return integer
	 */
	public function getIconScaledHeight() {
		return (integer) $this->getPropertyValue('iconScaledHeight', 'layer');
	}

	/**
	 * Sets this shadow
	 *
	 * @param string $shadow
	 * @return void
	 */
	public function setShadow($shadow) {
		$this->shadow = $shadow;
	}

	/**
	 * Returns this shadow
	 *
	 * @return string
	 */
	public function getShadow() {
		return $this->getPropertyValue('shadow', 'layer');
	}

	/**
	 * Sets this shadowObjectNumber
	 *
	 * @param string $shadowObjectNumber
	 * @return void
	 */
	public function setShadowObjectNumber($shadowObjectNumber) {
		$this->shadowObjectNumber = $shadowObjectNumber;
	}

	/**
	 * Returns this shadowObjectNumber
	 *
	 * @return string
	 */
	public function getShadowObjectNumber() {
		return $this->getPropertyValue('shadowObjectNumber', 'layer');
	}

	/**
	 * Sets this shadowWidth
	 *
	 * @param integer $shadowWidth
	 * @return void
	 */
	public function setShadowWidth($shadowWidth) {
		$this->shadowWidth = $shadowWidth;
	}

	/**
	 * Returns this shadowWidth
	 *
	 * @return integer
	 */
	public function getShadowWidth() {
		return (integer) $this->getPropertyValue('shadowWidth', 'layer');
	}

	/**
	 * Sets this shadowHeight
	 *
	 * @param integer $shadowHeight
	 * @return void
	 */
	public function setShadowHeight($shadowHeight) {
		$this->shadowHeight = $shadowHeight;
	}

	/**
	 * Returns this shadowHeight
	 *
	 * @return integer
	 */
	public function getShadowHeight() {
		return (integer) $this->getPropertyValue('shadowHeight', 'layer');
	}

	/**
	 * Sets this shadowOriginX
	 *
	 * @param integer $shadowOriginX
	 * @return void
	 */
	public function setShadowOriginX($shadowOriginX) {
		$this->shadowOriginX = $shadowOriginX;
	}

	/**
	 * Returns this shadowOriginX
	 *
	 * @return integer
	 */
	public function getShadowOriginX() {
		return (integer) $this->getPropertyValue('shadowOriginX', 'layer');
	}

	/**
	 * Sets this shadowOriginY
	 *
	 * @param integer $shadowOriginY
	 * @return void
	 */
	public function setShadowOriginY($shadowOriginY) {
		$this->shadowOriginY = $shadowOriginY;
	}

	/**
	 * Returns this shadowOriginY
	 *
	 * @return integer
	 */
	public function getShadowOriginY() {
		return (integer) $this->getPropertyValue('shadowOriginY', 'layer');
	}

	/**
	 * Sets this shadowAnchorX
	 *
	 * @param integer $shadowAnchorX
	 * @return void
	 */
	public function setShadowAnchorX($shadowAnchorX) {
		$this->shadowAnchorX = $shadowAnchorX;
	}

	/**
	 * Returns this shadowAnchorX
	 *
	 * @return integer
	 */
	public function getShadowAnchorX() {
		return (integer) $this->getPropertyValue('shadowAnchorX', 'layer');
	}

	/**
	 * Sets this shadowAnchorY
	 *
	 * @param integer $shadowAnchorY
	 * @return void
	 */
	public function setShadowAnchorY($shadowAnchorY) {
		$this->shadowAnchorY = $shadowAnchorY;
	}

	/**
	 * Returns this shadowAnchorY
	 *
	 * @return integer
	 */
	public function getShadowAnchorY() {
		return (integer) $this->getPropertyValue('shadowAnchorY', 'layer');
	}

	/**
	 * Sets this shadowScaledWidth
	 *
	 * @param integer $shadowScaledWidth
	 * @return void
	 */
	public function setShadowScaledWidth($shadowScaledWidth) {
		$this->shadowScaledWidth = $shadowScaledWidth;
	}

	/**
	 * Returns this shadowScaledWidth
	 *
	 * @return integer
	 */
	public function getShadowScaledWidth() {
		return (integer) $this->getPropertyValue('shadowScaledWidth', 'layer');
	}

	/**
	 * Sets this shadowScaledHeight
	 *
	 * @param integer $shadowScaledHeight
	 * @return void
	 */
	public function setShadowScaledHeight($shadowScaledHeight) {
		$this->shadowScaledHeight = $shadowScaledHeight;
	}

	/**
	 * Returns this shadowScaledHeight
	 *
	 * @return integer
	 */
	public function getShadowScaledHeight() {
		return (integer) $this->getPropertyValue('shadowScaledHeight', 'layer');
	}

	/**
	 * Sets this flat
	 *
	 * @param boolean $flat
	 * @return void
	 */
	public function setFlat($flat) {
		$this->flat = (boolean) $flat;
	}

	/**
	 * Returns this flat
	 *
	 * @return boolean
	 */
	public function isFlat() {
		return (boolean) $this->getPropertyValue('flat', 'layer');
	}

	/**
	 * Sets this shapeType
	 *
	 * @param string $shapeType
	 * @return void
	 */
	public function setShapeType($shapeType) {
		$this->shapeType = $shapeType;
	}

	/**
	 * Returns this shapeType
	 *
	 * @return string
	 */
	public function getShapeType() {
		return $this->getPropertyValue('shapeType', 'layer');
	}

	/**
	 * Sets this shapeCoords
	 *
	 * @param string $shapeCoords
	 * @return void
	 */
	public function setShapeCoords($shapeCoords) {
		$this->shapeCoords = $shapeCoords;
	}

	/**
	 * Returns this shapeCoords
	 *
	 * @return string
	 */
	public function getShapeCoords() {
		return $this->getPropertyValue('shapeCoords', 'layer');
	}

	/**
	 * Sets this mouseCursor
	 *
	 * @param string $mouseCursor
	 * @return void
	 */
	public function setMouseCursor($mouseCursor) {
		$this->mouseCursor = $mouseCursor;
	}

	/**
	 * Returns this mouseCursor
	 *
	 * @return string
	 */
	public function getMouseCursor() {
		return Tx_AdGoogleMaps_Utility_BackEnd::getRelativeUploadPathAndFileName('ad_google_maps', 'mouseCursor', $this->getPropertyValue('mouseCursor', 'layer'));
	}

	/**
	 * Sets this infoWindow
	 *
	 * @param integer $infoWindow
	 * @return void
	 */
	public function setInfoWindow($infoWindow) {
		$this->infoWindow = $infoWindow;
	}

	/**
	 * Returns this infoWindow
	 *
	 * @return integer
	 */
	public function getInfoWindow() {
		return $this->getPropertyValue('infoWindow', 'layer');
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
		return $this->getPropertyValue('infoWindowObjectNumber', 'layer');
	}

	/**
	 * Sets this infoWindowRenderConfiguration
	 *
	 * @param array $infoWindowRenderConfiguration
	 * @return void
	 */
	public function setInfoWindowRenderConfiguration(array $infoWindowRenderConfiguration) {
		$this->infoWindowRenderConfiguration = (array) $infoWindowRenderConfiguration;
	}

	/**
	 * Returns this infoWindowRenderConfiguration
	 *
	 * @return array
	 */
	public function getInfoWindowRenderConfiguration() {
		return (array) $this->infoWindowRenderConfiguration;
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
		return (boolean) $this->getPropertyValue('infoWindowKeepOpen', 'layer');
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
		return (boolean) $this->getPropertyValue('infoWindowCloseOnClick', 'layer');
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
		return (boolean) $this->getPropertyValue('infoWindowDisableAutoPan', 'layer');
	}

	/**
	 * Sets this infoWindowMaxWidth
	 *
	 * @param integer $infoWindowMaxWidth
	 * @return void
	 */
	public function setInfoWindowMaxWidth($infoWindowMaxWidth) {
		$this->infoWindowMaxWidth = (integer) $infoWindowMaxWidth;
	}

	/**
	 * Returns this infoWindowMaxWidth
	 *
	 * @return integer
	 */
	public function getInfoWindowMaxWidth() {
		return (integer) $this->getPropertyValue('infoWindowMaxWidth', 'layer');
	}

	/**
	 * Sets this infoWindowPixelOffsetWidth
	 *
	 * @param integer $infoWindowPixelOffsetWidth
	 * @return void
	 */
	public function setInfoWindowPixelOffsetWidth($infoWindowPixelOffsetWidth) {
		$this->infoWindowPixelOffsetWidth = (integer) $infoWindowPixelOffsetWidth;
	}

	/**
	 * Returns this infoWindowPixelOffsetWidth
	 *
	 * @return integer
	 */
	public function getInfoWindowPixelOffsetWidth() {
		return (integer) $this->getPropertyValue('infoWindowPixelOffsetWidth', 'layer');
	}

	/**
	 * Sets this infoWindowPixelOffsetHeight
	 *
	 * @param integer $infoWindowPixelOffsetHeight
	 * @return void
	 */
	public function setInfoWindowPixelOffsetHeight($infoWindowPixelOffsetHeight) {
		$this->infoWindowPixelOffsetHeight = (integer) $infoWindowPixelOffsetHeight;
	}

	/**
	 * Returns this infoWindowPixelOffsetHeight
	 *
	 * @return integer
	 */
	public function getInfoWindowPixelOffsetHeight() {
		return (integer) $this->getPropertyValue('infoWindowPixelOffsetHeight', 'layer');
	}

	/**
	 * Sets this infoWindowZindex
	 *
	 * @param integer $infoWindowZindex
	 * @return void
	 */
	public function setInfoWindowZindex($infoWindowZindex) {
		$this->infoWindowZindex = (integer) $infoWindowZindex;
	}

	/**
	 * Returns this infoWindowZindex
	 *
	 * @return integer
	 */
	public function getInfoWindowZindex() {
		return (integer) $this->getPropertyValue('infoWindowZindex', 'layer');
	}

}

?>