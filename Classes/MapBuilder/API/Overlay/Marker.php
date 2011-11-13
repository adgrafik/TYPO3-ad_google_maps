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
class Tx_AdGoogleMaps_MapBuilder_API_Overlay_Marker extends Tx_AdGoogleMaps_MapBuilder_API_Overlay_AbstractOverlay {

	/**
	 * Animation
	 */
	const ANIMATION_DROP = 'google.maps.Animation.DROP';
	const ANIMATION_BOUNCE = 'google.maps.Animation.BOUNCE';

	/**
	 * @var Tx_AdGoogleMaps_MapBuilder_API_Map_Map
	 * @jsonClassEncoder ignoreProperty
	 */
	protected $map;

	/**
	 * @var string
	 * @jsonClassEncoder ignorePropertyIfValueIs( )
	 */
	protected $title;

	/**
	 * @var Tx_AdGoogleMaps_MapBuilder_API_Base_LatLng
	 * @jsonClassEncoder useGetterMethod( getPrint )
	 */
	protected $position;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs( TRUE )
	 */
	protected $visible;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs( TRUE )
	 */
	protected $clickable;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs( FALSE )
	 */
	protected $draggable;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs( FALSE )
	 */
	protected $raiseOnDrag;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs( TRUE )
	 */
	protected $optimized;

	/**
	 * @var string
	 * @jsonClassEncoder ignorePropertyIfValueIs( )
	 * @jsonClassEncoder quoteValue( FALSE )
	 */
	protected $animation;

	/**
	 * @var integer
	 * @jsonClassEncoder ignorePropertyIfValueIs( 0 )
	 */
	protected $zindex;

	/**
	 * @var Tx_AdGoogleMaps_MapBuilder_API_Overlay_MarkerImage
	 * @jsonClassEncoder useGetterMethod( getPrint )
	 * @jsonClassEncoder ignorePropertyIfValueIs( 'null' )
	 */
	protected $icon;

	/**
	 * @var Tx_AdGoogleMaps_MapBuilder_API_Overlay_MarkerImage
	 * @jsonClassEncoder useGetterMethod( getPrint )
	 * @jsonClassEncoder ignorePropertyIfValueIs( 'null' )
	 */
	protected $shadow;

	/**
	 * @var boolean
	 * @jsonClassEncoder ignorePropertyIfValueIs( FALSE )
	 */
	protected $flat;

	/**
	 * @var Tx_AdGoogleMaps_MapBuilder_API_Overlay_MarkerShape
	 * @jsonClassEncoder useGetterMethod( getPrint )
	 * @jsonClassEncoder ignorePropertyIfValueIs( 'null' )
	 */
	protected $shape;

	/**
	 * @var string
	 * @jsonClassEncoder ignorePropertyIfValueIs( )
	 */
	protected $cursor;

	/**
	 * Constructor.
	 * 
	 * @param array $options
	 * @throws Tx_AdGoogleMaps_MapBuilder_API_Exception
	 */
	public function __construct(array $options = NULL) {
		// Set default values.
		$this->visible = TRUE;
		$this->clickable = TRUE;
		$this->optimized = TRUE;

		$this->mergeOptionsWithObject($options);

		// Check required attibutes.
		if ($this->position === NULL) {
#			throw new Tx_AdGoogleMaps_MapBuilder_API_Exception(sprintf('Required attribute "%s" not set.', 'position'), 1311314733);
		}
	}

	/**
	 * Sets this map.
	 *
	 * @param Tx_AdGoogleMaps_MapBuilder_API_Map_Map $map
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_Marker
	 */
	public function setMap($map) {
		$this->map = $map;
		return $this;
	}

	/**
	 * Returns this map.
	 *
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Map_Map
	 */
	public function getMap() {
		return $this->map;
	}

	/**
	 * Sets this title.
	 *
	 * @param string $title
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_Marker
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
	 * @param Tx_AdGoogleMaps_MapBuilder_API_Base_LatLng $position
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_Marker
	 */
	public function setPosition(Tx_AdGoogleMaps_MapBuilder_API_Base_LatLng $position) {
		$this->position = $position;
		return $this;
	}

	/**
	 * Returns this position.
	 *
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Base_LatLng
	 */
	public function getPosition() {
		return $this->position;
	}

	/**
	 * Sets this visible.
	 *
	 * @param boolean $visible
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_Marker
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
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_Marker
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
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_Marker
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
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_Marker
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
	 * Sets this optimized.
	 *
	 * @param boolean $optimized
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_Marker
	 */
	public function setOptimized($optimized) {
		$this->optimized = (boolean) $optimized;
		return $this;
	}

	/**
	 * Returns this optimized.
	 *
	 * @return boolean
	 */
	public function isOptimized() {
		return (boolean) $this->optimized;
	}

	/**
	 * Sets this animation.
	 *
	 * @param string $animation
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_Marker
	 */
	public function setAnimation($animation) {
		$this->animation = $animation;
		return $this;
	}

	/**
	 * Returns this animation.
	 *
	 * @return string
	 */
	public function getAnimation() {
		return $this->animation;
	}

	/**
	 * Sets this zindex.
	 *
	 * @param integer $zindex
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_Marker
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
	 * @param Tx_AdGoogleMaps_MapBuilder_API_Overlay_MarkerImage $icon
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_Marker
	 */
	public function setIcon(Tx_AdGoogleMaps_MapBuilder_API_Overlay_MarkerImage $icon) {
		$this->icon = $icon;
		return $this;
	}

	/**
	 * Returns this icon.
	 *
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_MarkerImage
	 */
	public function getIcon() {
		return $this->icon;
	}

	/**
	 * Sets this shadow.
	 *
	 * @param Tx_AdGoogleMaps_MapBuilder_API_Overlay_MarkerImage $shadow
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_Marker
	 */
	public function setShadow(Tx_AdGoogleMaps_MapBuilder_API_Overlay_MarkerImage $shadow) {
		$this->shadow = $shadow;
		return $this;
	}

	/**
	 * Returns this shadow.
	 *
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_MarkerImage
	 */
	public function getShadow() {
		return $this->shadow;
	}

	/**
	 * Sets this flat.
	 *
	 * @param boolean $flat
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_Marker
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
	 * @param Tx_AdGoogleMaps_MapBuilder_API_Overlay_MarkerShape $shape
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_Marker
	 */
	public function setShape(Tx_AdGoogleMaps_MapBuilder_API_Overlay_MarkerShape $shape) {
		$this->shape = $shape;
		return $this;
	}

	/**
	 * Returns this shape.
	 *
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_MarkerShape
	 */
	public function getShape() {
		return $this->shape;
	}

	/**
	 * Sets this cursor
	 *
	 * @param string $cursor
	 * @return Tx_AdGoogleMaps_MapBuilder_API_Overlay_Marker
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