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
 * Model: Category.
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 * @api
 */
class Tx_AdGoogleMaps_Domain_Model_Category extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $icon;

	/**
	 * @var integer
	 */
	protected $iconWidth;

	/**
	 * @var integer
	 */
	protected $iconHeight;

    /**
     * @var string
     */
    protected $description;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_Layer>
	 * @lazy
	 */
	protected $layers;

	/**
	 * @var Tx_AdGoogleMaps_Domain_Model_Category
	 */
	protected $parentCategory;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_Category>
	 */
	protected $subCategories;

	/*
	 * Initialize this category.
	 * 
	 * @return void
	 */
	public function initializeObject() {
		// Set default values.
		$this->layers = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/*
	 * Constructs this category.
	 */
	public function __construct() {
		$this->initializeObject();
	}

	/**
	 * Sets this title.
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns this title.
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets this icon.
	 *
	 * @param string $icon
	 * @return void
	 */
	public function setIcon($icon) {
		$this->icon = $icon;
	}

	/**
	 * Returns this icon.
	 *
	 * @return string
	 */
	public function getIcon() {
		return Tx_AdGoogleMaps_Tools_BackEnd::getFileRelativeFileName('categoryIcons', $this->icon);
	}

	/**
	 * Sets this iconWidth.
	 *
	 * @param integer $iconWidth
	 * @return void
	 */
	public function setIconWidth($iconWidth) {
		$this->iconWidth = $iconWidth;
	}

	/**
	 * Returns this iconWidth.
	 *
	 * @return integer
	 */
	public function getIconWidth() {
		return (integer) $this->iconWidth;
	}

	/**
	 * Sets this iconHeight.
	 *
	 * @param integer $iconHeight
	 * @return void
	 */
	public function setIconHeight($iconHeight) {
		$this->iconHeight = $iconHeight;
	}

	/**
	 * Returns this iconHeight.
	 *
	 * @return integer
	 */
	public function getIconHeight() {
		return (integer) $this->iconHeight;
	}

	/**
	 * Sets this description.
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns this description.
	 *
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets this layers.
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_Layer> $layers
	 * @return void
	 */
	public function setLayers(Tx_Extbase_Persistence_ObjectStorage $layers) {
		$this->layers = $layers;
	}

	/**
	 * Returns this layers.
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_Layer>
	 */
	public function getLayers() {
		if ($this->layers instanceof Tx_Extbase_Persistence_LazyLoadingProxy) {
			$this->layers->_loadRealInstance();
		}
		return $this->layers;
	}

	/**
	 * Sets this parentCategory.
	 *
	 * @param Tx_AdGoogleMaps_Domain_Model_Category $parentCategory
	 * @return void
	 */
	public function setParentCategory(Tx_AdGoogleMaps_Domain_Model_Category $parentCategory) {
		$this->parentCategory = $parentCategory;
	}

	/**
	 * Returns this parentCategory.
	 *
	 * @return Tx_AdGoogleMaps_Domain_Model_Category
	 */
	public function getParentCategory() {
		return $this->parentCategory;
	}

	/**
	 * Returns the subCategories.
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_AdGoogleMaps_Domain_Model_Category>
	 */
	public function getSubCategories() {
		$categoryRepository = t3lib_div::makeInstance('Tx_AdGoogleMaps_Domain_Repository_CategoryRepository');
		return $categoryRepository->findSubCategories($this);
	}

}

?>