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
		// Execute template controllers.
		$templateController = t3lib_div::removeArrayEntryByValue(explode(',', $this->settings['flexform']['templates']), '');
		foreach ($templateController as $templateId) {
			// Check if template ID exists in the TS-Setup.
			if (array_key_exists($templateId, $this->settings['flexform']['templateController']) === FALSE) {
				$this->flashMessageContainer->add('The template ID "' . $templateId . '" is not valid.');
				continue;
			}
			$templateConfiguration = $this->settings['flexform']['templateController'][$templateId];

			$bootstrap = $this->objectManager->get('Tx_Extbase_Core_Bootstrap');
			$templateContent .= $bootstrap->run($templateContent, $templateConfiguration);
		}

		$this->view->assign('templateContent', $templateContent);
		$this->view->assign('googleMapsPlugin', $this->getMapManager()->getGoogleMapsPlugin());
	}

	/**
	 * Index action
	 *
	 * @return void
	 */
	public function googleMapsAction() {
		$this->view->assign('googleMapsPlugin', $this->getMapManager()->getGoogleMapsPlugin());
	}

	/**
	 * listView action
	 *
	 * @return void
	 */
	public function listViewAction() {
		$this->view->assign('map', $this->getMap());
		$this->view->assign('categories', $this->getCategories());
	}

	/**
	 * simpleSearch action
	 *
	 * @return void
	 */
	public function simpleSearchAction() {
		// Include JavaScript file.
		Tx_AdGoogleMaps_Utility_FrontEnd::includeFrontEndResources('Tx_AdGoogleMaps_Controller_GoogleMapsController');

		$map = $this->getMap();
		$googleMapsPlugin = $this->getMapManager()->getGoogleMapsPlugin();
		$mapControl = $googleMapsPlugin->getPluginOptions()->getMapControl();

		// Set search marker.
		$searchMarker = $this->objectManager->create('Tx_AdGoogleMaps_Api_MarkerImage',
			$map->getSearchMarker(),
			$this->objectManager->create('Tx_AdGoogleMaps_Api_Size', 
				$map->getSearchMarkerWidth(),
				$map->getSearchMarkerHeight()
			),
			$this->objectManager->create('Tx_AdGoogleMaps_Api_Point', 
				$map->getSearchMarkerOriginX(),
				$map->getSearchMarkerOriginY()
			),
			$this->objectManager->create('Tx_AdGoogleMaps_Api_Point', 
				$map->getSearchMarkerAnchorX(),
				$map->getSearchMarkerAnchorY()
			),
			$this->objectManager->create('Tx_AdGoogleMaps_Api_Size', 
				$map->getSearchMarkerScaledWidth(),
				$map->getSearchMarkerScaledHeight()
			)
		);
		$mapControl->setSearchMarker($searchMarker);

		$this->view->assign('googleMapsPlugin', $googleMapsPlugin);
		$this->view->assign('map', $map);
	}

}

?>