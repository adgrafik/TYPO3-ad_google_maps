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
 * Repository: AddressGroup.
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_AdGoogleMaps_Domain_Repository_AddressGroupRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * Returns the addresses of the group recursively.
	 *
	 * @param mixed $addressGroups
	 * @param integer $level
	 * @return array
	 */
	public function getAddressesRecursively($addressGroups, $level = 0) {
		// Search addresses.
		$addressRepository = t3lib_div::makeInstance('Tx_AdGoogleMaps_Domain_Repository_AddressRepository');
		$query = $addressRepository->createQuery();
		$groupAddresses = $query->matching($query->in('addressgroup.uid', $addressGroups))
#			->setOrderings(array('lastName' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING))
			->execute();
		$addresses = $groupAddresses;
		// Search sub groups.
		$query = $this->createQuery();
		$addressSubGroups = $query->matching($query->in('parentGroup', $addressGroups))
#			->setOrderings(array('title' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING))
			->execute();
		if (count($addressSubGroups) && $level < 99) {
			array_merge($addresses, $this->getAddressesRecursively($addressSubGroups, $level++));
		}

		return $addresses;
	}

}
?>