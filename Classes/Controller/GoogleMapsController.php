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
 * Controller.
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_AdGoogleMaps_Controller_GoogleMapsController extends Tx_AdGoogleMaps_Controller_AbstractController {

	/**
	 * Index action
	 *
	 * @return string The rendered view
	 */
	public function indexAction() {
		if (!array_key_exists('mapDrawer', $this->settings)) {
			return $this->flashMessageContainer->add('Add static TypoScript "ad: Google Maps" to your template.');
		}

		// Merge TypoScript settings with FlexForm values. FlexForm values overrides TypoScript settings.
		if (array_key_exists('flexform', $this->settings) === TRUE) {
			$this->settings = Tx_Extbase_Utility_Arrays::arrayMergeRecursiveOverrule($this->settings, $this->settings['flexform']);
		}

		if (array_key_exists('uid', $this->settings['map']) === FALSE) {
			return $this->flashMessageContainer->add('No map defined.');
		}

		// Create map.
		$mapRepository = $this->objectManager->get('Tx_AdGoogleMaps_Domain_Repository_MapRepository');
		$map = $mapRepository->findByUid($this->settings['map']['uid']);
		if ($map instanceof Tx_AdGoogleMaps_Domain_Model_Map === FALSE) {
			return $this->flashMessageContainer->add('No map found. Add a map in the Google Maps Plugin.');
		}

		// Build map plugin.
		$mapBuilder = $this->objectManager->create('Tx_AdGoogleMaps_MapBuilder_MapBuilder');
		$this->jsonEncoder->setDebug($this->settings['plugin']['debugMode']);
		$mapBuilder->build(clone $map, $this->settings);

		// Execute template controllers.
		$templateControllerClassNames = t3lib_div::removeArrayEntryByValue(explode(',', $map->getTemplates()), '');
		foreach ($templateControllerClassNames as $templateControllerClassName) {
			// Get class and action name
			@list($templateControllerClassName, $templateControllerActionName) = explode('::', $templateControllerClassName);
			if (class_exists($templateControllerClassName) === FALSE) {
				$this->flashMessageContainer->add('Template controller class "' . $templateControllerClassName . '" not exists.');
				continue;
			}

			$templateController = $this->objectManager->create($templateControllerClassName);
			$templateController->injectMapBuilder($mapBuilder);
			$templateRequest = $this->objectManager->create('Tx_Extbase_MVC_Web_Request');
			$templateRequest->setControllerObjectName($templateControllerClassName);
			$templateRequest->setControllerActionName($templateControllerActionName);
			$templateController->processRequest($templateRequest, $this->response);
		}
	}

	/**
	 * Index action
	 *
	 * @return void
	 */
	public function googleMapsAction() {
		$this->view->assign('googleMapsPlugin', $this->mapBuilder->getGoogleMapsPlugin());
		$this->view->assign('map', $this->mapBuilder->getMap());
	}

	/**
	 * listView action
	 *
	 * @return void
	 */
	public function listViewAction() {
		$this->view->assign('map', $this->mapBuilder->getMap());
	}

	/**
	 * simpleSearch action
	 *
	 * @return void
	 */
	public function simpleSearchAction() {
		// Include JavaScript file.
		Tx_AdGoogleMaps_Utility_FrontEnd::includeFrontEndResources('Tx_AdGoogleMaps_Controller_GoogleMapsController');

		$map = $this->mapBuilder->getMap();
		$mapControl = $this->mapBuilder->getGoogleMapsPlugin()->getPluginOptions()->getMapControl();

		// Set search marker.
		if (($searchMarkerUrl = Tx_AdGoogleMaps_Utility_BackEnd::getRelativeUploadPathAndFileName('ad_google_maps', 'markerIcons', $map->getSearchMarker())) === NULL) {
			$searchMarkerUrl = 'typo3conf/ext/ad_google_maps/Resources/Public/Icons/MapDrawer/searchMarker.gif';
		}
		$searchMarker = $this->objectManager->create('Tx_AdGoogleMaps_Api_Overlay_MarkerImage',
			$searchMarkerUrl,
			$this->objectManager->create('Tx_AdGoogleMaps_Api_Base_Size', 
				$map->getSearchMarkerWidth(),
				$map->getSearchMarkerHeight()
			),
			$this->objectManager->create('Tx_AdGoogleMaps_Api_Base_Point', 
				$map->getSearchMarkerOriginX(),
				$map->getSearchMarkerOriginY()
			),
			$this->objectManager->create('Tx_AdGoogleMaps_Api_Base_Point', 
				$map->getSearchMarkerAnchorX(),
				$map->getSearchMarkerAnchorY()
			),
			$this->objectManager->create('Tx_AdGoogleMaps_Api_Base_Size', 
				$map->getSearchMarkerScaledWidth(),
				$map->getSearchMarkerScaledHeight()
			)
		);
		$mapControl->setSearchMarker($searchMarker);

		$this->view->assign('googleMapsPlugin', $this->mapBuilder->getGoogleMapsPlugin());
		$this->view->assign('map', $map);
	}

}

?>