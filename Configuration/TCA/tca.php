<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$extensionConfiguration = Tx_AdGoogleMaps_Utility_BackEnd::getExtensionConfiguration('ad_google_maps');
// l10n_mode for text fields.
$prependTranslationInfo = Tx_AdGoogleMaps_Utility_BackEnd::getExtensionConfigurationValue('prependTranslationInfo');
// l10n_mode for the image or file field.
$excludeFileTranslation = Tx_AdGoogleMaps_Utility_BackEnd::getExtensionConfigurationValue('excludeFileTranslation');
// l10n_mode for property fields.
$excludeProperties = Tx_AdGoogleMaps_Utility_BackEnd::getExtensionConfigurationValue('excludeProperties');
// hide new localizations.
$hideNewLocalizations = Tx_AdGoogleMaps_Utility_BackEnd::getExtensionConfigurationValue('hideNewLocalizations');

// Load ad_google_maps settings
$adgooglemapsapiSettings = Tx_AdGoogleMaps_Utility_BackEnd::getTypoScriptSetup('tx_adgooglemaps');

$systemColumns = array(
	't3ver_label' => array (
		'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
		'displayCond' => 'FIELD:t3ver_label:REQ:true',
		'config' => array (
			'type' => 'input',
			'size' => 30,
			'max'  => 30,
		)
	),
	'sys_language_uid' => array (		
		'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
		'exclude' => true,
		'l10n_display' => 'hideDiff',
		'config' => array (
			'type' => 'select',
			'foreign_table' => 'sys_language',
			'foreign_table_where' => 'ORDER BY sys_language.title',
			'items' => array(
				array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
				array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
			)
		)
	),
	'l18n_diffsource' => array (		
		'config' => array (
			'type' => 'passthrough'
		)
	),
	'hidden' => array(
		'exclude' => true,
		'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
		'l10n_mode' => $hideNewLocalizations,
		'l10n_display' => 'hideDiff',
		'config' => array(
			'type' => 'check',
		),
	),
	'starttime' => array (
		'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
		'exclude' => true,
		'l10n_mode' => $excludeProperties,
		'config' => array(
			'type' => 'input',
			'size' => '13',
			'max' => '20',
			'eval' => 'date',
			'default' => '0',
		),
	),
	'endtime' => array (
		'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
		'exclude' => true,
		'l10n_mode' => $excludeProperties,
		'config' => array (
			'type' => 'input',
			'size' => '8',
			'max' => '20',
			'eval' => 'date',
			'checkbox' => '0',
			'default' => '0',
			'range' => array (
				'upper' => mktime(0,0,0,12,31,2020),
			)
		)
	),
	'fe_group' => array (
		'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
		'exclude' => true,
		'l10n_mode' => $excludeProperties,
		'config' => array (
			'type' => 'select',
			'size' => 5,
			'maxitems' => 20,
			'items' => array (
				array('LLL:EXT:lang/locallang_general.php:LGL.hide_at_login', -1),
				array('LLL:EXT:lang/locallang_general.php:LGL.any_login', -2),
				array('LLL:EXT:lang/locallang_general.php:LGL.usergroups', '--div--')
			),
			'exclusiveKeys' => '-1,-2',
			'foreign_table' => 'fe_groups',
			'foreign_table_where' => 'ORDER BY fe_groups.title',
		)
	),
);

