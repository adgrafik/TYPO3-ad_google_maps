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
 * Google Maps API class.
 * Nearly the same like the Google Maps API
 * @see http://code.google.com/apis/maps/documentation/javascript/reference.html
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @package AdGoogleMaps
 */
class Tx_AdGoogleMaps_MapBuilder_API_Control_OverviewMap extends Tx_AdGoogleMaps_MapBuilder_API_Control_AbstractControl {

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs( FALSE )
	 */
	protected $opened;

	/**
	 * Constructor.
	 * 
	 * @param boolean $opened
	 */
	public function __construct($opened = FALSE) {
		$this->setOpened($opened);
	}

	/**
	 * Sets this opened.
	 *
	 * @param string $opened
	 * @return void
	 */
	public function setOpened($opened) {
		$this->opened = $opened;
	}

	/**
	 * Returns this opened.
	 *
	 * @return string
	 */
	public function isOpened() {
		return $this->opened;
	}

	/**
	 * Returns TRUE if one of the option have not a default value.
	 *
	 * @return string
	 */
	public function hasOptions() {
		return $this->isOpened();
	}

}

?>