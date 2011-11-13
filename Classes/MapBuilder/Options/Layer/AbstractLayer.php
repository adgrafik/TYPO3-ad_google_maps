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
abstract class Tx_AdGoogleMaps_MapBuilder_Options_Layer_AbstractLayer implements Tx_AdGoogleMaps_MapBuilder_Options_Layer_LayerInterface {

	/**
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 * @jsonClassEncoder ignoreProperty
	 */
	protected $objectManager;

	/**
	 * @var Tx_AdGoogleMaps_Utility_FrontEnd
	 * @jsonClassEncoder ignoreProperty
	 */
	protected $frontEndUtility;

	/**
	 * @var Tx_AdGoogleMaps_JsonClassEncoder_JsonEncoderInterface
	 * @jsonClassEncoder ignoreProperty
	 */
	protected $jsonEncoder;

	/**
	 * @var string
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $drawFunctionName;

	/**
	 * @var string
	 */
	protected $linkToLayerId;

	/**
	 * @var Tx_AdGoogleMaps_MapBuilder_API_Overlay_LayerInterface
	 */
	protected $options;

	/**
	 * @var mixed
	 * @jsonClassEncoder ignoreProperty
	 */
	protected $initializeOptions;

	/*
	 * Constructor.
	 * 
	 * @param Tx_AdGoogleMaps_MapBuilder_API_Overlay_LayerInterface $options
	 */
	public function __construct(Tx_AdGoogleMaps_MapBuilder_API_Overlay_LayerInterface $options) {
		// Set default values.
		$this->drawFunctionName = 'draw' . substr(strrchr(get_class($this), '_'), 1);
		$this->options = $options;
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

	/*
	 * Initialize this object.
	 */
	public function initializeObject() {
		$this->frontEndUtility->includeFrontEndResources(get_class($this));
	}

	/**
	 * Sets this id.
	 *
	 * @param string $id
	 * @return Tx_AdGoogleMaps_MapBuilder_Options_Layer_LayerInterface
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * Returns this id.
	 *
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Sets this drawFunctionName.
	 *
	 * @param string $drawFunctionName
	 * @return Tx_AdGoogleMaps_MapBuilder_Options_Layer_LayerInterface
	 */
	public function setDrawFunctionName($drawFunctionName) {
		$this->drawFunctionName = $drawFunctionName;
		return $this;
	}

	/**
	 * Returns this drawFunctionName.
	 *
	 * @return string
	 */
	public function getDrawFunctionName() {
		return $this->drawFunctionName;
	}

	/**
	 * Sets this linkToLayerId.
	 *
	 * @param string $linkToLayerId
	 * @return Tx_AdGoogleMaps_MapBuilder_Options_Layer_LayerInterface
	 */
	public function linkToLayer(Tx_AdGoogleMaps_MapBuilder_Options_Layer_LayerInterface $layerOptions) {
		$this->linkToLayerId = $layerOptions->getId();
		return $this;
	}

	/**
	 * Sets this linkToLayerId.
	 *
	 * @param string $linkToLayerId
	 * @return Tx_AdGoogleMaps_MapBuilder_Options_Layer_LayerInterface
	 */
	public function setLinkToLayerId($linkToLayerId) {
		$this->linkToLayerId = $linkToLayerId;
		return $this;
	}

	/**
	 * Returns this linkToLayerId.
	 *
	 * @return string
	 */
	public function getLinkToLayerId() {
		return $this->linkToLayerId;
	}

	/**
	 * Sets this options.
	 *
	 * @param Tx_AdGoogleMaps_MapBuilder_API_Layer_LayerInterface $options
	 * @return Tx_AdGoogleMaps_MapBuilder_Options_Layer_LayerInterface
	 */
	public function setOptions(Tx_AdGoogleMaps_MapBuilder_API_Layer_LayerInterface $options) {
		$this->options = $options;
		return $this;
	}

	/**
	 * Returns this options.
	 *
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Layer_LayerInterface
	 */
	public function getOptions() {
		return $this->options;
	}

	/**
	 * Returns the map as JavaScript string.
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->jsonEncoder->encode($this);
	}

	/**
	 * Alias methods for $this->options->*.
	 *
	 * @param string $methodName
	 * @param array $arguments
	 * @return void
	 */
	public function __call($methodName, array $arguments = array()) {
		if (is_callable(array($this->options, $methodName))) {
			return call_user_func_array(array($this->options, $methodName), $arguments);
		}
	}

	/**
	 * Returns this id.
	 *
	 * @return string
	 */
	protected function getOptionsApiClassName() {
		$classes = new ReflectionObject($this);
		return $classes->getConstant('OPTIONS_API_CLASS_NAME');
	}

}

?>