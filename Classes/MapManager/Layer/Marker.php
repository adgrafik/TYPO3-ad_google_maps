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
class Tx_AdGoogleMaps_MapManager_Layer_Marker extends Tx_AdGoogleMaps_MapManager_Layer_AbstractLayer {

	/**
	 * @var array
	 */
	protected $layerOptions;

	/**
	 * @var array
	 */
	protected $markerTitles;

	/**
	 * @var array
	 */
	protected $markerTitleObjectNumberConf;

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
	 * @var Tx_AdGoogleMaps_MapManager_Layer_InfoWindow
	 */
	protected $infoWindows;

	/**
	 * @var array
	 */
	protected $listTitles;

	/**
	 * @var string
	 */
	protected $listTitle;

	/**
	 * @var array
	 */
	protected $listTitleObjectNumberConf;

	/**
	 * @var array
	 */
	protected $listIcons;

	/**
	 * @var string
	 */
	protected $listIcon;

	/**
	 * @var array
	 */
	protected $listIconObjectNumberConf;

	/**
	 * @var array
	 */
	protected $listIconOptions;

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();

		Tx_AdGoogleMaps_Utility_FrontEnd::includeFrontEndResources('Tx_AdGoogleMaps_MapManager_Layer_Marker');

		$this->useCoordinatesProvider = TRUE;
		$this->coordinatesProviderIterateProperty = 'coordinates';

