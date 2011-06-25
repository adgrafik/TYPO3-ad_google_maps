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
 * MapManager class.
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_AdGoogleMaps_MapManager_Manager {

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
	 * @param Tx_Extbase_Persistence_QueryResultInterface $categories
	 * @param array $settings
	 * @return Tx_AdGoogleMaps_MapManager_Manager
	 */
	public function build(Tx_AdGoogleMaps_Domain_Model_Map $map, Tx_Extbase_Persistence_QueryResultInterface $categories, $settings) {
		$this->map = $map;
		$this->settings = $settings;

		// Create Google Maps API plugin.
		$this->googleMapsPlugin = t3lib_div::makeInstance('Tx_AdGoogleMaps_Plugin_GoogleMaps')
			->setMapId($this->map->getPropertyValue('uid', 'map'))
			->setWidth($this->settings['flexform']['width'] ? $this->settings['flexform']['width'] : $this->settings['plugin']['width'])
			->setHeight($this->settings['flexform']['height'] ? $this->settings['flexform']['height'] : $this->settings['plugin']['height']);

		// Set plugin options.
		$pluginOptions = $this->googleMapsPlugin->getPluginOptions();
		$canvas = $this->settings['plugin']['canvas'];
		$pluginOptions
			->setCanvasId(str_replace('###UID###', $this->map->getPropertyValue('uid', 'map'), $canvas));

		// Set initial map options.
		$mapCenter = $this->map->getCenter();
		if (Tx_AdGoogleMaps_MapBuilder_Api_LatLng::isValidCoordinate($mapCenter) === FALSE) {
			if (Tx_AdGoogleMaps_MapBuilder_Api_LatLng::isValidCoordinate($this->settings['models']['map']['center']) === TRUE) {
				$mapCenter = $this->settings['models']['map']['center'];
			} else {
				$mapCenter = '48.209206,16.372778';
			}
		}
		$pluginMapOption = $pluginOptions->getMapOptions();
		$pluginMapOption
			->setMapTypeId($this->map->getMapTypeId())
			->setCenter(new Tx_AdGoogleMaps_MapBuilder_Api_LatLng($mapCenter))
			->setBackgroundColor($this->map->getBackgroundColor())
			->setNoClear($this->map->isNoClear())
			->setDisableDefaultUi($this->map->isDisableDefaultUi())
			->setZoom($this->map->getZoom())
			->setMinZoom($this->map->getMinZoom())
			->setMaxZoom($this->map->getMaxZoom());
		// Set control options.
		if ($this->map->hasMapTypeControl() === TRUE) {
			$pluginMapOption
				->setMapTypeControl(TRUE)
				->setMapTypeControlOptions(t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_ControlOptions_MapType', 
					$this->map->getMapTypeControlOptionsMapTypeIds(),
					$this->map->getMapTypeControlOptionsPosition(),
					$this->map->getMapTypeControlOptionsStyle()
				));
		}
		if ($this->map->hasNavigationControl() === TRUE) {
			$pluginMapOption
				->setNavigationControl(TRUE)
				->setNavigationControlOptions(t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_ControlOptions_Navigation', 
					$this->map->getNavigationControlOptionsPosition(),
					$this->map->getNavigationControlOptionsStyle()
				));
		}
		if ($this->map->hasScaleControl() === TRUE) {
			$pluginMapOption
				->setScaleControl(TRUE)
				->setScaleControlOptions(t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_ControlOptions_Scale', 
					$this->map->getScaleControlOptionsPosition(),
					$this->map->getScaleControlOptionsStyle()
				));
		}
		if ($this->map->hasPanControl() === TRUE) {
			$pluginMapOption
				->setPanControl(TRUE)
				->setPanControlOptions(t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_ControlOptions_Pan', 
					$this->map->getPanControlOptionsPosition()
				));
		}
		if ($this->map->hasZoomControl() === TRUE) {
			$pluginMapOption
				->setZoomControl(TRUE)
				->setZoomControlOptions(t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_ControlOptions_Zoom', 
					$this->map->getZoomControlOptionsPosition(),
					$this->map->getZoomControlOptionsStyle()
				));
		}
		if ($this->map->hasStreetViewControl() === TRUE) {
			$pluginMapOption
				->setStreetViewControl(TRUE)
				->setStreetViewControlOptions(t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_ControlOptions_StreetView', 
					$this->map->getStreetViewControlOptionsPosition()
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

		$this->buildLayers($categories);

		return $this;
	}

	/**
	 * Builds the Google Maps layers.
	 *
	 * @param mixed $categories
	 * @return void
	 * @throw Tx_AdGoogleMaps_MapManager_Exception
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
					if (class_exists($layerBuilderClassName) === FALSE) {
						throw new Tx_AdGoogleMaps_MapManager_Exception('Given layer builder class "' . $layerBuilderClassName . '" doesn\'t exists.', 1297889103);
					}
					$layerBuilder = t3lib_div::makeInstance($layerBuilderClassName);
					$layerBuilder->injectSettings($this->settings);
					$layerBuilder->injectMapManager($this);
					$layerBuilder->injectGoogleMapsPlugin($this->googleMapsPlugin);
					$layerBuilder->injectMap($this->map);
					$layerBuilder->injectCategory($category);
					$layerBuilder->injectLayer($layer);

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
		$pluginMapObjectIdentifier = $this->googleMapsPlugin->getPluginMapObjectIdentifier();
		$layerUids = (count($categoryItemKeys) > 0 ? '[\'' . implode('\', \'', $categoryItemKeys) . '\']' : 'null');
		$mapControlFunctions = array(
			'panTo' => sprintf('%s.panTo(%s)', $pluginMapObjectIdentifier, $layerUids),
			'fitBounds' => sprintf('%s.fitBounds(%s)', $pluginMapObjectIdentifier, $layerUids),
			'show' => sprintf('%s.show(%s)', $pluginMapObjectIdentifier, $layerUids),
			'hide' => sprintf('%s.hide(%s)', $pluginMapObjectIdentifier, $layerUids),
			'toggle' => sprintf('%s.toggle(%s)', $pluginMapObjectIdentifier, $layerUids),
		);
		if (array_key_exists('mapControlFunctions', $this->settings['models']['category'])) {
			$mapControlFunctions = t3lib_div::array_merge_recursive_overrule($mapControlFunctions, $this->settings['models']['category']['mapControlFunctions']);
			// @deprecated: ###ITEM_KEYS### is deprecated. Use ###LAYER_UIDS### instead.
			$mapControlFunctions = str_replace(
				array('###ITEM_KEYS###', '###LAYER_UIDS###', '###PLUGIN_MAPOBJECT_IDENTIFIER###'),
				array($layerUids, $layerUids, $pluginMapObjectIdentifier),
				$mapControlFunctions
			);
		}
		return $mapControlFunctions;
	}

}

?>