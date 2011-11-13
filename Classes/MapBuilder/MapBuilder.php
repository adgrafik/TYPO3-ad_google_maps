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
 * GoogleMaps class.
 *
 * @scope prototype
 */
class Tx_AdGoogleMaps_MapBuilder_MapBuilder {

	/**
	 * Default settings
	 */
	const DEFAULT_GEOCODE_URL = 'http://maps.google.com/maps/api/geocode/json';
	const DEFAULT_HEIGHT = 400;

	/**
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @var Tx_AdGoogleMaps_Utility_FrontEnd
	 */
	protected $frontEndUtility;

	/**
	 * @var Tx_AdGoogleMaps_JsonClassEncoder_JsonEncoderInterface
	 */
	protected $jsonEncoder;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @var string
	 */
	protected $identifier;

	/**
	 * @var array
	 */
	protected $data;

	/**
	 * @var string
	 */
	protected $tableName;

	/**
	 * @var array
	 */
	protected $includeFrontEndResources;

	/**
	 * @var integer
	 */
	protected $width;

	/**
	 * @var integer
	 */
	protected $height;

	/**
	 * @var string
	 */
	protected $geocodeUrl;

	/**
	 * @var Tx_AdGoogleMaps_MapBuilder_Options
	 */
	protected $options;

	/*
	 * Constructor.
	 * 
	 * @param string $identifier
	 * @param array $data
	 * @param string $tableName
	 */
	public function __construct($identifier, array $data = array(), $tableName = NULL) {
		$this->identifier = $identifier;
		$this->data = $data;
		$this->tableName = $tableName;
	}

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
	 * Injects this frontEndUtility.
	 *
	 * @param Tx_AdGoogleMaps_Utility_FrontEnd $frontEndUtility
	 * @return void
	 */
	public function injectFrontEndUtility(Tx_AdGoogleMaps_Utility_FrontEnd $frontEndUtility) {
		$this->frontEndUtility = $frontEndUtility;
	}

	/**
	 * Injects this jsonEncoder.
	 *
	 * @param Tx_AdGoogleMaps_JsonClassEncoder_JsonEncoderInterface $jsonEncoder
	 * @return void
	 */
	public function injectJsonEncoder(Tx_AdGoogleMaps_JsonClassEncoder_JsonEncoderInterface $jsonEncoder) {
		$this->jsonEncoder = $jsonEncoder;
	}