		$this->preventAddInfoWindows = FALSE;
	}

	/**
	 * Sets this infoWindows.
	 *
	 * @param Tx_AdGoogleMaps_MapManager_Layer_InfoWindow $infoWindows
	 * @return void
	 */
	public function setInfoWindows(Tx_AdGoogleMaps_MapManager_Layer_InfoWindow $infoWindows) {
		$this->infoWindows = $infoWindows;
	}

	/**
	 * Returns this infoWindows.
	 *
	 * @return Tx_AdGoogleMaps_MapManager_Layer_InfoWindow
	 */
	public function getInfoWindows() {
		return $this->infoWindows;
	}

	/**
	 * Returns this listTitles.
	 *
	 * @return array
	 */
	public function getListTitles() {
		return $this->listTitles;
	}

	/**
	 * Returns this listTitleObjectNumberConf.
	 *
	 * @return array
	 */
	public function getListTitleObjectNumberConf() {
		return $this->listTitleObjectNumberConf;
	}

	/**
	 * Returns this listIcons.
	 *
	 * @return array
	 */
	public function getListIcons() {
		return $this->listIcons;
	}

	/**
	 * Returns this listIconObjectNumberConf.
	 *
	 * @return array
	 */
	public function getListIconObjectNumberConf() {
		return $this->listIconObjectNumberConf;
	}

	/**
	 * Returns this listIconOptions.
	 *
	 * @return array
	 */
	public function getListIconOptions() {
		return $this->listIconOptions;
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
	 * Pre processor to set options e.g. for all markers in the coordinates provider. 
	 *
	 * @return void
	 */
	public function buildItemPreProcessing() {
		// Get list titles.
		$listTitle = $this->layer->getListTitle();
		$this->listTitles = ($listTitle !== '') ? t3lib_div::trimExplode(LF, $listTitle) : array();
		$listTitleObjectNumber = $this->layer->getListTitleObjectNumber();
		$this->listTitleObjectNumberConf = $this->getObjectNumberConf($listTitleObjectNumber, $this->getCountCoordinates());

		// Get item titles.
		$markerTitle = $this->layer->getMarkerTitle();
		$this->markerTitles = ($markerTitle !== '') ? t3lib_div::trimExplode(LF, $markerTitle) : array();
		$markerTitleObjectNumber = $this->layer->getMarkerTitleObjectNumber();
		$this->markerTitleObjectNumberConf = $this->getObjectNumberConf($markerTitleObjectNumber, $this->getCountCoordinates());

		if (count($this->listTitles) === 0) {
			$this->listTitles = $this->markerTitles;
		}
		if ($this->listTitleObjectNumberConf === NULL) {
			$this->listTitleObjectNumberConf = $this->markerTitleObjectNumberConf;
		}

		// Get overall options.
		$this->layerOptions = array(
			'visible' => $this->layer->isVisible(),
			'clickable' => $this->layer->isClickable(),
			'draggable' => $this->layer->isDraggable(),
			'raiseOnDrag' => $this->layer->isRaiseOnDrag(),
			'shape' => t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_MarkerShape', 
				$this->layer->getShapeType(),
				json_decode($this->layer->getShapeCoords())
			),
			'zindex' => $this->layer->getZindex(),
			'flat' => $this->layer->isFlat(),
			'cursor' => $this->layer->getMouseCursor(),
		);

		// Get list icons.
		$listIcon = $this->layer->getListIcon();
		$this->listIcons = ($listIcon !== '') ? explode(',', $listIcon) : array();
		$listIconObjectNumber = $this->layer->getListIconObjectNumber();
		$this->listIconObjectNumberConf = $this->getObjectNumberConf($listIconObjectNumber, $this->getCountCoordinates());
		$this->listIconOptions = array(
			'width' => $this->layer->getListIconWidth(),
			'height' => $this->layer->getListIconHeight(),
		);

		// Set all over icon and shadow options.
		$this->markerIconOptions = array(
			'url' => NULL,
			'size' => t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_Size', $this->layer->getIconWidth(), $this->layer->getIconHeight()),
			'origin' => t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_Point', $this->layer->getIconOriginX(), $this->layer->getIconOriginY()),
			'anchor' => t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_Point', $this->layer->getIconAnchorX(), $this->layer->getIconAnchorY()),
			'scaled' => t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_Size', $this->layer->getIconScaledWidth(), $this->layer->getIconScaledHeight()),
		);
		$this->markerIcons = explode(',', $this->layer->getIcon());
		$this->markerIconObjectNumberConf = $this->getObjectNumberConf($this->layer->getIconObjectNumber(), $this->getCountCoordinates());

		if (count($this->listIcons) === 0) {
			$this->listIcons = $this->markerIcons;
			$this->listIconOptions = array(
				'width' => $this->layer->getIconWidth(),
				'height' => $this->layer->getIconHeight(),
			);
		}
		if ($this->listIconObjectNumberConf === NULL) {
			$this->listIconObjectNumberConf = $this->markerIconObjectNumberConf;
		}

		$this->markerShadowOptions = array(
			'url' => NULL,
			'size' => t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_Size', $this->layer->getShadowWidth(), $this->layer->getShadowHeight()),
			'origin' => t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_Point', $this->layer->getShadowOriginX(), $this->layer->getShadowOriginY()),
			'anchor' => t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_Point', $this->layer->getShadowAnchorX(), $this->layer->getShadowAnchorY()),
			'scaled' => t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_Size', $this->layer->getShadowScaledWidth(), $this->layer->getShadowScaledHeight()),
		);
		$this->markerShadows = explode(',', $this->layer->getShadow());
		$this->markerShadowObjectNumberConf = $this->getObjectNumberConf($this->layer->getShadowObjectNumber(), $this->getCountCoordinates());

		// Build info windows.
		if ($this->preventAddInfoWindows === FALSE) {
			$this->infoWindows = t3lib_div::makeInstance('Tx_AdGoogleMaps_MapManager_Layer_InfoWindow');
			$this->infoWindows->injectSettings($this->settings);
			$this->infoWindows->injectMapManager($this->mapManager);
			$this->infoWindows->injectGoogleMapsPlugin($this->googleMapsPlugin);
			$this->infoWindows->injectMap($this->map);
			$this->infoWindows->injectCategory($this->category);
			$this->infoWindows->injectLayer($this->layer);
			$this->infoWindows->injectCoordinatesProvider($this->coordinatesProvider);
			$this->infoWindows->setPreventAddListItems(TRUE);
			$this->infoWindows->setAddCountCoordinates($this->addCountCoordinates);
			$this->infoWindows->buildItemPreProcessing();
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
		$layerUid = sprintf('Marker_%d_%d', $this->layer->getUid(), $index);
		$infoWindowObjectNumber = $this->getInfoWindowOptionValueByInfoWindowBehaviour('infoWindowObjectNumber');
		$infoWindowObjectNumberConf = $this->getObjectNumberConf($infoWindowObjectNumber, $this->getCountCoordinates());
		$itemData = $this->getContentByObjectNumberConf($this->coordinatesProvider->getData(), $infoWindowObjectNumberConf, $index, NULL, FALSE, array());

		// Get marker title.
		$markerTitle = $this->getContentByObjectNumberConf($this->markerTitles, $this->markerTitleObjectNumberConf, $index, $itemData, TRUE);

		// Get item options.
		$layerOptions = $this->layerOptions;
		$layerOptions['title'] = $markerTitle;
		$layerOptions['position'] = t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_LatLng', $coordinates);

		if (($iconUrl = $this->getContentByObjectNumberConf($this->markerIcons, $this->markerIconObjectNumberConf, $index, NULL, TRUE))) {
			$iconOptions = $this->markerIconOptions;
			$iconOptions['url'] = Tx_AdGoogleMaps_Utility_BackEnd::getRelativeUploadPathAndFileName('ad_google_maps', 'markerIcons', $iconUrl);
			$layerOptions['icon'] = t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_MarkerImage', $iconOptions['url'], $iconOptions['size'], $iconOptions['origin'], $iconOptions['anchor'], $iconOptions['scaled']);
		}

		if (($shadowUrl = $this->getContentByObjectNumberConf($this->markerShadows, $this->markerShadowObjectNumberConf, $index, NULL, TRUE))) {
			$shadowOptions = $this->markerShadowOptions;
			$shadowOptions['url'] = Tx_AdGoogleMaps_Utility_BackEnd::getRelativeUploadPathAndFileName('ad_google_maps', 'shadowIcons', $shadowUrl);
			$layerOptions['shadow'] = t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_MarkerImage', $shadowOptions['url'], $shadowOptions['size'], $shadowOptions['origin'], $shadowOptions['anchor'], $shadowOptions['scaled']);
		}

		// Create marker.
		$layer = t3lib_div::makeInstance('Tx_AdGoogleMaps_MapBuilder_Api_Layer_Marker', $layerOptions);

		// Create option object.
		$layerOptionsObject = t3lib_div::makeInstance('Tx_AdGoogleMaps_Plugin_Options_Layer_Marker');
		$layerOptionsObject->setUid($layerUid);
		$layerOptionsObject->setDrawFunctionName('drawMarker');
		$layerOptionsObject->setOptions($layer);

		// Add layer options object to layer options.
		$pluginOptions = $this->googleMapsPlugin->getPluginOptions();
		$pluginOptions->addLayerOptions($layerOptionsObject);

		// Set info window after marker to draw the marker before the info window in the JavaScript.
		$infoWindowOptionsObject = NULL;
		if ($this->preventAddInfoWindows === FALSE) {
			$infoWindowOptionsObject = $this->infoWindows->buildItem($index, NULL); // Set no coordinates for marker info windows, cause info window sets position automatically on click.
			if ($infoWindowOptionsObject !== NULL) {
				$infoWindowOptionsObject->setLinkToLayerUid($layerUid);
				$this->addCategoryItemKey($this->infoWindows->getCategoryItemKeys());
			}
		}

		// Get list title.
		$listTitle = $this->getContentByObjectNumberConf($this->listTitles, $this->listTitleObjectNumberConf, $index, $itemData, TRUE);
		// Make list icons.
		if (($listIconUrl = $this->getContentByObjectNumberConf($this->listIcons, $this->listIconObjectNumberConf, $index, NULL, TRUE))) {
			$listIconOptions = $this->listIconOptions;
			$listIconOptions['url'] = Tx_AdGoogleMaps_Utility_BackEnd::getRelativeUploadPathAndFileName('ad_google_maps', 'markerIcons', $listIconUrl);
		}

		// Create list item.
		if ($this->preventAddListItems === FALSE) {
			$item = t3lib_div::makeInstance('Tx_AdGoogleMaps_Domain_Model_Item');
			$item->setTitle($listTitle);
			$item->setIcon($listIconOptions['url']);
			$item->setIconWidth($listIconOptions['width']);
			$item->setIconHeight($listIconOptions['height']);
			$item->setPosition($layerOptions['position']);
			$item->setMapControlFunctions($this->getItemMapControlFunctions($layerUid, ($infoWindowOptionsObject !== NULL ? $infoWindowOptionsObject->getUid() : NULL)));
			$item->setLayerOptions($layerOptions);
			$item->setInfoWindow($infoWindowOptionsObject);
			$item->setDataProvider($itemData);
			$this->layer->addItem($item);
		}

		$this->addCategoryItemKey($layerUid);

		return $layerOptionsObject;
	}

}

?>