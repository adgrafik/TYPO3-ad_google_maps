<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

include_once(t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Tools/BackEnd.php');
$extensionConfiguration = Tx_AdGoogleMaps_Tools_BackEnd::getExtensionConfiguration($_EXTKEY);

// Class used for constants.
include_once(t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Domain/Model/Map.php');
include_once(t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Domain/Model/Layer/LayerInterface.php');
include_once(t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Domain/Model/Layer/AbstractLayer.php');
include_once(t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Domain/Model/Layer/Marker.php');
include_once(t3lib_extMgm::extPath('ad_google_maps_api') . 'Classes/ControlOptions/AbstractControlOptions.php');
include_once(t3lib_extMgm::extPath('ad_google_maps_api') . 'Classes/ControlOptions/MapType.php');
include_once(t3lib_extMgm::extPath('ad_google_maps_api') . 'Classes/ControlOptions/Navigation.php');
include_once(t3lib_extMgm::extPath('ad_google_maps_api') . 'Classes/ControlOptions/Scale.php');
include_once(t3lib_extMgm::extPath('ad_google_maps_api') . 'Classes/ControlOptions/Pan.php');
include_once(t3lib_extMgm::extPath('ad_google_maps_api') . 'Classes/ControlOptions/Zoom.php');
include_once(t3lib_extMgm::extPath('ad_google_maps_api') . 'Classes/ControlOptions/StreetView.php');

// Registers a Plugin to be listed in the Backend. You also have to configure the Dispatcher in ext_localconf.php.
Tx_Extbase_Utility_Extension::registerPlugin($_EXTKEY, 'Pi1', 'Google Maps');

// TCA configuration for tx_adgooglemaps_domain_model_map
t3lib_extMgm::addLLrefForTCAdescr('tx_adgooglemaps_domain_model_map', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_tca_csh_map.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_adgooglemaps_domain_model_map');
$TCA['tx_adgooglemaps_domain_model_map'] = array(
	'ctrl' => array(
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
			'fe_group' => 'fe_group',
		),
		'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.label',
		'label' => 'title',
		'delete' => 'deleted',
		'sortby' => 'sorting',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'requestUpdate' => 'center_type,map_type_control,navigation_control,scale_control,pan_control,zoom_control,street_view_control,search_control,draggable,info_window_behaviour',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/TCA/iconMap.gif',
		'dividers2tabs' => 2,
		'prependAtCopy' => 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields' => 'sys_language_uid',
		'useColumnsForDefaultValues' => 'sys_language_uid',
		'dynamicConfigFile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'versioningWS' => 2,
		'versioning_followPages' => true,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
	),
);

// TCA configuration for tx_adgooglemaps_domain_model_category
t3lib_extMgm::addLLrefForTCAdescr('tx_adgooglemaps_domain_model_category', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_tca_csh_category.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_adgooglemaps_domain_model_category');
$TCA['tx_adgooglemaps_domain_model_category'] = array(
	'ctrl' => array(
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
			'fe_group' => 'fe_group',
		),
		'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_category.label',
		'label' => 'title',
		'delete' => 'deleted',
		'sortby' => 'sorting',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'requestUpdate' => 'rte_enabled',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/TCA/iconCategory.gif',
		'dividers2tabs' => 2,
		'prependAtCopy' => 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields' => 'sys_language_uid',
		'useColumnsForDefaultValues' => 'sys_language_uid',
		'dynamicConfigFile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'versioningWS' => 2,
		'versioning_followPages' => true,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
	),
);

// TCA configuration for tx_adgooglemaps_domain_model_layer
t3lib_extMgm::addLLrefForTCAdescr('tx_adgooglemaps_domain_model_layer', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_tca_csh_layer.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_adgooglemaps_domain_model_layer');
$TCA['tx_adgooglemaps_domain_model_layer'] = array(
	'ctrl' => array(
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
			'fe_group' => 'fe_group',
		),
		'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.label',
		'label' => 'title',
		'label_alt' => 'coordinates',
		'delete' => 'deleted',
		'sortby' => 'sorting',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'type' => 'type',
		'typeicon_column' => 'type',
		'typeicons' => array(
			'Tx_AdGoogleMaps_PluginAdapter_LayerBuilder_Marker' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/TCA/IconMarkers.gif',
			'Tx_AdGoogleMaps_PluginAdapter_LayerBuilder_Polyline' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/TCA/IconPolyline.gif',
			'Tx_AdGoogleMaps_PluginAdapter_LayerBuilder_Polygon' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/TCA/IconPolygon.gif',
			'Tx_AdGoogleMaps_PluginAdapter_LayerBuilder_Kml' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/TCA/IconKml.gif',
		),
		'requestUpdate' => 'data_provider,shape_type,place_markers,rte_enabled',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/TCA/iconLayer.gif',
		'dividers2tabs' => 2,
		'prependAtCopy' => 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields' => 'sys_language_uid',
		'useColumnsForDefaultValues' => 'sys_language_uid',
		'dynamicConfigFile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'versioningWS' => 2,
		'versioning_followPages' => true,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
	),
);

// Add static TypoScript
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/', 'ad: Google Maps');

$pluginSignature = strtolower(t3lib_div::underscoredToUpperCamelCase($_EXTKEY)) . '_pi1';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
//include_once(t3lib_extMgm::extPath($_EXTKEY) . 'class.tx_adgooglemaps_FlexFormProcFunc.php');
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform.xml');

if (t3lib_extMgm::isLoaded('tt_address') === TRUE && ((boolean) $extensionConfiguration['useMapDrawerForAddress']) === TRUE) {
	$tempColumns = array(
		'tx_adgooglemaps_coordinates' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps_api/Resources/Private/Language/Service/locallang_mapdrawer.xml:tx_adgooglemapsapi_service_mapdrawer.coordinates',
			'config'  => array(
				'type' => 'user',
				'size' => 20,
				'eval' => 'required,nospace,trim',
				'userFunc' => 'EXT:ad_google_maps_api/Classes/Service/MapDrawer.php:tx_AdGoogleMapsApi_Service_MapDrawer->user_parseCoordinatesField',
			),
		),
	);

	t3lib_div::loadTCA('tt_address');
	t3lib_extMgm::addTCAcolumns('tt_address', $tempColumns, 1);
	t3lib_extMgm::addLLrefForTCAdescr('tt_address', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_tca_csh_layer.xml');
	t3lib_extMgm::addToAllTCAtypes('tt_address', '--div--;LLL:EXT:ad_google_maps_api/Resources/Private/Language/Service/locallang_mapdrawer.xml:tx_adgooglemapsapi_service_mapdrawer.sheetMapDrawer, tx_adgooglemaps_coordinates;;;;1-1-1');
	$GLOBALS['TCA']['tt_address']['ctrl']['dividers2tabs'] = 2;
}

?>