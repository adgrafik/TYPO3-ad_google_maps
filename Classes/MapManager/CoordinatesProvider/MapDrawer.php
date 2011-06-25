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
 * Coordinates provider for the MapDrawer.
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_AdGoogleMaps_MapManager_CoordinatesProvider_MapDrawer extends Tx_AdGoogleMaps_MapManager_CoordinatesProvider_AbstractCoordinatesProvider {

	/**
	 * Loads the data and the coordinates.
	 *
	 * @return void
	 */
	public function load() {
		$layer = $this->layerBuilder->getLayer();

		// Get info window data.
		$loadDB = t3lib_div::makeInstance('FE_loadDBGroup');
		$loadDB->start($layer->getInfoWindow(), 'tt_content', 'tx_adgooglemaps_layer_ttcontent_mm');
		$loadDB->readMM('tx_adgooglemaps_layer_ttcontent_mm', $layer->getUid());
		$loadDB->getFromDB();

		foreach ($loadDB->itemArray as $itemArray) {
			$contentData = $loadDB->results['tt_content'][$itemArray['id']];
			$this->data[] = $contentData;
		}

		// Set coordinates.
		$coordinates = $layer->getCoordinates();
		$this->coordinates = t3lib_div::removeArrayEntryByValue(t3lib_div::trimExplode(LF, $coordinates), '');
	}

}

?>