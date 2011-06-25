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
class Tx_AdGoogleMaps_MapManager_Layer_InfoWindow extends Tx_AdGoogleMaps_MapManager_Layer_AbstractLayer {

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

		Tx_AdGoogleMaps_Utility_FrontEnd::includeFrontEndResources('Tx_AdGoogleMaps_MapManager_Layer_InfoWindow');

		$this->contentObject = t3lib_div::makeInstance('tslib_cObj');
		$this->useCoordinatesProvider = TRUE;
		$this->coordinatesProviderIterateProperty = 'coordinates';

		$this->infoWindowData = array();
		$this->layerOptions = array();
	}

	/**
	 * Pre processor to set options e.g. for all markers in the coordinates provider. 
	 *
	 * @return void
	 */
	public function buildItemPreProcessing() {
		// Set info window properties.
		$this->infoWindowKeepOpen = $this->getInfoWindowOptionValueByInfoWindowBehaviour('infoWindowKeepOpen');
		$this->infoWindowCloseOnClick = $this->getInfoWindowOptionValueByInfoWindowBehaviour('infoWindowCloseOnClick');
		$this->infoWindowObjectNumber = $this->getInfoWindowOptionValueByInfoWindowBehaviour('infoWindowObjectNumber');
		$this->infoWindowObjectNumberConf = $this->getObjectNumberConf($this->infoWindowObjectNumber, $this->getCountCoordinates());
		$this->infoWindowRenderConfiguration = $this->settings['models']['layer']['infoWindowRenderConfiguration'];
		$this->infoWindowRenderConfigurationTypoScriptNodeValue = $this->infoWindowRenderConfiguration['_typoScriptNodeValue'];
		$this->infoWindowRenderConfiguration = Tx_Extbase_Utility_TypoScript::convertPlainArrayToTypoScriptArray($this->infoWindowRenderConfiguration);

		// Set info window options.
		$this->layerOptions = array(
			'disableAutoPan' => $this->getInfoWindowOptionValueByInfoWindowBehaviour('infoWindowDisableAutoPan'),
			'disableAutoPan' => $this->getInfoWindowOptionValueByInfoWindowBehaviour('infoWindowMaxWidth'),
			'pixelOffsetWidth' => t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_Size', 
				$this->getInfoWindowOptionValueByInfoWindowBehaviour('infoWindowPixelOffsetWidth'), 
				$this->getInfoWindowOptionValueByInfoWindowBehaviour('infoWindowPixelOffsetHeight')
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
	 * @return Tx_AdGoogleMaps_Plugin_Options_Layer_LayerInterface
	 */
	public function buildItem($index, $coordinates) {
		$layerUid = sprintf('InfoWindow_%d_%d', $this->layer->getUid(), $index);
		$itemData = $this->getContentByObjectNumberConf($this->coordinatesProvider->getData(), $this->infoWindowObjectNumberConf, $index, NULL, TRUE);
		$infoWindowContent = $this->getContentByObjectNumberConf($this->infoWindowData, $this->infoWindowObjectNumberConf, $index, $itemData, TRUE);

		// If there is no info window content, nothing else to do.
		if ($infoWindowContent === NULL)
			return NULL;

		$layerOptions = $this->layerOptions;
		$layerOptions['disableAutoPan'] = $this->infoWindowDisableAutoPan;
		$layerOptions['content'] = $infoWindowContent;
		if ($coordinates !== NULL) {
			$layerOptions['position'] = t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_LatLng', $coordinates);
		}

		// Create marker.
		$layer = t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_Layer_InfoWindow', $layerOptions);

		// Create option object.
		$layerOptionsObject = t3lib_div::makeInstance('Tx_AdGoogleMaps_Plugin_Options_Layer_InfoWindow');
		$layerOptionsObject->setUid($layerUid);
		$layerOptionsObject->setDrawFunctionName('drawInfoWindow');
		$layerOptionsObject->setOptions($layer);
		$layerOptionsObject->setInfoWindowKeepOpen($this->infoWindowKeepOpen);
		$layerOptionsObject->setInfoWindowCloseOnClick($this->infoWindowCloseOnClick);

		// Add layer options object to layer options.
		$pluginOptions = $this->googleMapsPlugin->getPluginOptions();
		$pluginOptions->addLayerOptions($layerOptionsObject);

		$this->addCategoryItemKey($layerUid);

		// If is set, nothing else to do.
		if ($this->preventAddListItems === TRUE)
			return $layerOptionsObject;

		// Get item titles.
		// TODO: Make own layer type with info windows.
#		$itemTitle = $this->getItemTitle($index, $itemData);

		return $layerOptionsObject;
	}

}

?>