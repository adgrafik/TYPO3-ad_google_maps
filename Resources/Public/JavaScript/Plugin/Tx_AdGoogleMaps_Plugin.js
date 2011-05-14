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
Tx_AdGoogleMaps_Plugin = function(options){
	this.construct(options);
};
Tx_AdGoogleMaps_Plugin.prototype = {
	options: null,
	canvasId: null,
	canvas: null,

	mapOptions: null,
	mapControl: null,
	layerOptions: null,

	bounds: null,
	markerClusterer: null,
	markerClustererMarkers: [],

	map: null,
	layers: {},
	
	construct: function(options){
		this.options = options;
		this.canvasId = options.canvasId;
		this.canvas = document.getElementById(this.canvasId);

		this.mapOptions = options.mapOptions;
		this.mapControl = options.mapControl;
		this.layerOptions = options.layerOptions;

		this.bounds = new google.maps.LatLngBounds();

		this.drawMap();
		this.drawLayers();

		if (this.mapControl.useMarkerCluster === true){
			if (typeof(MarkerClusterer) === 'undefined'){
				this.mapControl.useMarkerCluster = false;
				console.log('Error Tx_AdGoogleMaps_Plugin.construct(): MarkerClusterer Lib not loaded.');
			} else {
				this.markerClusterer = new MarkerClusterer(this.map, this.markerClustererMarkers);
			}
		}
	},

	getMap: function(){
		return this.map;
	},

	getLayerOptions: function(layerIndex){
		return (this.layerOptions[layerIndex] !== undefined ? this.layerOptions[layerIndex] : null);
	},

	setLayer: function(layerUid, layerOptions){
		return this.layers[layerUid] = new Tx_AdGoogleMaps_Plugin_LayerObject(layerOptions);
	},
	
	getLayers: function(){
		return this.layers;
	},

	getLayer: function(layerUid){
		return (this.layers[layerUid] !== undefined ? this.layers[layerUid] : null);
	},

	drawMap: function(){
		this.map = new google.maps.Map(this.canvas, this.mapOptions);

		// Add click event for the map.
		var _this = this;
		if (this.mapControl.infoWindowCloseAllOnMapClick === true){
			google.maps.event.addListener(this.map, 'click', function(event) {
				_this.closeAllInfoWindows();
			});
		}
	},

	drawLayers: function(){
		var bounds = new google.maps.LatLngBounds();
		for (var layerIndex in this.layerOptions){
			var drawFunctionName = this.layerOptions[layerIndex].drawFunctionName;
			if (this[drawFunctionName] !== undefined){
				var layerUid = this[drawFunctionName](layerIndex);

				// Get bounds of layers on load.
				if (this.mapControl.fitBoundsOnLoad === true && this.getLayer(layerUid) !== null && this.getLayer(layerUid).getBounds() !== null){
					bounds.union(this.getLayer(layerUid).getBounds());
				}
			}
		}
		// Fit bounds on the map at loading.
		if (this.mapControl.fitBoundsOnLoad === true && layerIndex !== undefined){
			this.map.fitBounds(bounds);
		}
	},

	panTo: function(layerUids){
		// Use center of bounds cause if layerUids is a single marker "panToBounds" place the marker not in the center of the map.
		if (typeof layerUids === 'string'){
			var bounds = this.getLayer(layerUids).getBounds();
		} else {
			var bounds = new google.maps.LatLngBounds();
			for (layerUid in layerUids){
				var bound = this.getLayer(layerUids[layerUid]).getBounds();
				if (bound !== null){
					bounds.union(bound);
				}
			}
		}
		if (bounds !== null){
			this.map.panTo(bounds.getCenter());
		}
	},

	fitBounds: function(layerUids){
		if (typeof layerUids === 'string'){
			var bounds = this.getLayer(layerUids).getBounds();
		} else {
			var bounds = new google.maps.LatLngBounds();
			for (layerUid in layerUids){
				var bound = this.getLayer(layerUids[layerUid]).getBounds();
				if (bound !== null){
					bounds.union(bound);
				}
			}
		}
		if (bounds !== null){
			this.map.fitBounds(bounds);
		}
	},

	getCenterOfLatLngArray: function(latLngs){
		var bounds = new google.maps.LatLngBounds();
		latLngs.forEach(function(element, index){
			bounds.extend(element);
		});
		return bounds.getCenter();
	},

	getBoundsOfLatLngArray: function(latLngArray){
		var bounds = new google.maps.LatLngBounds();
		latLngArray.forEach(function(element, index){
			bounds.extend(element);
		});
		return bounds;
	}
};

/**
 * Layer object.
 */
Tx_AdGoogleMaps_Plugin_LayerObject = function(options){
	this.construct(options);
};
Tx_AdGoogleMaps_Plugin_LayerObject.prototype = {
	options: null,
	layer: null,
	center: null,
	bounds: null,

	construct: function(options){
		this.options = (options.options !== undefined ? options.options : null);
		this.layer = (options.layer !== undefined ? options.layer : null);
		this.center = (options.center !== undefined ? options.center : null);
		this.bounds = (options.bounds instanceof google.maps.LatLngBounds === true ? options.bounds : null);
	},

	getOptions: function(){
		return this.options;
	},

	setCenter: function(center){
		this.center = center;
		return this;
	},

	getCenter: function(){
		return this.center;
	},

	setBounds: function(bounds){
		this.bounds = bounds;
		return this;
	},

	getBounds: function(){
		return this.bounds;
	}
}



/**
 * Marker Extension.
 */
Tx_AdGoogleMaps_Plugin.prototype.opendInfoWindows = {};
Tx_AdGoogleMaps_Plugin.prototype.drawInfoWindow = function(layerIndex){
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

Tx_AdGoogleMaps_Plugin.prototype.openInfoWindow = function(layerUid, event){
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

Tx_AdGoogleMaps_Plugin.prototype.closeInfoWindow = function(layerUid){
	if (this.opendInfoWindows[layerUid] === undefined)
		return;
	this.opendInfoWindows[layerUid].close();
	delete this.opendInfoWindows[layerUid];
};

Tx_AdGoogleMaps_Plugin.prototype.closeAllInfoWindows = function(){
	for (var layerUid in this.opendInfoWindows){
		this.closeInfoWindow(layerUid);
	}
};


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