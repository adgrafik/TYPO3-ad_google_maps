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
 * @package AdGoogleMaps
 * @subpackage GoogleMaps\MapDrawer
 * @scope prototype
 * @entity
 * @api
 */
abstract class Tx_AdGoogleMaps_MapDrawer_Layer_AbstractLayer {

	/**
	 * @var array
	 */
	protected $currentField;

	/**
	 * @var t3lib_TCEforms
	 */
	protected $formObject;

	/**
	 * @var array
	 */
	protected $recordTypeConfiguration;

	/**
	 * @var Tx_Fluid_View_TemplateView
	 */
	protected $view;

	/**
	 * @var array
	 */
	protected $mapDrawerOptions;

	/**
	 * @var string
	 */
	protected $objectId;

	/**
	 * @var array
	 */
	protected $mapOptions;

	/**
	 * Constructor.
	 *
	 * @throws Tx_AdGoogleMaps_MapDrawer_Exception
	 */
	public function __construct($currentField, $formObject, $recordTypeConfiguration) {
		$this->currentField = $currentField;
		$this->formObject = $formObject;
		$this->recordTypeConfiguration = $recordTypeConfiguration;

		// Check database field. If field name is not in the database throw an error.
		if (array_key_exists($this->recordTypeConfiguration['columnsMapping']['coordinates'], $this->currentField['row']) === FALSE) {
			throw new Tx_AdGoogleMaps_MapDrawer_Exception('Field "coordinates" ("' . $this->recordTypeConfiguration['columnsMapping']['coordinates'] . '") is not a database field.<br />See: plugin.tx_adgooglemaps.settings.mapDrawer.tables.' . $this->currentField['table'] . '.columnsMapping.coordinates', 1299154339);
		}

		// Get language overlay on translate.
		$defaultLanguageDataKey = $this->currentField['table'] . ':' . $this->currentField['row']['uid'];
		if (array_key_exists($defaultLanguageDataKey, $this->currentField['pObj']->defaultLanguageData) && $this->currentField['itemFormElValue'] === '' && $this->currentField['pObj']->defaultLanguageData[$defaultLanguageDataKey]['coordinates'] !== '') {
			$this->currentField['itemFormElValue'] = $this->currentField['pObj']->defaultLanguageData[$defaultLanguageDataKey]['coordinates'];
		}

		// Prepare $currentField for view.
		$this->currentField['itemFormElID'] = htmlspecialchars($this->currentField['itemFormElID']);
		$this->currentField['fieldChangeFunc'] = htmlspecialchars(implode('', $this->currentField['fieldChangeFunc']));
		// Repair coordinates field.
		$this->currentField['itemFormElValue'] = preg_match('/^(-?\d+\.?\d*\s*,\s*-?\d+\.?\d*\n?)*/', $this->currentField['itemFormElValue'], $matches) ? $this->currentField['itemFormElValue'] : '';

		// Add JavaScript Files to the form.
		$this->addJavaScriptFilesToForm();

		// Initialize view object.
		$this->InitializeView();

		$this->objectId = 'Tx_AdGoogleMaps_MapDrawer_Uid' . $currentField['row']['uid'];

		$this->mapDrawerOptions = array(
			'className' => 'className: ' . '\'' . $this->recordTypeConfiguration['className'] . '\'',
			'objectId' => 'objectId: ' . '\'' . $this->objectId . '\'',
			'canvasId' => 'canvasId: ' . '\'' . $this->objectId . '_canvas\'',
			'coordinatesFieldId' => 'coordinatesFieldId: ' . '\'' . $currentField['itemFormElID'] . '\'',
			'searchFieldId' => 'searchFieldId: ' . '\'' . $this->objectId . '_searchField\'',
			'searchButtonId' => 'searchButtonId: ' . '\'' . $this->objectId . '_searchButton\'',
			'fitBoundsOnLoad' => 'fitBoundsOnLoad: ' . ((array_key_exists('fitBoundsOnLoad', $this->recordTypeConfiguration) === TRUE && (boolean) $this->recordTypeConfiguration['fitBoundsOnLoad'] === TRUE) ? 'true' : 'false'),
		);

		// Check map center.
		$center = (array_key_exists('center', $this->recordTypeConfiguration) === TRUE && $this->recordTypeConfiguration['center'] !== '') ? $this->recordTypeConfiguration['center'] : '48.209206,16.372778';
		if (Tx_AdGoogleMaps_Api_Base_LatLng::isValidCoordinate($center) === FALSE) {
			throw new Tx_AdGoogleMaps_MapDrawer_Exception('Given map center "' . $center . '" is invalid. The format must be like "48.209206,16.372778".<br />See: plugin.tx_adgooglemaps.settings.api.center', 1299154340);
		} else {
			$center = t3lib_div::makeInstance('Tx_AdGoogleMaps_Api_Base_LatLng', $center);
		}

		// Set map options.
		$this->mapOptions = array(
			'center' => 'center: ' . $center,
			'mapTypeId' => 'mapTypeId: ' . ((array_key_exists('mapTypeId', $this->recordTypeConfiguration) === TRUE && $this->recordTypeConfiguration['mapTypeId'] !== '') ? $this->recordTypeConfiguration['mapTypeId'] : 'google.maps.MapTypeId.HYBRID'),
			'zoom' => 'zoom: ' . ((array_key_exists('zoom', $this->recordTypeConfiguration) === TRUE && $this->recordTypeConfiguration['zoom'] !== '') ? intval($this->recordTypeConfiguration['zoom']) : 11),
			'minZoom' => 'minZoom: ' . ((array_key_exists('minZoom', $this->recordTypeConfiguration) === TRUE && $this->recordTypeConfiguration['minZoom'] !== '') ? intval($this->recordTypeConfiguration['minZoom']) : 'null'),
			'maxZoom' => 'maxZoom: ' . ((array_key_exists('maxZoom', $this->recordTypeConfiguration) === TRUE && $this->recordTypeConfiguration['maxZoom'] !== '') ? intval($this->recordTypeConfiguration['maxZoom']) : 'null'),
		);
	}

