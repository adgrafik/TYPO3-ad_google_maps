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
class Tx_AdGoogleMaps_Domain_Model_Layer extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * Provider of the coordinates.
	 */
	const COODRINATES_PROVIDER_MAP_DRAWER = 0;
	const COODRINATES_PROVIDER_ADDRESSES = 1;
	const COODRINATES_PROVIDER_ADDRESS_GROUPS = 2;

	/**
	 * Placing type of info windows.
	 */
	const INFO_WINDOW_PLACING_TYPE_MARKERS = 1;
	const INFO_WINDOW_PLACING_TYPE_SHAPE = 2;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var boolean
	 */
	protected $visible;

	/**
	 * @var string
	 */
	protected $coordinatesProvider;

	/**
	 * @var string
	 */
	protected $coordinates;

	/**
	 * @var SplObjectStorage<Tx_AdGoogleMaps_Domain_Model_Item>
	 */
	protected $items;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_Address>
	 * @lazy
	 */
	protected $addresses;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_AddressGroup>
	 * @lazy
	 */
	protected $addressGroups;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_Category>
	 * @lazy
	 */
	protected $categories;

	/**
	 * @var boolean
	 */
	protected $markerClickable;

	/**
	 * @var boolean
	 */
	protected $shapeClickable;

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
	protected $geodesic;

	/**
	 * @var integer
	 */
	protected $markerZindex;

	/**
	 * @var integer
	 */
	protected $shapeZindex;

	/**
	 * @var boolean
	 */
	protected $addMarkers;

	/**
	 * @var boolean
	 */
	protected $forceListing;

	/**
	 * @var string
	 */
	protected $itemTitles;

	/**
	 * @var string
	 */
	protected $itemTitlesObjectNumber;

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
	protected $kmlFile;

	/**
	 * @var string
	 */
	protected $kmlUrl;

	/**
	 * @var boolean
	 */
	protected $kmlSuppressInfoWindows;

	/**
	 * @var string
	 */
	protected $shapeType;

	/**
	 * @var string
	 */
	protected $shape;

	/**
	 * @var string
	 */
	protected $mouseCursor;

	/**
	 * @var string
	 */
	protected $strokeColor;

	/**
	 * @var integer
	 */
	protected $strokeOpacity;

	/**
	 * @var integer
	 */
	protected $strokeWeight;

	/**
	 * @var string
	 */
	protected $fillColor;

	/**
	 * @var integer
	 */
	protected $fillOpacity;

	/**
	 * @var integer
	 */
	protected $infoWindow;

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
		// Set default values.
		$this->items = new SplObjectStorage();
		$this->addresses = new Tx_Extbase_Persistence_ObjectStorage();
		$this->addressGroups = new Tx_Extbase_Persistence_ObjectStorage();
		$this->categories = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/*
	 * Constructs this layer.
	 */
	public function __construct() {
		$this->initializeObject();
	}

	/**
	 * Sets this type
	 *
	 * @param string $type
	 * @return void
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * Returns this type
	 *
	 * @return string
	 */
	public function getType() {
		return $this->type;
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
		return $this->title;
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
		return (boolean) $this->visible;
	}

	/**
	 * Sets this coordinatesProvider
	 *
	 * @param string $coordinatesProvider
	 * @return void
	 */
	public function setCoordinatesProvider($coordinatesProvider) {
		$this->coordinatesProvider = $coordinatesProvider;
	}

	/**
	 * Returns this coordinatesProvider
	 *
	 * @return string
	 */
	public function getCoordinatesProvider() {
		return $this->coordinatesProvider;
	}

	/**
	 * Sets this coordinates
	 *
	 * @param string $coordinates
	 * @return void
	 */
	public function setCoordinates($coordinates) {
		$this->coordinates = $coordinates;
	}

	/**
	 * Returns this coordinates
	 *
	 * @return string
	 */
	public function getCoordinates() {
		return $this->coordinates;
	}

	/**
	 * Sets this items
	 *
	 * @param SplObjectStorage<Tx_AdGoogleMaps_Domain_Model_Item> $items
	 * @return void
	 */
	public function setItems(SplObjectStorage $items) {
		$this->items = $items;
	}

	/**
	 * Adds an item to this items.
	 *
	 * @param SplObjectStorage<Tx_AdGoogleMaps_Domain_Model_Item> $items
	 * @return void
	 */
	public function addItem(Tx_AdGoogleMaps_Domain_Model_Item $item) {
		$this->items->attach($item);
	}

	/**
	 * Adds items to this items.
	 *
	 * @param SplObjectStorage<Tx_AdGoogleMaps_Domain_Model_Item> $items
	 * @return void
	 */
	public function addItems(SplObjectStorage $items) {
		$this->items->addAll($items);
	}

	/**
	 * Returns this items
	 *
	 * @return SplObjectStorage<Tx_AdGoogleMaps_Domain_Model_Item>
	 */
	public function getItems() {
		return $this->items;
	}

	/**
	 * Sets this addresses
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_Address> $addresses
	 * @return void
	 */
	public function setAddresses(Tx_AdGoogleMaps_Domain_Model_Address $addresses) {
		$this->addresses = $addresses;
	}

	/**
	 * Returns this addresses
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_Address>
	 */
	public function getAddresses() {
		if ($this->addresses instanceof Tx_Extbase_Persistence_LazyLoadingProxy) {
			$this->addresses->_loadRealInstance();
		}
		return $this->addresses;
	}

	/**
	 * Sets this addressGroups
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_AddressGroup> $addressGroups
	 * @return void
	 */
	public function setAddressGroups(Tx_AdGoogleMaps_Domain_Model_AddressGroup $addressGroups) {
		$this->addressGroups = $addressGroups;
	}

	/**
	 * Returns this addressGroups
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_AddressGroup>
	 */
	public function getAddressGroups() {
		if ($this->addressGroups instanceof Tx_Extbase_Persistence_LazyLoadingProxy) {
			$this->addressGroups->_loadRealInstance();
		}
		return $this->addressGroups;
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
	 * Sets this markerClickable
	 *
	 * @param boolean $markerClickable
	 * @return void
	 */
	public function setMarkerClickable($markerClickable) {
		$this->markerClickable = (boolean) $markerClickable;
	}

	/**
	 * Returns this markerClickable
	 *
	 * @return boolean
	 */
	public function isMarkerClickable() {
		return (boolean) $this->markerClickable;
	}

	/**
	 * Sets this shapeClickable
	 *
	 * @param boolean $shapeClickable
	 * @return void
	 */
	public function setShapeClickable($shapeClickable) {
		$this->shapeClickable = (boolean) $shapeClickable;
	}

	/**
	 * Returns this shapeClickable
	 *
	 * @return boolean
	 */
	public function isShapeClickable() {
		return (boolean) $this->shapeClickable;
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
		return (boolean) $this->draggable;
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
		return (boolean) ($this->isDraggable() === TRUE && $this->raiseOnDrag === TRUE);
	}

	/**
	 * Sets this geodesic
	 *
	 * @param boolean $geodesic
	 * @return void
	 */
	public function setGeodesic($geodesic) {
		$this->geodesic = (boolean) $geodesic;
	}

	/**
	 * Returns this geodesic
	 *
	 * @return boolean
	 */
	public function isGeodesic() {
		return (boolean) $this->geodesic;
	}

	/**
	 * Sets this markerZindex
	 *
	 * @param integer $markerZindex
	 * @return void
	 */
	public function setMarkerZindex($markerZindex) {
		$this->markerZindex = $markerZindex;
	}

	/**
	 * Returns this markerZindex
	 *
	 * @return integer
	 */
	public function getMarkerZindex() {
		return (integer) $this->markerZindex;
	}

	/**
	 * Sets this shapeZindex
	 *
	 * @param integer $shapeZindex
	 * @return void
	 */
	public function setShapeZindex($shapeZindex) {
		$this->shapeZindex = $shapeZindex;
	}

	/**
	 * Returns this shapeZindex
	 *
	 * @return integer
	 */
	public function getShapeZindex() {
		return (integer) $this->shapeZindex;
	}

	/**
	 * Sets this addMarkers
	 *
	 * @param boolean $addMarkers
	 * @return void
	 */
	public function setAddMarkers($addMarkers) {
		$this->addMarkers = (boolean) $addMarkers;
	}

	/**
	 * Returns this addMarkers
	 *
	 * @return boolean
	 */
	public function isAddMarkers() {
		return (boolean) $this->addMarkers;
	}

	/**
	 * Sets this forceListing
	 *
	 * @param boolean $forceListing
	 * @return void
	 */
	public function setForceListing($forceListing) {
		$this->forceListing = (boolean) $forceListing;
	}

	/**
	 * Returns this forceListing
	 *
	 * @return boolean
	 */
	public function isForceListing() {
		return (boolean) ($this->isAddMarkers() === FALSE || ($this->isAddMarkers() === TRUE && (boolean) $this->forceListing === TRUE));
	}

	/**
	 * Sets this itemTitles
	 *
	 * @param string $itemTitles
	 * @return void
	 */
	public function setItemTitles($itemTitles) {
		$this->itemTitles = $itemTitles;
	}

	/**
	 * Returns this itemTitles
	 *
	 * @return string
	 */
	public function getItemTitles() {
		return $this->itemTitles;
	}

	/**
	 * Sets this itemTitlesObjectNumber
	 *
	 * @param string $itemTitlesObjectNumber
	 * @return void
	 */
	public function setItemTitlesObjectNumber($itemTitlesObjectNumber) {
		$this->itemTitlesObjectNumber = $itemTitlesObjectNumber;
	}

	/**
	 * Returns this itemTitlesObjectNumber
	 *
	 * @return string
	 */
	public function getItemTitlesObjectNumber() {
		return $this->itemTitlesObjectNumber;
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
		return $this->icon;
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
		return $this->iconObjectNumber;
	}

	/**
	 * Sets this iconWidth
	 *
	 * @param integer $iconWidth
	 * @return void
	 */
	public function setIconWidth($iconWidth) {
		$this->iconWidth = $iconWidth;
	}

	/**
	 * Returns this iconWidth
	 *
	 * @return integer
	 */
	public function getIconWidth() {
		return (integer) $this->iconWidth;
	}

	/**
	 * Sets this iconHeight
	 *
	 * @param integer $iconHeight
	 * @return void
	 */
	public function setIconHeight($iconHeight) {
		$this->iconHeight = $iconHeight;
	}

	/**
	 * Returns this iconHeight
	 *
	 * @return integer
	 */
	public function getIconHeight() {
		return (integer) $this->iconHeight;
	}

	/**
	 * Sets this iconOriginX
	 *
	 * @param integer $iconOriginX
	 * @return void
	 */
	public function setIconOriginX($iconOriginX) {
		$this->iconOriginX = $iconOriginX;
	}

	/**
	 * Returns this iconOriginX
	 *
	 * @return integer
	 */
	public function getIconOriginX() {
		return (integer) $this->iconOriginX;
	}

	/**
	 * Sets this iconOriginY
	 *
	 * @param integer $iconOriginY
	 * @return void
	 */
	public function setIconOriginY($iconOriginY) {
		$this->iconOriginY = $iconOriginY;
	}

	/**
	 * Returns this iconOriginY
	 *
	 * @return integer
	 */
	public function getIconOriginY() {
		return (integer) $this->iconOriginY;
	}

	/**
	 * Sets this iconAnchorX
	 *
	 * @param integer $iconAnchorX
	 * @return void
	 */
	public function setIconAnchorX($iconAnchorX) {
		$this->iconAnchorX = $iconAnchorX;
	}

	/**
	 * Returns this iconAnchorX
	 *
	 * @return integer
	 */
	public function getIconAnchorX() {
		return (integer) $this->iconAnchorX;
	}

	/**
	 * Sets this iconAnchorY
	 *
	 * @param integer $iconAnchorY
	 * @return void
	 */
	public function setIconAnchorY($iconAnchorY) {
		$this->iconAnchorY = $iconAnchorY;
	}

	/**
	 * Returns this iconAnchorY
	 *
	 * @return integer
	 */
	public function getIconAnchorY() {
		return (integer) $this->iconAnchorY;
	}

	/**
	 * Sets this iconScaledWidth
	 *
	 * @param integer $iconScaledWidth
	 * @return void
	 */
	public function setIconScaledWidth($iconScaledWidth) {
		$this->iconScaledWidth = $iconScaledWidth;
	}

	/**
	 * Returns this iconScaledWidth
	 *
	 * @return integer
	 */
	public function getIconScaledWidth() {
		return (integer) $this->iconScaledWidth;
	}

	/**
	 * Sets this iconScaledHeight
	 *
	 * @param integer $iconScaledHeight
	 * @return void
	 */
	public function setIconScaledHeight($iconScaledHeight) {
		$this->iconScaledHeight = $iconScaledHeight;
	}

	/**
	 * Returns this iconScaledHeight
	 *
	 * @return integer
	 */
	public function getIconScaledHeight() {
		return (integer) $this->iconScaledHeight;
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
		return $this->shadow;
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
		return $this->shadowObjectNumber;
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
		return (integer) $this->shadowWidth;
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
		return (integer) $this->shadowHeight;
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
		return (integer) $this->shadowOriginX;
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
		return (integer) $this->shadowOriginY;
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
		return (integer) $this->shadowAnchorX;
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
		return (integer) $this->shadowAnchorY;
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
		return (integer) $this->shadowScaledWidth;
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
		return (integer) $this->shadowScaledHeight;
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
		return (boolean) $this->flat;
	}

	/**
	 * Sets this kmlFile
	 *
	 * @param string $kmlFile
	 * @return void
	 */
	public function setKmlFile($kmlFile) {
		$this->kmlFile = $kmlFile;
	}

	/**
	 * Returns this kmlFile
	 *
	 * @return string
	 */
	public function getKmlFile() {
		return Tx_AdGoogleMaps_Tools_BackEnd::getFileRelativeFileName('kmlFiles', $this->kmlFile);
	}

	/**
	 * Sets this kmlUrl
	 *
	 * @param string $kmlUrl
	 * @return void
	 */
	public function setKmlUrl($kmlUrl) {
		$this->kmlUrl = $kmlUrl;
	}

	/**
	 * Returns this kmlUrl
	 *
	 * @return string
	 */
	public function getKmlUrl() {
		return $this->kmlUrl;
	}

	/**
	 * Sets this kmlSuppressInfoWindows.
	 *
	 * @param boolean $kmlSuppressInfoWindows
	 * @return void
	 */
	public function setKmlSuppressInfoWindows($kmlSuppressInfoWindows) {
		$this->suppressInfoWindows = (boolean) $kmlSuppressInfoWindows;
	}

	/**
	 * Returns this suppressInfoWindows.
	 *
	 * @return boolean
	 */
	public function isKmlSuppressInfoWindows() {
		return (boolean) $this->kmlSuppressInfoWindows;
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
		return $this->shapeType;
	}

	/**
	 * Sets this shape
	 *
	 * @param string $shape
	 * @return void
	 */
	public function setShape($shape) {
		$this->shape = $shape;
	}

	/**
	 * Returns this shape
	 *
	 * @return string
	 */
	public function getShape() {
		return $this->shape;
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
		return Tx_AdGoogleMaps_Tools_BackEnd::getFileRelativeFileName('mouseCursor', $this->mouseCursor);
	}

	/**
	 * Sets this strokeColor
	 *
	 * @param string $strokeColor
	 * @return void
	 */
	public function setStrokeColor($strokeColor) {
		$this->strokeColor = $strokeColor;
	}

	/**
	 * Returns this strokeColor
	 *
	 * @return string
	 */
	public function getStrokeColor() {
		return $this->strokeColor;
	}

	/**
	 * Sets this strokeOpacity
	 *
	 * @param integer $strokeOpacity
	 * @return void
	 */
	public function setStrokeOpacity($strokeOpacity) {
		$this->strokeOpacity = $strokeOpacity;
	}

	/**
	 * Returns this strokeOpacity
	 *
	 * @return integer
	 */
	public function getStrokeOpacity() {
		return (integer) $this->strokeOpacity;
	}

	/**
	 * Sets this strokeWeight
	 *
	 * @param integer $strokeWeight
	 * @return void
	 */
	public function setStrokeWeight($strokeWeight) {
		$this->strokeWeight = $strokeWeight;
	}

	/**
	 * Returns this strokeWeight
	 *
	 * @return integer
	 */
	public function getStrokeWeight() {
		return (integer) $this->strokeWeight;
	}

	/**
	 * Sets this fillColor
	 *
	 * @param string $fillColor
	 * @return void
	 */
	public function setFillColor($fillColor) {
		$this->fillColor = $fillColor;
	}

	/**
	 * Returns this fillColor
	 *
	 * @return string
	 */
	public function getFillColor() {
		return $this->fillColor;
	}

	/**
	 * Sets this fillOpacity
	 *
	 * @param integer $fillOpacity
	 * @return void
	 */
	public function setFillOpacity($fillOpacity) {
		$this->fillOpacity = $fillOpacity;
	}

	/**
	 * Returns this fillOpacity
	 *
	 * @return integer
	 */
	public function getFillOpacity() {
		return (integer) $this->fillOpacity;
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
		return $this->infoWindow;
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
		return (integer) $this->infoWindowPlacingType;
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
		return $this->infoWindowPosition;
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
		return $this->infoWindowObjectNumber;
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
		return (boolean) $this->infoWindowKeepOpen;
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
		return (boolean) $this->infoWindowCloseOnClick;
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
		return (boolean) $this->infoWindowDisableAutoPan;
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
		return (integer) $this->infoWindowMaxWidth;
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
		return (integer) $this->infoWindowPixelOffsetWidth;
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
		return (integer) $this->infoWindowPixelOffsetHeight;
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
		return (integer) $this->infoWindowZindex;
	}

}

?>