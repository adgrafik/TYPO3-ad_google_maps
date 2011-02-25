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
 * Layer builder class.
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_AdGoogleMaps_PluginAdapter_LayerBuilder_InfoWindow extends Tx_AdGoogleMaps_PluginAdapter_LayerBuilder_AbstractLayerBuilder {

	/**
	 * @var tslib_cObj
	 */
	protected $contentObject;

	/**
	 * @var array
	 */
	protected $infoWindowData;

	/**
	 * @var boolean
	 */
	protected $infoWindowKeepOpen;

	/**
	 * @var boolean
	 */
	protected $infoWindowCloseOnClick;

	/**
	 * @var string
	 */
	protected $infoWindowObjectNumber;

	/**
	 * @var array
	 */
	protected $infoWindowObjectNumberConf;

	/**
	 * @var array
	 */
	protected $infoWindowRenderConfiguration;

	/**
	 * @var string
	 */
	protected $infoWindowRenderConfigurationTypoScriptNodeValue;

	/**
	 * @var array
	 */
	protected $layerOptions;

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->contentObject = t3lib_div::makeInstance('tslib_cObj');
		$this->useDataProvider = TRUE;
		$this->dataProviderIterateProperty = 'coordinates';

		$this->infoWindowData = array();
		$this->layerOptions = array();
	}

	/**
	 * Pre processor to set options e.g. for all markers in the data provider. 
	 *
	 * @return void
	 */
	public function buildItemPreProcessing() {
		// Set info window properties.
		$this->infoWindowKeepOpen = $this->getInfoWindowOptionValueByInfoWindowBehaviour(
			$this->mapBuilder->getPropertyValue('infoWindowKeepOpen', $this->layer, $this->settings['layer']), 
			$this->mapBuilder->getPropertyValue('infoWindowKeepOpen', $this->map, $this->settings['map'])
		);
		$this->infoWindowCloseOnClick = $this->getInfoWindowOptionValueByInfoWindowBehaviour(
			$this->mapBuilder->getPropertyValue('infoWindowCloseOnClick', $this->layer, $this->settings['layer']), 
			$this->mapBuilder->getPropertyValue('infoWindowCloseOnClick', $this->map, $this->settings['map'])
		);
		$this->infoWindowObjectNumber = $this->getInfoWindowOptionValueByInfoWindowBehaviour(
			$this->mapBuilder->getPropertyValue('infoWindowObjectNumber', $this->layer, $this->settings['layer']), 
			$this->mapBuilder->getPropertyValue('infoWindowObjectNumber', $this->map, $this->settings['map'])
		);
		$this->infoWindowObjectNumberConf = $this->getObjectNumberConf($this->infoWindowObjectNumber, $this->getCountCoordinates());
		$this->infoWindowRenderConfiguration = $this->settings['layer']['infoWindowRenderConfiguration'];
		$this->infoWindowRenderConfigurationTypoScriptNodeValue = $this->infoWindowRenderConfiguration['_typoScriptNodeValue'];
		$this->infoWindowRenderConfiguration = Tx_Extbase_Utility_TypoScript::convertPlainArrayToTypoScriptArray($this->infoWindowRenderConfiguration);

		// Set info window options.
		$this->layerOptions = array(
			'disableAutoPan' => $this->getInfoWindowOptionValueByInfoWindowBehaviour(
				$this->mapBuilder->getPropertyValue('infoWindowDisableAutoPan', $this->layer, $this->settings['layer']), 
				$this->mapBuilder->getPropertyValue('infoWindowDisableAutoPan', $this->map, $this->settings['map'])
			),
			'disableAutoPan' => $this->getInfoWindowOptionValueByInfoWindowBehaviour(
				$this->mapBuilder->getPropertyValue('infoWindowMaxWidth', $this->layer, $this->settings['layer']), 
				$this->mapBuilder->getPropertyValue('infoWindowMaxWidth', $this->map, $this->settings['map'])
			),
			'pixelOffsetWidth' => $this->getInfoWindowOptionValueByInfoWindowBehaviour(
				$this->mapBuilder->getPropertyValue('infoWindowPixelOffsetWidth', $this->layer, $this->settings['layer']), 
				$this->mapBuilder->getPropertyValue('infoWindowPixelOffsetWidth', $this->map, $this->settings['map'])
			),
			'pixelOffsetHeight' => $this->getInfoWindowOptionValueByInfoWindowBehaviour(
				$this->mapBuilder->getPropertyValue('infoWindowPixelOffsetHeight', $this->layer, $this->settings['layer']), 
				$this->mapBuilder->getPropertyValue('infoWindowPixelOffsetHeight', $this->map, $this->settings['map'])
			),
			'zindex' => $this->layer->getInfoWindowZindex(),
		);

		// Get info window data.
		$loadDB = t3lib_div::makeInstance('FE_loadDBGroup');
		$loadDB->start($this->layer->getInfoWindow(), 'tt_content', 'tx_adgooglemaps_layer_ttcontent_mm');
		$loadDB->readMM('tx_adgooglemaps_layer_ttcontent_mm', $this->layer->getUid());
		$loadDB->getFromDB();

		foreach ($loadDB->itemArray as $row) {
			$contentData = $loadDB->results['tt_content'][$row['id']];
			$this->contentObject->start($contentData, 'tt_content');
			$this->infoWindowData[] = $this->contentObject->cObjGetSingle($this->infoWindowRenderConfigurationTypoScriptNodeValue, $this->infoWindowRenderConfiguration);
		}
	}

	/**
	 * Builds the layer items.
	 *
	 * @param integer $index
	 * @param string $coordinates
	 * @return Tx_AdGoogleMapsApi_Layer_LayerInterface
	 */
	public function buildItem($index, $coordinates) {
		$itemKey = $this->layer->getUid() . '_' . intval($index);
		$itemData = $this->getContentByObjectNumberConf($this->dataProvider->getData(), $this->infoWindowObjectNumberConf, $index, NULL, TRUE, NULL, TRUE);
		$infoWindowContent = $this->getContentByObjectNumberConf($this->infoWindowData, $this->infoWindowObjectNumberConf, $index, $itemData, TRUE, NULL);

		// If there is no info window content, nothing else to do.
		if ($infoWindowContent === NULL)
			return NULL;

		$layerOptions = $this->layerOptions;
		$layerOptions['key'] = $itemKey;
		$layerOptions['disableAutoPan'] = $this->infoWindowDisableAutoPan;
		$layerOptions['content'] = $infoWindowContent;
		if ($coordinates !== NULL) {
			$layerOptions['position'] = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_LatLng', $coordinates);
		}

		$layer = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_Plugin_Layer_InfoWindow', $layerOptions);
		$this->googleMapsPlugin->addInfoWindow($layer);

		if ($this->infoWindowKeepOpen) {
			$this->googleMapsPlugin->addInfoWindowKeepOpen($itemKey);
		}
		if ($this->infoWindowCloseOnClick) {
			$this->googleMapsPlugin->addInfoWindowCloseOnClick($itemKey);
		}

		// If is set, nothing else to do.
		if ($this->preventAddListItems === TRUE)
			return $layer;

		// Get item titles.
		$itemTitle = $this->getItemTitle($index, $itemData);

		$mapControllFunctions = $this->getItemMapControllFunctions($itemKey, TRUE);

		$this->categoryItemKeys[] = $itemKey;

		return $layer;
	}

}

?>