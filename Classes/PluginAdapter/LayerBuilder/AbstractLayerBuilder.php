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
abstract class Tx_AdGoogleMaps_PluginAdapter_LayerBuilder_AbstractLayerBuilder implements Tx_AdGoogleMaps_PluginAdapter_LayerBuilder_LayerBuilderInterface {

	/**
	 * @var tslib_cObj
	 */
	protected $contentObject;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @var Tx_AdGoogleMaps_PluginAdapter_MapBuilder
	 */
	protected $mapBuilder;

	/**
	 * @var Tx_AdGoogleMapsApi_Plugin_GoogleMaps
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
	protected $useDataProvider;

	/**
	 * @var string
	 */
	protected $dataProviderIterateProperty;

	/**
	 * @var Tx_AdGoogleMaps_PluginAdapter_DataProvider_DataProviderInterface
	 */
	protected $dataProvider;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->useDataProvider = FALSE;
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
	 * @param Tx_AdGoogleMaps_PluginAdapter_MapBuilder $mapBuilder
	 * @return void
	 */
	public function injectMapBuilder(Tx_AdGoogleMaps_PluginAdapter_MapBuilder $mapBuilder) {
		$this->mapBuilder = $mapBuilder;
	}

	/**
	 * Injects this googleMapsPlugin
	 *
	 * @param Tx_AdGoogleMapsApi_Plugin_GoogleMaps $googleMapsPlugin
	 * @return void
	 */
	public function injectGoogleMapsPlugin(Tx_AdGoogleMapsApi_Plugin_GoogleMaps $googleMapsPlugin) {
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
	 * @param Tx_AdGoogleMaps_PluginAdapter_DataProvider_DataProviderInterface $dataProvider
	 * @return void
	 */
	public function injectDataProvider(Tx_AdGoogleMaps_PluginAdapter_DataProvider_DataProviderInterface $dataProvider) {
		$this->dataProvider = $dataProvider;
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
	 * @return Tx_AdGoogleMaps_PluginAdapter_MapBuilder
	 */
	public function getMapBuilder() {
		return $this->mapBuilder;
	}

	/**
	 * Returns this googleMapsPlugin
	 *
	 * @return Tx_AdGoogleMaps_PluginAdapter_Plugin_GoogleMaps
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
		return count($this->dataProvider->getCoordinates()) + (($addCount === TRUE && $this->addCountCoordinates === TRUE) ? 1 : 0);
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
	 * Loads the data provider.
	 *
	 * @return void
	 * @throw Tx_AdGoogleMaps_Exception
	 */
	public function loadDataProvider() {
		if ($this->useDataProvider === FALSE) return;

		$dataProviderClassName = $this->mapBuilder->getPropertyValue('dataProvider', $this->layer, $this->settings['layer']);
		if (class_exists($dataProviderClassName) === FALSE) {
			throw new Tx_AdGoogleMaps_Exception('Given coordinates provider class "' . $dataProviderClassName . '" doesn\'t exists.', 1297889105);
		}
		$this->dataProvider = t3lib_div::makeInstance($dataProviderClassName);
		$this->dataProvider->injectLayerBuilder($this);
		$this->dataProvider->load();
	}

	/**
	 * Pre processor to set options e.g. for all markers in the data provider. 
	 *
	 * @return void
	 */
	public function buildItemPreProcessing() {}

	/**
	 * Builds the layer items.
	 *
	 * @return void
	 * @throw Tx_AdGoogleMaps_Exception
	 */
	public function buildItems() {
		if ($this->useDataProvider === TRUE) {
			$this->loadDataProvider();
			$this->buildItemPreProcessing();
			if ($this->dataProviderIterateProperty !== NULL) {
				$getterName = 'get' . ucfirst($this->dataProviderIterateProperty);
				if (is_callable(array($this->dataProvider, $getterName)) === FALSE) {
					throw new Tx_AdGoogleMaps_Exception('Given property name to iterate data provider "' . $this->dataProviderIterateProperty . '" doesn\'t exists.', 1297889107);
				}
				foreach ($this->dataProvider->$getterName() as $index => $value) {
					$this->buildItem($index, $value);
				}
			} else {
				$this->buildItem(NULL, NULL);
			}
		} else {
			$this->buildItemPreProcessing();
			$this->buildItem(NULL, NULL);
		}
		// Do category stuff.
		$this->category->setMapControllFunctions($this->getCategoryMapControllFunctions($this->categoryItemKeys));
	}

	/**
	 * Builds the layer item.
	 *
	 * @param integer $index
	 * @param mixed $value
	 * @return Tx_AdGoogleMapsApi_Layer_LayerInterface
	 */
	public function buildItem($index, $value) {}

	/**
	 * Returns the layer item title.
	 *
	 * @param integer $index
	 * @param array $itemData
	 * @param boolean $defaultLast
	 * @return string
	 */
	protected function getItemTitle($index, $itemData, $defaultLast = TRUE) {
		$itemTitles = $this->mapBuilder->getPropertyValue('itemTitles', $this->layer, $this->settings['layer']);
		$itemTitles = ($itemTitles !== '') ? t3lib_div::trimExplode(LF, $itemTitles) : array();
		$itemTitlesObjectNumber = $this->mapBuilder->getPropertyValue('itemTitlesObjectNumber', $this->layer, $this->settings['layer']);
		$itemTitlesObjectNumberConf = $this->getObjectNumberConf($itemTitlesObjectNumber, $this->getCountCoordinates());
		return $this->getContentByObjectNumberConf($itemTitles, $itemTitlesObjectNumberConf, $index, $itemData, $defaultLast, $this->layer->getTitle());
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
			'openInfoWindow' => ($setInfoWindowFunction === TRUE ? $this->googleMapsPlugin->getPluginMapObjectIdentifier() . '.openInfoWindow(\'' . $itemKey . '\')' : 'void(0)'),
			'panTo' => $this->googleMapsPlugin->getPluginMapObjectIdentifier() . '.panTo(\'' . $itemKey . '\')',
			'fitBounds' => $this->googleMapsPlugin->getPluginMapObjectIdentifier() . '.fitBounds(\'' . $itemKey . '\')',
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
	 * @return array
	 */
	protected function getCategoryMapControllFunctions() {
		$javaScriptArray = (count($this->categoryItemKeys) > 0 ? '[\'' . implode('\', \'', $this->categoryItemKeys) . '\']' : 'null');
		$mapControllFunctions = array(
			'panTo' => $this->googleMapsPlugin->getPluginMapObjectIdentifier() . '.panTo(' . $javaScriptArray . ')',
			'fitBounds' => $this->googleMapsPlugin->getPluginMapObjectIdentifier() . '.fitBounds(' . $javaScriptArray . ')',
		);
		if (array_key_exists('mapControllFunctions', $this->settings['category'])) {
			$mapControllFunctions = t3lib_div::array_merge_recursive_overrule($mapControllFunctions, $this->settings['category']['mapControllFunctions']);
			$mapControllFunctions = str_replace('###ITEM_KEYS###', $javaScriptArray, $mapControllFunctions);
		}
		return $mapControllFunctions;
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
		$infoWindowBehaviour = (integer) $this->mapBuilder->getPropertyValue('infoWindowBehaviour', $this->map, $this->settings['map']);
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
		return $objectNumber === '0' ? NULL : $GLOBALS['TSFE']->tmpl->splitConfArray(array('objectNumber' => $objectNumber), $count);
	}

	/**
	 * Returns the content by object number configuration. If $dataProvider is set, the content will be redered.
	 *
	 * @param Pluginparam array $itemTitlesObjectNumberConf
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
				foreach ($result as $resultIndex => $resultValue) {
					if (array_key_exists($resultIndex, $dataProvider)) {
						$result .= $this->renderTemplate($resultValue, $dataProvider[$resultIndex]);
					}
				}
			} else {
				$result = $this->renderTemplate($result, $dataProvider);
			}
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

}

?>