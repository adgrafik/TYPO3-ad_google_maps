<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ad_google_maps']);

$categoryIconsUploadDirectory = str_replace(PATH_site, '', t3lib_div::getFileAbsFileName($extensionConfiguration['uploadDirectories.']['categoryIcons'] ? $extensionConfiguration['uploadDirectories.']['categoryIcons'] : 'EXT:ad_google_maps/Resources/Public/Uploads/Category/'));
$markerIconsUploadDirectory = str_replace(PATH_site, '', t3lib_div::getFileAbsFileName($extensionConfiguration['uploadDirectories.']['markerIcons'] ? $extensionConfiguration['uploadDirectories.']['markerIcons'] : 'EXT:ad_google_maps/Resources/Public/Uploads/Marker/'));
$shadowIconsUploadDirectory = str_replace(PATH_site, '', t3lib_div::getFileAbsFileName($extensionConfiguration['uploadDirectories.']['shadowIcons'] ? $extensionConfiguration['uploadDirectories.']['shadowIcons'] : 'EXT:ad_google_maps/Resources/Public/Uploads/Shadow/'));
$mouseCursorUploadDirectory = str_replace(PATH_site, '', t3lib_div::getFileAbsFileName($extensionConfiguration['uploadDirectories.']['mouseCursor'] ? $extensionConfiguration['uploadDirectories.']['mouseCursor'] : 'EXT:ad_google_maps/Resources/Public/Uploads/MouseCursor/'));
$kmlFilesUploadDirectory = str_replace(PATH_site, '', t3lib_div::getFileAbsFileName($extensionConfiguration['uploadDirectories.']['kmlFiles'] ? $extensionConfiguration['uploadDirectories.']['kmlFiles'] : 'EXT:ad_google_maps/Resources/Public/Uploads/KML/'));

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
		'exclude' => true,
		'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
		'config' => array (
			'type'                => 'select',
			'foreign_table'       => 'sys_language',
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
	'starttime' => array (
		'exclude' => true,
		'label' => 'LLL:EXT:lang/locallang_general.php:LGL.starttime',
		'config' => array (
			'type' => 'input',
			'size' => '8',
			'max' => '20',
			'eval' => 'date',
			'checkbox' => '0',
			'default' => '0'
		)
	),
	'endtime' => array (
		'exclude' => true,
		'label' => 'LLL:EXT:lang/locallang_general.php:LGL.endtime',
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
		'exclude' => true,
		'label' => 'LLL:EXT:lang/locallang_general.php:LGL.fe_group',
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
	'hidden' => array(
		'exclude' => true,
		'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
		'config'  => array(
			'type' => 'check'
		),
	),
);

$TCA['tx_adgooglemaps_domain_model_map'] = array(
	'ctrl' => $TCA['tx_adgooglemaps_domain_model_map']['ctrl'],
	'feInterface' => $TCA['tx_adgooglemaps_domain_model_map']['feInterface'],
	'interface' => array(
		'showRecordFieldList' => 'title'
	),
	'columns' => array(
		'l18n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_adgooglemaps_domain_model_map',
				'foreign_table_where' => 'AND tx_adgooglemaps_domain_model_map.pid=###CURRENT_PID### AND tx_adgooglemaps_domain_model_map.sys_language_uid IN (-1,0)',
			)
		),
		'title' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.title',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'required,trim',
			),
		),
		'categories' => Array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.categories',
			'config' => Array (
				'type' => 'select',
				'size' => 3,
				'autoSizeMax' => 15,
				'minitems' => 0,
				'maxitems' => 99,
				'foreign_table' => 'tx_adgooglemaps_domain_model_category',
				'foreign_table_where' => 'AND tx_adgooglemaps_domain_model_category.sys_language_uid IN (-1, ###REC_FIELD_sys_language_uid###) ORDER BY tx_adgooglemaps_domain_model_category.sorting',
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
		'map_type_id' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId',
			'exclude' => true,
			'config'  => array(
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.hybrid', Tx_AdGoogleMapsApi_ControlOptions_MapType::MAPTYPEID_HYBRID),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.roadmap', Tx_AdGoogleMapsApi_ControlOptions_MapType::MAPTYPEID_ROADMAP),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.satellite', Tx_AdGoogleMapsApi_ControlOptions_MapType::MAPTYPEID_SATELLITE),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.terrain', Tx_AdGoogleMapsApi_ControlOptions_MapType::MAPTYPEID_TERRAIN),
				),
			),
		),
		'width' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.width',
			'exclude' => true,
			'config'  => array(
				'type' => 'input',
				'size' => 2,
				'eval' => 'int',
				'default' => '0',
				'checkbox' => '0',
			),
		),
		'height' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.height',
			'exclude' => true,
			'config'  => array(
				'type' => 'input',
				'size' => 2,
				'eval' => 'int',
				'default' => '0',
				'checkbox' => '0',
			),
		),
		'background_color' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.backgroundColor',
			'exclude' => true,
			'config'  => array(
				'type' => 'input',
				'size' => 7,
				'default' => '0',
				'checkbox' => '0',
				'services' =>array(
					'colorpick' => array(
						'type' => 'colorbox',
						'title' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.colorPickerTitle',
						'script' => 'service_colorpicker.php',
						'dim' => '20x20',
						'tableStyle' => 'margin-left: 5px;',
						'JSopenParams' => 'height=300,width=365,status=0,menubar=0,scrollbars=0',
					),
				),
			),
		),
		'center_type' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.centerType',
			'exclude' => true,
			'config'  => array(
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.centerType.default', Tx_AdGoogleMaps_Domain_Model_Map::CENTER_TYPE_DEFAULT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.centerType.bounds', Tx_AdGoogleMaps_Domain_Model_Map::CENTER_TYPE_BOUNDS),
				),
			),
		),
		'zoom' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.zoom',
			'displayCond' => 'FIELD:center_type:=:' . Tx_AdGoogleMaps_Domain_Model_Map::CENTER_TYPE_DEFAULT,
			'exclude' => true,
			'config'  => array(
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
		'min_zoom' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.minZoom',
			'exclude' => true,
			'config'  => array(
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
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.maxZoom',
			'exclude' => true,
			'config'  => array(
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
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.noClear',
			'exclude' => true,
			'config'  => array(
				'type' => 'check',
			),
		),
		'disable_default_ui' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.disableDefaultUi',
			'exclude' => true,
			'config'  => array(
				'type' => 'check',
			),
		),
		'map_type_control' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControl',
			'exclude' => true,
			'config'  => array(
				'type' => 'check',
			),
		),
		'map_type_control_options_map_type_ids' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControlOptions.mapTypeIds',
			'displayCond' => 'FIELD:map_type_control:REQ:true',
			'exclude' => true,
			'config'  => array(
				'type' => 'select',
				'size' => 4,
				'minitems' => 1,
				'maxitems' => 4,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.hybrid', Tx_AdGoogleMapsApi_ControlOptions_MapType::MAPTYPEID_HYBRID),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.roadmap', Tx_AdGoogleMapsApi_ControlOptions_MapType::MAPTYPEID_ROADMAP),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.satellite', Tx_AdGoogleMapsApi_ControlOptions_MapType::MAPTYPEID_SATELLITE),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeId.terrain', Tx_AdGoogleMapsApi_ControlOptions_MapType::MAPTYPEID_TERRAIN),
				),
			),
		),
		'map_type_control_options_position' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControlOptions.position',
			'displayCond' => 'FIELD:map_type_control:REQ:true',
			'exclude' => true,
			'config'  => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMapsApi_ControlOptions_MapType::POSITION_TOP_RIGHT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.top', Tx_AdGoogleMapsApi_ControlOptions_MapType::POSITION_TOP),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topRight', Tx_AdGoogleMapsApi_ControlOptions_MapType::POSITION_TOP_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.right', Tx_AdGoogleMapsApi_ControlOptions_MapType::POSITION_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomRight', Tx_AdGoogleMapsApi_ControlOptions_MapType::POSITION_BOTTOM_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottom', Tx_AdGoogleMapsApi_ControlOptions_MapType::POSITION_BOTTOM),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomLeft', Tx_AdGoogleMapsApi_ControlOptions_MapType::POSITION_BOTTOM_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.left', Tx_AdGoogleMapsApi_ControlOptions_MapType::POSITION_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topLeft', Tx_AdGoogleMapsApi_ControlOptions_MapType::POSITION_TOP_LEFT),
				),
			),
		),
		'map_type_control_options_style' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControlOptions.style',
			'displayCond' => 'FIELD:map_type_control:REQ:true',
			'exclude' => true,
			'config'  => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMapsApi_ControlOptions_MapType::STYLE_DEFAULT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControlOptions.style.default', Tx_AdGoogleMapsApi_ControlOptions_MapType::STYLE_DEFAULT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControlOptions.style.dropdownMenu', Tx_AdGoogleMapsApi_ControlOptions_MapType::STYLE_DROPDOWN_MENU),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.mapTypeControlOptions.style.horizontalBar', Tx_AdGoogleMapsApi_ControlOptions_MapType::STYLE_HORIZONTAL_BAR),
				),
			),
		),
		'navigation_control' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.navigationControl',
			'exclude' => true,
			'config'  => array(
				'type' => 'check',
			),
		),
		'navigation_control_options_position' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.navigationControlOptions.position',
			'displayCond' => 'FIELD:navigation_control:REQ:true',
			'exclude' => true,
			'config'  => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMapsApi_ControlOptions_Navigation::POSITION_TOP_LEFT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.top', Tx_AdGoogleMapsApi_ControlOptions_Navigation::POSITION_TOP),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topRight', Tx_AdGoogleMapsApi_ControlOptions_Navigation::POSITION_TOP_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.right', Tx_AdGoogleMapsApi_ControlOptions_Navigation::POSITION_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomRight', Tx_AdGoogleMapsApi_ControlOptions_Navigation::POSITION_BOTTOM_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottom', Tx_AdGoogleMapsApi_ControlOptions_Navigation::POSITION_BOTTOM),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomLeft', Tx_AdGoogleMapsApi_ControlOptions_Navigation::POSITION_BOTTOM_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.left', Tx_AdGoogleMapsApi_ControlOptions_Navigation::POSITION_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topLeft', Tx_AdGoogleMapsApi_ControlOptions_Navigation::POSITION_TOP_LEFT),
				),
			),
		),
		'navigation_control_options_style' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.navigationControlOptions.style',
			'displayCond' => 'FIELD:navigation_control:REQ:true',
			'exclude' => true,
			'config'  => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMapsApi_ControlOptions_Navigation::STYLE_DEFAULT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.navigationControlOptions.style.default', Tx_AdGoogleMapsApi_ControlOptions_Navigation::STYLE_DEFAULT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.navigationControlOptions.style.android', Tx_AdGoogleMapsApi_ControlOptions_Navigation::STYLE_ANDROID),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.navigationControlOptions.style.small', Tx_AdGoogleMapsApi_ControlOptions_Navigation::STYLE_SMALL),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.navigationControlOptions.style.zoomPan', Tx_AdGoogleMapsApi_ControlOptions_Navigation::STYLE_ZOOM_PAN),
				),
			),
		),
		'scale_control' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.scaleControl',
			'exclude' => true,
			'config'  => array(
				'type' => 'check',
			),
		),
		'scale_control_options_position' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.scaleControlOptions.position',
			'displayCond' => 'FIELD:scale_control:REQ:true',
			'exclude' => true,
			'config'  => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMapsApi_ControlOptions_Scale::POSITION_BOTTOM_LEFT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.top', Tx_AdGoogleMapsApi_ControlOptions_Scale::POSITION_TOP),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topRight', Tx_AdGoogleMapsApi_ControlOptions_Scale::POSITION_TOP_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.right', Tx_AdGoogleMapsApi_ControlOptions_Scale::POSITION_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomRight', Tx_AdGoogleMapsApi_ControlOptions_Scale::POSITION_BOTTOM_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottom', Tx_AdGoogleMapsApi_ControlOptions_Scale::POSITION_BOTTOM),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomLeft', Tx_AdGoogleMapsApi_ControlOptions_Scale::POSITION_BOTTOM_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.left', Tx_AdGoogleMapsApi_ControlOptions_Scale::POSITION_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topLeft', Tx_AdGoogleMapsApi_ControlOptions_Scale::POSITION_TOP_LEFT),
				),
			),
		),
		'scale_control_options_style' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.scaleControlOptions.style',
			'displayCond' => 'FIELD:scale_control:REQ:true',
			'exclude' => true,
			'config'  => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMapsApi_ControlOptions_Scale::STYLE_DEFAULT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.scaleControlOptions.style.default', Tx_AdGoogleMapsApi_ControlOptions_Scale::STYLE_DEFAULT),
				),
			),
		),
		'pan_control' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.panControl',
			'exclude' => true,
			'config'  => array(
				'type' => 'check',
			),
		),
		'pan_control_options_position' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.panControlOptions.position',
			'displayCond' => 'FIELD:pan_control:REQ:true',
			'exclude' => true,
			'config'  => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMapsApi_ControlOptions_Pan::POSITION_TOP_LEFT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.top', Tx_AdGoogleMapsApi_ControlOptions_Pan::POSITION_TOP),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topRight', Tx_AdGoogleMapsApi_ControlOptions_Pan::POSITION_TOP_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.right', Tx_AdGoogleMapsApi_ControlOptions_Pan::POSITION_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomRight', Tx_AdGoogleMapsApi_ControlOptions_Pan::POSITION_BOTTOM_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottom', Tx_AdGoogleMapsApi_ControlOptions_Pan::POSITION_BOTTOM),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomLeft', Tx_AdGoogleMapsApi_ControlOptions_Pan::POSITION_BOTTOM_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.left', Tx_AdGoogleMapsApi_ControlOptions_Pan::POSITION_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topLeft', Tx_AdGoogleMapsApi_ControlOptions_Pan::POSITION_TOP_LEFT),
				),
			),
		),
		'zoom_control' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.zoomControl',
			'exclude' => true,
			'config'  => array(
				'type' => 'check',
			),
		),
		'zoom_control_options_position' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.zoomControlOptions.position',
			'displayCond' => 'FIELD:zoom_control:REQ:true',
			'exclude' => true,
			'config'  => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMapsApi_ControlOptions_Zoom::POSITION_BOTTOM_LEFT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.top', Tx_AdGoogleMapsApi_ControlOptions_Zoom::POSITION_TOP),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topRight', Tx_AdGoogleMapsApi_ControlOptions_Zoom::POSITION_TOP_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.right', Tx_AdGoogleMapsApi_ControlOptions_Zoom::POSITION_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomRight', Tx_AdGoogleMapsApi_ControlOptions_Zoom::POSITION_BOTTOM_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottom', Tx_AdGoogleMapsApi_ControlOptions_Zoom::POSITION_BOTTOM),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomLeft', Tx_AdGoogleMapsApi_ControlOptions_Zoom::POSITION_BOTTOM_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.left', Tx_AdGoogleMapsApi_ControlOptions_Zoom::POSITION_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topLeft', Tx_AdGoogleMapsApi_ControlOptions_Zoom::POSITION_TOP_LEFT),
				),
			),
		),
		'zoom_control_options_style' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.zoomControlOptions.style',
			'displayCond' => 'FIELD:zoom_control:REQ:true',
			'exclude' => true,
			'config'  => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMapsApi_ControlOptions_Zoom::STYLE_DEFAULT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.zoomControlOptions.style.default', Tx_AdGoogleMapsApi_ControlOptions_Zoom::STYLE_DEFAULT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.zoomControlOptions.style.small', Tx_AdGoogleMapsApi_ControlOptions_Zoom::STYLE_SMALL),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.zoomControlOptions.style.large', Tx_AdGoogleMapsApi_ControlOptions_Zoom::STYLE_LARGE),
				),
			),
		),
		'street_view_control' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.streetViewControl',
			'exclude' => true,
			'config'  => array(
				'type' => 'check',
			),
		),
		'street_view_control_options_position' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.streetViewControlOptions.position',
			'displayCond' => 'FIELD:street_view_control:REQ:true',
			'exclude' => true,
			'config'  => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMapsApi_ControlOptions_StreetView::POSITION_TOP_LEFT,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.top', Tx_AdGoogleMapsApi_ControlOptions_StreetView::POSITION_TOP),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topRight', Tx_AdGoogleMapsApi_ControlOptions_StreetView::POSITION_TOP_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.right', Tx_AdGoogleMapsApi_ControlOptions_StreetView::POSITION_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomRight', Tx_AdGoogleMapsApi_ControlOptions_StreetView::POSITION_BOTTOM_RIGHT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottom', Tx_AdGoogleMapsApi_ControlOptions_StreetView::POSITION_BOTTOM),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.bottomLeft', Tx_AdGoogleMapsApi_ControlOptions_StreetView::POSITION_BOTTOM_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.left', Tx_AdGoogleMapsApi_ControlOptions_StreetView::POSITION_LEFT),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.controlPosition.topLeft', Tx_AdGoogleMapsApi_ControlOptions_StreetView::POSITION_TOP_LEFT),
				),
			),
		),
		'disable_double_click_zoom' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.disableDoubleClickZoom',
			'exclude' => true,
			'config'  => array(
				'type' => 'check',
				'default' => 1,
			),
		),
		'scrollwheel' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.scrollwheel',
			'exclude' => true,
			'config'  => array(
				'type' => 'check',
				'default' => 1,
			),
		),
		'draggable' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.draggable',
			'exclude' => true,
			'config'  => array(
				'type' => 'check',
				'default' => 1,
			),
		),
		'draggable_cursor' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.draggableCursor',
			'displayCond' => 'FIELD:draggable:REQ:true',
			'exclude' => true,
			'config'  => array(
				'type'          => 'group',
				'internal_type' => 'file',
				'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size'      => 3000,
				'uploadfolder'  => $mouseCursorUploadDirectory,
				'show_thumbs'   => 1,
				'size'          => 1,
				'minitems'      => 0,
				'maxitems'      => 1,
			),
		),
		'dragging_cursor' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.draggingCursor',
			'displayCond' => 'FIELD:draggable:REQ:true',
			'exclude' => true,
			'config'  => array(
				'type'          => 'group',
				'internal_type' => 'file',
				'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size'      => 3000,
				'uploadfolder'  => $mouseCursorUploadDirectory,
				'show_thumbs'   => 1,
				'size'          => 1,
				'minitems'      => 0,
				'maxitems'      => 1,
			),
		),
		'keyboard_shortcuts' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.keyboardShortcuts',
			'exclude' => true,
			'config'  => array(
				'type' => 'check',
			),
		),
		'info_window_close_all_on_map_click' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowCloseAllOnMapClick',
			'config'  => array(
				'type' => 'check',
				'default' => 0,
			),
		),
		'info_window_behaviour' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowBehaviour',
			'exclude' => true,
			'config'  => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_MAP | Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowBehaviour.byMapAndLayer', Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_MAP | Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowBehaviour.byMap', Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_MAP),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowBehaviour.byLayer', Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER),
				),
			),
		),
		'info_window_placing_type' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowPlacingType',
			'displayCond' => 'FIELD:info_window_behaviour:!=:' . Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER,
			'config'  => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_Domain_Model_Layer::INFO_WINDOW_PLACING_TYPE_MARKERS | Tx_AdGoogleMaps_Domain_Model_Layer::INFO_WINDOW_PLACING_TYPE_SHAPE,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowPlacingType.both', Tx_AdGoogleMaps_Domain_Model_Layer::INFO_WINDOW_PLACING_TYPE_MARKERS | Tx_AdGoogleMaps_Domain_Model_Layer::INFO_WINDOW_PLACING_TYPE_SHAPE),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowPlacingType.markers', Tx_AdGoogleMaps_Domain_Model_Layer::INFO_WINDOW_PLACING_TYPE_MARKERS),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowPlacingType.shape', Tx_AdGoogleMaps_Domain_Model_Layer::INFO_WINDOW_PLACING_TYPE_SHAPE),
				),
			),
		),
		'info_window_position' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowPosition',
			'displayCond' => 'FIELD:info_window_behaviour:!=:' . Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER,
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 15,
				'eval' => 'trim',
			),
		),
		'info_window_object_number' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowObjectNumber',
			'displayCond' => 'FIELD:info_window_behaviour:!=:' . Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER,
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 15,
				'eval' => 'trim',
			),
		),
		'info_window_keep_open' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowKeepOpen',
			'displayCond' => 'FIELD:info_window_behaviour:!=:' . Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER,
			'config'  => array(
				'type' => 'check',
			),
		),
		'info_window_close_on_click' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowCloseOnClick',
			'displayCond' => 'FIELD:info_window_behaviour:!=:' . Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER,
			'config'  => array(
				'type' => 'check',
			),
		),
		'info_window_disable_auto_pan' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowDisableAutoPan',
			'displayCond' => 'FIELD:info_window_behaviour:!=:' . Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER,
			'config'  => array(
				'type' => 'check',
				'default' => 0,
			),
		),
		'info_window_max_width' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowMaxWidth',
			'displayCond' => 'FIELD:info_window_behaviour:!=:' . Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER,
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'info_window_pixel_offset_width' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowPixelOffsetWidth',
			'displayCond' => 'FIELD:info_window_behaviour:!=:' . Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER,
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'info_window_pixel_offset_height' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.infoWindowPixelOffsetHeight',
			'displayCond' => 'FIELD:info_window_behaviour:!=:' . Tx_AdGoogleMaps_Domain_Model_Map::INFO_WINDOW_BEHAVIOUR_BY_LAYER,
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
	),
	'palettes' => array(
		'1' => array('showitem' => 'hidden, sys_language_uid, l18n_parent'),
		'2' => array('showitem' => 'width, height, background_color, --linebreak--, min_zoom, max_zoom, no_clear'),
		'3' => array('canNotCollapse' => true, 'showitem' => 'zoom'),
		// Can't be in one line with linebreak option. Gives error.
		// @see: http://bugs.typo3.org/view.php?id=16498 
		'4' => array('canNotCollapse' => true, 'showitem' => 'map_type_control_options_map_type_ids'),
		'5' => array('canNotCollapse' => true, 'showitem' => 'map_type_control_options_position, map_type_control_options_style'),
		'6' => array('canNotCollapse' => true, 'showitem' => 'navigation_control_options_position, navigation_control_options_style'),
		'7' => array('canNotCollapse' => true, 'showitem' => 'scale_control_options_position, scale_control_options_style'),
		'8' => array('canNotCollapse' => true, 'showitem' => 'pan_control_options_position'),
		'9' => array('canNotCollapse' => true, 'showitem' => 'zoom_control_options_position, zoom_control_options_style'),
		'10' => array('canNotCollapse' => true, 'showitem' => 'street_view_control_options_position'),
		// Can't be in one line with linebreak option. Gives error.
		// @see: http://bugs.typo3.org/view.php?id=16498 
		'11' => array('canNotCollapse' => true, 'showitem' => 'draggable_cursor'),
		'12' => array('canNotCollapse' => true, 'showitem' => 'dragging_cursor'),
		'13' => array('canNotCollapse' => true, 'showitem' => 'info_window_keep_open, info_window_close_on_click, info_window_disable_auto_pan'),
		'14' => array('canNotCollapse' => true, 'showitem' => 'info_window_max_width, info_window_pixel_offset_width, info_window_pixel_offset_height'),
		'15' => array('canNotCollapse' => true, 'showitem' => 'info_window_placing_type, info_window_position, info_window_object_number'),
	),
	'types' => array(
		'1' => array(
			'showitem' => 'title;;1, categories;;;;1-1-1, 
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.sheetInitial, 
				map_type_id;;2, center_type;;3;;1-1-1,
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.sheetControllers, 
				disable_default_ui, map_type_control;;4, --palette--;;5, navigation_control;;6, scale_control;;7, pan_control;;8, zoom_control;;9, street_view_control;;10,
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.sheetInteraction, 
				disable_double_click_zoom, scrollwheel, draggable;;11, --palette--;;12, keyboard_shortcuts,
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_map.sheetInfoWindows, 
				info_window_close_all_on_map_click, info_window_behaviour, --palette--;;13, --palette--;;14, --palette--;;15,
				--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access, 
				starttime, endtime, fe_group'
		),
	),
);