$TCA['tx_adgooglemaps_domain_model_map'] = array(
	'ctrl' => $TCA['tx_adgooglemaps_domain_model_map']['ctrl'],
	'feInterface' => $TCA['tx_adgooglemaps_domain_model_map']['feInterface'],
	'interface' => array(
	),
	'columns' => array(
		'l18n_parent' => array (		
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'config' => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_adgooglemaps_domain_model_map',
				'foreign_table_where' => 'AND tx_adgooglemaps_domain_model_map.pid=###CURRENT_PID### AND tx_adgooglemaps_domain_model_map.sys_language_uid IN (-1,0)',
			)
		),
		'title' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.title',
			'exclude' => true,
			'l10n_mode' => $prependTranslationInfo,
			'l10n_cat' => 'text',
			'config' => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'required,trim',
			),
		),
		'map_type_id' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.hybrid', Tx_AdGoogleMaps_Api_ControlOptions_MapType::MAPTYPEID_HYBRID),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.roadmap', Tx_AdGoogleMaps_Api_ControlOptions_MapType::MAPTYPEID_ROADMAP),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.satellite', Tx_AdGoogleMaps_Api_ControlOptions_MapType::MAPTYPEID_SATELLITE),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.terrain', Tx_AdGoogleMaps_Api_ControlOptions_MapType::MAPTYPEID_TERRAIN),
				),
			),
		),
		'background_color' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.backgroundColor',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'size' => 7,
				'default' => '0',
				'checkbox' => '0',
				'wizards' =>array(
					'colorpick' => array(
						'type' => 'colorbox',
						'title' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.colorPickerTitle',
						'script' => 'wizard_colorpicker.php',
						'dim' => '20x20',
						'tableStyle' => 'margin-left: 5px;',
						'JSopenParams' => 'height=300,width=365,status=0,menubar=0,scrollbars=0',
					),
				),
			),
		),
		'min_zoom' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.minZoom',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 2,
				'range' => array(
					'lower' => 0,
					'upper' => 20,
				),
				'eval' => 'int',
			),
		),
		'max_zoom' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.maxZoom',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 2,
				'range' => array(
					'lower' => 0,
					'upper' => 20,
				),
				'eval' => 'int',
			),
		),
		'no_clear' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.noClear',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
			),
		),
		'center_type' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.centerType',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_Domain_Model_Map::CENTER_TYPE_DEFAULT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.centerType.default', Tx_AdGoogleMaps_Domain_Model_Map::CENTER_TYPE_DEFAULT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.centerType.bounds', Tx_AdGoogleMaps_Domain_Model_Map::CENTER_TYPE_BOUNDS),
				),
			),
		),
		'center' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.center',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:center_type:=:' . Tx_AdGoogleMaps_Domain_Model_Map::CENTER_TYPE_DEFAULT,
			'config' => array(
				'type' => 'input',
				'size' => 16,
				'eval' => 'trim,required',
				'default' => ($adgooglemapsapiSettings !== NULL ? $adgooglemapsapiSettings['map']['center'] : '48.209206,16.372778'),
			),
		),
		'zoom' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.zoom',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:center_type:=:' . Tx_AdGoogleMaps_Domain_Model_Map::CENTER_TYPE_DEFAULT,
			'config' => array(
				'type' => 'input',
				'size' => 2,
				'range' => array(
					'lower' => 0,
					'upper' => 20,
				),
				'eval' => 'int',
				'default' => '11',
			),
		),
		'use_marker_cluster' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.useMarkerCluster',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
			),
		),
		'disable_default_ui' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.disableDefaultUi',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
			),
		),
		'map_type_control' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControl',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
			),
		),
		'map_type_control_options_map_type_ids' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControlOptions.mapTypeIds',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:map_type_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'size' => 4,
				'minitems' => 1,
				'maxitems' => 4,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.hybrid', Tx_AdGoogleMaps_Api_ControlOptions_MapType::MAPTYPEID_HYBRID),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.roadmap', Tx_AdGoogleMaps_Api_ControlOptions_MapType::MAPTYPEID_ROADMAP),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.satellite', Tx_AdGoogleMaps_Api_ControlOptions_MapType::MAPTYPEID_SATELLITE),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.terrain', Tx_AdGoogleMaps_Api_ControlOptions_MapType::MAPTYPEID_TERRAIN),
				),
			),
		),
		'map_type_control_options_position' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControlOptions.position',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:map_type_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_Api_ControlOptions_MapType::POSITION_TOP_RIGHT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topCenter', Tx_AdGoogleMaps_Api_ControlOptions_MapType::POSITION_TOP_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topRight', Tx_AdGoogleMaps_Api_ControlOptions_MapType::POSITION_TOP_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.rightCenter', Tx_AdGoogleMaps_Api_ControlOptions_MapType::POSITION_RIGHT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomRight', Tx_AdGoogleMaps_Api_ControlOptions_MapType::POSITION_BOTTOM_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomCenter', Tx_AdGoogleMaps_Api_ControlOptions_MapType::POSITION_BOTTOM_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomLeft', Tx_AdGoogleMaps_Api_ControlOptions_MapType::POSITION_BOTTOM_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.leftCenter', Tx_AdGoogleMaps_Api_ControlOptions_MapType::POSITION_LEFT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topLeft', Tx_AdGoogleMaps_Api_ControlOptions_MapType::POSITION_TOP_LEFT),
				),
			),
		),
		'map_type_control_options_style' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControlOptions.style',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:map_type_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_Api_ControlOptions_MapType::STYLE_DEFAULT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControlOptions.style.default', Tx_AdGoogleMaps_Api_ControlOptions_MapType::STYLE_DEFAULT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControlOptions.style.dropdownMenu', Tx_AdGoogleMaps_Api_ControlOptions_MapType::STYLE_DROPDOWN_MENU),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControlOptions.style.horizontalBar', Tx_AdGoogleMaps_Api_ControlOptions_MapType::STYLE_HORIZONTAL_BAR),
				),
			),
		),
		'navigation_control' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.navigationControl',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
			),
		),
		'navigation_control_options_position' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.navigationControlOptions.position',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:navigation_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_Api_ControlOptions_Navigation::POSITION_TOP_LEFT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topCenter', Tx_AdGoogleMaps_Api_ControlOptions_Navigation::POSITION_TOP_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topRight', Tx_AdGoogleMaps_Api_ControlOptions_Navigation::POSITION_TOP_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.rightCenter', Tx_AdGoogleMaps_Api_ControlOptions_Navigation::POSITION_RIGHT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomRight', Tx_AdGoogleMaps_Api_ControlOptions_Navigation::POSITION_BOTTOM_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomCenter', Tx_AdGoogleMaps_Api_ControlOptions_Navigation::POSITION_BOTTOM_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomLeft', Tx_AdGoogleMaps_Api_ControlOptions_Navigation::POSITION_BOTTOM_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.leftCenter', Tx_AdGoogleMaps_Api_ControlOptions_Navigation::POSITION_LEFT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topLeft', Tx_AdGoogleMaps_Api_ControlOptions_Navigation::POSITION_TOP_LEFT),
				),
			),
		),
		'navigation_control_options_style' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.navigationControlOptions.style',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:navigation_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_Api_ControlOptions_Navigation::STYLE_DEFAULT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.navigationControlOptions.style.default', Tx_AdGoogleMaps_Api_ControlOptions_Navigation::STYLE_DEFAULT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.navigationControlOptions.style.android', Tx_AdGoogleMaps_Api_ControlOptions_Navigation::STYLE_ANDROID),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.navigationControlOptions.style.small', Tx_AdGoogleMaps_Api_ControlOptions_Navigation::STYLE_SMALL),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.navigationControlOptions.style.zoomPan', Tx_AdGoogleMaps_Api_ControlOptions_Navigation::STYLE_ZOOM_PAN),
				),
			),
		),
		'scale_control' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.scaleControl',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
			),
		),
		'scale_control_options_position' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.scaleControlOptions.position',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:scale_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_Api_ControlOptions_Scale::POSITION_BOTTOM_LEFT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topCenter', Tx_AdGoogleMaps_Api_ControlOptions_Scale::POSITION_TOP_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topRight', Tx_AdGoogleMaps_Api_ControlOptions_Scale::POSITION_TOP_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.rightCenter', Tx_AdGoogleMaps_Api_ControlOptions_Scale::POSITION_RIGHT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomRight', Tx_AdGoogleMaps_Api_ControlOptions_Scale::POSITION_BOTTOM_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomCenter', Tx_AdGoogleMaps_Api_ControlOptions_Scale::POSITION_BOTTOM_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomLeft', Tx_AdGoogleMaps_Api_ControlOptions_Scale::POSITION_BOTTOM_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.leftCenter', Tx_AdGoogleMaps_Api_ControlOptions_Scale::POSITION_LEFT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topLeft', Tx_AdGoogleMaps_Api_ControlOptions_Scale::POSITION_TOP_LEFT),
				),
			),
		),
		'scale_control_options_style' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.scaleControlOptions.style',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:scale_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_Api_ControlOptions_Scale::STYLE_DEFAULT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.scaleControlOptions.style.default', Tx_AdGoogleMaps_Api_ControlOptions_Scale::STYLE_DEFAULT),
				),
			),
		),
		'pan_control' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.panControl',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
			),
		),
		'pan_control_options_position' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.panControlOptions.position',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:pan_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_Api_ControlOptions_Pan::POSITION_TOP_LEFT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topCenter', Tx_AdGoogleMaps_Api_ControlOptions_Pan::POSITION_TOP_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topRight', Tx_AdGoogleMaps_Api_ControlOptions_Pan::POSITION_TOP_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.rightCenter', Tx_AdGoogleMaps_Api_ControlOptions_Pan::POSITION_RIGHT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomRight', Tx_AdGoogleMaps_Api_ControlOptions_Pan::POSITION_BOTTOM_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomCenter', Tx_AdGoogleMaps_Api_ControlOptions_Pan::POSITION_BOTTOM_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomLeft', Tx_AdGoogleMaps_Api_ControlOptions_Pan::POSITION_BOTTOM_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.leftCenter', Tx_AdGoogleMaps_Api_ControlOptions_Pan::POSITION_LEFT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topLeft', Tx_AdGoogleMaps_Api_ControlOptions_Pan::POSITION_TOP_LEFT),
				),
			),
		),
		'zoom_control' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.zoomControl',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
			),
		),
		'zoom_control_options_position' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.zoomControlOptions.position',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:zoom_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_Api_ControlOptions_Zoom::POSITION_BOTTOM_LEFT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topCenter', Tx_AdGoogleMaps_Api_ControlOptions_Zoom::POSITION_TOP_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topRight', Tx_AdGoogleMaps_Api_ControlOptions_Zoom::POSITION_TOP_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.rightCenter', Tx_AdGoogleMaps_Api_ControlOptions_Zoom::POSITION_RIGHT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomRight', Tx_AdGoogleMaps_Api_ControlOptions_Zoom::POSITION_BOTTOM_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomCenter', Tx_AdGoogleMaps_Api_ControlOptions_Zoom::POSITION_BOTTOM_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomLeft', Tx_AdGoogleMaps_Api_ControlOptions_Zoom::POSITION_BOTTOM_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.leftCenter', Tx_AdGoogleMaps_Api_ControlOptions_Zoom::POSITION_LEFT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topLeft', Tx_AdGoogleMaps_Api_ControlOptions_Zoom::POSITION_TOP_LEFT),
				),
			),
		),
		'zoom_control_options_style' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.zoomControlOptions.style',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:zoom_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_Api_ControlOptions_Zoom::STYLE_DEFAULT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.zoomControlOptions.style.default', Tx_AdGoogleMaps_Api_ControlOptions_Zoom::STYLE_DEFAULT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.zoomControlOptions.style.small', Tx_AdGoogleMaps_Api_ControlOptions_Zoom::STYLE_SMALL),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.zoomControlOptions.style.large', Tx_AdGoogleMaps_Api_ControlOptions_Zoom::STYLE_LARGE),
				),
			),
		),
		'street_view_control' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.streetViewControl',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
			),
		),
		'street_view_control_options_position' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.streetViewControlOptions.position',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:street_view_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_Api_ControlOptions_StreetView::POSITION_TOP_LEFT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topCenter', Tx_AdGoogleMaps_Api_ControlOptions_StreetView::POSITION_TOP_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topRight', Tx_AdGoogleMaps_Api_ControlOptions_StreetView::POSITION_TOP_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.rightCenter', Tx_AdGoogleMaps_Api_ControlOptions_StreetView::POSITION_RIGHT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomRight', Tx_AdGoogleMaps_Api_ControlOptions_StreetView::POSITION_BOTTOM_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomCenter', Tx_AdGoogleMaps_Api_ControlOptions_StreetView::POSITION_BOTTOM_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomLeft', Tx_AdGoogleMaps_Api_ControlOptions_StreetView::POSITION_BOTTOM_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.leftCenter', Tx_AdGoogleMaps_Api_ControlOptions_StreetView::POSITION_LEFT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topLeft', Tx_AdGoogleMaps_Api_ControlOptions_StreetView::POSITION_TOP_LEFT),
				),
			),
		),
		'disable_double_click_zoom' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.disableDoubleClickZoom',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'default' => 1,
			),
		),
		'scrollwheel' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.scrollwheel',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'default' => 1,
			),
		),
		'draggable' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.draggable',
			'exclude' => true,
			'l10n_mode' => $excludeFileTranslation,
			'config' => array(
				'type' => 'check',
				'default' => 1,
			),
		),
		'draggable_cursor' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.draggableCursor',
			'exclude' => true,
			'l10n_mode' => $excludeFileTranslation,
			'displayCond' => 'FIELD:draggable:REQ:true',
			'config' => array(
				'type'          => 'group',
				'internal_type' => 'file',
				'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size'      => 3000,
				'uploadfolder'  => Tx_AdGoogleMaps_Utility_BackEnd::getAbsoluteUploadPath('ad_google_maps', 'mouseCursor'),
				'show_thumbs'   => 1,
				'size'          => 1,
				'minitems'      => 0,
				'maxitems'      => 1,
			),
		),
		'dragging_cursor' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.draggingCursor',
			'exclude' => true,
			'l10n_mode' => $excludeFileTranslation,
			'displayCond' => 'FIELD:draggable:REQ:true',
			'config' => array(
				'type'          => 'group',
				'internal_type' => 'file',
				'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size'      => 3000,
				'uploadfolder'  => Tx_AdGoogleMaps_Utility_BackEnd::getAbsoluteUploadPath('ad_google_maps', 'mouseCursor'),
				'show_thumbs'   => 1,
				'size'          => 1,
				'minitems'      => 0,
				'maxitems'      => 1,
			),
		),
		'keyboard_shortcuts' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.keyboardShortcuts',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'default' => 1,
			),
		),
		'info_window_close_all_on_map_click' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowCloseAllOnMapClick',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
			),
		),
		'info_window_behaviour' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowBehaviour',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_MAP | Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowBehaviour.byMapAndLayer', Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_MAP | Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowBehaviour.byMap', Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_MAP),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowBehaviour.byLayer', Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER),
				),
			),
		),
		'info_window_object_number' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowObjectNumber',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:info_window_behaviour:!=:' . Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 15,
				'eval' => 'trim',
			),
		),
		'info_window_keep_open' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowKeepOpen',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:info_window_behaviour:!=:' . Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER,
			'config' => array(
				'type' => 'check',
			),
		),
		'info_window_close_on_click' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowCloseOnClick',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:info_window_behaviour:!=:' . Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER,
			'config' => array(
				'type' => 'check',
			),
		),
		'info_window_disable_auto_pan' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowDisableAutoPan',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:info_window_behaviour:!=:' . Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER,
			'config' => array(
				'type' => 'check',
				'default' => 0,
			),
		),
		'info_window_max_width' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowMaxWidth',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:info_window_behaviour:!=:' . Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'info_window_pixel_offset_width' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowPixelOffsetWidth',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:info_window_behaviour:!=:' . Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'info_window_pixel_offset_height' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowPixelOffsetHeight',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:info_window_behaviour:!=:' . Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'search_marker' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.searchMarker',
			'exclude' => true,
			'l10n_mode' => $excludeFileTranslation,
			'config' => array(
				'type'          => 'group',
				'internal_type' => 'file',
				'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size'      => 3000,
				'uploadfolder'  => Tx_AdGoogleMaps_Utility_BackEnd::getAbsoluteUploadPath('ad_google_maps', 'markerIcons'),
				'show_thumbs'   => 1,
				'size'          => 1,
				'minitems'      => 0,
				'maxitems'      => 1,
			),
		),
		'search_marker_width' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.searchMarkerWidth',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'search_marker_height' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.searchMarkerHeight',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'search_marker_scaled_width' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.searchMarkerScaledWidth',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'search_marker_scaled_height' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.searchMarkerScaledHeight',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'search_marker_origin_x' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.searchMarkerOriginX',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'search_marker_origin_y' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.searchMarkerOriginY',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'search_marker_anchor_x' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.searchMarkerAnchorX',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'search_marker_anchor_y' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.searchMarkerAnchorY',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
	),
	'palettes' => array(
		'system' => array('canNotCollapse' => true, 'showitem' => 'title, sys_language_uid, l18n_parent'),
		'map' => array('showitem' => 'min_zoom, max_zoom, background_color, no_clear'),
		'center' => array('canNotCollapse' => true, 'showitem' => 'center, zoom'),
		'typeControll' => array('canNotCollapse' => true, 'showitem' => 'map_type_control_options_map_type_ids, --linebreak--, map_type_control_options_position, map_type_control_options_style'),
		'navigationControl' => array('canNotCollapse' => true, 'showitem' => 'navigation_control_options_position, navigation_control_options_style'),
		'scaleControl' => array('canNotCollapse' => true, 'showitem' => 'scale_control_options_position, scale_control_options_style'),
		'panControl' => array('canNotCollapse' => true, 'showitem' => 'pan_control_options_position'),
		'zoomControl' => array('canNotCollapse' => true, 'showitem' => 'zoom_control_options_position, zoom_control_options_style'),
		'streetViewControl' => array('canNotCollapse' => true, 'showitem' => 'street_view_control_options_position'),
		'dragCursor' => array('showitem' => 'draggable_cursor, --linebreak--, dragging_cursor'),
		'infoWindowArrangement' => array('showitem' => 'info_window_object_number'),
		'infoWindowActions' => array('showitem' => 'info_window_keep_open, info_window_close_on_click, info_window_disable_auto_pan'),
		'infoWindowDimensions' => array('showitem' => 'info_window_max_width, info_window_pixel_offset_width, info_window_pixel_offset_height'),
		'simpleSearchDimensions' => array('showitem' => 'search_marker_width, search_marker_height, search_marker_scaled_height, search_marker_scaled_width'),
		'simpleSearchPosition' => array('showitem' => 'search_marker_origin_x, search_marker_origin_y, search_marker_anchor_x, search_marker_anchor_y'),
		'visibility' => array('canNotCollapse' => 1, 'showitem' => 'hidden'),
		'access' => array('canNotCollapse' => 1, 'showitem' => 'starttime;LLL:EXT:cms/locallang_ttc.xml:starttime_formlabel, endtime;LLL:EXT:cms/locallang_ttc.xml:endtime_formlabel, --linebreak--, fe_group;LLL:EXT:cms/locallang_ttc.xml:fe_group_formlabel'),
	),
	'types' => array(
		'1' => array(
			'showitem' => '
					--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.paletteTitle.system;system, 
					map_type_id, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.paletteTitle.map;map, 
					center_type, 
						--palette--;;center, 
					use_marker_cluster,
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.sheetControllers, 
					disable_default_ui, 
					map_type_control, 
						--palette--;;typeControll, 
					navigation_control, 
						--palette--;;navigationControl, 
					scale_control, 
						--palette--;;scaleControl, 
					pan_control, 
						--palette--;;panControl, 
					zoom_control, 
						--palette--;;zoomControl, 
					street_view_control, 
						--palette--;;streetViewControl,
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.sheetInteraction, 
					disable_double_click_zoom, 
					scrollwheel, 
					draggable, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.paletteTitle.dragCursor;dragCursor, 
					keyboard_shortcuts,
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.sheetInfoWindows, 
					info_window_close_all_on_map_click, 
					info_window_behaviour, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.paletteTitle.infoWindowArrangement;infoWindowArrangement,
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.paletteTitle.infoWindowActions;infoWindowActions, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.paletteTitle.infoWindowDimensions;infoWindowDimensions,
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.sheetSimpleSearch, 
					search_marker, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.paletteTitle.simpleSearchDimensions;simpleSearchDimensions, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.paletteTitle.simpleSearchPosition;simpleSearchPosition,
				--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,
					--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.visibility;visibility,
					--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.access;access',
		),
	),
);

