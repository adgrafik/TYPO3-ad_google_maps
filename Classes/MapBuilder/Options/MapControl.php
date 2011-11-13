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
class Tx_AdGoogleMaps_MapBuilder_Options_MapControl {

	/**
	 * @var Tx_AdGoogleMaps_JsonClassEncoder_JsonEncoderInterface
	 * @jsonClassEncoder ignoreProperty
	 */
	protected $jsonEncoder;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs( FALSE )
	 */
	protected $fitBoundsOnLoad;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs( FALSE )
	 */
	protected $useMarkerCluster;

	/**
	 * @var Tx_AdGoogleMaps_MapBuilder_API_Overlay_MarkerImage
	 * @jsonClassEncoder useGetterMethod( getPrint )
	 * @jsonClassEncoder ignorePropertyIfValueIs( NULL )
	 */
	protected $searchMarker;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs( FALSE )
	 */
	protected $infoWindowCloseAllOnMapClick;

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
	 * Sets this fitBoundsOnLoad.
	 *
	 * @param boolean $fitBoundsOnLoad
	 * @return Tx_AdGoogleMaps_MapBuilder_Options_MapControl
	 */
	public function setFitBoundsOnLoad($fitBoundsOnLoad) {
		$this->fitBoundsOnLoad = (boolean) $fitBoundsOnLoad;
		return $this;
	}

	/**
	 * Returns this fitBoundsOnLoad.
	 *
	 * @return boolean
	 */
	public function isFitBoundsOnLoad() {
		return (boolean) $this->fitBoundsOnLoad;
	}

	/**
	 * Sets this useMarkerCluster.
	 *
	 * @param boolean $useMarkerCluster
	 * @return Tx_AdGoogleMaps_MapBuilder_Options_MapControl
	 */
	public function setUseMarkerCluster($useMarkerCluster) {
		$this->useMarkerCluster = (boolean) $useMarkerCluster;
		return $this;
	}

	/**
	 * Returns this useMarkerCluster.
	 *
	 * @return boolean
	 */
	public function isUseMarkerCluster() {
		return (boolean) $this->useMarkerCluster;
	}

	/**
	 * Sets this searchMarker
	 *
	 * @param Tx_AdGoogleMaps_MapBuilder_API_Overlay_MarkerImage $searchMarker
	 * @return Tx_AdGoogleMaps_MapBuilder_Options_MapControl
	 */
	public function setSearchMarker($searchMarker) {
		$this->searchMarker = $searchMarker;
		return $this;
	}

	/**
	 * Returns this searchMarker
	 *
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_MarkerImage
	 */
	public function getSearchMarker() {
		return $this->searchMarker;
	}

	/**
	 * Sets this infoWindowCloseAllOnMapClick.
	 *
	 * @param boolean $infoWindowCloseAllOnMapClick
	 * @return Tx_AdGoogleMaps_MapBuilder_Options_MapControl
	 */
	public function setInfoWindowCloseAllOnMapClick($infoWindowCloseAllOnMapClick) {
		$this->infoWindowCloseAllOnMapClick = (boolean) $infoWindowCloseAllOnMapClick;
		return $this;
	}

	/**
	 * Returns this infoWindowCloseAllOnMapClick.
	 *
	 * @return boolean
	 */
	public function isInfoWindowCloseAllOnMapClick() {
		return (boolean) $this->infoWindowCloseAllOnMapClick;
	}

	/**
	 * Returns the map as JavaScript string.
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->jsonEncoder->encode($this);
	}

}

?>