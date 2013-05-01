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
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @api
 */
class Tx_AdGoogleMaps_Api_Layer_Marker extends Tx_AdGoogleMaps_Api_Layer_AbstractLayer {

	/**
	 * @var Tx_AdGoogleMaps_Api_Map
	 * @javaScriptHelper dontSetValue = TRUE
	 */
	protected $map;

	/**
	 * @var string
	 * @javaScriptHelper dontSetIfValueIs = ''
	 */
	protected $title;

	/**
	 * @var Tx_AdGoogleMaps_Api_LatLng
	 * @javaScriptHelper getFunction = __toString
	 */
	protected $position;

	/**
	 * @var boolean
	 * @javaScriptHelper dontSetIfValueIs = TRUE
	 */
	protected $visible;

	/**
	 * @var boolean
	 * @javaScriptHelper dontSetIfValueIs = TRUE
	 */
	protected $clickable;

	/**
	 * @var boolean
	 * @javaScriptHelper dontSetIfValueIs = FALSE
	 */
	protected $draggable;

	/**
	 * @var boolean
	 * @javaScriptHelper dontSetIfValueIs = FALSE
	 */
	protected $raiseOnDrag;

	/**
	 * @var integer
	 * @javaScriptHelper dontSetIfValueIs = 0
	 */
	protected $zindex;

	/**
	 * @var Tx_AdGoogleMaps_Api_MarkerImage
	 * @javaScriptHelper getFunction = __toString; dontSetIfValueIs = 'null'
	 */
	protected $icon;

	/**
	 * @var Tx_AdGoogleMaps_Api_MarkerImage
	 * @javaScriptHelper getFunction = __toString; dontSetIfValueIs = 'null'
	 */
	protected $shadow;

	/**
	 * @var boolean
	 * @javaScriptHelper dontSetIfValueIs = FALSE
	 */
	protected $flat;

	/**
	 * @var Tx_AdGoogleMaps_Api_MarkerShape
	 * @javaScriptHelper getFunction = __toString; dontSetIfValueIs = 'null'
	 */
	protected $shape;

	/**
	 * @var string
	 * @javaScriptHelper dontSetIfValueIs = ''
	 */
	protected $cursor;

	/**
	 * Sets this map.
	 *
	 * @param Tx_AdGoogleMaps_Api_Map $map
	 * @return Tx_AdGoogleMaps_Api_Layer_Marker
	 */
	public function setMap($map) {
		$this->map = $map;
		return $this;
	}

	/**
	 * Returns this map.
	 *
	 * @return Tx_AdGoogleMaps_Api_Map
	 */
	public function getMap() {
		return $this->map;
	}

