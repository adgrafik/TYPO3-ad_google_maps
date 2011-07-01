<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2004-2009 Rupert Germann <rupi@gmx.li>
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
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * New for tt_news 3.0.0
 * Class for updating tt_news content elements and static template file relations.
 *
 * $Id: class.ext_update.php 26950 2009-11-25 13:01:54Z rupi $
 *
 * @author  Rupert Germann <rupi@gmx.li>
 * @package TYPO3
 * @subpackage tt_news
 */
class ext_update {

	/**
	 * @var integer
	 */
	protected $version;

	/**
	 * @var boolean
	 */
	protected $doUpdate;

	/**
	 * @var array
	 */
	protected $tables;

	/**
	 * @var array
	 */
	protected $tablesToRename = array(
		'tx_adgooglemaps_layer_ttaddress_mm' => 'tx_adgooglemapspluginaddress_layer_ttaddress_mm',
		'tx_adgooglemaps_layer_ttaddressgroup_mm' => 'tx_adgooglemapspluginaddress_layer_ttaddressgroup_mm',
	);

	/**
	 * @var array
	 */
	protected $fieldsToRename = array(
		'tx_adgooglemaps_domain_model_map' => array(
			'info_window_placing_type' => 'tx_adgooglemapspluginpoly_info_window_placing_type tinyint(4)',
			'info_window_position' => 'tx_adgooglemapspluginpoly_info_window_position varchar(64)',
		),
		'tx_adgooglemaps_domain_model_layer' => array(
			'marker_clickable' => 'clickable tinyint(4)',
			'marker_zindex' => 'zindex mediumint(11)',
			'shape' => 'shape_coords text',
			'item_titles' => 'marker_title text',
			'item_titles_object_number' => 'marker_title_object_number varchar(64)',
			'shape_clickable' => 'tx_adgooglemapspluginpoly_clickable tinyint(4)',
			'shape_zindex' => 'tx_adgooglemapspluginpoly_zindex mediumint(11)',
			'add_markers' => 'tx_adgooglemapspluginpoly_add_markers tinyint(4)',
			'geodesic' => 'tx_adgooglemapspluginpoly_geodesic tinyint(4)',
			'stroke_color' => 'tx_adgooglemapspluginpoly_stroke_color varchar(7)',
			'stroke_opacity' => 'tx_adgooglemapspluginpoly_stroke_opacity tinyint(4)',
			'stroke_weight' => 'tx_adgooglemapspluginpoly_stroke_weight tinyint(4)',
			'fill_color' => 'tx_adgooglemapspluginpoly_fill_color varchar(7)',
			'fill_opacity' => 'tx_adgooglemapspluginpoly_fill_opacity tinyint(4)',
			'info_window_placing_type' => 'tx_adgooglemapspluginpoly_info_window_placing_type tinyint(4)',
			'info_window_position' => 'tx_adgooglemapspluginpoly_info_window_position varchar(64)',
			'kml_file' => 'tx_adgooglemapspluginkml_file text',
			'kml_url' => 'tx_adgooglemapspluginkml_url text',
			'kml_suppress_info_windows' => 'tx_adgooglemapspluginkml_suppress_info_windows tinyint(4)',
			'addresses' => 'tx_adgooglemapspluginaddress_addresses tinyint(11)',
			'address_groups' => 'tx_adgooglemapspluginaddress_address_groups tinyint(11)',
		),
		'tt_address' => array(
			'tx_adgooglemaps_coordinates' => 'tx_adgooglemapspluginaddress_coordinates text',
		),
	);

	/**
	 * @var array
	 */
	protected $valuesToUpdate = array(
		'tx_adgooglemaps_domain_model_layer' => array(
			'type' => array(
				'definition' => 'varchar(128)',
				'values' => array(
					'tx_adgooglemaps_layers_marker' => 'Tx_AdGoogleMaps_MapBuilder_Layer_Marker',
					'tx_adgooglemaps_layers_polyline' => 'Tx_AdGoogleMapsPluginPoly_MapBuilder_Layer_Polyline',
					'tx_adgooglemaps_layers_polygon' => 'Tx_AdGoogleMapsPluginPoly_MapBuilder_Layer_Polygon',
					'tx_adgooglemaps_layers_kml' => 'Tx_AdGoogleMapsPluginKml_MapBuilder_Layer_Kml',
				),
			),
			'coordinates_provider' => array(
				'definition' => 'varchar(128)',
				'values' => array(
					'0' => 'Tx_AdGoogleMaps_MapBuilder_CoordinatesProvider_MapDrawer',
					'1' => 'Tx_AdGoogleMapsPluginAddress_MapBuilder_CoordinatesProvider_Addresses',
					'2' => 'Tx_AdGoogleMapsPluginAddress_MapBuilder_CoordinatesProvider_AddressGroup',
				),
			),
		),
	);

