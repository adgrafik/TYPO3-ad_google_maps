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
 * Model: Layer.
 * Nearly the same like the Google Maps API
 * @see http://code.google.com/apis/maps/documentation/javascript/reference.html
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 * @api
 */
class Tx_AdGoogleMaps_Domain_Model_Layer extends Tx_Extbase_DomainObject_AbstractEntity implements Tx_AdGoogleMaps_Domain_Model_Layer_LayerInterface {

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $coordinatesProvider;

	/**
	 * @var string
	 */
	protected $coordinates;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_Category>
	 * @lazy
	 */
	protected $categories;

	/**
	 * @var SplObjectStorage<Tx_AdGoogleMaps_Domain_Model_Item>
	 */
	protected $items;

	/*
	 * Initialize this layer.
	 * 
	 * @return void
	 */
	public function initializeObject() {
		// Set default values.
		$this->items = new SplObjectStorage();
		$this->categories = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/*
	 * Constructs this layer.
	 */
	public function __construct() {
		$this->initializeObject();
	}

	/**
	 * Sets this type
	 *
	 * @param string $type
	 * @return void
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * Returns this type
	 *
	 * @return string
	 */
	public function getType() {
		return $this->type;
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
	 * Sets this coordinatesProvider
	 *
	 * @param string $coordinatesProvider
	 * @return void
	 */
	public function setCoordinatesProvider($coordinatesProvider) {
		$this->coordinatesProvider = $coordinatesProvider;
	}

	/**
	 * Returns this coordinatesProvider
	 *
	 * @return string
	 */
	public function getCoordinatesProvider() {
		return $this->coordinatesProvider;
	}

	/**
	 * Sets this coordinates
	 *
	 * @param string $coordinates
	 * @return void
	 */
	public function setCoordinates($coordinates) {
		$this->coordinates = $coordinates;
	}

	/**
	 * Returns this coordinates
	 *
	 * @return string
	 */
	public function getCoordinates() {
		return $this->coordinates;
	}

	/**
	 * Sets this categories
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_Category> $categories
	 * @return void
	 */
	public function setCategories(Tx_Extbase_Persistence_ObjectStorage $categories) {
		$this->categories = $categories;
	}

	/**
	 * Returns this categories
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_Category>
	 */
	public function getCategories() {
		if ($this->categories instanceof Tx_Extbase_Persistence_LazyLoadingProxy) {
			$this->categories->_loadRealInstance();
		}
		return $this->categories;
	}

	/**
	 * Sets this items
	 *
	 * @param SplObjectStorage<Tx_AdGoogleMaps_Domain_Model_Item> $items
	 * @return void
	 */
	public function setItems(SplObjectStorage $items) {
		$this->items = $items;
	}

	/**
	 * Adds an item to this items.
	 *
	 * @param SplObjectStorage<Tx_AdGoogleMaps_Domain_Model_Item> $items
	 * @return void
	 */
	public function addItem(Tx_AdGoogleMaps_Domain_Model_Item $item) {
		$this->items->attach($item);
	}

	/**
	 * Adds items to this items.
	 *
	 * @param SplObjectStorage<Tx_AdGoogleMaps_Domain_Model_Item> $items
	 * @return void
	 */
	public function addItems(SplObjectStorage $items) {
		$this->items->addAll($items);
	}

	/**
	 * Returns this items
	 *
	 * @return SplObjectStorage<Tx_AdGoogleMaps_Domain_Model_Item>
	 */
	public function getItems() {
		return $this->items;
	}

}

?>