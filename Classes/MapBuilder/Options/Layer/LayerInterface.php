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
interface Tx_AdGoogleMaps_MapBuilder_Options_Layer_LayerInterface {

	/**
	 * Sets this uid.
	 *
	 * @param string $uid
	 * @return Tx_AdGoogleMaps_MapBuilder_Api_Layer_LayerInterface
	 */
	public function setUid($uid);

	/**
	 * Returns this uid.
	 *
	 * @return string
	 */
	public function getUid();

	/**
	 * Sets this drawFunctionName.
	 *
	 * @param string $drawFunctionName
	 * @return Tx_AdGoogleMaps_MapBuilder_Api_Layer_LayerInterface
	 */
	public function setDrawFunctionName($drawFunctionName);

	/**
	 * Returns this drawFunctionName.
	 *
	 * @return string
	 */
	public function getDrawFunctionName();

	/**
	 * Sets this options.
	 *
	 * @param Tx_AdGoogleMaps_MapBuilder_Api_Layer_LayerInterface $options
	 * @return Tx_AdGoogleMaps_MapBuilder_Api_Layer_LayerInterface
	 */
	public function setOptions(Tx_AdGoogleMaps_MapBuilder_Api_Layer_LayerInterface $options);

	/**
	 * Returns this options.
	 *
	 * @return Tx_AdGoogleMaps_MapBuilder_Api_Layer_LayerInterface
	 */
	public function getOptions();

	/**
	 * Returns the map as JavaScript string.
	 *
	 * @return string
	 */
	public function __toString();

}

?>