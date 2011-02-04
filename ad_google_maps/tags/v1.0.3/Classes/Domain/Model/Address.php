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
 * Model: Address.
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 * @api
 */
class Tx_AdGoogleMaps_Domain_Model_Address extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $gender;

	/**
	 * @var string
	 */
	protected $firstName;

	/**
	 * @var string
	 */
	protected $middleName;

	/**
	 * @var string
	 */
	protected $lastName;

	/**
	 * @var DateTime
	 */
	protected $birthday;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $email;

	/**
	 * @var string
	 */
	protected $phone;

	/**
	 * @var string
	 */
	protected $mobile;

	/**
	 * @var string
	 */
	protected $www;

	/**
	 * @var string
	 */
	protected $address;

	/**
	 * @var string
	 */
	protected $building;

	/**
	 * @var string
	 */
	protected $room;

	/**
	 * @var string
	 */
	protected $company;

	/**
	 * @var string
	 */
	protected $city;

	/**
	 * @var string
	 */
	protected $zip;

	/**
	 * @var string
	 */
	protected $region;

	/**
	 * @var string
	 */
	protected $country;

	/**
	 * @var string
	 */
	protected $image;

	/**
	 * @var string
	 */
	protected $fax;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_AddressGroup>
	 * @lazy
	 */
	protected $addressgroup;

	/**
	 * @var string
	 */
	protected $txAdgooglemapsCoordinates;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->addressgroup = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Sets this name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns this name
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets this gender
	 *
	 * @param string $gender
	 * @return void
	 */
	public function setGender($gender) {
		$this->gender = $gender;
	}

	/**
	 * Returns this gender
	 *
	 * @return string
	 */
	public function getGender() {
		return $this->gender;
	}

	/**
	 * Sets this firstName
	 *
	 * @param string $firstName
	 * @return void
	 */
	public function setFirstName($firstName) {
		$this->firstName = $firstName;
	}

	/**
	 * Returns this firstName
	 *
	 * @return string
	 */
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	 * Sets this middleName
	 *
	 * @param string $middleName
	 * @return void
	 */
	public function setMiddleName($middleName) {
		$this->middleName = $middleName;
	}

	/**
	 * Returns this middleName
	 *
	 * @return string
	 */
	public function getMiddleName() {
		return $this->middleName;
	}

	/**
	 * Sets this lastName
	 *
	 * @param string $lastName
	 * @return void
	 */
	public function setLastName($lastName) {
		$this->lastName = $lastName;
	}

	/**
	 * Returns this lastName
	 *
	 * @return string
	 */
	public function getLastName() {
		return $this->lastName;
	}

	/**
	 * Sets this birthday
	 *
	 * @param DateTime $birthday
	 * @return void
	 */
	public function setBirthday(DateTime $birthday) {
		$this->birthday = $birthday;
	}

	/**
	 * Returns this birthday
	 *
	 * @return DateTime
	 */
	public function getBirthday() {
		return $this->birthday;
	}

	/**
	 * Sets this title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns this title
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets this email
	 *
	 * @param string $email
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * Returns this email
	 *
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Sets this phone
	 *
	 * @param string $phone
	 * @return void
	 */
	public function setPhone($phone) {
		$this->phone = $phone;
	}

	/**
	 * Returns this phone
	 *
	 * @return string
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * Sets this mobile
	 *
	 * @param string $mobile
	 * @return void
	 */
	public function setMobile($mobile) {
		$this->mobile = $mobile;
	}

	/**
	 * Returns this mobile
	 *
	 * @return string
	 */
	public function getMobile() {
		return $this->mobile;
	}

	/**
	 * Sets this www
	 *
	 * @param string $www
	 * @return void
	 */
	public function setWww($www) {
		$this->www = $www;
	}

	/**
	 * Returns this www
	 *
	 * @return string
	 */
	public function getWww() {
		return $this->www;
	}

	/**
	 * Sets this address
	 *
	 * @param string $address
	 * @return void
	 */
	public function setAddress($address) {
		$this->address = $address;
	}

	/**
	 * Returns this address
	 *
	 * @return string
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * Sets this building
	 *
	 * @param string $building
	 * @return void
	 */
	public function setBuilding($building) {
		$this->building = $building;
	}

	/**
	 * Returns this building
	 *
	 * @return string
	 */
	public function getBuilding() {
		return $this->building;
	}

	/**
	 * Sets this room
	 *
	 * @param string $room
	 * @return void
	 */
	public function setRoom($room) {
		$this->room = $room;
	}

	/**
	 * Returns this room
	 *
	 * @return string
	 */
	public function getRoom() {
		return $this->room;
	}

	/**
	 * Sets this company
	 *
	 * @param string $company
	 * @return void
	 */
	public function setCompany($company) {
		$this->company = $company;
	}

	/**
	 * Returns this company
	 *
	 * @return string
	 */
	public function getCompany() {
		return $this->company;
	}

	/**
	 * Sets this city
	 *
	 * @param string $city
	 * @return void
	 */
	public function setCity($city) {
		$this->city = $city;
	}

	/**
	 * Returns this city
	 *
	 * @return string
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * Sets this zip
	 *
	 * @param string $zip
	 * @return void
	 */
	public function setZip($zip) {
		$this->zip = $zip;
	}

	/**
	 * Returns this zip
	 *
	 * @return string
	 */
	public function getZip() {
		return $this->zip;
	}

	/**
	 * Sets this region
	 *
	 * @param string $region
	 * @return void
	 */
	public function setRegion($region) {
		$this->region = $region;
	}

	/**
	 * Returns this region
	 *
	 * @return string
	 */
	public function getRegion() {
		return $this->region;
	}

	/**
	 * Sets this country
	 *
	 * @param string $country
	 * @return void
	 */
	public function setCountry($country) {
		$this->country = $country;
	}

	/**
	 * Returns this country
	 *
	 * @return string
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * Sets this image
	 *
	 * @param string $image
	 * @return void
	 */
	public function setImage($image) {
		$this->image = $image;
	}

	/**
	 * Returns this image
	 *
	 * @return string
	 */
	public function getImage() {
		return explode(',', $this->image);
	}

	/**
	 * Sets this fax
	 *
	 * @param string $fax
	 * @return void
	 */
	public function setFax($fax) {
		$this->fax = $fax;
	}

	/**
	 * Returns this fax
	 *
	 * @return string
	 */
	public function getFax() {
		return $this->fax;
	}

	/**
	 * Sets this description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns this description
	 *
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets this addressgroup
	 * 
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_AddressGroup> $addressgroup 
	 */
	public function setAddressgroup(Tx_Extbase_Persistence_ObjectStorage $addressgroup) {
		$this->addressgroup = $addressgroup;
	}

	/**
	 * Returns this addressgroup
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_AddressGroup>
	 */
	public function getAddressgroup() {
		if ($this->addressgroup instanceof Tx_Extbase_Persistence_LazyLoadingProxy) {
			$this->addressgroup->_loadRealInstance();
		}
		return $this->addressgroup;
	}

	/**
	 * Sets this txAdgooglemapsCoordinates
	 *
	 * @param string $txAdgooglemapsCoordinates
	 * @return void
	 */
	public function setTxAdgooglemapsCoordinates($txAdgooglemapsCoordinates) {
		$this->txAdgooglemapsCoordinates = $txAdgooglemapsCoordinates;
	}

	/**
	 * Returns this txAdgooglemapsCoordinates
	 *
	 * @return string
	 */
	public function getTxAdgooglemapsCoordinates() {
		return $this->txAdgooglemapsCoordinates;
	}

}

?>