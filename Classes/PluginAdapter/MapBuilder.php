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
 * Adapter for the Tx_AdGoogleMapsApi_Plugin_GoogleMaps class.
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_AdGoogleMaps_PluginAdapter_MapBuilder {

	/**
	 * @var Tx_AdGoogleMaps_Domain_Model_Map
	 */
	protected $map;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @var Tx_AdGoogleMapsApi_Plugin_GoogleMaps
	 */
	protected $googleMapsPlugin;

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
		$this->map = clone $map;
		$this->settings = $settings;
		$this->addressRepository = t3lib_div::makeInstance('Tx_AdGoogleMaps_Domain_Repository_AddressRepository');
		$this->addressGroupRepository = t3lib_div::makeInstance('Tx_AdGoogleMaps_Domain_Repository_AddressGroupRepository');
	}

	/**
	 * Returns the setting value instead of property value if is set. 
	 *
	 * @param string $propertyName
	 * @param mixed $object
	 * @param array $settings
	 * @return mixed
	 */
	public function getPropertyValue($propertyName, $object, $settings) {
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

	/**
	 * Returns this map.
	 *
	 * @return Tx_AdGoogleMaps_Domain_Model_Map
	 */
	public function getMap() {
		return $this->map;
	}

	/**
	 * Returns this googleMapsPlugin
	 *
	 * @return Tx_AdGoogleMapsApi_Plugin_GoogleMaps
	 */
	public function getGoogleMapsPlugin() {
		return $this->googleMapsPlugin;
	}

	/**
	 * Returns the Google Maps API object.
	 *
	 * @return void
	 */
	public function buildMap() {
		// Create Google Maps API plugin.
		$this->googleMapsPlugin = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_Plugin_GoogleMaps')
			->setMapId($this->getPropertyValue('uid', $this->map, $this->settings['map']))
			->setWidth($this->getPropertyValue('width', $this->map, $this->settings['map']))
			->setHeight($this->getPropertyValue('height', $this->map, $this->settings['map']))
			->setUseMarkerCluster($this->getPropertyValue('useMarkerCluster', $this->map, $this->settings['map']))
			->setSearchControl($this->getPropertyValue('searchControl', $this->map, $this->settings['map']))
			->setInfoWindowCloseAllOnMapClick($this->getPropertyValue('infoWindowCloseAllOnMapClick', $this->map, $this->settings['map']));
		// Set search control.
		if ($this->getPropertyValue('searchControl', $this->map, $this->settings['map']) === TRUE) {
			if (($searchMarkerUrl = Tx_AdGoogleMaps_Tools_BackEnd::getRelativeUploadPathAndFileName('ad_google_maps', 'markerIcons', $this->getPropertyValue('searchMarker', $this->map, $this->settings['map']))) === NULL) {
				$searchMarkerUrl = 'typo3conf/ext/ad_google_maps_api/Resources/Public/Icons/Service/MapDrawer/searchMarker.gif';
			} 
			$searchMarker = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_MarkerImage', array(
				'url' => $searchMarkerUrl,
				'width' => $this->getPropertyValue('searchMarkerWidth', $this->map, $this->settings['map']),
				'height' => $this->getPropertyValue('searchMarkerHeight', $this->map, $this->settings['map']),
				'originX' => $this->getPropertyValue('searchMarkerOriginX', $this->map, $this->settings['map']),
				'originY' => $this->getPropertyValue('searchMarkerOriginY', $this->map, $this->settings['map']),
				'anchorX' => $this->getPropertyValue('searchMarkerAnchorX', $this->map, $this->settings['map']),
				'anchorY' => $this->getPropertyValue('searchMarkerAnchorY', $this->map, $this->settings['map']),
				'scaledWidth' => $this->getPropertyValue('searchMarkerScaledWidth', $this->map, $this->settings['map']),
				'scaledHeight' => $this->getPropertyValue('searchMarkerScaledHeight', $this->map, $this->settings['map']),
			));
			$this->googleMapsPlugin->setSearchMarker($searchMarker);
		}

		$mapApi = $this->googleMapsPlugin->getMap();

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
			if (($center = $this->getPropertyValue('center', $this->map, $this->settings['map']))) {
				$mapApi->setCenter(new Tx_AdGoogleMapsApi_LatLng($center));
			}
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
	 * @throw Tx_AdGoogleMaps_Exception
	 */
	protected function buildLayers($categories) {
		foreach ($categories as $category) {
			$this->buildLayers($category->getSubCategories());
			foreach ($category->getLayers() as $layer) {
				// Check if layer built allready. If there is a recursion of the categories witch contains 
				// the same layers, than duplicates are added to the layer items.
				if ($layer->getItems()->count() === 0) {
					$layerBuilderClassName = $this->getPropertyValue('type', $layer, $this->settings['layer']);
					if (class_exists($layerBuilderClassName) === FALSE) {
						throw new Tx_AdGoogleMaps_Exception('Given layer builder class "' . $layerBuilderClassName . '" doesn\'t exists.', 1297889103);
					}
					$layerBuilder = t3lib_div::makeInstance($layerBuilderClassName);
					$layerBuilder->injectSettings($this->settings);
					$layerBuilder->injectMapBuilder($this);
					$layerBuilder->injectGoogleMapsPlugin($this->googleMapsPlugin);
					$layerBuilder->injectMap($this->map);
					$layerBuilder->injectCategory($category);
					$layerBuilder->injectLayer($layer);

					$layerBuilder->buildItems();
				}
			}
		}
	}

	/**
	 * Returns the Google Maps API object.
	 *
	 * @param Tx_AdGoogleMaps_Domain_Model_Category $category
	 * @param Tx_AdGoogleMaps_Domain_Model_Layer_LayerInterface $layer
	 * @return Tx_AdGoogleMapsApi_Map
	 */
	protected function buildItems(Tx_AdGoogleMaps_Domain_Model_Category $category, Tx_AdGoogleMaps_Domain_Model_Layer_LayerInterface $layer) {
		$mapCenterType = (integer) $this->getPropertyValue('centerType', $this->map, $this->settings['map']);
		if ($mapCenterType === Tx_AdGoogleMaps_Domain_Model_Map::CENTER_TYPE_BOUNDS) {
			$itemBounds = $this->googleMapsPlugin->getBounds();
		}

		// Do only if markers set.
		if ($layerAddMarkers === TRUE || $layerType === 'tx_adgooglemapsapi_layers_marker') {
			for ($index = 0; $index < $countCoordinates; $index++) {
				if ($mapCenterType === Tx_AdGoogleMaps_Domain_Model_Map::CENTER_TYPE_BOUNDS) {
					$itemBounds->extend($itemOptions['position']);
				}
			}
		}
		// Do if type is a shape.
		if ($layerType === 'tx_adgooglemapsapi_layers_polyline' || $layerType === 'tx_adgooglemapsapi_layers_polygon') {
			if ($mapCenterType === Tx_AdGoogleMaps_Domain_Model_Map::CENTER_TYPE_BOUNDS) {
				$itemBounds->extendArray($itemOptions['path']);
			}
		}
	}

}

?>