	/**
	 * Sets this title.
	 *
	 * @param string $title
	 * @return Tx_AdGoogleMaps_Api_Layer_Marker
	 */
	public function setTitle($title) {
		$this->title = $title;
		return $this;
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
	 * Sets this position.
	 *
	 * @param Tx_AdGoogleMaps_Api_LatLng $position
	 * @return Tx_AdGoogleMaps_Api_Layer_Marker
	 */
	public function setPosition(Tx_AdGoogleMaps_Api_LatLng $position) {
		$this->position = $position;
		return $this;
	}

	/**
	 * Returns this position.
	 *
	 * @return Tx_AdGoogleMaps_Api_LatLng
	 */
	public function getPosition() {
		return $this->position;
	}

	/**
	 * Sets this visible.
	 *
	 * @param boolean $visible
	 * @return Tx_AdGoogleMaps_Api_Layer_Marker
	 */
	public function setVisible($visible) {
		$this->visible = (boolean) $visible;
		return $this;
	}

	/**
	 * Returns this visible.
	 *
	 * @return boolean
	 */
	public function isVisible() {
		return (boolean) $this->visible;
	}

	/**
	 * Sets this clickable.
	 *
	 * @param boolean $clickable
	 * @return Tx_AdGoogleMaps_Api_Layer_Marker
	 */
	public function setClickable($clickable) {
		$this->clickable = (boolean) $clickable;
		return $this;
	}

	/**
	 * Returns this clickable.
	 *
	 * @return boolean
	 */
	public function isClickable() {
		return (boolean) $this->clickable;
	}

	/**
	 * Sets this draggable.
	 *
	 * @param boolean $draggable
	 * @return Tx_AdGoogleMaps_Api_Layer_Marker
	 */
	public function setDraggable($draggable) {
		$this->draggable = (boolean) $draggable;
		return $this;
	}

	/**
	 * Returns this draggable.
	 *
	 * @return boolean
	 */
	public function isDraggable() {
		return (boolean) $this->draggable;
	}

	/**
	 * Sets this raiseOnDrag.
	 *
	 * @param boolean $raiseOnDrag
	 * @return Tx_AdGoogleMaps_Api_Layer_Marker
	 */
	public function setRaiseOnDrag($raiseOnDrag) {
		$this->raiseOnDrag = (boolean) $raiseOnDrag;
		return $this;
	}

	/**
	 * Returns this raiseOnDrag.
	 *
	 * @return boolean
	 */
	public function isRaiseOnDrag() {
		return (boolean) ($this->isDraggable() === TRUE && $this->raiseOnDrag === TRUE);
	}

	/**
	 * Sets this zindex.
	 *
	 * @param integer $zindex
	 * @return Tx_AdGoogleMaps_Api_Layer_Marker
	 */
	public function setZindex($zindex) {
		$this->zindex = (integer) $zindex;
		return $this;
	}

	/**
	 * Returns this zindex.
	 *
	 * @return integer
	 */
	public function getZindex() {
		return (integer) $this->zindex;
	}

	/**
	 * Sets this icon.
	 *
	 * @param Tx_AdGoogleMaps_Api_MarkerImage $icon
	 * @return Tx_AdGoogleMaps_Api_Layer_Marker
	 */
	public function setIcon(Tx_AdGoogleMaps_Api_MarkerImage $icon) {
		$this->icon = $icon;
		return $this;
	}

	/**
	 * Returns this icon.
	 *
	 * @return Tx_AdGoogleMaps_Api_MarkerImage
	 */
	public function getIcon() {
		return $this->icon;
	}

	/**
	 * Sets this shadow.
	 *
	 * @param Tx_AdGoogleMaps_Api_MarkerImage $shadow
	 * @return Tx_AdGoogleMaps_Api_Layer_Marker
	 */
	public function setShadow(Tx_AdGoogleMaps_Api_MarkerImage $shadow) {
		$this->shadow = $shadow;
		return $this;
	}

	/**
	 * Returns this shadow.
	 *
	 * @return Tx_AdGoogleMaps_Api_MarkerImage
	 */
	public function getShadow() {
		return $this->shadow;
	}

	/**
	 * Sets this flat.
	 *
	 * @param boolean $flat
	 * @return Tx_AdGoogleMaps_Api_Layer_Marker
	 */
	public function setFlat($flat) {
		$this->flat = (boolean) $flat;
		return $this;
	}

	/**
	 * Returns this flat.
	 *
	 * @return boolean
	 */
	public function isFlat() {
		return (boolean) $this->flat;
	}

	/**
	 * Sets this shape.
	 *
	 * @param Tx_AdGoogleMaps_Api_MarkerShape $shape
	 * @return Tx_AdGoogleMaps_Api_Layer_Marker
	 */
	public function setShape(Tx_AdGoogleMaps_Api_MarkerShape $shape) {
		$this->shape = $shape;
		return $this;
	}

	/**
	 * Returns this shape.
	 *
	 * @return Tx_AdGoogleMaps_Api_MarkerShape
	 */
	public function getShape() {
		return $this->shape;
	}

	/**
	 * Sets this cursor
	 *
	 * @param string $cursor
	 * @return Tx_AdGoogleMaps_Api_Layer_Marker
	 */
	public function setCursor($cursor) {
		$this->cursor = $cursor;
		return $this;
	}

	/**
	 * Returns this cursor
	 *
	 * @return string
	 */
	public function getCursor() {
		return $this->cursor;
	}

	/**
	 * Returns the marker as JavaScript string.
	 *
	 * @return string
	 */
	public function getPrint() {
		return 'new google.maps.Marker(' . $this->getPrintOptions() . ')';
	}

}

?>