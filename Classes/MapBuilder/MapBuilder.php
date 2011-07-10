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
 * Adapter for the Tx_AdGoogleMaps_Plugin_GoogleMaps class.
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_AdGoogleMaps_MapBuilder_MapBuilder {

	/**
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @var Tx_AdGoogleMaps_Domain_Model_Map
	 */
	protected $map;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @var Tx_AdGoogleMaps_Plugin_GoogleMaps
	 */
	protected $googleMapsPlugin;

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
	 * @return Tx_AdGoogleMaps_Plugin_GoogleMaps
	 */
	public function getGoogleMapsPlugin() {
		return $this->googleMapsPlugin;
	}

	/**
	 * Returns the Google Maps API object.
	 *
	 * @param Tx_AdGoogleMaps_Domain_Model_Map $map
	 * @param array $settings
	 * @return Tx_AdGoogleMaps_MapBuilder_MapBuilder
	 */
	public function build(Tx_AdGoogleMaps_Domain_Model_Map $map, $settings) {
		$this->map = $map;
		$this->settings = $settings;

		// Create Google Maps API plugin.
		$this->googleMapsPlugin = $this->objectManager->create('Tx_AdGoogleMaps_Plugin_GoogleMaps')
			->setMapId($this->map->getPropertyValue('uid', 'map'))
			->setWidth($this->map->getWidth())
			->setHeight($this->map->getHeight());

		// Set plugin options.
		$apiSettings = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_adgooglemaps.']['settings.']['api.'];
		$pluginOptions = $this->googleMapsPlugin->getPluginOptions();
		$canvas = $apiSettings['canvas'];
		$pluginOptions
			->setCanvasId(str_replace('###UID###', $this->map->getPropertyValue('uid', 'map'), $canvas));

		// Set initial map options.
		$mapZoom = $this->map->getZoom();
		$mapZoom = $mapZoom > 0 ? $mapZoom : $apiSettings['zoom']; 
		$mapCenter = $this->map->getCenter();
		if (Tx_AdGoogleMaps_Api_Base_LatLng::isValidCoordinate($mapCenter) === FALSE) {
			if (Tx_AdGoogleMaps_Api_Base_LatLng::isValidCoordinate($this->settings['map']['center']) === TRUE) {
				$mapCenter = $this->settings['map']['center'];
			} else {
				$mapCenter = '48.209206,16.372778';
			}
		}
		$pluginMapOption = $pluginOptions->getMapOptions();
		$pluginMapOption
			->setMapTypeId($this->map->getMapTypeId())
			->setCenter(new Tx_AdGoogleMaps_Api_Base_LatLng($mapCenter))
			->setBackgroundColor($this->map->getBackgroundColor())
			->setNoClear($this->map->isNoClear())
			->setDisableDefaultUi($this->map->isDisableDefaultUi())
			->setZoom($mapZoom)
			->setMinZoom($this->map->getMinZoom())
			->setMaxZoom($this->map->getMaxZoom());
		// Set control options.
		if ($this->map->hasMapTypeControl() === TRUE) {
			$pluginMapOption
				->setMapTypeControl(TRUE)
				->setMapTypeControls($this->objectManager->create('Tx_AdGoogleMaps_Api_Control_MapType', 
					$this->map->getMapTypeControlsMapTypeIds(),
					$this->map->getMapTypeControlsPosition(),
					$this->map->getMapTypeControlsStyle()
				));
		}
		if ($this->map->hasRotateControl() === TRUE) {
			$pluginMapOption
				->setRotateControl(TRUE)
				->setRotateControls($this->objectManager->create('Tx_AdGoogleMaps_Api_Control_Rotate', 
					$this->map->getRotateControlsPosition()
				));
		}
		if ($this->map->hasScaleControl() === TRUE) {
			$pluginMapOption
				->setScaleControl(TRUE)
				->setScaleControls($this->objectManager->create('Tx_AdGoogleMaps_Api_Control_Scale', 
					$this->map->getScaleControlsPosition(),
					$this->map->getScaleControlsStyle()
				));
		}
		if ($this->map->hasPanControl() === TRUE) {
			$pluginMapOption
				->setPanControl(TRUE)
				->setPanControls($this->objectManager->create('Tx_AdGoogleMaps_Api_Control_Pan', 
					$this->map->getPanControlsPosition()
				));
		}
		if ($this->map->hasZoomControl() === TRUE) {
			$pluginMapOption
				->setZoomControl(TRUE)
				->setZoomControls($this->objectManager->create('Tx_AdGoogleMaps_Api_Control_Zoom', 
					$this->map->getZoomControlsPosition(),
					$this->map->getZoomControlsStyle()
				));
		}
		if ($this->map->hasOverviewMapControl() === TRUE) {
			$pluginMapOption
				->setOverviewMapControl(TRUE)
				->setOverviewMapControls($this->objectManager->create('Tx_AdGoogleMaps_Api_Control_OverviewMap', 
					$this->map->getOverviewMapControlsIsOpened()
				));
		}
		if ($this->map->hasStreetViewControl() === TRUE) {
			$pluginMapOption
				->setStreetViewControl(TRUE)
				->setStreetViewControls($this->objectManager->create('Tx_AdGoogleMaps_Api_Control_StreetView', 
					$this->map->getStreetViewControlsPosition()
				));
		}
		// Set interaction options.
		$pluginMapOption
			->setDisableDoubleClickZoom($this->map->isDisableDoubleClickZoom())
			->setScrollwheel($this->map->hasScrollwheel())
			->setDraggable($this->map->isDraggable())
			->setKeyboardShortcuts($this->map->hasKeyboardShortcuts())
			->setDraggableCursor($this->map->getDraggableCursor())
			->setDraggingCursor($this->map->getDraggingCursor());

		// Set map control options.
		$pluginMapControl = $pluginOptions->getMapControl();
		$pluginMapControl
			->setFitBoundsOnLoad($this->map->getCenterType() === Tx_AdGoogleMaps_Domain_Model_Map::CENTER_TYPE_BOUNDS)
			->setUseMarkerCluster($this->map->isUseMarkerCluster())
			->setInfoWindowCloseAllOnMapClick($this->map->isInfoWindowCloseAllOnMapClick());

		$this->buildLayers($this->map->getCategories());

		return $this;
	}

	/**
	 * Returns the Google Maps API object.
	 *
	 * @param mixed $categories
	 * @return Tx_AdGoogleMaps_Api_Map_Map
	 * @throw Tx_AdGoogleMaps_MapBuilder_Exception
	 */
	protected function buildLayers($categories) {
		foreach ($categories as $category) {
			$categoryItemKeys = array();
			$layerBuilder = NULL;
			$this->buildLayers($category->getSubCategories());
			foreach ($category->getLayers() as $layer) {
				// Check if layer built allready. If there is a recursion of the categories witch contains 
				// the same layers, than duplicates are added to the layer items.
				if ($layer->getItems()->count() === 0) {
					$layerBuilderClassName = $layer->getType();
					if (strpos($layerBuilderClassName, 'Tx_AdGoogleMaps') === FALSE) {
						throw new Tx_AdGoogleMaps_MapBuilder_Exception('Given layer builder class "' . $layerBuilderClassName . '" must begin with "Tx_AdGoogleMaps".', 1297889110);
					}
					if (class_exists($layerBuilderClassName) === FALSE) {
						throw new Tx_AdGoogleMaps_MapBuilder_Exception('Given layer builder class "' . $layerBuilderClassName . '" doesn\'t exists.', 1297889111);
					}
					$layerBuilder = $this->objectManager->create($layerBuilderClassName);
					$layerBuilder->setSettings($this->settings);
					$layerBuilder->setMapBuilder($this);
					$layerBuilder->setGoogleMapsPlugin($this->googleMapsPlugin);
					$layerBuilder->setMap($this->map);
					$layerBuilder->setCategory($category);
					$layerBuilder->setLayer($layer);

					$layerBuilder->buildItems();

					// Get category map Control functions.
					$categoryItemKeys = array_merge($categoryItemKeys, $layerBuilder->getCategoryItemKeys());
				}
			}
			// Set category map control functions.
			if ($layerBuilder !== NULL) {
				$layerBuilder->getCategory()->setMapControlFunctions(
					$this->getCategoryMapControlFunctions($categoryItemKeys)
				);
			}
		}
	}

	/**
	 * Returns the map control functions as an array.
	 *
	 * @param array $categoryItemKeys
	 * @return array
	 */
	protected function getCategoryMapControlFunctions($categoryItemKeys) {
		$javaScriptArray = (count($categoryItemKeys) > 0 ? '[\'' . implode('\', \'', $categoryItemKeys) . '\']' : 'null');
		$mapControlFunctions = array(
			'panTo' => $this->googleMapsPlugin->getPluginMapObjectIdentifier() . '.panTo(' . $javaScriptArray . ')',
			'fitBounds' => $this->googleMapsPlugin->getPluginMapObjectIdentifier() . '.fitBounds(' . $javaScriptArray . ')',
		);
		if (array_key_exists('mapControlFunctions', $this->settings['category'])) {
			$mapControlFunctions = t3lib_div::array_merge_recursive_overrule($mapControlFunctions, $this->settings['category']['mapControlFunctions']);
			$mapControlFunctions = str_replace('###LAYER_UIDS###', $javaScriptArray, $mapControlFunctions);
		}
		return $mapControlFunctions;
	}

}

?>