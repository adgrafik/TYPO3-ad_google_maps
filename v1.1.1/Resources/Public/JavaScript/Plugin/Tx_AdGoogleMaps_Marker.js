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
 * A Google Maps API JavaScript class for the Plugin.
 *
 * @version $Id:$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
/**
 * Marker Extension.
 */
Tx_AdGoogleMaps_Plugin.prototype.drawMarker = function(layerIndex){
	var _this = this;
	var layerOptions = this.getLayerOptions(layerIndex);
	var layerUid = layerOptions.uid;
	// Set layer object.
	layerOptions.options.map = this.map;
	var layer = new google.maps.Marker(layerOptions.options);
	this.setLayer(layerUid, {
		options: layerOptions,
		layer: layer,
		bounds: new google.maps.LatLngBounds(layer.getPosition()),
		center: layer
	});
	// Add marker to marker cluster.
	if (this.mapControl.useMarkerCluster === true){
		this.markerClustererMarkers.push(this.getLayer(layerUid).layer);
	}
	// Must return the layerUid.
	return layerUid;
};