	function init() {
		$this->version = t3lib_div::int_from_ver(t3lib_extMgm::getExtensionVersion('ad_google_maps'));
		$this->doUpdate = (boolean) t3lib_div::_GP('do_update');
		$this->tables = $GLOBALS['TYPO3_DB']->admin_get_tables();
	}

	/**
	 * Main function, returning the HTML content of the module
	 *
	 * @return	string		HTML
	 */
	function main() {
		$this->init();

		$out = $this->getFlashMessage('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_extupdate.xml:update.warningMessage', 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_extupdate.xml:update.warningHeader');
		$out .= '<br />';

		// Rename tables.
		$renamedTables = $this->renameTables();
		if (count($renamedTables) > 0) {
			$out .= $this->getFlashMessage(implode('<br />', $renamedTables), 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_extupdate.xml:update.renameTablesHeader', $this->doUpdate ? t3lib_FlashMessage::OK : t3lib_FlashMessage::NOTICE);
		} else {
			$out .= $this->getFlashMessage('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_extupdate.xml:update.renameTablesOK', 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_extupdate.xml:update.renameTablesHeader', t3lib_FlashMessage::OK);
		}

		// Rename fields.
		$renamedFields = $this->renameFields();
		if (count($renamedFields) > 0) {
			$out .= $this->getFlashMessage(implode('<br />', $renamedFields), 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_extupdate.xml:update.renameFieldsHeader', $this->doUpdate ? t3lib_FlashMessage::OK : t3lib_FlashMessage::NOTICE);
		} else {
			$out .= $this->getFlashMessage('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_extupdate.xml:update.renameFieldsOK', 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_extupdate.xml:update.renameTablesHeader', t3lib_FlashMessage::OK);
		}

		// Update values.
		$updatedValues = $this->updateValues();
		if (count($updatedValues) > 0) {
			$out .= $this->getFlashMessage(implode('<br />', $updatedValues), 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_extupdate.xml:update.updateValuesHeader', $this->doUpdate ? t3lib_FlashMessage::OK : t3lib_FlashMessage::NOTICE);
		} else {
			$out .= $this->getFlashMessage('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_extupdate.xml:update.updateValuesOK', 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_extupdate.xml:update.updateValuesHeader', t3lib_FlashMessage::OK);
		}

		$out .= '<br />';
		$out .= '<img style="vertical-align: bottom;" ' . t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'], 'gfx/refresh_n.gif', 'width="18" height="16"') . '>
			<a href="' . t3lib_div::linkThisScript(array('do_update' => 1)) . '">' . Tx_Extbase_Utility_Localization::translate('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_extupdate.xml:update.update', 'ad_google_maps') . '</a><br>';

		return $out;
	}

	function renameTables() {
		$renamedTables = array();
		foreach ($this->tablesToRename as $fromTableName => $toTableName) {
			if (array_key_exists($fromTableName, $this->tables)) {
				$result = ($this->doUpdate === TRUE) ? $GLOBALS['TYPO3_DB']->admin_query(sprintf('RENAME TABLE %s TO %s;', $fromTableName, $toTableName)) : TRUE;
				if ($result === TRUE) {
					$renamedTables[] = sprintf(
						Tx_Extbase_Utility_Localization::translate('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_extupdate.xml:update.renameTable', 'ad_google_maps'), 
						$fromTableName, 
						$toTableName
					);
				}
			}
		}
		return $renamedTables;
	}

	function renameFields() {
		$renamedFields = array();
		foreach ($this->fieldsToRename as $tableName => $tableFields) {
			foreach ($tableFields as $fromFieldName => $toFieldName) {
				$fields = $GLOBALS['TYPO3_DB']->admin_get_fields($tableName);
				if (array_key_exists($tableName, $this->tables) && array_key_exists($fromFieldName, $fields)) {
					$result = ($this->doUpdate === TRUE) ? $GLOBALS['TYPO3_DB']->admin_query(sprintf('ALTER TABLE %s CHANGE %s %s', $tableName, $fromFieldName, $toFieldName)) : TRUE;
					if ($result === TRUE) {
						$renamedFields[] = sprintf(
							Tx_Extbase_Utility_Localization::translate('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_extupdate.xml:update.renameField', 'ad_google_maps'), 
							$tableName . '.' . $fromFieldName, 
							$tableName . '.' . $toFieldName
						);
					}
				}
			}
		}
		return $renamedFields;
	}

	function updateValues() {
		$updatedValues = array();
		foreach ($this->valuesToUpdate as $tableName => $tableFields) {
			foreach ($tableFields as $tableFieldName => $tableFieldConfig) {
				if ($this->doUpdate === TRUE && array_key_exists('definition', $tableFieldConfig)) {
					$GLOBALS['TYPO3_DB']->admin_query(sprintf('ALTER TABLE %s CHANGE %s %s', $tableName, $tableFieldName, $tableFieldName . ' ' . $tableFieldConfig['definition']));
				}
				foreach ($tableFieldConfig['values'] as $oldValue => $newValue) {
					if ($this->doUpdate === TRUE) {
						$GLOBALS['TYPO3_DB']->exec_UPDATEquery(
							$tableName,
							$tableFieldName . '="' . $oldValue . '"', 
							array($tableFieldName => $newValue), 
							TRUE
						);
					}
					if ($GLOBALS['TYPO3_DB']->exec_SELECTcountRows($tableFieldName, $tableName, $tableFieldName . '="' . $oldValue . '"') > 0) {
						$updatedValues[] = sprintf(
							Tx_Extbase_Utility_Localization::translate('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_extupdate.xml:update.updateValue', 'ad_google_maps'), 
							$tableName . '.' . $tableFieldName, 
							$oldValue, 
							$newValue
						);
					}
				}
			}
		}
		return $updatedValues;
	}

	function getFlashMessage($message, $header, $severity = t3lib_FlashMessage::WARNING) {
		return Tx_AdGoogleMaps_Utility_BackEnd::getFlashMessage(
			(substr($message, 0, 8) === 'LLL:EXT:') ? Tx_Extbase_Utility_Localization::translate($message, 'ad_google_maps') : $message, 
			(substr($header, 0, 8) === 'LLL:EXT:') ? Tx_Extbase_Utility_Localization::translate($header, 'ad_google_maps') : $header, 
			$severity
		);
	}

	/**
	 * Checks how many rows are found and returns true if there are any
	 * (this function is called from the extension manager)
	 *
	 * @return	boolean
	 */
	function access() {
		$this->init();
		$renamedTables = count($this->renameTables()) > 0;
		$renamedFields = count($this->renameFields()) > 0;
		$updatedValues = count($this->updateValues()) > 0;
		return $renamedTables || $renamedFields || $updatedValues;
	}

	/**
	 * Checks how many rows are found and returns true if there are any
	 * (this function is called from the extension manager)
	 *
	 * @param	string		$what: what should be updated
	 * @return	boolean
	 */
	function displayMessage(&$params, &$tsObj) {
		if ($this->access() === TRUE) {
			$out = Tx_AdGoogleMaps_Utility_BackEnd::addFlashMessage(
				sprintf(Tx_Extbase_Utility_Localization::translate('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_extconf.xml:update.updateMessage', 'ad_google_maps'), t3lib_div::linkThisScript(array('SET[singleDetails]' => 'updateModule'))), 
				Tx_Extbase_Utility_Localization::translate('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_extconf.xml:update.updateHeader', 'ad_google_maps'), 
				t3lib_FlashMessage::INFO);
			$out = '<div style="position: absolute; top: 10px; right: 10px; width: 300px;">' . $out . '</div>';
		}
		return $out;
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tt_news/class.ext_update.php']) {
	include_once ($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tt_news/class.ext_update.php']);
}
?>