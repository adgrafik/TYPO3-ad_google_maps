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
 * The TCA service MapDrawer. 
 *
 * @package Extbase
 * @subpackage GoogleMaps\MapDrawer
 * @scope prototype
 * @entity
 * @api
 */
class Tx_AdGoogleMaps_MapDrawer_Layer_Marker extends Tx_AdGoogleMaps_MapDrawer_Layer_AbstractLayer {

	/**
	 * User function for Google Maps database fields. 
	 *
	 * @return void
	 */
	public function draw() {
		$this->mapDrawerOptions['onlyOneMarker'] = 'onlyOneMarker: ' . ((array_key_exists('onlyOneMarker', $this->recordTypeConfiguration) === TRUE && (boolean) $this->recordTypeConfiguration['onlyOneMarker'] === TRUE) ? 'true' : 'false');
		$this->mapDrawerOptions['fitBoundsOnLoad'] = 'fitBoundsOnLoad: ' . ((array_key_exists('fitBoundsOnLoad', $this->recordTypeConfiguration) === TRUE && (boolean) $this->recordTypeConfiguration['fitBoundsOnLoad'] === TRUE) ? 'true' : 'false');
	}

}

?>