$TCA['tx_adgooglemaps_domain_model_map']['columns'] = array_merge($TCA['tx_adgooglemaps_domain_model_map']['columns'], $systemColumns);

$TCA['tx_adgooglemaps_domain_model_category'] = array(
	'ctrl' => $TCA['tx_adgooglemaps_domain_model_category']['ctrl'],
	'feInterface' => $TCA['tx_adgooglemaps_domain_model_category']['feInterface'],
	'interface' => array(
		'showRecordFieldList' => 'title, coordinates'
	),
	'columns' => array(
		'l18n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_adgooglemaps_domain_model_category',
				'foreign_table_where' => 'AND tx_adgooglemaps_domain_model_category.pid=###CURRENT_PID### AND tx_adgooglemaps_domain_model_category.sys_language_uid IN (-1,0)',
			)
		),
		'title' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_category.title',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'required,trim',
				'max'  => 256
			)
		),
		'icon' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_category.icon',
			'config'  => array(
				'type'          => 'group',
				'internal_type' => 'file',
				'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size'      => 3000,
				'uploadfolder'  => $categoryIconsUploadDirectory,
				'show_thumbs'   => 1,
				'size'          => 1,
				'minitems'      => 0,
				'maxitems'      => 1,
			),
		),
		'icon_width' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_category.iconWidth',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'icon_height' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_category.iconHeight',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'description' => Array (
			'l10n_mode' => 'prefixLangTitle',
			'l10n_cat' => 'text',
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_category.description',
			'config' => Array (
				'type' => 'text',
				'cols' => '48',
				'rows' => '5',
				'services' => Array(
					'_PADDING' => 4,
					'_VALIGN' => 'middle',
					'RTE' => Array(
						'notNewRecords' => 1,
						'RTEonly' => 1,
						'type' => 'script',
						'title' => 'LLL:EXT:cms/locallang_ttc.php:bodytext.W.RTE',
						'icon' => 'service_rte2.gif',
						'script' => 'service_rte.php',
					),
					'table' => Array(
						'notNewRecords' => 1,
						'enableByTypeConfig' => 1,
						'type' => 'script',
						'title' => 'Table service',
						'icon' => 'service_table.gif',
						'script' => 'service_table.php',
						'params' => array('xmlOutput' => 0)
					),
					'forms' => Array(
						'notNewRecords' => 1,
						'enableByTypeConfig' => 1,
						'type' => 'script',
#						'hideParent' => array('rows' => 4),
						'title' => 'Forms service',
						'icon' => 'service_forms.gif',
						'script' => 'service_forms.php?special=formtype_mail',
						'params' => array('xmlOutput' => 0)
					)
				),
				'softref' => 'typolink_tag,images,email[subst],url'
			)
		),
		'rte_enabled' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_ttc.php:rte_enabled',
			'config' => Array (
				'type' => 'check',
				'showIfRTE' => 1
			)
		),
		'layers' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_category.layers',
			'config'  => array(
				'type' => 'select',
				'size' => '5',
				'autoSizeMax' => 15,
				'maxitems' => 99,
				'foreign_table' => 'tx_adgooglemaps_domain_model_layer',
				'foreign_table_where' => 'AND tx_adgooglemaps_domain_model_layer.sys_language_uid=###REC_FIELD_sys_language_uid### ORDER BY tx_adgooglemaps_domain_model_layer.sorting',
				'MM' => 'tx_adgooglemaps_category_layer_mm',
			),
		),
		'parent_category' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_category.parentCategory',
			'config'  => array(
				'type' => 'select',
				'size' => 1,
				'autoSizeMax' => 15,
				'minitems' => 0,
				'maxitems' => 1,
				'items' => array (
					array('', ''),
				),
				'foreign_table' => 'tx_adgooglemaps_domain_model_category',
				'foreign_table_where' => 'AND tx_adgooglemaps_domain_model_category.uid!=###THIS_UID### AND tx_adgooglemaps_domain_model_category.sys_language_uid=###REC_FIELD_sys_language_uid### ORDER BY tx_adgooglemaps_domain_model_category.sorting',
				'MM' => 'tx_adgooglemaps_category_category_mm',
			),
		),
	),
	'palettes' => array(
		'1' => array('showitem' => 'hidden, sys_language_uid, l18n_parent'),
		'2' => array('showitem' => 'icon_width, icon_height'),
	),
	'types' => array(
		'1' => array(
			'showitem' => 'title;;1;;1-1-1, icon;;2, description;;;richtext:rte_transform[flag=rte_enabled|mode=ts_css];3-3-3, --palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_category.descriptionExtendedSettingsLabel;2, parent_category, layers,
				--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access, 
				starttime, endtime, fe_group', 
		),
	),
);