$TCA['tx_adgooglemaps_domain_model_map']['columns'] = array_merge($TCA['tx_adgooglemaps_domain_model_map']['columns'], $systemColumns);

$TCA['tx_adgooglemaps_domain_model_category'] = array(
	'ctrl' => $TCA['tx_adgooglemaps_domain_model_category']['ctrl'],
	'feInterface' => $TCA['tx_adgooglemaps_domain_model_category']['feInterface'],
	'interface' => array(
	),
	'columns' => array(
		'l18n_parent' => array (		
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'config' => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_adgooglemaps_domain_model_category',
				'foreign_table_where' => 'AND tx_adgooglemaps_domain_model_category.pid=###CURRENT_PID### AND tx_adgooglemaps_domain_model_category.sys_language_uid IN (-1,0)',
			)
		),
		'title' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_category.title',
			'exclude' => true,
			'l10n_mode' => $prependTranslationInfo,
			'l10n_cat' => 'text',
			'config' => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'required,trim',
				'max'  => 256
			)
		),
		'icon' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_category.icon',
			'exclude' => true,
			'l10n_mode' => $excludeFileTranslation,
			'config' => array(
				'type'          => 'group',
				'internal_type' => 'file',
				'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size'      => 3000,
				'uploadfolder'  => Tx_AdGoogleMaps_Utility_BackEnd::getAbsoluteUploadPath('ad_google_maps', 'categoryIcons'),
				'show_thumbs'   => 1,
				'size'          => 1,
				'minitems'      => 0,
				'maxitems'      => 1,
			),
		),
		'icon_width' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_category.iconWidth',
			'exclude' => true,
			'l10n_mode' => $excludeFileTranslation,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'icon_height' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_category.iconHeight',
			'exclude' => true,
			'l10n_mode' => $excludeFileTranslation,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'description' => Array (
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_category.description',
			'exclude' => true,
			'l10n_mode' => $prependTranslationInfo,
			'l10n_cat' => 'text',
			'config' => Array (
				'type' => 'text',
				'cols' => '48',
				'rows' => '5',
				'softref' => 'typolink_tag,images,email[subst],url',
				'wizards' => Array(
					'_PADDING' => 4,
					'_VALIGN' => 'middle',
					'RTE' => Array(
						'notNewRecords' => 1,
						'RTEonly' => 1,
						'type' => 'script',
						'title' => 'LLL:EXT:cms/locallang_ttc.php:bodytext.W.RTE',
						'icon' => 'wizard_rte2.gif',
						'script' => 'wizard_rte.php',
					),
				),
			),
		),
		'rte_enabled' => Array (
			'label' => 'LLL:EXT:cms/locallang_ttc.php:rte_enabled',
			'exclude' => true,
			'l10n_mode' => $prependTranslationInfo,
			'l10n_display' => 'hideDiff',
			'config' => Array (
				'type' => 'check',
				'showIfRTE' => 1
			)
		),
		'parent_category' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_category.parentCategory',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'select',
				'size' => 4,
				'autoSizeMax' => 15,
				'minitems' => 0,
				'maxitems' => 2,
				'foreign_table' => 'tx_adgooglemaps_domain_model_category',
				'foreign_table_where' => 'AND (tx_adgooglemaps_domain_model_category.sys_language_uid = 0 OR tx_adgooglemaps_domain_model_category.l18n_parent = 0) AND tx_adgooglemaps_domain_model_category.uid != ###THIS_UID### ORDER BY tx_adgooglemaps_domain_model_category.sorting',
				'renderMode' => 'tree',
				'treeConfig' => array(
					'parentField' => 'parent_category',
					'appearance' => array(
						'expandAll' => true,
						'showHeader' => true,
					),
				),
			),
		),
		'layers' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_category.layers',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'l10n_display' => ($excludeProperties === 'exclude' ? '' : 'hideDiff'),
			'config' => array(
				'type' => 'select',
				'size' => '5',
				'autoSizeMax' => 15,
				'maxitems' => 99,
				'foreign_table' => 'tx_adgooglemaps_domain_model_layer',
				'foreign_table_where' => 'AND (tx_adgooglemaps_domain_model_layer.sys_language_uid = 0 OR tx_adgooglemaps_domain_model_layer.l18n_parent = 0) ORDER BY tx_adgooglemaps_domain_model_layer.sorting',
				'MM' => 'tx_adgooglemaps_category_layer_mm',
			),
		),
	),
	'palettes' => array(
		'system' => array('canNotCollapse' => true, 'showitem' => 'title, sys_language_uid, l18n_parent'),
		'iconDimensions' => array('showitem' => 'icon_width, icon_height'),
		'rte' => array('canNotCollapse' => true, 'showitem' => 'rte_enabled'),
		'visibility' => array('canNotCollapse' => 1, 'showitem' => 'hidden'),
		'access' => array('canNotCollapse' => 1, 'showitem' => 'starttime;LLL:EXT:cms/locallang_ttc.xml:starttime_formlabel, endtime;LLL:EXT:cms/locallang_ttc.xml:endtime_formlabel, --linebreak--, fe_group;LLL:EXT:cms/locallang_ttc.xml:fe_group_formlabel'),
	),
	'types' => array(
		'1' => array(
			'showitem' => '
					--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_category.paletteTitle.system;system, 
					icon, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_category.paletteTitle.iconDimensions;iconDimensions, 
					description;;;richtext:rte_transform[flag=rte_enabled|mode=ts_css];, 
						--palette--;;rte, 
					parent_category, 
					layers,
				--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,
					--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.visibility;visibility,
					--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.access;access',
		),
	),
);

