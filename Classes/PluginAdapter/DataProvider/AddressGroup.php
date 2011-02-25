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
 * Data provider for address group.
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_AdGoogleMaps_PluginAdapter_DataProvider_AddressGroup extends Tx_AdGoogleMaps_PluginAdapter_DataProvider_Addresses {

	/**
	 * Loads the data and the coordinates.
	 *
	 * @return void
	 */
	public function load() {
		$layer = $this->layerBuilder->getLayer();

		// Load addresses of address groups and call loadCoordinates of address coordinates provider.
		$addressGroupRepository = t3lib_div::makeInstance('Tx_AdGoogleMaps_Domain_Repository_AddressGroupRepository');
		$this->addresses = $addressGroupRepository->getAddressesRecursively($layer->getAddressGroups());

		parent::load();
	}

}

?>