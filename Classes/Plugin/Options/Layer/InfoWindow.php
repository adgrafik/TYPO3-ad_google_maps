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
class Tx_AdGoogleMaps_Plugin_Options_Layer_InfoWindow extends Tx_AdGoogleMaps_Plugin_Options_Layer_AbstractLayer {

	/**
	 * @var string
	 */
	protected $linkToLayerUid;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs = FALSE
	 */
	protected $infoWindowKeepOpen;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs = FALSE
	 */
	protected $infoWindowCloseOnClick;

	/**
	 * Sets this linkToLayerUid.
	 *
	 * @param string $linkToLayerUid
	 * @return Tx_AdGoogleMaps_Plugin_Options_Marker
	 */
	public function setLinkToLayerUid($linkToLayerUid) {
		$this->linkToLayerUid = $linkToLayerUid;
		return $this;
	}

	/**
	 * Returns this linkToLayerUid.
	 *
	 * @return string
	 */
	public function getLinkToLayerUid() {
		return $this->linkToLayerUid;
	}
	/**
	 * Sets this infoWindowKeepOpen.
	 *
	 * @param boolean $infoWindowKeepOpen
	 * @return Tx_AdGoogleMaps_Plugin_Options_Marker
	 */
	public function setInfoWindowKeepOpen($infoWindowKeepOpen) {
		$this->infoWindowKeepOpen = (boolean) $infoWindowKeepOpen;
		return $this;
	}

	/**
	 * Returns this infoWindowKeepOpen.
	 *
	 * @return boolean
	 */
	public function getInfoWindowKeepOpen() {
		return (boolean) $this->infoWindowKeepOpen;
	}

	/**
	 * Sets this infoWindowCloseOnClick.
	 *
	 * @param boolean $infoWindowCloseOnClick
	 * @return Tx_AdGoogleMaps_Plugin_Options_MapControl
	 */
	public function setInfoWindowCloseOnClick($infoWindowCloseOnClick) {
		$this->infoWindowCloseOnClick = (boolean) $infoWindowCloseOnClick;
		return $this;
	}

	/**
	 * Returns this infoWindowCloseOnClick.
	 *
	 * @return boolean
	 */
	public function getInfoWindowCloseOnClick() {
		return (boolean) $this->infoWindowCloseOnClick;
	}

}

?>