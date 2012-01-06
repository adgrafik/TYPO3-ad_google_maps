<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

// l10n_mode for text fields.
$prependTranslationInfo = Tx_AdGoogleMaps_Utility_BackEnd::getExtensionConfigurationValue('l10n.prependTranslationInfo') ? 'prefixLangTitle' : '';
// l10n_mode for the image or file field.
$excludeFileTranslation = ((integer) Tx_AdGoogleMaps_Utility_BackEnd::getExtensionConfigurationValue('l10n.excludeFileTranslation') ^ 2) ? 'exclude' : '';
// l10n_mode for property fields.
$excludeProperties = Tx_AdGoogleMaps_Utility_BackEnd::getExtensionConfigurationValue('l10n.excludeProperties') ? 'exclude' : '';
// hide new localizations.
$hideNewLocalizations = Tx_AdGoogleMaps_Utility_BackEnd::getExtensionConfigurationValue('l10n.hideNewLocalizations') ? 'mergeIfNotBlank' : '';

// Load ad_google_maps settings
$query = array();
if (($returnUrl = t3lib_div::_GP('returnUrl')) !== NULL) {
	$url = parse_url($returnUrl);
	if (array_key_exists('query', $url) === TRUE) {
		parse_str($url['query'], $query);
	}
}
$pid = (array_key_exists('id', $query) === TRUE) ? $query['id'] : 0;
$adgooglemapsapiSettings = Tx_AdGoogleMaps_Utility_BackEnd::getTypoScriptSetup($pid, 'tx_adgooglemaps');

