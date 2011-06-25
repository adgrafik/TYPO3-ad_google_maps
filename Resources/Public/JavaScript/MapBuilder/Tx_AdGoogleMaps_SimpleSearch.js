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
 * Simple search Extension.
 */
Tx_AdGoogleMaps_MapBuilder.prototype.geocoder = new google.maps.Geocoder();
Tx_AdGoogleMaps_MapBuilder.prototype.searchMarker = null;

Tx_AdGoogleMaps_MapBuilder.prototype.searchByAddress = function(address){
	var _this = this;
	this.geocoder.geocode({ 'address': address }, function(results, status){
		if (status == google.maps.GeocoderStatus.OK) {
			if (_this.searchMarker === null){
				var searchMarkerOptions = {
					map: _this.map,
					position: results[0].geometry.location,
					zIndex: google.maps.Marker.MAX_ZINDEX,
					icon: _this.mapControl.searchMarker
				};
				_this.searchMarker = new google.maps.Marker(searchMarkerOptions);
			} else {
				_this.searchMarker.setPosition(results[0].geometry.location);
			}
			_this.map.panTo(results[0].geometry.location);
		} else {
			alert('Warning: Geocode search was not successful for the following reason: ' + status);
			console.log('Warning Tx_AdGoogleMaps_MapBuilder.searchByAddress(): Geocode was not successful for the following reason: ' + status);
		}
	});
};