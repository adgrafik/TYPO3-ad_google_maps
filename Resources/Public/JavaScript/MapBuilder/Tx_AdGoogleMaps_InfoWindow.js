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
 * A Google Maps API JavaScript class for the MapBuilder.
 *
 * @version $Id:$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
/**
 * InfoWindow Extension.
 */
Tx_AdGoogleMaps_MapBuilder.prototype.opendInfoWindows = {};
Tx_AdGoogleMaps_MapBuilder.prototype.drawInfoWindow = function(layerIndex){
	var _this = this;
	var layerOptions = this.getLayerOptions(layerIndex);
	var layerUid = layerOptions.uid;
	// Set layer object.
	var layer = new google.maps.InfoWindow(layerOptions.options);
	this.setLayer(layerUid, {
		options: layerOptions,
		layer: layer
	});
	// Add click event for the close icon of the info window.
	google.maps.event.addListener(this.getLayer(layerUid).layer, 'closeclick', function(event) {
		_this.closeInfoWindow(layerUid);
	});
	// Add click event if a linked layer is defined.
	var linkToLayerUid = layerOptions.linkToLayerUid;
	var linkLayer = this.getLayer(linkToLayerUid);
	if (linkLayer !== null && layerOptions.linkToLayerUid !== undefined){
		google.maps.event.addListener(linkLayer.layer, 'click', function(event) {
			_this.openInfoWindow(layerUid, event);
		});
	}
	// Must return the layerUid.
	return layerUid;
};

Tx_AdGoogleMaps_MapBuilder.prototype.openInfoWindow = function(layerUid, event){
	var infoWindow = this.getLayer(layerUid);
	if (infoWindow === null)
		return;
	var infoWindowOptions = infoWindow.getOptions();
	var anchor = null;
	if (this.opendInfoWindows[layerUid] === undefined){
		if (infoWindowOptions.infoWindowKeepOpen !== true){
			this.closeAllInfoWindows();
		}
		var linkLayer = this.getLayer(infoWindowOptions.linkToLayerUid);
		if (linkLayer !== null && infoWindowOptions.options.position === undefined && infoWindowOptions.linkToLayerUid !== undefined){
			var center = linkLayer.getCenter();
			if (event !== undefined && linkLayer.layer instanceof google.maps.Marker === false){
				infoWindow.layer.setPosition(event.latLng);
			} else if (linkLayer !== undefined && center !== null){
				if (center instanceof google.maps.LatLng === true) {
					infoWindow.layer.setPosition(center);
				} else {
					anchor = center;
				}
			}
		}
		if (anchor !== null){
			infoWindow.layer.open(this.map, anchor);
		} else {
			infoWindow.layer.open(this.map);
		}
		this.opendInfoWindows[layerUid] = infoWindow.layer;
	} else if (infoWindowOptions.infoWindowCloseOnClick === true){
		this.closeInfoWindow(layerUid);
	}
};

Tx_AdGoogleMaps_MapBuilder.prototype.closeInfoWindow = function(layerUid){
	if (this.opendInfoWindows[layerUid] === undefined)
		return;
	this.opendInfoWindows[layerUid].close();
	delete this.opendInfoWindows[layerUid];
};

Tx_AdGoogleMaps_MapBuilder.prototype.closeAllInfoWindows = function(){
	for (var layerUid in this.opendInfoWindows){
		this.closeInfoWindow(layerUid);
	}
};