$TCA['tx_adgooglemaps_domain_model_map'] = array(
	'ctrl' => $TCA['tx_adgooglemaps_domain_model_map']['ctrl'],
	'feInterface' => $TCA['tx_adgooglemaps_domain_model_map']['feInterface'],
	'interface' => array(
	),
	'columns' => array(
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
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.disable',
					),
				),
			),
		),
		'starttime' => array (
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array (
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
				'size' => '13',
				'max' => '20',
				'eval' => 'date',
				'default' => '0',
				'range' => array(
					'upper' => mktime(0,0,0,12,31,2020),
				),
			),
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
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'exclusiveKeys' => '-1,-2',
				'foreign_table' => 'fe_groups',
				'foreign_table_where' => 'ORDER BY fe_groups.title',
			)
		),
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
				'eval' => 'trim',
			),
		),
		'display_mode' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.displayMode',
			'exclude' => true,
			'l10n_mode' => $prependTranslationInfo,
			'config' => array(
				'type' => 'select',
				'default' => 'Tx_AdGoogleMaps_MapManager_DisplayModeProcessor_AllLayers',
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.displayMode.allLayers', 'Tx_AdGoogleMaps_MapManager_DisplayModeProcessor_AllLayers'),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.displayMode.selectedLayers', 'Tx_AdGoogleMaps_MapManager_DisplayModeProcessor_SelectedLayers'),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.displayMode.byCategories', 'Tx_AdGoogleMaps_MapManager_DisplayModeProcessor_ByCategories'),
				),
			),
		),
		'categories' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.categories',
			'exclude' => true,
			'l10n_mode' => $prependTranslationInfo,
			'displayCond' => 'FIELD:display_mode:=:Tx_AdGoogleMaps_MapManager_DisplayModeProcessor_ByCategories',
			'config' => array(
				'type' => 'select',
				'size' => 3,
				'autoSizeMax' => 15,
				'minitems' => 0,
				'maxitems' => 99,
				'foreign_table' => 'tx_adgooglemaps_domain_model_category',
				'foreign_table_where' => 'AND (tx_adgooglemaps_domain_model_category.sys_language_uid = 0 OR tx_adgooglemaps_domain_model_category.l18n_parent = 0) ORDER BY tx_adgooglemaps_domain_model_category.sorting',
				'MM' => 'tx_adgooglemaps_map_category_mm',
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
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.layers',
			'exclude' => true,
			'l10n_mode' => $prependTranslationInfo,
			'displayCond' => 'FIELD:display_mode:=:Tx_AdGoogleMaps_MapManager_DisplayModeProcessor_SelectedLayers',
			'config' => array(
				'type' => 'select',
				'size' => 3,
				'autoSizeMax' => 15,
				'minitems' => 0,
				'maxitems' => 99,
				'foreign_table' => 'tx_adgooglemaps_domain_model_layer',
				'foreign_table_where' => 'AND (tx_adgooglemaps_domain_model_layer.sys_language_uid = 0 OR tx_adgooglemaps_domain_model_layer.l18n_parent = 0) ORDER BY tx_adgooglemaps_domain_model_layer.sorting',
			),
		),
		'map_type_id' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.hybrid', Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::MAPTYPEID_HYBRID),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.roadmap', Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::MAPTYPEID_ROADMAP),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.satellite', Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::MAPTYPEID_SATELLITE),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.terrain', Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::MAPTYPEID_TERRAIN),
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
				'size' => 2,
				'range' => array(
					'lower' => 0,
					'upper' => 20,
				),
				'eval' => 'int',
			),
		),
		'heading' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.heading',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'size' => 2,
				'eval' => 'int',
				'range' => array(
					'lower' => 0,
					'upper' => 360,
				),
			),
		),
		'tilt' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.tilt',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
				'size' => 2,
				'eval' => 'int',
				'range' => array(
					'lower' => 0,
					'upper' => 90,
				),
			),
		),
		'no_clear' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.noClear',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.enable',
					),
				),
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
				'default' => $adgooglemapsapiSettings['api']['center'],
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
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.enable',
					),
				),
			),
		),
		'disable_default_ui' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.disableDefaultUi',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.disable',
					),
				),
			),
		),
		'map_type_control' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControl',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.enable',
					),
				),
			),
		),
		'map_type_control_options_map_type_ids' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControls.mapTypeIds',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:map_type_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'size' => 4,
				'minitems' => 1,
				'maxitems' => 4,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.hybrid', Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::MAPTYPEID_HYBRID),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.roadmap', Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::MAPTYPEID_ROADMAP),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.satellite', Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::MAPTYPEID_SATELLITE),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.terrain', Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::MAPTYPEID_TERRAIN),
				),
			),
		),
		'map_type_control_options_position' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControls.position',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:map_type_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::POSITION_TOP_RIGHT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::POSITION_TOP_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topRight', Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::POSITION_TOP_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.rightCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::POSITION_RIGHT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomRight', Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::POSITION_BOTTOM_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::POSITION_BOTTOM_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomLeft', Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::POSITION_BOTTOM_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.leftCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::POSITION_LEFT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topLeft', Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::POSITION_TOP_LEFT),
				),
			),
		),
		'map_type_control_options_style' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControls.style',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:map_type_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::STYLE_DEFAULT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControls.style.default', Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::STYLE_DEFAULT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControls.style.dropdownMenu', Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::STYLE_DROPDOWN_MENU),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControls.style.horizontalBar', Tx_AdGoogleMaps_MapBuilder_API_Control_MapType::STYLE_HORIZONTAL_BAR),
				),
			),
		),
		'rotate_control' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.rotateControl',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.enable',
					),
				),
			),
		),
		'rotate_control_options_position' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.rotateControls.position',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:rotate_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_MapBuilder_API_Control_Rotate::POSITION_TOP_LEFT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_Rotate::POSITION_TOP_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topRight', Tx_AdGoogleMaps_MapBuilder_API_Control_Rotate::POSITION_TOP_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.rightCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_Rotate::POSITION_RIGHT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomRight', Tx_AdGoogleMaps_MapBuilder_API_Control_Rotate::POSITION_BOTTOM_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_Rotate::POSITION_BOTTOM_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomLeft', Tx_AdGoogleMaps_MapBuilder_API_Control_Rotate::POSITION_BOTTOM_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.leftCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_Rotate::POSITION_LEFT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topLeft', Tx_AdGoogleMaps_MapBuilder_API_Control_Rotate::POSITION_TOP_LEFT),
				),
			),
		),
		'scale_control' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.scaleControl',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.enable',
					),
				),
			),
		),
		'scale_control_options_position' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.scaleControls.position',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:scale_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_MapBuilder_API_Control_Scale::POSITION_BOTTOM_LEFT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_Scale::POSITION_TOP_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topRight', Tx_AdGoogleMaps_MapBuilder_API_Control_Scale::POSITION_TOP_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.rightCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_Scale::POSITION_RIGHT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomRight', Tx_AdGoogleMaps_MapBuilder_API_Control_Scale::POSITION_BOTTOM_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_Scale::POSITION_BOTTOM_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomLeft', Tx_AdGoogleMaps_MapBuilder_API_Control_Scale::POSITION_BOTTOM_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.leftCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_Scale::POSITION_LEFT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topLeft', Tx_AdGoogleMaps_MapBuilder_API_Control_Scale::POSITION_TOP_LEFT),
				),
			),
		),
		'scale_control_options_style' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.scaleControls.style',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:scale_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_MapBuilder_API_Control_Scale::STYLE_DEFAULT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.scaleControls.style.default', Tx_AdGoogleMaps_MapBuilder_API_Control_Scale::STYLE_DEFAULT),
				),
			),
		),
		'pan_control' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.panControl',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.enable',
					),
				),
			),
		),
		'pan_control_options_position' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.panControls.position',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:pan_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_MapBuilder_API_Control_Pan::POSITION_TOP_LEFT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_Pan::POSITION_TOP_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topRight', Tx_AdGoogleMaps_MapBuilder_API_Control_Pan::POSITION_TOP_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.rightCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_Pan::POSITION_RIGHT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomRight', Tx_AdGoogleMaps_MapBuilder_API_Control_Pan::POSITION_BOTTOM_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_Pan::POSITION_BOTTOM_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomLeft', Tx_AdGoogleMaps_MapBuilder_API_Control_Pan::POSITION_BOTTOM_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.leftCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_Pan::POSITION_LEFT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topLeft', Tx_AdGoogleMaps_MapBuilder_API_Control_Pan::POSITION_TOP_LEFT),
				),
			),
		),
		'zoom_control' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.zoomControl',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.enable',
					),
				),
			),
		),
		'zoom_control_options_position' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.zoomControls.position',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:zoom_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_MapBuilder_API_Control_Zoom::POSITION_BOTTOM_LEFT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_Zoom::POSITION_TOP_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topRight', Tx_AdGoogleMaps_MapBuilder_API_Control_Zoom::POSITION_TOP_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.rightCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_Zoom::POSITION_RIGHT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomRight', Tx_AdGoogleMaps_MapBuilder_API_Control_Zoom::POSITION_BOTTOM_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_Zoom::POSITION_BOTTOM_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomLeft', Tx_AdGoogleMaps_MapBuilder_API_Control_Zoom::POSITION_BOTTOM_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.leftCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_Zoom::POSITION_LEFT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topLeft', Tx_AdGoogleMaps_MapBuilder_API_Control_Zoom::POSITION_TOP_LEFT),
				),
			),
		),
		'zoom_control_options_style' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.zoomControls.style',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:zoom_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_MapBuilder_API_Control_Zoom::STYLE_DEFAULT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.zoomControls.style.default', Tx_AdGoogleMaps_MapBuilder_API_Control_Zoom::STYLE_DEFAULT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.zoomControls.style.small', Tx_AdGoogleMaps_MapBuilder_API_Control_Zoom::STYLE_SMALL),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.zoomControls.style.large', Tx_AdGoogleMaps_MapBuilder_API_Control_Zoom::STYLE_LARGE),
				),
			),
		),
		'overview_map_control' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.overviewMapControl',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.enable',
					),
				),
			),
		),
		'overview_map_control_options_is_opened' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.overviewMapControls.isOpened',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:overview_map_control:REQ:true',
			'config' => array(
				'type' => 'check',
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.enable',
					),
				),
			),
		),
		'street_view_control' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.streetViewControl',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.enable',
					),
				),
			),
		),
		'street_view_control_options_position' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.streetViewControls.position',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:street_view_control:REQ:true',
			'config' => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_MapBuilder_API_Control_StreetView::POSITION_TOP_LEFT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_StreetView::POSITION_TOP_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topRight', Tx_AdGoogleMaps_MapBuilder_API_Control_StreetView::POSITION_TOP_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.rightCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_StreetView::POSITION_RIGHT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomRight', Tx_AdGoogleMaps_MapBuilder_API_Control_StreetView::POSITION_BOTTOM_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_StreetView::POSITION_BOTTOM_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomLeft', Tx_AdGoogleMaps_MapBuilder_API_Control_StreetView::POSITION_BOTTOM_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.leftCenter', Tx_AdGoogleMaps_MapBuilder_API_Control_StreetView::POSITION_LEFT_CENTER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topLeft', Tx_AdGoogleMaps_MapBuilder_API_Control_StreetView::POSITION_TOP_LEFT),
				),
			),
		),
		'disable_double_click_zoom' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.disableDoubleClickZoom',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'default' => 0,
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.disable',
					),
				),
			),
		),
		'scrollwheel' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.scrollwheel',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'default' => 1,
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.enable',
					),
				),
			),
		),
		'draggable' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.draggable',
			'exclude' => true,
			'l10n_mode' => $excludeFileTranslation,
			'config' => array(
				'type' => 'check',
				'default' => 1,
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.enable',
					),
				),
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
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.enable',
					),
				),
			),
		),
		'info_window_close_all_on_map_click' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowCloseAllOnMapClick',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.enable',
					),
				),
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
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.enable',
					),
				),
			),
		),
		'info_window_close_on_click' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowCloseOnClick',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'displayCond' => 'FIELD:info_window_behaviour:!=:' . Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER,
			'config' => array(
				'type' => 'check',
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.enable',
					),
				),
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
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.disable',
					),
				),
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
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
	),
	'palettes' => array(
		'recordSettings' => array(
			'showitem' => 'title, sys_language_uid, l18n_parent',
			'canNotCollapse' => 1,
		),
		'display' => array(
			'showitem' => 'display_mode, --linebreak--, categories, layers',
			'canNotCollapse' => 1,
		),
		'initialSettings' => array(
			'showitem' => 'map_type_id, background_color, no_clear, --linebreak--, min_zoom, max_zoom, heading, tilt, --linebreak--, center_type, center, zoom',
			'canNotCollapse' => true,
		),
		'typeControl' => array(
			'showitem' => 'map_type_control_options_map_type_ids, --linebreak--, map_type_control_options_position, map_type_control_options_style',
			'canNotCollapse' => true,
		),
		'rotateControl' => array(
			'showitem' => 'rotate_control_options_position',
			'canNotCollapse' => true,
		),
		'scaleControl' => array(
			'showitem' => 'scale_control_options_position, scale_control_options_style',
			'canNotCollapse' => true,
		),
		'panControl' => array(
			'showitem' => 'pan_control_options_position',
			'canNotCollapse' => true,
		),
		'zoomControl' => array(
			'showitem' => 'zoom_control_options_position, zoom_control_options_style',
			'canNotCollapse' => true,
		),
		'overviewMapControl' => array(
			'showitem' => 'overview_map_control_options_is_opened',
			'canNotCollapse' => true,
		),
		'streetViewControl' => array(
			'showitem' => 'street_view_control_options_position',
			'canNotCollapse' => true,
		),
		'dragCursor' => array(
			'showitem' => 'draggable_cursor, --linebreak--, dragging_cursor',
			'canNotCollapse' => true,
		),
		'infoWindowArrangement' => array(
			'showitem' => 'info_window_object_number',
			'canNotCollapse' => true,
		),
		'infoWindowActions' => array(
			'showitem' => 'info_window_keep_open, info_window_close_on_click, info_window_disable_auto_pan',
			'canNotCollapse' => true,
		),
		'infoWindowDimensions' => array(
			'showitem' => 'info_window_max_width, info_window_pixel_offset_width, info_window_pixel_offset_height',
			'canNotCollapse' => true,
		),
		'visibility' => array(
			'showitem' => 'hidden;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.label',
			'canNotCollapse' => true,
		),
		'access' => array(
			'showitem' => 'starttime;LLL:EXT:cms/locallang_ttc.xml:starttime_formlabel, endtime;LLL:EXT:cms/locallang_ttc.xml:endtime_formlabel, --linebreak--, fe_group;LLL:EXT:cms/locallang_ttc.xml:fe_group_formlabel',
			'canNotCollapse' => true,
		),
	),
	'types' => array(
		'1' => array(
			'showitem' => '
					--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.paletteTitle.recordSettings;recordSettings, 
					--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.paletteTitle.display;display, 
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.sheetAppearance, 
					--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.paletteTitle.initialSettings;initialSettings, 
					use_marker_cluster,
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.sheetControllers, 
					disable_default_ui, 
					map_type_control, 
						--palette--;;typeControl, 
					rotate_control, 
						--palette--;;rotateControl, 
					scale_control, 
						--palette--;;scaleControl, 
					pan_control, 
						--palette--;;panControl, 
					zoom_control, 
						--palette--;;zoomControl, 
					overview_map_control, 
						--palette--;;overviewMapControl, 
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
				--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,
					--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.visibility;visibility,
					--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.access;access',
		),
	),
);

?>