$TCA['tx_adgooglemaps_domain_model_category']['columns'] = array_merge($TCA['tx_adgooglemaps_domain_model_category']['columns'], $systemColumns);

$TCA['tx_adgooglemaps_domain_model_layer'] = array(
	'ctrl' => $TCA['tx_adgooglemaps_domain_model_layer']['ctrl'],
	'feInterface' => $TCA['tx_adgooglemaps_domain_model_layer']['feInterface'],
	'interface' => array(
		'showRecordFieldList' => 'title, coordinates'
	),
	'columns' => array(
		'l18n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_adgooglemaps_domain_model_layer',
				'foreign_table_where' => 'AND tx_adgooglemaps_domain_model_layer.pid=###CURRENT_PID### AND tx_adgooglemaps_domain_model_layer.sys_language_uid IN (-1,0)',
			)
		),
		'type' => array (
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.type',
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.type.markers', 'tx_adgooglemapsapi_layers_marker', 'EXT:ad_google_maps/Resources/Public/Icons/TCA/IconMarkers.gif'),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.type.polyline', 'tx_adgooglemapsapi_layers_polyline', 'EXT:ad_google_maps/Resources/Public/Icons/TCA/IconPolyline.gif'),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.type.polygon', 'tx_adgooglemapsapi_layers_polygon', 'EXT:ad_google_maps/Resources/Public/Icons/TCA/IconPolygon.gif'),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.type.kml', 'tx_adgooglemapsapi_layers_kml', 'EXT:ad_google_maps/Resources/Public/Icons/TCA/IconKml.gif'),
				),
				'default' => 'tx_adgooglemapsapi_layers_marker',
				'authMode' => $GLOBALS['TYPO3_CONF_VARS']['BE']['explicitADmode'],
				'authMode_enforce' => 'strict',
				'iconsInOptionTags' => 1,
				'noIconsBelowSelect' => 1,
			)
		),
		'title' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.title',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim',
			)
		),
		'visible' => array(
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.visible',
			'exclude' => true,
			'default' => 1,
			'config'  => array(
				'type' => 'check',
				'default' => 1,
			),
		),
		'coordinates_provider' => array (
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.coordinatesProvider',
			'config' => array (
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_Domain_Model_Layer::COODRINATES_PROVIDER_MAP_DRAWER,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.coordinatesProvider.mapDrawer', Tx_AdGoogleMaps_Domain_Model_Layer::COODRINATES_PROVIDER_MAP_DRAWER),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.coordinatesProvider.addresses', Tx_AdGoogleMaps_Domain_Model_Layer::COODRINATES_PROVIDER_ADDRESSES),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.coordinatesProvider.addressGroups', Tx_AdGoogleMaps_Domain_Model_Layer::COODRINATES_PROVIDER_ADDRESS_GROUPS),
				),
			)
		),
		'coordinates' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.coordinates',
			'displayCond' => 'FIELD:coordinates_provider:=:' . Tx_AdGoogleMaps_Domain_Model_Layer::COODRINATES_PROVIDER_MAP_DRAWER,
			'config'  => array(
				'type' => 'user',
				'userFunc' => 'EXT:ad_google_maps_api/Classes/Service/MapDrawer.php:tx_AdGoogleMapsApi_Service_MapDrawer->user_parseCoordinatesField',
			),
		),
		'addresses' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.addresses',
			'displayCond' => 'FIELD:coordinates_provider:=:' . Tx_AdGoogleMaps_Domain_Model_Layer::COODRINATES_PROVIDER_ADDRESSES,
			'config'  => array(
				'type' => 'select',
				'size' => '5',
				'autoSizeMax' => 15,
				'minitems' => 0,
				'maxitems' => 99,
				'foreign_table' => 'tt_address',
				'MM' => 'tx_adgooglemaps_layer_ttaddress_mm',
			),
		),
		'address_groups' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.addressGroups',
			'displayCond' => 'FIELD:coordinates_provider:=:' . Tx_AdGoogleMaps_Domain_Model_Layer::COODRINATES_PROVIDER_ADDRESS_GROUPS,
			'config'  => array(
				'type' => 'select',
				'size' => '5',
				'autoSizeMax' => 15,
				'minitems' => 0,
				'maxitems' => 99,
				'foreign_table' => 'tt_address_group',
				'MM' => 'tx_adgooglemaps_layer_ttaddressgroup_mm',
			),
		),
		'categories' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.categories',
			'config'  => array(
				'type' => 'select',
				'size' => 3,
				'autoSizeMax' => 15,
				'minitems' => 0,
				'maxitems' => 99,
				'foreign_table' => 'tx_adgooglemaps_domain_model_category',
				'foreign_table_where' => 'AND tx_adgooglemaps_domain_model_category.sys_language_uid IN (-1, ###REC_FIELD_sys_language_uid###) ORDER BY tx_adgooglemaps_domain_model_category.sorting',
				'MM' => 'tx_adgooglemaps_category_layer_mm',
				'MM_opposite_field' => 'layers',
			),
		),
		'marker_clickable' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.markerClickable',
			'config'  => array(
				'type' => 'check',
				'default' => 1,
			),
		),
		'shape_clickable' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shapeClickable',
			'config'  => array(
				'type' => 'check',
				'default' => 1,
			),
		),
		'draggable' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.draggable',
			'config'  => array(
				'type' => 'check',
				'default' => 0,
			),
		),
		'raise_on_drag' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.raiseOnDrag',
			'config'  => array(
				'type' => 'check',
				'default' => 1,
			),
		),
		'marker_zindex' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.markerZindex',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 4,
				'eval' => 'num,int,trim',
			),
		),
		'shape_zindex' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shapeZindex',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 4,
				'eval' => 'num,int,trim',
			),
		),
		'item_titles' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.itemTitles',
			'config'  => array(
				'type' => 'text',
				'size' => 20,
				'eval' => 'trim',
			)
		),
		'item_titles_object_number' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.itemTitlesObjectNumber',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 30,
				'eval' => 'trim',
			),
		),
		'add_markers' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.addMarkers',
			'config'  => array(
				'type' => 'check',
				'default' => 1,
			),
		),
		'force_listing' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.forceListing',
			'config'  => array(
				'type' => 'check',
				'default' => 1,
			),
		),
		'icon' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.icon',
			'config'  => array(
				'type'          => 'group',
				'internal_type' => 'file',
				'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size'      => 3000,
				'uploadfolder'  => $markerIconsUploadDirectory,
				'show_thumbs'   => 1,
				'size'          => 3,
				'autoSizeMax'	=> 15,
				'minitems'      => 0,
				'maxitems'      => 99,
			),
		),
		'icon_object_number' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconObjectNumber',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '',
				'size' => 30,
				'eval' => 'trim',
			),
		),
		'icon_width' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconWidth',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'icon_height' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconHeight',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'icon_scaled_width' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconScaledWidth',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'icon_scaled_height' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconScaledHeight',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'icon_origin_x' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconOriginX',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'icon_origin_y' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconOriginY',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'icon_anchor_x' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconAnchorX',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'icon_anchor_y' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconAnchorY',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'shadow' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadow',
			'config'  => array(
				'type'          => 'group',
				'internal_type' => 'file',
				'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size'      => 3000,
				'uploadfolder'  => $shadowIconsUploadDirectory,
				'show_thumbs'   => 1,
				'size'          => 3,
				'autoSizeMax'	=> 15,
				'minitems'      => 0,
				'maxitems'      => 99,
			),
		),
		'shadow_object_number' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowObjectNumber',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 30,
				'eval' => 'trim',
			),
		),
		'shadow_width' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowWidth',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'shadow_height' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowHeight',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'shadow_scaled_width' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowScaledWidth',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'shadow_scaled_height' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowScaledHeight',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'shadow_origin_x' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowOriginX',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'shadow_origin_y' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowOriginY',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'shadow_anchor_x' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowAnchorX',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'shadow_anchor_y' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowAnchorY',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'flat' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.flat',
			'config'  => array(
				'type' => 'check'
			),
		),
		'kml_file' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.kmlFile',
			'config'  => array(
				'type'          => 'group',
				'internal_type' => 'file',
				'allowed'       => 'kml,kmz',
				'max_size'      => 3000,
				'uploadfolder'  => $kmlFilesUploadDirectory,
				'show_thumbs'   => 1,
				'size'          => 1,
				'minitems'      => 0,
				'maxitems'      => 1,
			),
		),
		'kml_url' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.kmlUrl',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 24,
				'eval' => 'trim',
			),
		),
		'kml_suppress_info_windows' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.kmlSuppressInfoWindows',
			'config'  => array(
				'type' => 'check'
			),
		),
		'shape_type' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shapeType',
			'config'  => array(
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
		'shape' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shape',
			'displayCond' => 'FIELD:shape_type:!=:',
			'config'  => array(
				'type' => 'text',
				'rows' => 3,
			),
		),
		'mouse_cursor' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.mouseCursor',
			'config'  => array(
				'type'          => 'group',
				'internal_type' => 'file',
				'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size'      => 3000,
				'uploadfolder'  => $mouseCursorUploadDirectory,
				'show_thumbs'   => 1,
				'size'          => 1,
				'minitems'      => 0,
				'maxitems'      => 1,
			),
		),
		'geodesic' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.geodesic',
			'config'  => array(
				'type' => 'check',
				'default' => 0,
			),
		),
		'stroke_color' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.strokeColor',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'required,trim',
				'services' =>array(
					'colorpick' => array(
						'type' => 'colorbox',
						'title' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.colorPickerTitle',
						'script' => 'service_colorpicker.php',
						'dim' => '20x20',
						'tableStyle' => 'margin-left: 5px;',
						'JSopenParams' => 'height=300,width=365,status=0,menubar=0,scrollbars=0',
					),
				),
			),
		),
		'stroke_opacity' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.strokeOpacity',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 3,
				'eval' => 'required,num,int,trim',
				'range' => array(
					'lower' => 0,
					'upper' => 100,
				),
			),
		),
		'stroke_weight' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.strokeWeight',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 3,
				'eval' => 'required,num,int,trim',
			),
		),
		'fill_color' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.fillColor',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'required,trim',
				'services' =>array(
					'colorpick' => array(
						'type' => 'colorbox',
						'title' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.colorPickerTitle',
						'script' => 'service_colorpicker.php',
						'dim' => '20x20',
						'tableStyle' => 'margin-left: 5px;',
						'JSopenParams' => 'height=300,width=365,status=0,menubar=0,scrollbars=0',
					),
				),
			),
		),
		'fill_opacity' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.fillOpacity',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 3,
				'eval' => 'required,num,int,trim',
				'range' => array(
					'lower' => 0,
					'upper' => 100,
				),
			),
		),
		'info_window' => Array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindow',
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
		'info_window_placing_type' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowPlacingType',
			'config'  => array(
				'type' => 'select',
				'default' => Tx_AdGoogleMaps_Domain_Model_Layer::INFO_WINDOW_PLACING_TYPE_MARKERS | Tx_AdGoogleMaps_Domain_Model_Layer::INFO_WINDOW_PLACING_TYPE_SHAPE,
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowPlacingType.both', Tx_AdGoogleMaps_Domain_Model_Layer::INFO_WINDOW_PLACING_TYPE_MARKERS | Tx_AdGoogleMaps_Domain_Model_Layer::INFO_WINDOW_PLACING_TYPE_SHAPE),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowPlacingType.markers', Tx_AdGoogleMaps_Domain_Model_Layer::INFO_WINDOW_PLACING_TYPE_MARKERS),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowPlacingType.shape', Tx_AdGoogleMaps_Domain_Model_Layer::INFO_WINDOW_PLACING_TYPE_SHAPE),
				),
			),
		),
		'info_window_position' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowPosition',
			'config'  => array(
				'type' => 'input',
				'size' => 15,
				'eval' => 'trim',
				'default' => '0',
				'checkbox' => '0',
			),
		),
		'info_window_object_number' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowObjectNumber',
			'config'  => array(
				'type' => 'input',
				'size' => 15,
				'eval' => 'trim',
				'default' => '0',
				'checkbox' => '0',
			),
		),
		'info_window_keep_open' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowKeepOpen',
			'config'  => array(
				'type' => 'check',
				'default' => 0,
			),
		),
		'info_window_close_on_click' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowCloseOnClick',
			'config'  => array(
				'type' => 'check',
				'default' => 0,
			),
		),
		'info_window_disable_auto_pan' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowDisableAutoPan',
			'config'  => array(
				'type' => 'check',
				'default' => 0,
			),
		),
		'info_window_max_width' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowMaxWidth',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'info_window_zindex' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowZIndex',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 4,
				'eval' => 'required,num,int,trim',
			),
		),
		'info_window_pixel_offset_width' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowPixelOffsetWidth',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'info_window_pixel_offset_height' => array(
			'exclude' => true,
			'label'   => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowPixelOffsetHeight',
			'config'  => array(
				'type' => 'input',
				'default' => '0',
				'checkbox' => '0',
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
	),
	'palettes' => array(
		'1' => array('showitem' => 'hidden, sys_language_uid, l18n_parent'),
		'2' => array('canNotCollapse' => true, 'showitem' => 'item_titles_object_number, --linebreak--, visible, marker_clickable, draggable, raise_on_drag, marker_zindex'),
		'3' => array('canNotCollapse' => true, 'showitem' => 'shape_clickable, geodesic, shape_zindex'),
		'4' => array('showitem' => 'icon_object_number, --linebreak--, icon_width, icon_height, icon_scaled_height, icon_scaled_width, --linebreak--, icon_origin_x, icon_origin_y, icon_anchor_x, icon_anchor_y'),
		'5' => array('showitem' => 'shadow_object_number, --linebreak--, shadow_width, shadow_height, shadow_scaled_height, shadow_scaled_width, --linebreak--, shadow_origin_x, shadow_origin_y, shadow_anchor_x, shadow_anchor_y, --linebreak--, flat'),
		'6' => array('canNotCollapse' => true, 'showitem' => 'shape'),
		'7' => array('canNotCollapse' => true, 'showitem' => 'stroke_color, stroke_opacity, stroke_weight'),
		'8' => array('canNotCollapse' => true, 'showitem' => 'fill_color, fill_opacity'),
		'9' => array('showitem' => 'info_window_keep_open, info_window_close_on_click, info_window_disable_auto_pan, --linebreak--, info_window_max_width, info_window_zindex, info_window_pixel_offset_width, info_window_pixel_offset_height, --linebreak--,info_window_placing_type, info_window_position, info_window_object_number'),
		'10' => array('showitem' => 'force_listing'),
		'11' => array('showitem' => 'kml_url, --linebreak--, kml_suppress_info_windows'),
	),
	'types' => array(
		'tx_adgooglemapsapi_layers_marker' => array(
			'showitem' => 'type;;1;;1-1-1, title, coordinates_provider, coordinates, addresses, address_groups, categories;;;;1-1-1, 
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.sheetMarkers, 
				item_titles, --palette--;;2, icon, --palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconExtendedSettingsLabel;4, shadow, --palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowExtendedSettingsLabel;5, shape_type;;6, mouse_cursor;;;;1-1-1,
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.sheetInfoWindow, 
				info_window, --palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowExtendedSettingsLabel;9,
				--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access, 
				starttime, endtime, fe_group'
		),
		'tx_adgooglemapsapi_layers_polyline' => array(
			'showitem' => 'type;;1;;1-1-1, title, coordinates_provider, coordinates, addresses, address_groups, categories;;;;1-1-1,
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.sheetAppearance, 
				--palette--;;3, --palette--;;7,
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.sheetMarkers, 
				add_markers;;10, item_titles, --palette--;;2, icon, --palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconExtendedSettingsLabel;4, shadow, --palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowExtendedSettingsLabel;5, shape_type;;6, mouse_cursor;;;;1-1-1,
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.sheetInfoWindow, 
				info_window, --palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowExtendedSettingsLabel;9,
				--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access, 
				starttime, endtime, fe_group', 
		),
		'tx_adgooglemapsapi_layers_polygon' => array(
			'showitem' => 'type;;1;;1-1-1, title, coordinates_provider, coordinates, addresses, address_groups, categories;;;;1-1-1,
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.sheetAppearance, 
				--palette--;;3, --palette--;;7, --palette--;;8,
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.sheetMarkers, 
				add_markers;;10, item_titles, --palette--;;2, icon, --palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.iconExtendedSettingsLabel;4, shadow, --palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.shadowExtendedSettingsLabel;5, shape_type;;6, mouse_cursor;;;;1-1-1,
				--div--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.sheetInfoWindow, 
				info_window, --palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowExtendedSettingsLabel;9,
				--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access, 
				starttime, endtime, fe_group'
		),
		'tx_adgooglemapsapi_layers_kml' => array(
			'showitem' => 'type;;1;;1-1-1, title, kml_file;;11,
				--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access, 
				starttime, endtime, fe_group'
		),
	),
);

$TCA['tx_adgooglemaps_domain_model_layer']['columns'] = array_merge($TCA['tx_adgooglemaps_domain_model_layer']['columns'], $systemColumns);

?>