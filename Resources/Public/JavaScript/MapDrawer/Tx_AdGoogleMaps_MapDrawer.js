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

Ext.ns('TYPO3');


/**
 * A Google Maps Api JavaScript class for the MapDrawer.
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
TYPO3.Tx_AdGoogleMaps_MapDrawer_AbstractLayer = Ext.extend(Object, {

	markerIcon: {
		'address': new google.maps.MarkerImage(
			'../typo3conf/ext/ad_google_maps/Resources/Public/Icons/MapDrawer/searchMarker.gif', 
			new google.maps.Size(9, 9), 
			new google.maps.Point(0, 0), 
			new google.maps.Point(4, 5)
		)
	},

	processor: null,

	geocoder: null,

	coordinatesFieldId: null,
	coordinatesField: null,

	searchFieldId: null,
	searchField: null,
	searchButtonId: null,
	searchButton: null,

	mapOptions: null,
	map: null,

	fitBoundsOnLoad: false,

	searchMarker: null,
	searchMarkerInfo: null,
	searchMarkerCallback: null,

	/**
	 * Constructor
	 *
	 * @param object options
	 * @return void
	 */
	constructor: function(options){
		Ext.apply(this, options);

		// Set visible of TCA-Tab to draw map correctly.
		var tabHideAgain = false;
		var tab = Ext.get(this.canvasId).parent('.c-tablayer');
		if (tab && !tab.isVisible()){
			tabHideAgain = true;
			tab.setVisibilityMode(Ext.Element.DISPLAY).show().setStyle({ height: 0, overflow: 'hidden' });
		}

		this.geocoder = new google.maps.Geocoder();

		this.coordinatesField = Ext.get(this.coordinatesFieldId);
		// Add change listener to coordinates field.
		this.coordinatesField.on('change', function(event, target){
			event.preventDefault();
			this.drawLayer(true);
		}, this);

		this.searchField = Ext.get(this.searchFieldId);
		this.searchButton = Ext.get(this.searchButtonId);
		// Prevent Geo Search to submit form by press ENTER and get location by field value. 
		this.searchField.on('keydown', function(event, target){
			if (event.getKey() === event.ENTER){
				event.preventDefault();
				target.blur();
				this.setSearchMarker(target.value);
			}
		}, this);
		this.searchButton.on('click', function(event, target){
			event.preventDefault();
			this.setSearchMarker(this.searchField.getValue());
			return false;
		}, this);

		this.createMap();
		this.drawLayer();

		// Hide TCA-Tab again after map draw.
		var projectionChangedListener = google.maps.event.addListener(this.map, 'bounds_changed', function(event){
			if (tabHideAgain) tab.setVisibilityMode(Ext.Element.DISPLAY).hide().setStyle({ height: 'auto', overflow: 'auto' });
			google.maps.event.removeListener(projectionChangedListener);
		});
	},

	/**
	 * Creates the map on the map canvas.
	 *
	 * @return void
	 */
	createMap: function(){
		var canvas = Ext.getDom(this.canvasId);
		if (canvas === null){
			alert('Error TYPO3.Tx_AdGoogleMaps_MapDrawerApi.createMap(): Map container with ID "' + this.canvasId + '" not found.');
		} else {
			this.mapOptions.disableDoubleClickZoom = true;
			this.map = new google.maps.Map(canvas, this.mapOptions);
		}
	},

	/**
	 * Set marker position by given address.
	 *
	 * @param string address
	 * @return void
	 */
	setSearchMarker: function(address){
		var _this = this;
		this.geocoder.geocode({ 'address': address }, function(results, status){
			if (status == google.maps.GeocoderStatus.OK) {
				var searchMarkerInfoContent = 
					'<strong>Search:</strong> ' + address + '<br />' +
					'<strong>Latitude:</strong> ' + results[0].geometry.location.lat() + '<br />' +
					'<strong>Longitude:</strong> ' + results[0].geometry.location.lng() + '<br /><br />' +
					'<input type="button" onclick="javascript: ' + _this.objectId + '.addMarker(new google.maps.LatLng(' + results[0].geometry.location.toUrlValue() + ')); ' + _this.objectId + '.updateCoordinatesField(); return false;" value="Set Marker" /">';
				if (_this.searchMarker){
					_this.searchMarker.setPosition(results[0].geometry.location);
					_this.searchMarkerInfo.setContent(searchMarkerInfoContent);
					google.maps.event.trigger(_this.searchMarker, 'click');
				} else {
					var searchMarkerOptions = {
						map: _this.map,
						position: results[0].geometry.location,
						zIndex: google.maps.Marker.MAX_ZINDEX,
						icon: _this.markerIcon.address
					};
					_this.searchMarker = new google.maps.Marker(searchMarkerOptions);
					_this.searchMarkerInfo = new google.maps.InfoWindow({
						content: searchMarkerInfoContent
					});
					google.maps.event.addListener(_this.searchMarker, 'click', function() {
						_this.searchMarkerInfo.open(_this.map, _this.searchMarker);
					});
					google.maps.event.trigger(_this.searchMarker, 'click');
				}
				_this.map.setCenter(results[0].geometry.location);
			} else {
				alert('Error Geocode was not successful for the following reason: ' + status);
			}
		});
	},

	/**
	 * Returns a google.maps.LatLng object by given lat,lng string.
	 *
	 * @param string coordinates
	 * @return google.maps.LatLng
	 */
	getLatLng: function(coordinates){
		if (coordinates instanceof google.maps.LatLng)
			return coordinates;
		var lat = coordinates.split(',')[0];
		var lng = coordinates.split(',')[1];
		return new google.maps.LatLng(lat, lng);
	},

	/**
	 * Returns an array of google.maps.LatLng objects by given lat,lng string.
	 *
	 * @param mixed coordinates
	 * @return array
	 */
	getLatLngArray: function(coordinates){
		if (coordinates instanceof google.maps.LatLng)
			return [coordinates];
		var coordinates = coordinates.split("\n");
		var latLngs = [];
		Ext.each(coordinates, function(coordinate, index){
			if (coordinate){
				latLngs.push(this.getLatLng(coordinate));
			}
		}, this);
		return latLngs;
	}

});