	/**
	 * Injects this settings.
	 *
	 * @param array Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager
	 * @return void
	 */
	public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager) {
		$settings = $configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManager::CONFIGURATION_TYPE_SETTINGS);
		$this->settings = $settings['mapBuilder'];
	}

	/*
	 * Initialize this map.
	 * This function initialize the MapBuilder and set all properties set in the "mapBuilder"-setting.
	 */
	public function initializeObject() {
		// Set default values.
		$this->jsonEncoder->setDebug($this->settings['jsonEncoder']);
		$this->geocodeUrl = $this->settings['geocodeUrl'];
		$this->includeFrontEndResources = $this->settings['includeFrontEndResources'];

		$this->frontEndUtility->includeFrontEndResources(get_class($this));

		$this->options = $this->objectManager->create('Tx_AdGoogleMaps_MapBuilder_Options', $this);
		$this->options->setCanvasId($this->settings['options']['canvasId']);

		// Merge mapOptions settings.
#		$this->frontEndUtility->objectTypoScriptInjection($this->options->getMapOptions(), $this->settings['options']['mapOptions'], $this->data, $this->tableName);
		// Merge mapControl settings.
#		$this->frontEndUtility->objectTypoScriptInjection($this->options->getMapControl(), $this->settings['options']['mapControl'], $this->data, $this->tableName);




		$this->frontEndUtility->objectTypoScriptInjection($this->options, 'plugin.tx_adgooglemaps.mapBuilder.options', $this->settings['options'], $this->data, $this->tableName);
/*
		// Build layers.
		if (array_key_exists('layers', $this->settings['options']) === TRUE) {
			$layerConfigurations = $this->settings['options']['layers'];
			// Unset default configuration if set.
			if (array_key_exists('defaults', $layerConfigurations) === TRUE) {
				unset($layerConfigurations['defaults']);
			}
			foreach ($layerConfigurations as $layerClassName => $layerConfiguration) {
				$this->createLayer($layerClassName, $layerConfiguration);
			}
		}
*/
	}

	/**
	 * Returns this jsonEncoder.
	 *
	 * @return Tx_AdGoogleMaps_JsonClassEncoder_JsonEncoderInterface
	 */
	public function getJsonEncoder() {
		return $this->jsonEncoder;
	}

	/**
	 * Sets this settings.
	 *
	 * @param array $settings
	 * @return Tx_AdGoogleMaps_MapBuilder_MapBuilder
	 */
	public function setSettings(array $settings) {
		$this->settings = $settings;
		return $this;
	}

	/**
	 * Sets this identifier.
	 *
	 * @param string $identifier
	 * @return Tx_AdGoogleMaps_MapBuilder_MapBuilder
	 */
	public function setIdentifier($identifier) {
		$this->identifier = $identifier;
		return $this;
	}

	/**
	 * Returns this identifier.
	 *
	 * @return string
	 */
	public function getIdentifier() {
		return $this->identifier;
	}

	/**
	 * Sets this includeFrontEndResources.
	 *
	 * @param array $includeFrontEndResources
	 * @return Tx_AdGoogleMaps_MapBuilder_MapBuilder
	 */
	public function setIncludeFrontEndResources($includeFrontEndResources) {
		$this->includeFrontEndResources = $includeFrontEndResources;
		return $this;
	}

	/**
	 * Returns this includeFrontEndResources.
	 *
	 * @return array
	 */
	public function getIncludeFrontEndResources() {
		return $this->includeFrontEndResources;
	}

	/**
	 * Sets this width.
	 *
	 * @param integer $width
	 * @return Tx_AdGoogleMaps_MapBuilder_MapBuilder
	 */
	public function setWidth($width) {
		$this->width = (integer) $width;
		return $this;
	}

	/**
	 * Returns this width.
	 *
	 * @return integer
	 */
	public function getWidth() {
		return (integer) $this->width;
	}

	/**
	 * Sets this height.
	 *
	 * @param integer $height
	 * @return Tx_AdGoogleMaps_MapBuilder_MapBuilder
	 */
	public function setHeight($height) {
		$this->height = (integer) $height;
		return $this;
	}

	/**
	 * Returns this height.
	 *
	 * @return integer
	 */
	public function getHeight() {
		return (integer) $this->height ? $this->height : self::DEFAULT_HEIGHT;
	}

	/**
	 * Sets this geocodeUrl.
	 *
	 * @param string $geocodeUrl
	 * @return Tx_AdGoogleMaps_MapBuilder_MapBuilder
	 */
	public function setGeocodeUrl($geocodeUrl) {
		$this->geocodeUrl = $geocodeUrl;
		return $this;
	}

	/**
	 * Returns this geocodeUrl.
	 *
	 * @return string
	 */
	public function getGeocodeUrl() {
		return $this->geocodeUrl ? $this->geocodeUrl : self::DEFAULT_GEOCODE_URL;
	}

	/**
	 * Sets this options.
	 *
	 * @param Tx_AdGoogleMaps_MapBuilder_Options $options
	 * @return Tx_AdGoogleMaps_MapBuilder_MapBuilder
	 */
	public function setOptions(Tx_AdGoogleMaps_MapBuilder_Options $options) {
		$this->options = $options;
		return $this;
	}

	/**
	 * Returns this options.
	 *
	 * @return Tx_AdGoogleMaps_MapBuilder_Options
	 */
	public function getOptions() {
		return $this->options;
	}

	/**
	 * Alias of $this->options->setCanvasId(). Sets this canvas ID.
	 *
	 * @param string $canvasId
	 * @return Tx_AdGoogleMaps_MapBuilder_MapBuilder
	 */
	public function setCanvasId($canvasId) {
		$this->options->setCanvasId($canvasId);
		return $this;
	}

	/**
	 * Alias of $this->options->getCanvasId(). Returns this canvas ID.
	 *
	 * @return string
	 */
	public function getCanvasId() {
		return $this->options->getCanvasId();
	}

	/**
	 * Creates a new layer and append it to $this->options->layers.
	 *
	 * @param string $layerClassName
	 * @param array $layerConfiguration
	 * @param array $data
	 * @param string $tableName
	 * @return Tx_AdGoogleMaps_MapManager_Layer_LayerInterface
	 */
	public function createLayer($layerClassName, array $layerConfiguration = array(), array $layerData = array(), $layerTableName = '') {
		if (class_exists($layerClassName) === FALSE) {
			throw new Tx_AdGoogleMaps_MapBuilder_Exception(sprintf('Layer class "%s" don\'t exists.', $layerClassName), 1319184803);
		}

		if (count($layerConfiguration) == 0) {
			throw new Tx_AdGoogleMaps_MapBuilder_Exception(sprintf('Layer class "%s" have no configuration.', $layerClassName), 1319272723);
		}

		// Set ID if not set.
		if (array_key_exists('id', $layerConfiguration) === FALSE) {
			$layerConfiguration['id'] = md5(serialize($layerConfiguration));
		}

		$layer = $this->objectManager->create($layerClassName);

		$this->frontEndUtility->objectTypoScriptInjection($layer, $layerConfiguration, $layerData, $layerTableName);
		$this->options->addLayer($layer);

		return $layer;
	}

	/**
	 * Add a new layer to the $this->options->layers.
	 *
	 * @param Tx_AdGoogleMaps_MapBuilder_Options_Layer_LayerInterface $layer
	 * @param array $data
	 * @param string $tableName
	 * @return Tx_AdGoogleMaps_MapBuilder_MapBuilder
	 */
	public function addLayer(Tx_AdGoogleMaps_MapBuilder_Options_Layer_LayerInterface $layer, array $layerData = array(), $layerTableName = '') {
		$layerClassName = get_class($layer);
		if (array_key_exists($layerClassName, $this->settings['options']['layers']) === TRUE) {
			$this->frontEndUtility->objectTypoScriptInjection($layer, $this->settings['options']['layers'][$layerClassName], $layerData, $layerTableName);
		}
		$this->options->addLayer($layer);
		return $this;
	}

	/**
	 * Returns the plugin object options identifier as string.
	 *
	 * @return string
	 */
	public function getPrintOptionsObjectIdentifier() {
		return 'Tx_AdGoogleMaps_MapBuilder_Options' . ($this->identifier !== NULL ? '_Uid_' . $this->identifier : '');
	}

	/**
	 * Returns the plugin object identifier as string.
	 *
	 * @return string
	 */
	public function getPrintMapObjectIdentifier() {
		return 'Tx_AdGoogleMaps_MapBuilder_Map' . ($this->identifier !== NULL ? '_Uid_' . $this->identifier : '');
	}

	/**
	 * Returns the initialize function as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrintInitializeFunction() {
		return $this->getPrintMapObjectIdentifier() . ' = new Tx_AdGoogleMaps_MapBuilder(' . $this->getPrintOptionsObjectIdentifier() . ');';
	}

	/**
	 * Returns this canvas ID.
	 *
	 * @return string
	 */
	public function getPrintCanvasId() {
		return $this->getCanvasId();
	}

	/**
	 * Returns this canvas as HTML-DIV-Element.
	 *
	 * @return string
	 */
	public function getPrintCanvas() {
		$size = array();
		if ($this->height) $size[] = 'height: ' . $this->height . 'px';
		if ($this->width)  $size[] = 'width: ' . $this->width . 'px';
		$style = (count($size) > 0 ? ' style="' . implode('; ', t3lib_div::removeArrayEntryByValue($size, NULL)) . ';"' : '');
		return LF . '<div id="' . $this->getPrintCanvasId() . '"' . $style . '></div>';
	}

	/**
	 * Returns this options as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrintOptions() {
		return $this->options->getPrint();
	}

	/**
	 * Returns plugin options as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrintJavaScript() {
		$javaScript .= LF . $this->getPrintOptionsObjectIdentifier() . ' = ' . $this->getPrintOptions() . ';';
		$javaScript .= LF . $this->getPrintInitializeFunction();
		return $javaScript;
			
	}

	/**
	 * Returns plugin options as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrintJavaScriptHTML() {
		$javaScript  = LF . '<script type="text/javascript">' . LF . '/*<![CDATA[*/' . LF . '<!--';
		$javaScript .= $this->getPrintJavaScript();
		$javaScript .= LF . '//-->' . LF . '/*]]>*/' . LF . '</script>' . LF;
		return $javaScript;
			
	}

	/**
	 * Returns complete Google Maps.
	 *
	 * @return string
	 */
	public function getPrint() {
		return $this->getPrintCanvas() . $this->getPrintJavaScriptHTML();
	}

	/**
	 * Returns the address coordinate string. Returns NULL if no address found.
	 * 
	 * @param string $addressQuery
	 * @return string
	 */
	public function getCoordinatesByAddress($addressQuery) {
		$coordinate = NULL;
		$geocodeUrl = $this->getGeocodeUrl();
		$geocodeUrl .= '?sensor=false&address=' . urlencode(str_replace(LF, ', ', $addressQuery));
		$geocodeResult = t3lib_div::getURL($geocodeUrl);
		$geocodeResult = json_decode($geocodeResult);
		if ($geocodeResult !== NULL && strtolower($geocodeResult->status) === 'ok') {
			$coordinate = $geocodeResult->results[0]->geometry->location->lat . ',' . $geocodeResult->results[0]->geometry->location->lng;
		}
		return $coordinate;
	}

	/**
	 * Returns the address LatLng object. Returns NULL if no address found.
	 * 
	 * @param string $addressQuery
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Base_LatLng
	 */
	public function getLatLngByAddress($addressQuery) {
		$latLng = NULL;
		$geocodeUrl = $this->getGeocodeUrl();
		$geocodeUrl .= '?sensor=false&address=' . urlencode(str_replace(LF, ', ', $addressQuery));
		$geocodeResult = t3lib_div::getURL($geocodeUrl);
		$geocodeResult = json_decode($geocodeResult);
		if ($geocodeResult !== NULL && strtolower($geocodeResult->status) === 'ok') {
			$coordinates = new Tx_AdGoogleMaps_MapBuilder_API_Base_LatLng($geocodeResult->results[0]->geometry->location->lat, $geocodeResult->results[0]->geometry->location->lng);
		}
		return $latLng;
	}

	/**
	 * Returns the map as JavaScript string.
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getPrint();
	}

}

?>