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
 * Abstract layer builder class.
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
abstract class Tx_AdGoogleMaps_MapBuilder_Layer_AbstractLayer implements Tx_AdGoogleMaps_MapBuilder_Layer_LayerInterface {

	/**
	 * @var tslib_cObj
	 */
	protected $contentObject;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @var Tx_AdGoogleMaps_MapBuilder_MapBuilder
	 */
	protected $mapBuilder;

	/**
	 * @var Tx_AdGoogleMaps_Plugin_GoogleMaps
	 */
	protected $googleMapsPlugin;

	/**
	 * @var Tx_AdGoogleMaps_Domain_Model_Map
	 */
	protected $map;

	/**
	 * @var Tx_AdGoogleMaps_Domain_Model_Category
	 */
	protected $category;

	/**
	 * @var Tx_AdGoogleMaps_Domain_Model_Layer_LayerInterface
	 */
	protected $layer;

	/**
	 * If type is e.g. a shape and placing type of the info windows is set to shape this means, 
	 * that there should be an info window on every item. In this case it must be one more.
	 * 
	 * @var boolean
	 */
	protected $addCountCoordinates;

	/**
	 * @var array
	 */
	protected $categoryItemKeys;

	/**
	 * @var boolean
	 */
	protected $preventAddListItems;

	/**
	 * @var boolean
	 */
	protected $useCoordinatesProvider;

	/**
	 * @var string
	 */
	protected $coordinatesProviderIterateProperty;

