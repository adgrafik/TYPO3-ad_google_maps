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
TYPO3.Tx_AdGoogleMaps_MapDrawer_Layer_Marker = Ext.extend(TYPO3.Tx_AdGoogleMaps_MapDrawer_AbstractLayer, {

	onlyOneMarker: false,
	fitBoundsOnLoad: false,
	latlngs: null,
	markers: null,

	/**
	 * Constructor
	 *
	 * @param object options
	 * @return void
	 */
	constructor: function(options){
		// Call parent constructor to initialize the map.
		TYPO3.Tx_AdGoogleMaps_MapDrawer_Layer_Marker.superclass.constructor.call(this, options);

		var _this = this;

		if (this.fitBoundsOnLoad === true){
			var bounds = new google.maps.LatLngBounds();
			this.latlngs.forEach(function(latlng, index){
				bounds.extend(latlng);
			});
			if (bounds.isEmpty() === false) this.map.fitBounds(bounds);
		}

		// Set callback for search.
		this.searchMarkerCallback = this.addMarker;

		// Add click listener to the map.
		google.maps.event.addListener(this.map, 'click', function(event){
			if (_this.onlyOneMarker === true && _this.latlngs.getLength()){
				_this.removeMarkerAt(0);
			}
			_this.addMarker(event.latLng);
			_this.updateCoordinatesField();
		});
	},

	/**
	 * Load markers from coordinates field.
	 *
	 * @param boolean resetMap
	 * @return void
	 */
	drawLayer: function(resetMap){
		if (resetMap){
			var _this = this;
			this.markers.forEach(function(marker, index){
				marker.setMap(null);
			});
		}

		this.latlngs = new google.maps.MVCArray(); // Reset this.markers.
		this.markers = new google.maps.MVCArray(); // Reset this.markers.
		var coordinatesFieldValue = this.coordinatesField.getValue().split("\n");
		Ext.each(coordinatesFieldValue, function(coordinate, index){
			var match = coordinate.match(/-?\d+\.?\d*,-?\d+\.?\d*/);
			if (match){
				latlng = this.getLatLng(match[0]);
				this.addMarker(latlng);
			}
		}, this);

		this.updateCoordinatesField();
	},

	/**
	 * Create a new draggable marker.
	 *
	 * @param google.maps.LatLng latLng
	 * @return void
	 */
	addMarker: function(coordinate, markerOptionsOverride){
		var index = this.latlngs.push(this.getLatLng(coordinate)) - 1;
		var markerOptions = {
			map: this.map,
			position: this.latlngs.getAt(index),
			draggable: true
		};
		Ext.apply(markerOptions, markerOptionsOverride);

		var marker = new google.maps.Marker(markerOptions);
		this.markers.push(marker);

		var _this = this;
		// Set drag function to update coordinates field on marker.
		var onDrag = function(event){
			_this.updateCoordinatesField();
		}
		google.maps.event.addListener(marker, 'dragend', onDrag);
		google.maps.event.addListener(marker, 'drag', onDrag);

		// Set double click function to remove marker.
		var onDblClick = function(event){
			var marker = this;
			_this.markers.forEach(function(element, index){
				if (element === marker){
					_this.removeMarkerAt(index);
				}
			});
			_this.updateCoordinatesField();
		}
		google.maps.event.addListener(marker, 'dblclick', onDblClick);
	},

	/**
	 * Removes a marker by given index.
	 *
	 * @param integer index
	 * @return void
	 */
	removeMarkerAt: function(index){
		this.markers.getAt(index).setMap(null);
		this.markers.removeAt(index);
		this.latlngs.removeAt(index);
	},

	/**
	 * Event function on click the map.
	 *
	 * @return void
	 */
	updateCoordinatesField: function(){
		var _this = this;
		var coordinates = [];
		this.latlngs.clear(); // Reset this.markers.
		this.markers.forEach(function(marker, index){
			var latlng = marker.getPosition();
			_this.latlngs.push(latlng);
			coordinates.push(latlng.toUrlValue());
		});
		this.coordinatesField.dom.value = coordinates.join("\n");
	}

});