if (t3lib_extMgm::isLoaded('cps_tcatree') === TRUE) {
	$TCA['tx_adgooglemaps_domain_model_category']['columns']['parent_category']['config'] = array(
		'type' => 'select',
		'form_type' => 'user',
		'userFunc' => 'tx_cpstcatree->getTree',
		'size' => 3,
		'autoSizeMax' => 15,
		'minitems' => 0,
		'maxitems' => 2,
		'foreign_table' => 'tx_adgooglemaps_domain_model_category',
		'foreign_table_where' => 'AND (tx_adgooglemaps_domain_model_category.sys_language_uid = 0 OR tx_adgooglemaps_domain_model_category.l18n_parent = 0) AND tx_adgooglemaps_domain_model_category.uid != ###THIS_UID### ORDER BY tx_adgooglemaps_domain_model_category.sorting',
		'treeView' => '1',
		'expandable' => '1',
		'expandFirst' => '0',
		'expandAll' => '0',
	);
}

$TCA['tx_adgooglemaps_domain_model_category']['columns'] = array_merge($TCA['tx_adgooglemaps_domain_model_category']['columns'], $systemColumns);

$TCA['tx_adgooglemaps_domain_model_layer'] = array(
	'ctrl' => $TCA['tx_adgooglemaps_domain_model_layer']['ctrl'],
	'feInterface' => $TCA['tx_adgooglemaps_domain_model_layer']['feInterface'],
	'interface' => array(
		'showRecordFieldList' => 'title, coordinates'
	),
	'columns' => array(
		'l18n_parent' => array (		
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'config' => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_adgooglemaps_domain_model_layer',
				'foreign_table_where' => 'AND tx_adgooglemaps_domain_model_layer.pid=###CURRENT_PID### AND tx_adgooglemaps_domain_model_layer.sys_language_uid IN (-1,0)',
			)
		),
		'type' => array (
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.type',
			'exclude' => true,
			'l10n_display' => 'defaultAsReadonly',
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.type.markers', 'Tx_AdGoogleMaps_MapManager_Layer_Marker', 'EXT:ad_google_maps/Resources/Public/Icons/TCA/IconMarkers.gif'),
				),
				'default' => 'Tx_AdGoogleMaps_MapManager_Layer_Marker',
				'authMode' => $GLOBALS['TYPO3_CONF_VARS']['BE']['explicitADmode'],
				'authMode_enforce' => 'strict',
				'iconsInOptionTags' => 1,
				'noIconsBelowSelect' => 1,
			)
		),
		'title' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.title',
			'exclude' => true,
			'l10n_mode' => $prependTranslationInfo,
			'l10n_cat' => 'text',
			'config' => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim',
			)
		),
		'visible' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.visible',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'default' => 1,
			),
		),
		'coordinates_provider' => array (
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.coordinatesProvider',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array (
				'type' => 'select',
				'default' => 'Tx_AdGoogleMaps_MapManager_CoordinatesProvider_MapDrawer',
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.coordinatesProvider.mapDrawer', 'Tx_AdGoogleMaps_MapManager_CoordinatesProvider_MapDrawer'),
				),
			)
		),
		'coordinates' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/MapDrawer/locallang.xml:tx_adgooglemaps_mapdrawer.coordinates',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:coordinates_provider:=:Tx_AdGoogleMaps_MapManager_CoordinatesProvider_MapDrawer',
			'config' => array(
				'type' => 'user',
				'userFunc' => 'EXT:ad_google_maps/Classes/MapDrawer/MapDrawerApi.php:tx_AdGoogleMaps_MapDrawer_MapDrawerApi->tx_draw',
			),
		),
		'categories' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.categories',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'l10n_display' => ($excludeProperties === 'exclude' ? '' : 'hideDiff'),
			'config' => array(
				'type' => 'select',
				'size' => 3,
				'autoSizeMax' => 15,
				'minitems' => 0,
				'maxitems' => 99,
				'foreign_table' => 'tx_adgooglemaps_domain_model_category',
				'foreign_table_where' => 'AND (tx_adgooglemaps_domain_model_category.sys_language_uid = 0 OR tx_adgooglemaps_domain_model_category.l18n_parent = 0) ORDER BY tx_adgooglemaps_domain_model_category.sorting',
				'MM' => 'tx_adgooglemaps_category_layer_mm',
				'MM_opposite_field' => 'layers',
				'renderMode' => 'tree',
				'treeConfig' => array(
					'parentField' => 'parent_category',
					'appearance' => array(
						'expandAll' => true,
						'showHeader' => true,
					),
				),
			),
		),
		'clickable' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.clickable',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'default' => 1,
			),
		),
		'draggable' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.draggable',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'default' => 0,
			),
		),
		'raise_on_drag' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.raiseOnDrag',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'default' => 1,
			),
		),
		'zindex' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.zindex',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 4,
				'eval' => 'num,int,trim',
			),
		),
		'marker_title' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.markerTitle',
			'exclude' => true,
			'l10n_mode' => $prependTranslationInfo,
			'l10n_cat' => 'text',
			'config' => array(
				'type' => 'text',
				'size' => 20,
				'eval' => 'trim',
			)
		),
		'marker_title_object_number' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.markerTitleObjectNumber',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 30,
				'eval' => 'trim',
			),
		),
		'icon' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.icon',
			'exclude' => true,
			'l10n_mode' => $excludeFileTranslation,
			'config' => array(
				'type'          => 'group',
				'internal_type' => 'file',
				'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size'      => 3000,
				'uploadfolder'  => Tx_AdGoogleMaps_Utility_BackEnd::getAbsoluteUploadPath('ad_google_maps', 'markerIcons'),
				'show_thumbs'   => 1,
				'size'          => 3,
				'autoSizeMax'	=> 15,
				'minitems'      => 0,
				'maxitems'      => 99,
				'multiple'      => 1,
			),
		),
		'icon_object_number' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconObjectNumber',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 30,
				'eval' => 'trim',
			),
		),
		'icon_width' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconWidth',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'icon_height' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconHeight',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'icon_scaled_width' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconScaledWidth',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'icon_scaled_height' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconScaledHeight',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'icon_origin_x' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconOriginX',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'icon_origin_y' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconOriginY',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'icon_anchor_x' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconAnchorX',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'icon_anchor_y' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconAnchorY',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'shadow' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadow',
			'exclude' => true,
			'l10n_mode' => $excludeFileTranslation,
			'config' => array(
				'type'          => 'group',
				'internal_type' => 'file',
				'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size'      => 3000,
				'uploadfolder'  => Tx_AdGoogleMaps_Utility_BackEnd::getAbsoluteUploadPath('ad_google_maps', 'shadowIcons'),
				'show_thumbs'   => 1,
				'size'          => 3,
				'autoSizeMax'	=> 15,
				'minitems'      => 0,
				'maxitems'      => 99,
				'multiple'      => 1,
			),
		),
		'shadow_object_number' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowObjectNumber',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 30,
				'eval' => 'trim',
			),
		),
		'shadow_width' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowWidth',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'shadow_height' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowHeight',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'shadow_scaled_width' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowScaledWidth',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'shadow_scaled_height' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowScaledHeight',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'shadow_origin_x' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowOriginX',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'shadow_origin_y' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowOriginY',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'shadow_anchor_x' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowAnchorX',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'shadow_anchor_y' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowAnchorY',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'flat' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.flat',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check'
			),
		),
		'shape_type' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shapeType',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'select',
				'eval' => 'required',
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shapeType.none', ''),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shapeType.rect', 'rect'),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shapeType.circle', 'circle'),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shapeType.poly', 'poly'),
				),
			),
		),
		'shape_coords' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shapeCoords',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:shape_type:!=:',
			'config' => array(
				'type' => 'text',
				'rows' => 3,
			),
		),
		'mouse_cursor' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.mouseCursor',
			'exclude' => true,
			'l10n_mode' => $excludeFileTranslation,
			'config' => array(
				'type'          => 'group',
				'internal_type' => 'file',
				'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size'      => 3000,
				'uploadfolder'  => Tx_AdGoogleMaps_Utility_BackEnd::getAbsoluteUploadPath('ad_google_maps', 'mouseCursor'),
				'show_thumbs'   => 1,
				'size'          => 1,
				'minitems'      => 0,
				'maxitems'      => 1,
			),
		),
		'info_window' => Array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindow',
			'exclude' => true,
			'l10n_mode' => 'mergeIfNotBlank',
			'config' => Array (
				'type' => 'inline',
				'foreign_table' => 'tt_content',
				'foreign_sortby' => 'sorting',
				'MM' => 'tx_adgooglemaps_layer_ttcontent_mm',
				'maxitems' => 1000,
				'appearance' => Array(
					'collapseAll' => 1,
					'expandSingle' => 1,
					'useSortable' => 1,
					'newRecordLinkAddTitle' => 1,
					'newRecordLinkPosition' => 'both',
					
					'showSynchronizationLink' => false,
					'showAllLocalizationLink' => true,
					'showPossibleLocalizationRecords' => true,
					'showRemovedLocalizationRecords' => true,
				),
				'behaviour' => array(
					'localizeChildrenAtParentLocalization' => true,						    		
					'localizationMode' => 'select',
				),			
			)
		),
		'info_window_object_number' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowObjectNumber',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'size' => 15,
				'eval' => 'trim',
				'default' => '0',
				'checkbox' => '0',
			),
		),
		'info_window_keep_open' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowKeepOpen',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'default' => 0,
			),
		),
		'info_window_close_on_click' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowCloseOnClick',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'default' => 0,
			),
		),
		'info_window_disable_auto_pan' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowDisableAutoPan',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'default' => 0,
			),
		),
		'info_window_max_width' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowMaxWidth',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'info_window_zindex' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowZIndex',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 4,
				'eval' => 'required,num,int,trim',
			),
		),
		'info_window_pixel_offset_width' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowPixelOffsetWidth',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'info_window_pixel_offset_height' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowPixelOffsetHeight',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'list_title' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.listTitle',
			'exclude' => true,
			'l10n_mode' => $prependTranslationInfo,
			'l10n_cat' => 'text',
			'config' => array(
				'type' => 'text',
				'size' => 20,
				'eval' => 'trim',
			)
		),
		'list_title_object_number' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.listTitleObjectNumber',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 30,
				'eval' => 'trim',
			),
		),
		'list_icon' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.listIcon',
			'exclude' => true,
			'l10n_mode' => $excludeFileTranslation,
			'config' => array(
				'type'          => 'group',
				'internal_type' => 'file',
				'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size'      => 3000,
				'uploadfolder'  => Tx_AdGoogleMaps_Utility_BackEnd::getAbsoluteUploadPath('ad_google_maps', 'markerIcons'),
				'show_thumbs'   => 1,
				'size'          => 3,
				'autoSizeMax'	=> 15,
				'minitems'      => 0,
				'maxitems'      => 99,
				'multiple'      => 1,
			),
		),
		'list_icon_object_number' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.listIconObjectNumber',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 30,
				'eval' => 'trim',
			),
		),
		'list_icon_width' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.listIconWidth',
			'exclude' => true,
			'l10n_mode' => $excludeFileTranslation,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'list_icon_height' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.listIconHeight',
			'exclude' => true,
			'l10n_mode' => $excludeFileTranslation,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
	),
	'palettes' => array(
		'system' => array('canNotCollapse' => 1, 'showitem' => 'type, sys_language_uid, l18n_parent'),
		'markerTitleArrangement' => array('showitem' => 'marker_title_object_number'),
		'markerProperties' => array('showitem' => 'visible, clickable, draggable, raise_on_drag, zindex'),
		'iconArrangement' => array('showitem' => 'icon_object_number'),
		'iconDimensions' => array('showitem' => 'icon_width, icon_height, icon_scaled_height, icon_scaled_width'),
		'iconPosition' => array('showitem' => 'icon_origin_x, icon_origin_y, icon_anchor_x, icon_anchor_y'),
		'shadowFlat' => array('canNotCollapse' => true, 'showitem' => 'flat'),
		'shadowArrangement' => array('showitem' => 'shadow_object_number'),
		'shadowDimensions' => array('showitem' => 'shadow_width, shadow_height, shadow_scaled_height, shadow_scaled_width'),
		'shadowPosition' => array('showitem' => 'shadow_origin_x, shadow_origin_y, shadow_anchor_x, shadow_anchor_y'),
		'shapeCoords' => array('canNotCollapse' => true, 'showitem' => 'shape_coords'),
		'infoWindowArrangement' => array('showitem' => 'info_window_object_number'),
		'infoWindowActions' => array('showitem' => 'info_window_keep_open, info_window_close_on_click, info_window_disable_auto_pan'),
		'infoWindowDimensions' => array('showitem' => 'info_window_max_width, info_window_pixel_offset_width, info_window_pixel_offset_height, info_window_zindex'),
		'listTitleArrangement' => array('showitem' => 'list_title_object_number'),
		'listIconArrangement' => array('showitem' => 'list_icon_object_number'),
		'listIconDimensions' => array('showitem' => 'list_icon_width, list_icon_height'),
		'visibility' => array('canNotCollapse' => 1, 'showitem' => 'hidden'),
		'access' => array('canNotCollapse' => 1, 'showitem' => 'starttime;LLL:EXT:cms/locallang_ttc.xml:starttime_formlabel, endtime;LLL:EXT:cms/locallang_ttc.xml:endtime_formlabel, --linebreak--, fe_group;LLL:EXT:cms/locallang_ttc.xml:fe_group_formlabel'),
	),
	'types' => array(
		'Tx_AdGoogleMaps_MapManager_Layer_Marker' => array(
			'showitem' => '
					--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.paletteTitle.system;system, 
					title, 
					coordinates_provider, 
					coordinates, 
					categories, 
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.sheetMarkers, 
					marker_title, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.paletteTitle.markerTitleArrangement;markerTitleArrangement, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.paletteTitle.markerProperties;markerProperties, 
					icon, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.paletteTitle.iconArrangement;iconArrangement, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.paletteTitle.iconDimensions;iconDimensions, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.paletteTitle.iconPosition;iconPosition, 
					shadow, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.paletteTitle.shadowArrangement;shadowArrangement, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.paletteTitle.shadowDimensions;shadowDimensions, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.paletteTitle.shadowPosition;shadowPosition, 
						--palette--;;shadowFlat, 
					shape_type, 
						--palette--;;shapeCoords, 
					mouse_cursor,
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.sheetInfoWindow, 
					info_window, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.paletteTitle.infoWindowArrangement;infoWindowArrangement,
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.paletteTitle.infoWindowActions;infoWindowActions, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.paletteTitle.infoWindowDimensions;infoWindowDimensions,
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.sheetListView, 
					list_title, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.paletteTitle.listTitleArrangement;listTitleArrangement, 
					list_icon, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.paletteTitle.listIconArrangement;listIconArrangement, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.paletteTitle.listIconDimensions;listIconDimensions,
				--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,
					--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.visibility;visibility,
					--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.access;access',
		),
	),
);

if (t3lib_extMgm::isLoaded('cps_tcatree') === TRUE) {
	$TCA['tx_adgooglemaps_domain_model_layer']['columns']['categories']['config'] = array(
		'type' => 'select',
		'form_type' => 'user',
		'userFunc' => 'tx_cpstcatree->getTree',
		'size' => 3,
		'autoSizeMax' => 15,
		'minitems' => 0,
		'maxitems' => 99,
		'foreign_table' => 'tx_adgooglemaps_domain_model_category',
		'foreign_table_where' => 'AND (tx_adgooglemaps_domain_model_category.sys_language_uid = 0 OR tx_adgooglemaps_domain_model_category.l18n_parent = 0) ORDER BY tx_adgooglemaps_domain_model_category.sorting',
		'MM' => 'tx_adgooglemaps_category_layer_mm',
		'MM_opposite_field' => 'layers',
		'treeView' => '1',
		'expandable' => '1',
		'expandFirst' => '0',
		'expandAll' => '0',
	);
}

$TCA['tx_adgooglemaps_domain_model_layer']['columns'] = array_merge($TCA['tx_adgooglemaps_domain_model_layer']['columns'], $systemColumns);

?>