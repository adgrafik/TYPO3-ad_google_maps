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
 * Adapter for the Tx_AdGoogleMapsApi_Service_MapPlugin class.
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_AdGoogleMaps_Service_MapPluginAdapter {

	/**
	 * @var tslib_cObj
	 */
	protected $contentObject;

	/**
	 * @var array
	 */
	protected $extensionConfiguration;

	/**
	 * @var Tx_AdGoogleMaps_Domain_Model_Map
	 */
	protected $map;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @var Tx_AdGoogleMapsApi_Service_GoogleMapsApiMapPlugin
	 */
	protected $mapPlugin;

	/**
	 * @var Tx_AdGoogleMaps_Domain_Repository_AddressRepository
	 */
	protected $addressRepository;

	/**
	 * @var Tx_AdGoogleMaps_Domain_Repository_AddressGroupRepository
	 */
	protected $addressGroupRepository;

	/**
	 * Constructor.
	 * 
	 * @param Tx_AdGoogleMaps_Domain_Model_Map $map
	 * @param array $settings
	 */
	public function __construct(Tx_AdGoogleMaps_Domain_Model_Map $map, $settings) {
		$this->contentObject = t3lib_div::makeInstance('tslib_cObj');
		$this->extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ad_google_maps']);
		$this->extensionConfiguration = Tx_Extbase_Utility_TypoScript::convertTypoScriptArrayToPlainArray($this->extensionConfiguration);
		$this->map = clone $map;
		$this->settings = $settings;
		$this->addressRepository = t3lib_div::makeInstance('Tx_AdGoogleMaps_Domain_Repository_AddressRepository');
		$this->addressGroupRepository = t3lib_div::makeInstance('Tx_AdGoogleMaps_Domain_Repository_AddressGroupRepository');
	}

	/**
	 * Returns this map.
	 *
	 * @return Tx_AdGoogleMapsApi_Map
	 */
	public function getMap() {
		return $this->map;
	}

	/**
	 * Returns this mapPlugin
	 *
	 * @return Tx_AdGoogleMapsApi_Service_MapPlugin
	 */
	public function getMapPlugin() {
		return $this->mapPlugin;
	}

	/**
	 * Returns the Google Maps API object.
	 *
	 * @return void
	 */
	public function buildMap() {
		// Create Google Maps API plugin.
		$this->mapPlugin = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_Service_MapPlugin')
			->setMapId($this->getPropertyValue('uid', $this->map, $this->settings['map']))
			->setWidth($this->getPropertyValue('width', $this->map, $this->settings['map']))
			->setHeight($this->getPropertyValue('height', $this->map, $this->settings['map']))
			->setUseMarkerCluster($this->getPropertyValue('useMarkerCluster', $this->map, $this->settings['map']))
			->setInfoWindowCloseAllOnMapClick($this->getPropertyValue('infoWindowCloseAllOnMapClick', $this->map, $this->settings['map']));

		$mapApi = $this->mapPlugin->getMap();

		// Set initial map options.
		$mapApi
			->setMapTypeId($this->getPropertyValue('mapTypeId', $this->map, $this->settings['map']))
			->setBackgroundColor($this->getPropertyValue('backgroundColor', $this->map, $this->settings['map']))
			->setNoClear($this->getPropertyValue('noClear', $this->map, $this->settings['map']))
			->setDisableDefaultUi($this->getPropertyValue('disableDefaultUi', $this->map, $this->settings['map']))
			->setMinZoom($this->getPropertyValue('minZoom', $this->map, $this->settings['map']))
			->setMaxZoom($this->getPropertyValue('maxZoom', $this->map, $this->settings['map']));
		if ((integer) $this->getPropertyValue('centerType', $this->map, $this->settings['map']) === Tx_AdGoogleMaps_Domain_Model_Map::CENTER_TYPE_DEFAULT 
				&& ($zoom = $this->getPropertyValue('zoom', $this->map, $this->settings['map']))) {
			$mapApi->setZoom($zoom);
		}
		// Set controll options.
		if ($this->getPropertyValue('mapTypeControl', $this->map, $this->settings['map']) === TRUE) {
			$mapApi
				->setMapTypeControl(TRUE)
				->setMapTypeControlOptions(t3lib_div::makeInstance('Tx_AdGoogleMapsApi_ControlOptions_MapType', 
					$this->getPropertyValue('mapTypeControlOptionsMapTypeIds', $this->map, $this->settings['map']),
					$this->getPropertyValue('mapTypeControlOptionsPosition', $this->map, $this->settings['map']),
					$this->getPropertyValue('mapTypeControlOptionsStyle', $this->map, $this->settings['map'])
				));
		}
		if ($this->getPropertyValue('navigationControl', $this->map, $this->settings['map']) === TRUE) {
			$mapApi
				->setNavigationControl(TRUE)
				->setNavigationControlOptions(t3lib_div::makeInstance('Tx_AdGoogleMapsApi_ControlOptions_Navigation', 
					$this->getPropertyValue('navigationControlOptionsPosition', $this->map, $this->settings['map']),
					$this->getPropertyValue('navigationControlOptionsStyle', $this->map, $this->settings['map'])
				));
		}
		if ($this->getPropertyValue('scaleControl', $this->map, $this->settings['map']) === TRUE) {
			$mapApi
				->setScaleControl(TRUE)
				->setScaleControlOptions(t3lib_div::makeInstance('Tx_AdGoogleMapsApi_ControlOptions_Scale', 
					$this->getPropertyValue('scaleControlOptionsPosition', $this->map, $this->settings['map']),
					$this->getPropertyValue('scaleControlOptionsStyle', $this->map, $this->settings['map'])
				));
		}
		if ($this->getPropertyValue('panControl', $this->map, $this->settings['map']) === TRUE) {
			$mapApi
				->setPanControl(TRUE)
				->setPanControlOptions(t3lib_div::makeInstance('Tx_AdGoogleMapsApi_ControlOptions_Pan', 
					$this->getPropertyValue('panControlOptionsPosition', $this->map, $this->settings['map'])
				));
		}
		if ($this->getPropertyValue('zoomControl', $this->map, $this->settings['map']) === TRUE) {
			$mapApi
				->setZoomControl(TRUE)
				->setZoomControlOptions(t3lib_div::makeInstance('Tx_AdGoogleMapsApi_ControlOptions_Zoom', 
					$this->getPropertyValue('zoomControlOptionsPosition', $this->map, $this->settings['map']),
					$this->getPropertyValue('zoomControlOptionsStyle', $this->map, $this->settings['map'])
				));
		}
		if ($this->getPropertyValue('streetViewControl', $this->map, $this->settings['map']) === TRUE) {
			$mapApi
				->setStreetViewControl(TRUE)
				->setStreetViewControlOptions(t3lib_div::makeInstance('Tx_AdGoogleMapsApi_ControlOptions_StreetView', 
					$this->getPropertyValue('streetViewControlOptionsPosition', $this->map, $this->settings['map'])
				));
		}
		// Set interaction options.
		$mapApi
			->setDisableDoubleClickZoom($this->getPropertyValue('disableDoubleClickZoom', $this->map, $this->settings['map']))
			->setScrollwheel($this->getPropertyValue('scrollwheel', $this->map, $this->settings['map']))
			->setDraggable($this->getPropertyValue('draggable', $this->map, $this->settings['map']))
			->setKeyboardShortcuts($this->getPropertyValue('keyboardShortcuts', $this->map, $this->settings['map']))
			->setDraggableCursor($this->getPropertyValue('draggableCursor', $this->map, $this->settings['map']))
			->setDraggingCursor($this->getPropertyValue('draggingCursor', $this->map, $this->settings['map']));

		$this->buildLayers($this->map->getCategories());
	}

	/**
	 * Returns the Google Maps API object.
	 *
	 * @param mixed $categories
	 * @return Tx_AdGoogleMapsApi_Map
	 */
	protected function buildLayers($categories) {
		foreach ($categories as $category) {
			$this->buildLayers($category->getSubCategories());
			foreach ($category->getLayers() as $layer) {
				// Check if layer built allready. If there is a recursion of the categories witch contains 
				// the same layers, than duplicates are added to the layer items.
				if ($layer->getItems()->count() === 0) {
					$this->buildItems($category, $layer);
				}
			}
		}
	}

	/**
	 * Returns the Google Maps API object.
	 *
	 * @param Tx_AdGoogleMaps_Domain_Model_Category $category
	 * @param Tx_AdGoogleMaps_Domain_Model_Layer $layer
	 * @return Tx_AdGoogleMapsApi_Map
	 */
	protected function buildItems(Tx_AdGoogleMaps_Domain_Model_Category $category, Tx_AdGoogleMaps_Domain_Model_Layer $layer) {
		$mapCenterType = (integer) $this->getPropertyValue('centerType', $this->map, $this->settings['map']);
		$categoryItemKeys = array();
		if ($mapCenterType === Tx_AdGoogleMaps_Domain_Model_Map::CENTER_TYPE_BOUNDS) {
			$itemBounds = $this->mapPlugin->getBounds();
		}
		$layerUid = $layer->getUid();
		$layerType = $this->getPropertyValue('type', $layer, $this->settings['layer']);
		$layerAddMarkers = $this->getPropertyValue('addMarkers', $layer, $this->settings['layer']);

		// Do KML only.
		if ($layerType === 'tx_adgooglemapsapi_layers_kml') {
			$itemKey = $layerUid . '_0';
			$kmlFile = $this->getPropertyValue('kmlFile', $layer, $this->settings['layer']);
			$kmlUrl = $this->getPropertyValue('kmlUrl', $layer, $this->settings['layer']);
			$itemOptions = array(
				'key' => $itemKey,
				'url' => ($kmlUrl ? $kmlUrl : $kmlFile),
				'preserveViewport' => TRUE,
				'suppressInfoWindows' => $this->getPropertyValue('kmlSuppressInfoWindows', $layer, $this->settings['layer']),
			);

			$kml = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_Service_MapPlugin_ExtendedApi_Layers_Kml', $itemOptions);

			$categoryItemKeys[] = $itemKey;
			$mapControllFunctions = $this->getItemMapControllFunctions($itemKey);

			$this->mapPlugin->addLayer($kml);

			$layerItem = t3lib_div::makeInstance('Tx_AdGoogleMaps_Domain_Model_Item');
			$layerItem->setTitle($this->getPropertyValue('title', $layer, $this->settings['layer']));
			$layerItem->setMapControllFunctions($mapControllFunctions);
			$layer->addItem($layerItem);

			// Nothing else to do after KML processing.
			return;
		}

		$infoWindows = $this->getInfoWindows($layer);

		// Get coordinates array
		$coordinates = array();
		$coordinatesProvider = (integer) $this->getPropertyValue('coordinatesProvider', $layer, $this->settings['layer']);
		switch ($coordinatesProvider) {
			case Tx_AdGoogleMaps_Domain_Model_Layer::COODRINATES_PROVIDER_MAP_DRAWER:
				$coordinates = t3lib_div::removeArrayEntryByValue(t3lib_div::trimExplode(LF, $this->getPropertyValue('coordinates', $layer, $this->settings['layer'])), '');
				$dataProvider = array_key_exists('data', $infoWindows) ? $infoWindows['data'] : array();
			break;

			case Tx_AdGoogleMaps_Domain_Model_Layer::COODRINATES_PROVIDER_ADDRESS_GROUPS:
				$addresses = $this->addressGroupRepository->getAddressesRecursively($layer->getAddressGroups(), new SplObjectStorage());
			// No break.

			case Tx_AdGoogleMaps_Domain_Model_Layer::COODRINATES_PROVIDER_ADDRESSES:
				if (!isset($addresses)) {
					$addresses = $layer->getAddresses();
				}
				foreach ($addresses as $address) {
					if (($coordinate = $address->getTxAdgooglemapsCoordinates())) {
						$coordinates[] = $coordinate;
						$dataProvider[] = $address->_getCleanProperties();
					} else {
						$addressQuery = $address->getZip() . ' ' . $address->getCity() . ', ' . $address->getCountry() . ', ' . $address->getAddress();
						if (($coordinate = $this->mapPlugin->getCoordinatesByAddress($addressQuery)) !== NULL) {
							$address->setTxAdgooglemapsCoordinates($coordinate);
							$coordinates[] = $coordinate;
							$dataProvider[] = $address->_getCleanProperties();
						}
					}
				}
			break;
		}

		$countCoordinates = count($coordinates);
		if (!$countCoordinates)
			return;

		$infoWindowPlacingType = $this->getInfoWindowOptionValueByInfoWindowBehaviour(
			$this->getPropertyValue('infoWindowPlacingType', $layer, $this->settings['layer']), 
			$this->getPropertyValue('infoWindowPlacingType', $this->map, $this->settings['map'])
		);
		$infoWindowKeepOpen = $this->getInfoWindowOptionValueByInfoWindowBehaviour(
			$this->getPropertyValue('infoWindowKeepOpen', $layer, $this->settings['layer']), 
			$this->getPropertyValue('infoWindowKeepOpen', $this->map, $this->settings['map'])
		);
		$infoWindowCloseOnClick = $this->getInfoWindowOptionValueByInfoWindowBehaviour(
			$this->getPropertyValue('infoWindowCloseOnClick', $layer, $this->settings['layer']), 
			$this->getPropertyValue('infoWindowCloseOnClick', $this->map, $this->settings['map'])
		);
		$infoWindowPosition = $this->getInfoWindowOptionValueByInfoWindowBehaviour(
			$this->getPropertyValue('infoWindowPosition', $layer, $this->settings['layer']), 
			$this->getPropertyValue('infoWindowPosition', $this->map, $this->settings['map'])
		);
		$infoWindowObjectNumber = $this->getInfoWindowOptionValueByInfoWindowBehaviour(
			$this->getPropertyValue('infoWindowObjectNumber', $layer, $this->settings['layer']), 
			$this->getPropertyValue('infoWindowObjectNumber', $this->map, $this->settings['map'])
		);

		$allInfoWindowOptions = array(
			'disableAutoPan' => $this->getInfoWindowOptionValueByInfoWindowBehaviour(
				$this->getPropertyValue('infoWindowDisableAutoPan', $layer, $this->settings['layer']), 
				$this->getPropertyValue('infoWindowDisableAutoPan', $this->map, $this->settings['map'])
			),
			'disableAutoPan' => $this->getInfoWindowOptionValueByInfoWindowBehaviour(
				$this->getPropertyValue('infoWindowMaxWidth', $layer, $this->settings['layer']), 
				$this->getPropertyValue('infoWindowMaxWidth', $this->map, $this->settings['map'])
			),
			'pixelOffsetWidth' => $this->getInfoWindowOptionValueByInfoWindowBehaviour(
				$this->getPropertyValue('infoWindowPixelOffsetWidth', $layer, $this->settings['layer']), 
				$this->getPropertyValue('infoWindowPixelOffsetWidth', $this->map, $this->settings['map'])
			),
			'pixelOffsetHeight' => $this->getInfoWindowOptionValueByInfoWindowBehaviour(
				$this->getPropertyValue('infoWindowPixelOffsetHeight', $layer, $this->settings['layer']), 
				$this->getPropertyValue('infoWindowPixelOffsetHeight', $this->map, $this->settings['map'])
			),
			'zindex' => $layer->getInfoWindowZindex(),
		);

		// If type is a shape and placing type of the info windows is set to shape this means, that there should be an info window on every item. In this case it must be one more.
		$countCoordinatesInfoWindow = $countCoordinates;
		if (($layerType === 'tx_adgooglemapsapi_layers_polyline' || $layerType === 'tx_adgooglemapsapi_layers_polygon') 
				&& $infoWindowPlacingType & Tx_AdGoogleMaps_Domain_Model_Layer::INFO_WINDOW_PLACING_TYPE_SHAPE) {
			$countCoordinatesInfoWindow = $countCoordinates + 1;
		}

		$infoWindowObjectNumberConf = $this->getObjectNumberConf($infoWindowObjectNumber, $countCoordinatesInfoWindow);

		// Get item titles.
		$itemTitles = $this->getPropertyValue('itemTitles', $layer, $this->settings['layer']);
		$layerForceListing = $this->getPropertyValue('forceListing', $layer, $this->settings['layer']);
		$itemTitlesObjectNumber = $this->getPropertyValue('itemTitlesObjectNumber', $layer, $this->settings['layer']);
		$itemTitles = $itemTitles ? t3lib_div::trimExplode(LF, $itemTitles) : array();
		if (!$layerAddMarkers === TRUE || ($layerAddMarkers === TRUE && $layerForceListing === TRUE)) {
			$itemTitlesObjectNumberConf = $this->getObjectNumberConf($itemTitlesObjectNumber, $countCoordinatesInfoWindow);
		} else {
			$itemTitlesObjectNumberConf = $this->getObjectNumberConf($itemTitlesObjectNumber, $countCoordinates);
		}

		// Set all over icon and shadow options.
		$allIconOptions = array(
			'url' => NULL,
			'width' => $this->getPropertyValue('iconWidth', $layer, $this->settings['layer']),				'height' => $this->getPropertyValue('iconHeight', $layer, $this->settings['layer']),
			'originX' => $this->getPropertyValue('iconOriginX', $layer, $this->settings['layer']),			'originY' => $this->getPropertyValue('iconOriginY', $layer, $this->settings['layer']),
			'anchorX' => $this->getPropertyValue('iconAnchorX', $layer, $this->settings['layer']),			'anchorY' => $this->getPropertyValue('iconAnchorY', $layer, $this->settings['layer']),
			'scaledWidth' => $this->getPropertyValue('iconScaledWidth', $layer, $this->settings['layer']),	'scaledWidth' => $this->getPropertyValue('iconScaledHeight', $layer, $this->settings['layer']),
		);
		$itemIcons = explode(',', $this->getPropertyValue('icon', $layer, $this->settings['layer']));
		if (!$layerAddMarkers === TRUE || ($layerAddMarkers === TRUE && $layerForceListing === TRUE)) {
			$itemIconObjectNumberConf = $this->getObjectNumberConf($this->getPropertyValue('iconObjectNumber', $layer, $this->settings['layer']), $countCoordinatesInfoWindow);
		} else {
			$itemIconObjectNumberConf = $this->getObjectNumberConf($this->getPropertyValue('iconObjectNumber', $layer, $this->settings['layer']), $countCoordinates);
		}

		$allShadowOptions = array(
			'url' => NULL,
			'width' => $this->getPropertyValue('shadowWidth', $layer, $this->settings['layer']),				'height' => $this->getPropertyValue('shadowHeight', $layer, $this->settings['layer']),
			'originX' => $this->getPropertyValue('shadowOriginX', $layer, $this->settings['layer']),			'originY' => $this->getPropertyValue('shadowOriginY', $layer, $this->settings['layer']),
			'anchorX' => $this->getPropertyValue('shadowAnchorX', $layer, $this->settings['layer']),			'anchorY' => $this->getPropertyValue('shadowAnchorY', $layer, $this->settings['layer']),
			'scaledWidth' => $this->getPropertyValue('shadowScaledWidth', $layer, $this->settings['layer']),	'scaledWidth' => $this->getPropertyValue('shadowScaledHeight', $layer, $this->settings['layer']),
		);
		$itemShadows = explode(',', $this->getPropertyValue('shadow', $layer, $this->settings['layer']));
		if (!$layerAddMarkers === TRUE || ($layerAddMarkers === TRUE && $layerForceListing === TRUE)) {
			$itemShadowObjectNumberConf = $this->getObjectNumberConf($this->getPropertyValue('shadowObjectNumber', $layer, $this->settings['layer']), $countCoordinatesInfoWindow);
		} else {
			$itemShadowObjectNumberConf = $this->getObjectNumberConf($this->getPropertyValue('shadowObjectNumber', $layer, $this->settings['layer']), $countCoordinates);
		}

		// Do only if markers set.
		if ($layerAddMarkers === TRUE || $layerType === 'tx_adgooglemapsapi_layers_marker') {
			// Get overall options.
			$allItemOptions = array(
				'visible' => $this->getPropertyValue('visible', $layer, $this->settings['layer']),
				'clickable' => $this->getPropertyValue('markerClickable', $layer, $this->settings['layer']),
				'draggable' => $this->getPropertyValue('draggable', $layer, $this->settings['layer']),
				'raiseOnDrag' => $this->getPropertyValue('raiseOnDrag', $layer, $this->settings['layer']),
				'shapeType' => $this->getPropertyValue('shapeType', $layer, $this->settings['layer']),
				'shape' => $this->getPropertyValue('shape', $layer, $this->settings['layer']),
				'zindex' => $layer->getMarkerZindex(),
				'flat' => $this->getPropertyValue('flat', $layer, $this->settings['layer']),
				'cursor' => $this->getPropertyValue('mouseCursor', $layer, $this->settings['layer']),
			);

			$index = 0;
			for ($index = 0; $index < $countCoordinates; $index++) {
				$itemKey = $layerUid . '_' . intval($index);
				$itemDataProvider = $this->getContentByObjectNumberConf($dataProvider, $infoWindowObjectNumberConf, $index, NULL, FALSE, array());
				$position = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_LatLng', $coordinates[$index]);

				$itemOptions = $allItemOptions;
				$itemOptions['key'] = $itemKey;
				$itemOptions['title'] = $this->getContentByObjectNumberConf($itemTitles, $itemTitlesObjectNumberConf, $index, $itemDataProvider, TRUE, $layer->getTitle());
				$itemOptions['position'] = $position;

				if (($iconUrl = $this->getContentByObjectNumberConf($itemIcons, $itemIconObjectNumberConf, $index, NULL, TRUE))) {
					$iconOptions = $allIconOptions;
					$iconOptions['url'] = Tx_AdGoogleMaps_Tools_BackEnd::getRelativeUploadPathAndFileName('markerIcons', $iconUrl);
					$itemOptions['icon'] = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_MarkerImage', $iconOptions);
				}

				if (($shadowUrl = $this->getContentByObjectNumberConf($itemShadows, $itemShadowObjectNumberConf, $index, NULL, TRUE))) {
					$shadowOptions = $allShadowOptions;
					$shadowOptions['url'] = Tx_AdGoogleMaps_Tools_BackEnd::getRelativeUploadPathAndFileName('shadowIcons', $shadowUrl);
					$itemOptions['shadow'] = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_MarkerImage', $shadowOptions);
				}

				$marker = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_Service_MapPlugin_ExtendedApi_Layers_Marker', $itemOptions);

				if ($mapCenterType === Tx_AdGoogleMaps_Domain_Model_Map::CENTER_TYPE_BOUNDS) {
					$itemBounds->extend($itemOptions['position']);
				}

				$this->mapPlugin->addLayer($marker);

				$infoWindowOptions = $allInfoWindowOptions;
				if (array_key_exists('content', $infoWindows)
						&& ($layerType === 'tx_adgooglemapsapi_layers_marker' || $infoWindowPlacingType & Tx_AdGoogleMaps_Domain_Model_Layer::INFO_WINDOW_PLACING_TYPE_MARKERS)) {
					$infoWindowOptions['key'] = $itemKey;
					$infoWindowOptions['disableAutoPan'] = $infoWindowDisableAutoPan;
					$infoWindowOptions['content'] = $this->getContentByObjectNumberConf($infoWindows['content'], $infoWindowObjectNumberConf, $index, $itemDataProvider, TRUE);

					if ($infoWindowOptions['content']) {
						$infoWindow = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_Service_MapPlugin_ExtendedApi_Layers_InfoWindow', $infoWindowOptions);
						$this->mapPlugin->addInfoWindow($infoWindow);

						if ($infoWindowKeepOpen) {
							$this->mapPlugin->addInfoWindowKeepOpen($itemKey);
						}
						if ($infoWindowCloseOnClick) {
							$this->mapPlugin->addInfoWindowCloseOnClick($itemKey);
						}
					}
				}

				$categoryItemKeys[] = $itemKey;
				$mapControllFunctions = $this->getItemMapControllFunctions($itemKey, (boolean) $infoWindowOptions['content']);

				$layerItem = t3lib_div::makeInstance('Tx_AdGoogleMaps_Domain_Model_Item');
				$layerItem->setTitle($itemOptions['title']);
				$layerItem->setIcon($iconOptions['url']);
				$layerItem->setIconWidth($iconOptions['width']);
				$layerItem->setIconHeight($iconOptions['height']);
				$layerItem->setPosition($itemOptions['position']);
				$layerItem->setMapControllFunctions($mapControllFunctions);
				$layerItem->setItemOptions($itemOptions);
				if ($infoWindowOptions['content']) {
					$layerItem->setInfoWindowOptions($infoWindowOptions);
				}
				if ($itemDataProvider) {
					$layerItem->setDataProvider($itemDataProvider);
				}
				$layer->addItem($layerItem);
			}
		}
		// Do if type is a shape.
		if ($layerType === 'tx_adgooglemapsapi_layers_polyline' || $layerType === 'tx_adgooglemapsapi_layers_polygon') {
			$itemKey = $layerUid . '_' . intval($index);
			$itemDataProvider = $this->getContentByObjectNumberConf($dataProvider, $infoWindowObjectNumberConf, $index, NULL, FALSE, array());

			// Get options.
			$itemOptions = array(
				'key' => $itemKey,
				'title' => $this->getContentByObjectNumberConf($itemTitles, $itemTitlesObjectNumberConf, $index, $itemDataProvider, TRUE, $layer->getTitle()),
				'clickable' => $this->getPropertyValue('shapeClickable', $layer, $this->settings['layer']),
				'geodesic' => $this->getPropertyValue('geodesic', $layer, $this->settings['layer']),
				'zindex' => $this->getPropertyValue('shapeZindex', $layer, $this->settings['layer']),
				'strokeColor' => $this->getPropertyValue('strokeColor', $layer, $this->settings['layer']),
				'strokeOpacity' => ($this->getPropertyValue('strokeOpacity', $layer, $this->settings['layer']) / 100),
				'strokeWeight' => $this->getPropertyValue('strokeWeight', $layer, $this->settings['layer']),
				'fillColor' => $this->getPropertyValue('fillColor', $layer, $this->settings['layer']),
				'fillOpacity' => ($this->getPropertyValue('fillOpacity', $layer, $this->settings['layer']) / 100),
				'flat' => $this->getPropertyValue('flat', $layer, $this->settings['layer']),
				'cursor' => $this->getPropertyValue('mouseCursor', $layer, $this->settings['layer']),
			);

			$itemOptions['paths'] = $itemOptions['path'] = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_LatLngArray', $coordinates);

			if (($iconUrl = $this->getContentByObjectNumberConf($itemIcons, $itemIconObjectNumberConf, $index, NULL, TRUE))) {
				$iconOptions = $allIconOptions;
				$iconOptions['url'] = Tx_AdGoogleMaps_Tools_BackEnd::getRelativeUploadPathAndFileName('markerIcons', $iconUrl);
			}

			switch ($layerType) {
				case 'tx_adgooglemapsapi_layers_polyline':
					$shape = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_Service_MapPlugin_ExtendedApi_Layers_Polyline', $itemOptions);
				break;

				case 'tx_adgooglemapsapi_layers_polygon':
					$shape = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_Service_MapPlugin_ExtendedApi_Layers_Polygon', $itemOptions);
				break;
			}

			if ($mapCenterType === Tx_AdGoogleMaps_Domain_Model_Map::CENTER_TYPE_BOUNDS) {
				$itemBounds->extendArray($itemOptions['path']);
			}

			$this->mapPlugin->addLayer($shape);

			$infoWindowOptions = $allInfoWindowOptions;
			if (array_key_exists('content', $infoWindows) && $infoWindowPlacingType & Tx_AdGoogleMaps_Domain_Model_Layer::INFO_WINDOW_PLACING_TYPE_SHAPE) {
				$infoWindowOptions['key'] = $itemKey;
				$infoWindowOptions['disableAutoPan'] = $infoWindowDisableAutoPan;

				// $infoWindowPosition can be a coordinate or a position of the coordinates
				if (preg_match('/^-?\d+\.?\d*\s*,\s*-?\d+\.?\d*$/', $infoWindowPosition)) {
					$infoWindowOptions['position'] = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_LatLng', $infoWindowPosition);
				} else if ($infoWindowPosition && array_key_exists(--$infoWindowPosition, $coordinates)) {
					$infoWindowOptions['position'] = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_LatLng', $coordinates[$match[0]]);
				}

				// If placing type ist "only on shape" the info window content are all content elements, else get content by object number.
				if ($infoWindowPlacingType === Tx_AdGoogleMaps_Domain_Model_Layer::INFO_WINDOW_PLACING_TYPE_SHAPE) {
					$infoWindowOptions['content'] = $this->renderTemplate(implode('', $infoWindows['content']), $itemDataProvider);
				} else {
					$infoWindowOptions['content'] = $this->getContentByObjectNumberConf($infoWindows['content'], $infoWindowObjectNumberConf, $index, $itemDataProvider, TRUE);
				}

				if ($infoWindowOptions['content']) {
					$infoWindow = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_Service_MapPlugin_ExtendedApi_Layers_InfoWindow', $infoWindowOptions);
					$this->mapPlugin->addInfoWindow($infoWindow);

					if ($infoWindowKeepOpen) {
						$this->mapPlugin->addInfoWindowKeepOpen($itemKey);
					}
					if ($infoWindowCloseOnClick) {
						$this->mapPlugin->addInfoWindowCloseOnClick($itemKey);
					}
				}
			}

			$categoryItemKeys[] = $itemKey;
			$mapControllFunctions = $this->getItemMapControllFunctions($itemKey, (boolean) $infoWindowOptions['content']);

			if (!$layerAddMarkers === TRUE || ($layerAddMarkers === TRUE && $layer->isForceListing() === TRUE)) {
				$layerItem = t3lib_div::makeInstance('Tx_AdGoogleMaps_Domain_Model_Item');
				$layerItem->setTitle($itemOptions['title']);
				$layerItem->setIcon($iconOptions['url']);
				$layerItem->setIconWidth($iconOptions['width']);
				$layerItem->setIconHeight($iconOptions['height']);
				$layerItem->setPosition($itemOptions['position']);
				$layerItem->setMapControllFunctions($mapControllFunctions);
				$layerItem->setItemOptions($itemOptions);
				if ($infoWindowOptions['content']) {
					$layerItem->setInfoWindowOptions($infoWindowOptions);
				}
				if ($itemDataProvider) {
					$layerItem->setDataProvider($itemDataProvider);
				}
				$layer->addItem($layerItem);
			}
		}

		// Do category stuff.
		$category->setMapControllFunctions($this->getCategoryMapControllFunctions($categoryItemKeys));
	}

	/**
	 * Returns the $itemTitlesObjectNumberConf.
	 *
	 * @param Tx_AdGoogleMaps_Domain_Model_Layer $layer
	 * @param integer $count
	 * @return array
	 */
	protected function getInfoWindows(Tx_AdGoogleMaps_Domain_Model_Layer $layer) {
		// Get info window data
		$loadDB = t3lib_div::makeInstance('FE_loadDBGroup');
		$loadDB->start($layer->getInfoWindow(), 'tt_content', 'tx_adgooglemaps_layer_ttcontent_mm');
		$loadDB->readMM('tx_adgooglemaps_layer_ttcontent_mm', $layer->getUid());
		$loadDB->getFromDB();

		$infoWindows = array();
		$infoWindowRenderConfiguration = $this->settings['layer']['infoWindowRenderConfiguration'];
		$typoScriptNodeValue = $infoWindowRenderConfiguration['_typoScriptNodeValue'];
		$infoWindowRenderConfiguration = Tx_Extbase_Utility_TypoScript::convertPlainArrayToTypoScriptArray($infoWindowRenderConfiguration);
		foreach ($loadDB->itemArray as $itemArray) {
			$contentData = $loadDB->results['tt_content'][$itemArray['id']];
			$this->contentObject->start($contentData, 'tt_content');
			$infoWindows['content'][] = $this->contentObject->cObjGetSingle($typoScriptNodeValue, $infoWindowRenderConfiguration);
			$infoWindows['data'][] = $contentData;
		}
		return $infoWindows;
	}

	/**
	 * Returns the $itemTitlesObjectNumberConf.
	 *
	 * @param string $itemTitlesObjectNumber
	 * @param integer $count
	 * @return void
	 */
	protected function getObjectNumberConf($itemTitlesObjectNumber, $count) {
		return $itemTitlesObjectNumber ? $GLOBALS['TSFE']->tmpl->splitConfArray(array('objectNumber' => $itemTitlesObjectNumber), $count) : NULL;
	}

	/**
	 * Returns the content by object number conf. If $dataProvider is set, the content will be redered.
	 *
	 * @param array $contentProvider
	 * @param array $itemTitlesObjectNumberConf
	 * @param integer $index
	 * @param array $dataProvider
	 * @param string $defaultValue
	 * @return mixed
	 */
	protected function getContentByObjectNumberConf($contentProvider, $objectNumberConf, $index, $dataProvider = NULL, $defaultLast = FALSE, $defaultValue = NULL) {
		// Get content. Can be empty. This check first if optionSplit is used.
		// Then look for current row or last row, else set the default value.
		$result = NULL;
		if ($objectNumberConf) {
			$result = $this->getObjectNumberValue($contentProvider, $objectNumberConf, $index);
		} else if (array_key_exists($index, $contentProvider)) {
			$result = $contentProvider[$index];
		} else if ($defaultLast === TRUE && count($contentProvider)) {
			$result = array_pop($contentProvider);
		} else if ($defaultLast === FALSE && array_key_exists(0, $contentProvider)) {
			$result = $contentProvider[0];
		} else if ($defaultValue) {
			$result = $defaultValue;
		}
		if ($dataProvider !== NULL && $result !== NULL) {
			$result = $this->renderTemplate($result, $dataProvider);
		}
		return $result;
	}

	/**
	 * Get overall info windows options. Override only if map behaviour contains "by layer" 
	 * and layer property is true ("0" are false also), OR map behaviour contains "only layer":
	 *
	 * @param mixed $layerValue
	 * @param mixed $mapValue
	 * @return mixed
	 */
	protected function getInfoWindowOptionValueByInfoWindowBehaviour($layerValue, $mapValue) {
		$infoWindowBehaviour = (integer) $this->getPropertyValue('infoWindowBehaviour', $this->map, $this->settings['map']);
		if ($infoWindowBehaviour === (Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_MAP | Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER)) {
			$value = $layerValue ? $layerValue : $mapValue;
		} else if ($infoWindowBehaviour === Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_MAP) {
			$value = $mapValue;
		} else {
			$value = $layerValue;
		}
		return $value;
	}

	/**
	 * Returns the map controll functions as an array.
	 *
	 * @param string $itemKey
	 * @param boolean $setInfoWindowFunction
	 * @return array
	 */
	protected function getItemMapControllFunctions($itemKey, $setInfoWindowFunction = FALSE) {
		$mapControllFunctions = array(
			'openInfoWindow' => ($setInfoWindowFunction === TRUE ? $this->mapPlugin->getPluginMapObjectIdentifier() . '.openInfoWindow(\'' . $itemKey . '\')' : 'void(0)'),
			'panTo' => $this->mapPlugin->getPluginMapObjectIdentifier() . '.panTo(\'' . $itemKey . '\')',
			'fitBounds' => $this->mapPlugin->getPluginMapObjectIdentifier() . '.fitBounds(\'' . $itemKey . '\')',
		);
		if (array_key_exists('mapControllFunctions', $this->settings['layer'])) {
			$mapControllFunctions = t3lib_div::array_merge_recursive_overrule($mapControllFunctions, $this->settings['layer']['mapControllFunctions']);
			$mapControllFunctions = str_replace('###ITEM_KEY###', $itemKey, $mapControllFunctions);
		}
		return $mapControllFunctions;
	}

	/**
	 * Returns the map controll functions as an array.
	 *
	 * @param array $categoryItemKeys
	 * @return array
	 */
	protected function getCategoryMapControllFunctions($categoryItemKeys) {
		$javaScriptArray = (count($categoryItemKeys) > 0 ? '[\'' . implode('\', \'', $categoryItemKeys) . '\']' : 'null');
		$mapControllFunctions = array(
			'panTo' => $this->mapPlugin->getPluginMapObjectIdentifier() . '.panTo(' . $javaScriptArray . ')',
			'fitBounds' => $this->mapPlugin->getPluginMapObjectIdentifier() . '.fitBounds(' . $javaScriptArray . ')',
		);
		if (array_key_exists('mapControllFunctions', $this->settings['category'])) {
			$mapControllFunctions = t3lib_div::array_merge_recursive_overrule($mapControllFunctions, $this->settings['category']['mapControllFunctions']);
			$mapControllFunctions = str_replace('###ITEM_KEYS###', $javaScriptArray, $mapControllFunctions);
		}
		return $mapControllFunctions;
	}

	/**
	 * Renders the given template via fluid rendering engine.
	 * 
	 * @param string $templateSource
	 * @param array $templateData
	 * @return string
	 */
	protected function renderTemplate($templateSource, array $templateData) {
		$templateParser = Tx_Fluid_Compatibility_TemplateParserBuilder::build();

		if ($templateSource) {
			$content = $templateParser->parse($templateSource);
			$variableContainer = t3lib_div::makeInstance('Tx_Fluid_Core_ViewHelper_TemplateVariableContainer', $templateData);
			$renderingContext = t3lib_div::makeInstance('Tx_Fluid_Core_Rendering_RenderingContext');
			$renderingContext->setTemplateVariableContainer($variableContainer);
			$viewHelperVariableContainer = t3lib_div::makeInstance('Tx_Fluid_Core_ViewHelper_ViewHelperVariableContainer');
			$renderingContext->setViewHelperVariableContainer($viewHelperVariableContainer);

			return $content->render($renderingContext);
		}
	}

	/**
	 * Returns this items by index
	 *
	 * @param array $dataArray
	 * @param array $objectNumberConf
	 * @param integer $index
	 * @return array
	 */
	protected function getObjectNumberValue($dataArray, $objectNumberConf, $index) {
		$value = NULL;
		if (count($objectNumberConf)) {
			if (array_key_exists($index, $objectNumberConf) && $objectNumberConf[$index]['objectNumber']) {
				$objectNumbers = t3lib_div::trimExplode(',', $objectNumberConf[$index]['objectNumber']);
				foreach ($objectNumbers as $objectNumber) {
					$objectNumber--;
					if (array_key_exists($objectNumber, $dataArray)) {
						if (is_array($dataArray[$objectNumber])) {
							$value[] = $dataArray[$objectNumber];
						} else {
							$value .= $dataArray[$objectNumber];
						}
					}
				}
			}
		} else if (count($dataArray)) {
			if (array_key_exists($index, $dataArray)) {
				if (is_array($dataArray[$index])) {
					$value[] = $dataArray[$index];
				} else {
					$value = $dataArray[$index];
				}
			}
		}
		return $value;
	}

	/**
	 * Returns the setting value instead of property value if is set. 
	 *
	 * @param string $propertyName
	 * @param mixed $object
	 * @param array $settings
	 * @return mixed
	 */
	protected function getPropertyValue($propertyName, $object, $settings) {
		$currentValue = NULL;
		if (is_callable(array($object, 'get' . ucfirst($propertyName)))) {
			$currentValue = call_user_func(array($object, 'get' . ucfirst($propertyName)));
		} else if (is_callable(array($object, 'is' . ucfirst($propertyName)))) {
			$currentValue = call_user_func(array($object, 'is' . ucfirst($propertyName)));
		} else if (is_callable(array($object, 'has' . ucfirst($propertyName)))) {
			$currentValue = call_user_func(array($object, 'has' . ucfirst($propertyName)));
		} else if (array_key_exists($propertyName, get_object_vars($object))) {
			$currentValue = $object->$propertyName;
		}

		// Get settings value only if set and current value is "false", "0" or empty.
		if (array_key_exists($propertyName, $settings) === TRUE && !$currentValue) {
			if (is_callable(array($object, 'is' . ucfirst($propertyName))) || is_callable(array($object, 'has' . ucfirst($propertyName)))) {
				return (boolean) $settings[$propertyName];
			} else {
				return $settings[$propertyName];
			}
		}

		return $currentValue;
	}

}

?>