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
 * Abstract coordinates provider class.
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
abstract class Tx_AdGoogleMaps_MapManager_CoordinatesProvider_AbstractCoordinatesProvider implements Tx_AdGoogleMaps_MapManager_CoordinatesProvider_CoordinatesProviderInterface {

	/**
	 * @var Tx_AdGoogleMaps_MapManager_Layer_LayerInterface
	 */
	protected $layerBuilder;

	/**
	 * @var array
	 */
	protected $data;

	/**
	 * @var array
	 */
	protected $coordinates;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->data = array();
		$this->coordinates = array();
	}

	/**
	 * Injects this mapManager.
	 *
	 * @param Tx_AdGoogleMaps_MapManager_Layer_LayerInterface $mapManager
	 * @return void
	 */
	public function injectLayer(Tx_AdGoogleMaps_MapManager_Layer_LayerInterface $layerBuilder) {
		$this->layerBuilder = $layerBuilder;
	}

	/**
	 * Loads the data and the coordinates.
	 *
	 * @return void
	 */
	public function load() {}

	/**
	 * Returns this data.
	 *
	 * @return array
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * Returns this coordinates.
	 *
	 * @return array
	 */
	public function getCoordinates() {
		return $this->coordinates;
	}

	/**
	 * Returns this coordinates.
	 *
	 * @param integer $index
	 * @return array
	 */
	public function getCoordinatesByIndex($index) {
		return array_key_exists($index, $this->coordinates) ? $this->coordinates[$index] : NULL;
	}

}

?>