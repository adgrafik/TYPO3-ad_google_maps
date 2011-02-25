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
class Tx_AdGoogleMaps_PluginAdapter_LayerBuilder_Marker extends Tx_AdGoogleMaps_PluginAdapter_LayerBuilder_AbstractLayerBuilder {

	/**
	 * @var array
	 */
	protected $layerOptions;

	/**
	 * @var array
	 */
	protected $markerIcons;

	/**
	 * @var array
	 */
	protected $markerIconOptions;

	/**
	 * @var array
	 */
	protected $markerIconObjectNumberConf;

	/**
	 * @var array
	 */
	protected $markerShadows;

	/**
	 * @var array
	 */
	protected $markerShadowOptions;

	/**
	 * @var array
	 */
	protected $markerIconShadowNumberConf;

	/**
	 * @var boolean
	 */
	protected $preventAddInfoWindows;

	/**
	 * @var Tx_AdGoogleMaps_PluginAdapter_LayerBuilder_InfoWindow
	 */
	protected $infoWindows;

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->useDataProvider = TRUE;
		$this->dataProviderIterateProperty = 'coordinates';

		$this->preventAddInfoWindows = FALSE;
	}

	/**
	 * Sets this infoWindows.
	 *
	 * @param Tx_AdGoogleMaps_PluginAdapter_LayerBuilder_InfoWindow $infoWindows
	 * @return void
	 */
	public function setInfoWindows(Tx_AdGoogleMaps_PluginAdapter_LayerBuilder_InfoWindow $infoWindows) {
		$this->infoWindows = $infoWindows;
	}

	/**
	 * Returns this infoWindows.
	 *
	 * @return Tx_AdGoogleMaps_PluginAdapter_LayerBuilder_InfoWindow
	 */
	public function getInfoWindows() {
		return $this->infoWindows;
	}

	/**
	 * Sets this preventAddInfoWindows
	 *
	 * @param boolean $preventAddInfoWindows
	 * @return void
	 */
	public function setPreventAddInfoWindows($preventAddInfoWindows) {
		$this->preventAddInfoWindows = (boolean) $preventAddInfoWindows;
	}

	/**
	 * Returns this preventAddInfoWindows
	 *
	 * @return boolean
	 */
	public function isPreventAddInfoWindows() {
		return (boolean) $this->preventAddInfoWindows;
	}

	/**
	 * Pre processor to set options e.g. for all markers in the data provider. 
	 *
	 * @return void
	 */
	public function buildItemPreProcessing() {
		// Build info windows.
		if ($this->preventAddInfoWindows === FALSE) {
			$this->infoWindows = t3lib_div::makeInstance('Tx_AdGoogleMaps_PluginAdapter_LayerBuilder_InfoWindow');
			$this->infoWindows->injectSettings($this->settings);
			$this->infoWindows->injectMapBuilder($this->mapBuilder);
			$this->infoWindows->injectGoogleMapsPlugin($this->googleMapsPlugin);
			$this->infoWindows->injectMap($this->map);
			$this->infoWindows->injectCategory($this->category);
			$this->infoWindows->injectLayer($this->layer);
			$this->infoWindows->injectDataProvider($this->dataProvider);
			$this->infoWindows->setPreventAddListItems(TRUE);
			$this->infoWindows->setAddCountCoordinates($this->addCountCoordinates);
			$this->infoWindows->buildItemPreProcessing();
		}

		// Get overall options.
		$this->layerOptions = array(
			'visible' => $this->mapBuilder->getPropertyValue('visible', $this->layer, $this->settings['layer']),
			'clickable' => $this->mapBuilder->getPropertyValue('markerClickable', $this->layer, $this->settings['layer']),
			'draggable' => $this->mapBuilder->getPropertyValue('draggable', $this->layer, $this->settings['layer']),
			'raiseOnDrag' => $this->mapBuilder->getPropertyValue('raiseOnDrag', $this->layer, $this->settings['layer']),
			'shapeType' => $this->mapBuilder->getPropertyValue('shapeType', $this->layer, $this->settings['layer']),
			'shape' => $this->mapBuilder->getPropertyValue('shape', $this->layer, $this->settings['layer']),
			'zindex' => $this->layer->getMarkerZindex(),
			'flat' => $this->mapBuilder->getPropertyValue('flat', $this->layer, $this->settings['layer']),
			'cursor' => $this->mapBuilder->getPropertyValue('mouseCursor', $this->layer, $this->settings['layer']),
		);

		// Set all over icon and shadow options.
		$this->markerIconOptions = array(
			'url' => NULL,
			'width' => $this->mapBuilder->getPropertyValue('iconWidth', $this->layer, $this->settings['layer']),				'height' => $this->mapBuilder->getPropertyValue('iconHeight', $this->layer, $this->settings['layer']),
			'originX' => $this->mapBuilder->getPropertyValue('iconOriginX', $this->layer, $this->settings['layer']),			'originY' => $this->mapBuilder->getPropertyValue('iconOriginY', $this->layer, $this->settings['layer']),
			'anchorX' => $this->mapBuilder->getPropertyValue('iconAnchorX', $this->layer, $this->settings['layer']),			'anchorY' => $this->mapBuilder->getPropertyValue('iconAnchorY', $this->layer, $this->settings['layer']),
			'scaledWidth' => $this->mapBuilder->getPropertyValue('iconScaledWidth', $this->layer, $this->settings['layer']),	'scaledWidth' => $this->mapBuilder->getPropertyValue('iconScaledHeight', $this->layer, $this->settings['layer']),
		);
		$this->markerIcons = explode(',', $this->mapBuilder->getPropertyValue('icon', $this->layer, $this->settings['layer']));
		$this->markerIconObjectNumberConf = $this->getObjectNumberConf($this->mapBuilder->getPropertyValue('iconObjectNumber', $this->layer, $this->settings['layer']), $this->getCountCoordinates());

		$this->markerShadowOptions = array(
			'url' => NULL,
			'width' => $this->mapBuilder->getPropertyValue('shadowWidth', $this->layer, $this->settings['layer']),				'height' => $this->mapBuilder->getPropertyValue('shadowHeight', $this->layer, $this->settings['layer']),
			'originX' => $this->mapBuilder->getPropertyValue('shadowOriginX', $this->layer, $this->settings['layer']),			'originY' => $this->mapBuilder->getPropertyValue('shadowOriginY', $this->layer, $this->settings['layer']),
			'anchorX' => $this->mapBuilder->getPropertyValue('shadowAnchorX', $this->layer, $this->settings['layer']),			'anchorY' => $this->mapBuilder->getPropertyValue('shadowAnchorY', $this->layer, $this->settings['layer']),
			'scaledWidth' => $this->mapBuilder->getPropertyValue('shadowScaledWidth', $this->layer, $this->settings['layer']),	'scaledWidth' => $this->mapBuilder->getPropertyValue('shadowScaledHeight', $this->layer, $this->settings['layer']),
		);
		$this->markerShadows = explode(',', $this->mapBuilder->getPropertyValue('shadow', $this->layer, $this->settings['layer']));
		$this->markerShadowObjectNumberConf = $this->getObjectNumberConf($this->mapBuilder->getPropertyValue('shadowObjectNumber', $this->layer, $this->settings['layer']), $this->getCountCoordinates());
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
		$infoWindowObjectNumber = $this->getInfoWindowOptionValueByInfoWindowBehaviour(
			$this->mapBuilder->getPropertyValue('infoWindowObjectNumber', $this->layer, $this->settings['layer']), 
			$this->mapBuilder->getPropertyValue('infoWindowObjectNumber', $this->map, $this->settings['map'])
		);
		$infoWindowObjectNumberConf = $this->getObjectNumberConf($infoWindowObjectNumber, $this->getCountCoordinates());
		$itemData = $this->getContentByObjectNumberConf($this->dataProvider->getData(), $infoWindowObjectNumberConf, $index, NULL, FALSE, array());

		// Get item options.
		$layerOptions = $this->layerOptions;
		$layerOptions['key'] = $itemKey;
		$layerOptions['title'] = $this->getItemTitle($index, $itemData);
		$layerOptions['position'] = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_LatLng', $coordinates);

		if (($iconUrl = $this->getContentByObjectNumberConf($this->markerIcons, $this->markerIconObjectNumberConf, $index, NULL, TRUE))) {
			$iconOptions = $this->markerIconOptions;
			$iconOptions['url'] = Tx_AdGoogleMaps_Tools_BackEnd::getRelativeUploadPathAndFileName('ad_google_maps', 'markerIcons', $iconUrl);
			$layerOptions['icon'] = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_MarkerImage', $iconOptions);
		}

		if (($shadowUrl = $this->getContentByObjectNumberConf($this->markerShadows, $this->markerShadowObjectNumberConf, $index, NULL, TRUE))) {
			$shadowOptions = $this->markerShadowOptions;
			$shadowOptions['url'] = Tx_AdGoogleMaps_Tools_BackEnd::getRelativeUploadPathAndFileName('ad_google_maps', 'shadowIcons', $shadowUrl);
			$layerOptions['shadow'] = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_MarkerImage', $shadowOptions);
		}

		// Create marker.
		$layer = t3lib_div::makeInstance('Tx_AdGoogleMapsApi_Plugin_Layer_Marker', $layerOptions);
		$this->googleMapsPlugin->addLayer($layer);

		// Create list item.
		$infoWindow = NULL;
		if ($this->preventAddInfoWindows === FALSE) {
			$infoWindow = $this->infoWindows->buildItem($index, NULL); // Set no coordinates for marker info windows, cause info window sets position automatically on click.
		}

		$mapControllFunctions = $this->getItemMapControllFunctions($itemKey, (boolean) $infoWindow);
		$item = t3lib_div::makeInstance('Tx_AdGoogleMaps_Domain_Model_Item');
		$item->setTitle($layerOptions['title']);
		$item->setIcon($iconOptions['url']);
		$item->setIconWidth($iconOptions['width']);
		$item->setIconHeight($iconOptions['height']);
		$item->setPosition($layerOptions['position']);
		$item->setMapControllFunctions($mapControllFunctions);
		$item->setLayerOptions($layerOptions);
		$item->setInfoWindow($infoWindow);
		$item->setDataProvider($itemData);
		$this->layer->addItem($item);

		$this->categoryItemKeys[] = $itemKey;

		return $layer;
	}

}

?>