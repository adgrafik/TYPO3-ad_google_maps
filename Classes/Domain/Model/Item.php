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
 * Model: Item.
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 * @api
 */
class Tx_AdGoogleMaps_Domain_Model_Item {

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $icon;

	/**
	 * @var integer
	 */
	protected $iconWidth;

	/**
	 * @var integer
	 */
	protected $iconHeight;

	/**
	 * @var mixed
	 */
	protected $position;

	/**
	 * @var array
	 */
	protected $mapControlFunctions;

	/**
	 * @var array
	 */
	protected $layerOptions;

	/**
	 * @var Tx_AdGoogleMaps_PluginAdapter_LayerBuilder_InfoWindow
	 */
	protected $infoWindow;

	/**
	 * @var array
	 */
	protected $dataProvider;

	/**
	 * Sets this title.
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns this title.
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets this icon.
	 *
	 * @param string $icon
	 * @return void
	 */
	public function setIcon($icon) {
		$this->icon = $icon;
	}

	/**
	 * Returns this icon.
	 *
	 * @return string
	 */
	public function getIcon() {
		return $this->icon;
	}

	/**
	 * Sets this iconWidth.
	 *
	 * @param integer $iconWidth
	 * @return void
	 */
	public function setIconWidth($iconWidth) {
		$this->iconWidth = $iconWidth;
	}

	/**
	 * Returns this iconWidth.
	 *
	 * @return integer
	 */
	public function getIconWidth() {
		return (integer) $this->iconWidth;
	}

	/**
	 * Sets this iconHeight.
	 *
	 * @param integer $iconHeight
	 * @return void
	 */
	public function setIconHeight($iconHeight) {
		$this->iconHeight = $iconHeight;
	}

	/**
	 * Returns this iconHeight.
	 *
	 * @return integer
	 */
	public function getIconHeight() {
		return (integer) $this->iconHeight;
	}

	/**
	 * Sets this position.
	 *
	 * @param mixed $position
	 * @return void
	 */
	public function setPosition($position) {
		$this->position = $position;
	}

	/**
	 * Returns this position.
	 *
	 * @return mixed
	 */
	public function getPosition() {
		return $this->position;
	}

	/**
	 * Sets this mapControlFunctions
	 *
	 * @param array $mapControlFunctions
	 * @return void
	 */
	public function setMapControlFunctions($mapControlFunctions) {
		$this->mapControlFunctions = $mapControlFunctions;
	}

	/**
	 * Adds a function to this mapControlFunctions
	 *
	 * @param string $key
	 * @param string $functionString
	 * @return void
	 */
	public function addMapControlFunction($key, $functionString) {
		$this->mapControlFunctions[$key] = $functionString;
	}

	/**
	 * Returns this mapControlFunctions
	 *
	 * @return array
	 */
	public function getMapControlFunctions() {
		return $this->mapControlFunctions;
	}

	/**
	 * Sets this layerOptions
	 *
	 * @param array $layerOptions
	 * @return void
	 */
	public function setLayerOptions($layerOptions) {
		$this->layerOptions = $layerOptions;
	}

	/**
	 * Returns this layerOptions
	 *
	 * @return array
	 */
	public function getLayerOptions() {
		return $this->layerOptions;
	}

	/**
	 * Sets this infoWindow
	 *
	 * @param array $infoWindow
	 * @return Tx_AdGoogleMaps_PluginAdapter_LayerBuilder_InfoWindow
	 */
	public function setInfoWindow($infoWindow) {
		$this->infoWindow = $infoWindow;
	}

	/**
	 * Returns this infoWindow
	 *
	 * @return Tx_AdGoogleMaps_PluginAdapter_LayerBuilder_InfoWindow
	 */
	public function getInfoWindow() {
		return $this->infoWindow;
	}

	/**
	 * Sets this dataProvider
	 *
	 * @param array $dataProvider
	 * @return void
	 */
	public function setDataProvider($dataProvider) {
		$this->dataProvider = $dataProvider;
	}

	/**
	 * Returns this dataProvider
	 *
	 * @return array
	 */
	public function getDataProvider() {
		return $this->dataProvider;
	}

}

?>