	/**
	 * User function for Google Maps database fields. 
	 *
	 * @return void
	 */
	public function render() {
		$options = array();
		$options[] = TAB . '{';
		$options[] = TAB . TAB . TAB . implode(', '. LF . TAB . TAB . TAB, $this->mapDrawerOptions) . ',';
		$options[] = TAB . TAB . TAB . 'mapOptions: { ' . implode(', ', $this->mapOptions) . ' }';
		$options[] = TAB . TAB . '}';

		$map = array(
			'className' => $this->recordTypeConfiguration['className'],
			'objectId' => $this->objectId,
			'canvasId' => $this->objectId . '_canvas',
			'canvasWidth' => ((array_key_exists('canvasWidth', $this->recordTypeConfiguration) === TRUE && $this->recordTypeConfiguration['canvasWidth'] !== '') ? $this->recordTypeConfiguration['canvasWidth'] : '90%'),
			'canvasHeight' => ((array_key_exists('canvasHeight', $this->recordTypeConfiguration) === TRUE && $this->recordTypeConfiguration['canvasHeight'] !== '') ? $this->recordTypeConfiguration['canvasHeight'] : '400px'),
			'coordinatesFieldId' => $this->currentField['itemFormElID'],
			'searchFieldId' => $this->objectId . '_searchField',
			'searchButtonId' => $this->objectId . '_searchButton',
			'options' => implode(LF, $options),
		);

		$this->view->assignMultiple(array(
			'map' => $map,
			'currentField' => $this->currentField,
			'formObject' => $this->formObject,
		));

		return $this->view->render();
	}

	/**
	 * User function for Google Maps database fields. 
	 *
	 * @return void
	 */
	abstract public function draw();

	/**
	 * Adds the JavaScriptFiles to the form.
	 *
	 * @return void
	 */
	protected function addJavaScriptFilesToForm() {
		// Add record type JavaScript file to form.
		if (array_key_exists('javaScriptFiles', $this->recordTypeConfiguration) === TRUE && is_array($this->recordTypeConfiguration['javaScriptFiles']) === TRUE) {
			foreach ($this->recordTypeConfiguration['javaScriptFiles'] as $javaScriptResource) {
				$javaScriptFile = Tx_AdGoogleMaps_Utility_BackEnd::getRelativePathAndFileName($javaScriptResource, '../');
				$this->formObject->loadJavascriptLib($javaScriptFile);
			}
		}
	}

	/**
	 * Initialize this view object.
	 *
	 * @return string
	 */
	protected function InitializeView() {
		if (array_key_exists('templateFile', $this->recordTypeConfiguration) === TRUE && $this->recordTypeConfiguration['templateFile'] !== '') {
			$templateFile = t3lib_div::getFileAbsFileName($this->recordTypeConfiguration['templateFile']);
			$controllerContext = t3lib_div::makeInstance('Tx_Extbase_MVC_Controller_ControllerContext');
			$controllerContext->setRequest(t3lib_div::makeInstance('Tx_Extbase_MVC_Request'));
			$this->view = t3lib_div::makeInstance('Tx_Fluid_View_TemplateView');
			$this->view->setControllerContext($controllerContext);
			$this->view->setTemplatePathAndFilename($templateFile);
		}
	}

}

?>