	/**
	 * @var Tx_AdGoogleMaps_MapBuilder_CoordinatesProvider_CoordinatesProviderInterface
	 */
	protected $coordinatesProvider;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->useCoordinatesProvider = FALSE;
		$this->addCountCoordinates = FALSE;
		$this->preventAddListItems = FALSE;
		$this->categoryItemKeys = array();
	}

	/**
	 * Injects this settings
	 *
	 * @param array $settings
	 * @return void
	 */
	public function injectSettings($settings) {
		$this->settings = $settings;
	}

	/**
	 * Injects this mapBuilder
	 *
	 * @param Tx_AdGoogleMaps_MapBuilder_MapBuilder $mapBuilder
	 * @return void
	 */
	public function injectMapBuilder(Tx_AdGoogleMaps_MapBuilder_MapBuilder $mapBuilder) {
		$this->mapBuilder = $mapBuilder;
	}

	/**
	 * Injects this googleMapsPlugin
	 *
	 * @param Tx_AdGoogleMaps_Plugin_GoogleMaps $googleMapsPlugin
	 * @return void
	 */
	public function injectGoogleMapsPlugin(Tx_AdGoogleMaps_Plugin_GoogleMaps $googleMapsPlugin) {
		$this->googleMapsPlugin = $googleMapsPlugin;
	}

	/**
	 * Injects this map
	 *
	 * @param Tx_AdGoogleMaps_Domain_Model_Map $map
	 * @return void
	 */
	public function injectMap(Tx_AdGoogleMaps_Domain_Model_Map $map) {
		$this->map = $map;
	}

	/**
	 * Injects this category.
	 *
	 * @param Tx_AdGoogleMaps_Domain_Model_Category $category
	 * @return void
	 */
	public function injectCategory(Tx_AdGoogleMaps_Domain_Model_Category $category) {
		$this->category = $category;
	}

	/**
	 * Injects this layer.
	 *
	 * @param Tx_AdGoogleMaps_Domain_Model_Layer_LayerInterface $layer
	 * @return void
	 */
	public function injectLayer(Tx_AdGoogleMaps_Domain_Model_Layer_LayerInterface $layer) {
		$this->layer = $layer;
	}

	/**
	 * Injects this layer.
	 *
	 * @param Tx_AdGoogleMaps_MapBuilder_CoordinatesProvider_CoordinatesProviderInterface $coordinatesProvider
	 * @return void
	 */
	public function injectCoordinatesProvider(Tx_AdGoogleMaps_MapBuilder_CoordinatesProvider_CoordinatesProviderInterface $coordinatesProvider) {
		$this->coordinatesProvider = $coordinatesProvider;
	}

	/**
	 * Returns this settings
	 *
	 * @return array
	 */
	public function getSettings() {
		return $this->settings;
	}

	/**
	 * Returns this mapBuilder
	 *
	 * @return Tx_AdGoogleMaps_MapBuilder_MapBuilder
	 */
	public function getMapBuilder() {
		return $this->mapBuilder;
	}

	/**
	 * Returns this googleMapsPlugin
	 *
	 * @return Tx_AdGoogleMaps_MapBuilder_Plugin_GoogleMaps
	 */
	public function getGoogleMapsPlugin() {
		return $this->googleMapsPlugin;
	}

	/**
	 * Returns this map
	 *
	 * @return Tx_AdGoogleMaps_Domain_Model_Map
	 */
	public function getMap() {
		return $this->map;
	}

	/**
	 * Returns this category.
	 *
	 * @return Tx_AdGoogleMaps_Domain_Model_Category
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * Returns this layer.
	 *
	 * @return Tx_AdGoogleMaps_Domain_Model_Layer_LayerInterface
	 */
	public function getLayer() {
		return $this->layer;
	}

	/**
	 * Sets this addCountCoordinates.
	 * If type is e.g. a shape and placing type of the info windows is set to shape this means, 
	 * that there should be an info window on every item. In this case it must be one more.
	 *
	 * @param boolean $addCountCoordinates
	 * @return void
	 */
	public function setAddCountCoordinates($addCountCoordinates) {
		$this->addCountCoordinates = $addCountCoordinates;
	}

	/**
	 * Returns the number of coordinates.
	 *
	 * @param boolean $addCount
	 * @return integer
	 */
	public function getCountCoordinates($addCount = TRUE) {
		$countCoordinates = 0;
		if ($this->useCoordinatesProvider === TRUE) {
			$countCoordinates = count($this->coordinatesProvider->getCoordinates());
			$countCoordinates += ($addCount === TRUE && $this->addCountCoordinates === TRUE) ? 1 : 0;
		}
		return $countCoordinates;
	}

	/**
	 * Returns this categoryItemKeys.
	 *
	 * @return array
	 */
	public function getCategoryItemKeys() {
		return $this->categoryItemKeys;
	}

	/**
	 * Sets this preventAddListItems
	 *
	 * @param boolean $preventAddListItems
	 * @return void
	 */
	public function setPreventAddListItems($preventAddListItems) {
		$this->preventAddListItems = (boolean) $preventAddListItems;
	}

	/**
	 * Returns this preventAddListItems
	 *
	 * @return boolean
	 */
	public function isPreventAddListItems() {
		return (boolean) $this->preventAddListItems;
	}

	/**
	 * Loads the coordinates provider.
	 *
	 * @return void
	 * @throw Tx_AdGoogleMaps_MapBuilder_Exception
	 */
	public function loadCoordinatesProvider() {
		if ($this->useCoordinatesProvider === FALSE) return;

		$coordinatesProviderClassName = $this->layer->getCoordinatesProvider();
		if (class_exists($coordinatesProviderClassName) === FALSE) {
			throw new Tx_AdGoogleMaps_MapBuilder_Exception('Given coordinates provider class "' . $coordinatesProviderClassName . '" doesn\'t exists.', 1297889105);
		}
		$this->coordinatesProvider = t3lib_div::makeInstance($coordinatesProviderClassName);
		$this->coordinatesProvider->injectLayer($this);
		$this->coordinatesProvider->load();
	}

	/**
	 * Pre processor to set options e.g. for all markers in the coordinates provider. 
	 *
	 * @return void
	 */
	public function buildItemPreProcessing() {}

	/**
	 * Builds the layer items.
	 *
	 * @return void
	 * @throw Tx_AdGoogleMaps_MapBuilder_Exception
	 */
	public function buildItems() {
		if ($this->useCoordinatesProvider === TRUE) {
			$this->loadCoordinatesProvider();
			$this->buildItemPreProcessing();
			if ($this->coordinatesProviderIterateProperty !== NULL) {
				$getterName = 'get' . ucfirst($this->coordinatesProviderIterateProperty);
				if (is_callable(array($this->coordinatesProvider, $getterName)) === FALSE) {
					throw new Tx_AdGoogleMaps_MapBuilder_Exception('Given property name to iterate coordinates provider "' . $this->coordinatesProviderIterateProperty . '" doesn\'t exists.', 1297889107);
				}
				foreach ($this->coordinatesProvider->$getterName() as $index => $value) {
					$this->buildItem($index, $value);
				}
			} else {
				$this->buildItem(NULL, NULL);
			}
		} else {
			$this->buildItemPreProcessing();
			$this->buildItem(NULL, NULL);
		}
	}

	/**
	 * Builds the layer item.
	 *
	 * @param integer $index
	 * @param mixed $value
	 * @return Tx_AdGoogleMaps_Api_Layer_LayerInterface
	 */
	abstract public function buildItem($index, $value);

	/**
	 * Returns the map control functions as an array.
	 *
	 * @param string $layerUid
	 * @param boolean $setInfoWindowFunction
	 * @return array
	 */
	protected function getItemMapControlFunctions($layerUid, $infoWindowUid = NULL) {
		$mapControlFunctions = array(
			'openInfoWindow' => ($infoWindowUid !== NULL ? $this->googleMapsPlugin->getPluginMapObjectIdentifier() . '.openInfoWindow(\'' . $infoWindowUid . '\')' : 'void(0)'),
			'panTo' => $this->googleMapsPlugin->getPluginMapObjectIdentifier() . '.panTo(\'' . $layerUid . '\')',
			'fitBounds' => $this->googleMapsPlugin->getPluginMapObjectIdentifier() . '.fitBounds(\'' . $layerUid . '\')',
		);
		if (array_key_exists('mapControlFunctions', $this->settings['layer'])) {
			$mapControlFunctions = t3lib_div::array_merge_recursive_overrule($mapControlFunctions, $this->settings['layer']['mapControlFunctions']);
			$mapControlFunctions = str_replace('###ITEM_KEY###', $layerUid, $mapControlFunctions);
		}
		return $mapControlFunctions;
	}

	/**
	 * Get overall info windows options. Override only if map behaviour contains "by layer" 
	 * and layer property is true ("0" are false also), OR map behaviour contains "only layer":
	 *
	 * @param string $propertyName
	 * @return mixed
	 */
	protected function getInfoWindowOptionValueByInfoWindowBehaviour($propertyName) {
		$layerValue = $this->layer->getPropertyValue($propertyName, 'layer');
		$mapValue = $this->map->getPropertyValue($propertyName, 'map');
		$infoWindowBehaviour = (integer) $this->map->getPropertyValue('infoWindowBehaviour', 'map');
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
	 * Returns the object number configuration.
	 *
	 * @param string $itemTitlesObjectNumber
	 * @param integer $count
	 * @return void
	 */
	protected function getObjectNumberConf($objectNumber, $count) {
		return $objectNumber === '0' || $objectNumber === '' ? NULL : $GLOBALS['TSFE']->tmpl->splitConfArray(array('objectNumber' => $objectNumber), $count);
	}

	/**
	 * Returns the layer item title.
	 *
	 * @param integer $index
	 * @param array $itemData
	 * @param boolean $defaultLast
	 * @return string
	 */
	protected function getItemTitle($index, $itemData, $defaultLast = TRUE) {
		$itemTitles = $this->mapBuilder->layer->getItemTitles();
		$itemTitles = ($itemTitles !== '') ? t3lib_div::trimExplode(LF, $itemTitles) : array();
		$itemTitlesObjectNumber = $this->mapBuilder->layer->getItemTitlesObjectNumber();
		$itemTitlesObjectNumber = $this->getObjectNumberConf($itemTitlesObjectNumber, $this->getCountCoordinates());
		return $this->getContentByObjectNumberConf($itemTitles, $itemTitlesObjectNumber, $index, $itemData, $defaultLast, $this->layer->getTitle());
	}

	/**
	 * Returns the content by object number configuration. If $dataProvider is set, the content will be redered.
	 *
	 * @param array $contentProvider
	 * @param array $objectNumberConf
	 * @param integer $index
	 * @param array $dataProvider
	 * @param boolean $defaultLast
	 * @param string $defaultValue
	 * @return mixed
	 */
	protected function getContentByObjectNumberConf($contentProvider, $objectNumberConf, $index, $dataProvider = NULL, $defaultLast = FALSE, $defaultValue = NULL, $resultAll = NULL) {
		// Get content. Can be empty. This check first if optionSplit is used.
		// Then look for current row or last row, else set the default value.
		$result = NULL;
		if ($objectNumberConf !== NULL) {
			$result = $this->getObjectNumberValue($contentProvider, $objectNumberConf, $index);
		} else if ($objectNumberConf === NULL && $resultAll === TRUE) {
			$result = $contentProvider;
		} else if (array_key_exists($index, $contentProvider)) {
			$result = $contentProvider[$index];
		} else if ($defaultLast === TRUE && count($contentProvider) > 0) {
			$result = array_pop($contentProvider);
		} else if ($defaultValue !== NULL) {
			$result = $defaultValue;
		} else if ($defaultLast === FALSE && array_key_exists(0, $contentProvider)) {
			$result = $contentProvider[0];
		}
		if ($dataProvider !== NULL && $result !== NULL) {
			if (is_array($result)) {
				$renderedResult = '';
				foreach ($result as $resultIndex => $resultValue) {
					if (array_key_exists($resultIndex, $dataProvider)) {
						$renderedResult .= Tx_AdGoogleMaps_Utility_BackEnd::renderTemplate($resultValue, $dataProvider[$resultIndex]);
					}
				}
			} else {
				$renderedResult = Tx_AdGoogleMaps_Utility_BackEnd::renderTemplate($result, $dataProvider);
			}
			return $renderedResult;
		}
		return $result;
	}

	/**
	 * Returns this items by index.
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

}

?>