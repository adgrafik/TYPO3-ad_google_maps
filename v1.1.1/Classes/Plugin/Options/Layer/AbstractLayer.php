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
 * @api
 */
abstract class Tx_AdGoogleMaps_Plugin_Options_Layer_AbstractLayer implements Tx_AdGoogleMaps_Plugin_Options_Layer_LayerInterface {

	/**
	 * @var string
	 * @javaScriptHelper
	 */
	protected $uid;

	/**
	 * @var string
	 * @javaScriptHelper
	 */
	protected $drawFunctionName;

	/**
	 * @var Tx_AdGoogleMaps_Api_Layer_LayerInterface
	 * @javaScriptHelper
	 */
	protected $options;

	/**
	 * Sets this uid.
	 *
	 * @param string $uid
	 * @return Tx_AdGoogleMaps_Api_Layer_LayerInterface
	 */
	public function setUid($uid) {
		$this->uid = $uid;
		return $this;
	}

	/**
	 * Returns this uid.
	 *
	 * @return string
	 */
	public function getUid() {
		return $this->uid;
	}

	/**
	 * Sets this drawFunctionName.
	 *
	 * @param string $drawFunctionName
	 * @return Tx_AdGoogleMaps_Api_Layer_LayerInterface
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
	 * Sets this options.
	 *
	 * @param Tx_AdGoogleMaps_Api_Layer_LayerInterface $options
	 * @return Tx_AdGoogleMaps_Api_Layer_LayerInterface
	 */
	public function setOptions(Tx_AdGoogleMaps_Api_Layer_LayerInterface $options) {
		$this->options = $options;
		return $this;
	}

	/**
	 * Returns this options.
	 *
	 * @return Tx_AdGoogleMaps_Api_Layer_LayerInterface
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
		return Tx_AdGoogleMaps_Utility_FrontEnd::getClassAsJsonObject($this);
	}

}

?>