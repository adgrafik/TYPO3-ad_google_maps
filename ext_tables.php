<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

include_once(t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Utility/BackEnd.php');
$extensionConfiguration = Tx_AdGoogleMaps_Utility_BackEnd::getExtensionConfiguration($_EXTKEY);

// Class used for constants.
$extensionClassesPath = t3lib_extMgm::extPath($_EXTKEY) . 'Classes/';
include_once($extensionClassesPath . 'Domain/Model/Map.php');
include_once($extensionClassesPath . 'Domain/Model/Layer/LayerInterface.php');
include_once($extensionClassesPath . 'Domain/Model/Layer.php');
include_once($extensionClassesPath . 'Domain/Model/Layer/Marker.php');

// Registers a Plugin to be listed in the Backend. You also have to configure the Dispatcher in ext_localconf.php.
Tx_Extbase_Utility_Extension::registerPlugin($_EXTKEY, 'Pi1', 'Google Maps');

// TCA configuration for tx_adgooglemaps_domain_model_map.
t3lib_extMgm::addLLrefForTCAdescr('tx_adgooglemaps_domain_model_map', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_tca_csh_map.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_adgooglemaps_domain_model_map', 'EXT:context_help/locallang_csh_ttcontent.xml');
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
		// Using mixed-ins hack from Franz Koch to make map table extendable.
		// @see http://lists.typo3.org/pipermail/typo3-project-typo3v4mvc/2010-September/006497.html
		'type' => 'deleted',
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

// TCA configuration for tx_adgooglemaps_domain_model_category.
t3lib_extMgm::addLLrefForTCAdescr('tx_adgooglemaps_domain_model_category', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_tca_csh_category.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_adgooglemaps_domain_model_category', 'EXT:context_help/locallang_csh_ttcontent.xml');
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
		'treeParentField' => 'parent_category',
	),
);

// TCA configuration for tx_adgooglemaps_domain_model_layer.
t3lib_extMgm::addLLrefForTCAdescr('tx_adgooglemaps_domain_model_layer', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_tca_csh_layer.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_adgooglemaps_domain_model_layer', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_tca_csh_layer.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_adgooglemaps_domain_model_layer', 'EXT:context_help/locallang_csh_ttcontent.xml');
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
			'Tx_AdGoogleMaps_MapBuilder_Layer_Marker' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/TCA/IconMarkers.gif',
		),
		'requestUpdate' => 'coordinates_provider,shape_type,place_markers,rte_enabled',
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

// Add static TypoScript.
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/', 'ad: Google Maps');

// Add plugin to tt_content.
$pluginSignature = strtolower(t3lib_div::underscoredToUpperCamelCase($_EXTKEY)) . '_pi1';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform.xml');
t3lib_extMgm::addLLrefForTCAdescr('tt_content.pi_flexform.' . $pluginSignature . '.list', 'EXT:ad_google_maps/Resources/Private/Language/locallang_flexform_csh.xml');

?>