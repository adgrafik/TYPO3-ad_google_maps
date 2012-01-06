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

$TCA['tx_adgooglemaps_domain_model_layer'] = array(
	'ctrl' => $TCA['tx_adgooglemaps_domain_model_layer']['ctrl'],
	'feInterface' => $TCA['tx_adgooglemaps_domain_model_layer']['feInterface'],
	'interface' => array(
		'showRecordFieldList' => 'title, coordinates'
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
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.type.markers', 'Tx_AdGoogleMaps_MapManager_LayerProcessor_Marker', 'EXT:ad_google_maps/Resources/Public/Icons/TCA/IconMarker.gif'),
				),
				'default' => 'Tx_AdGoogleMaps_MapManager_LayerProcessor_Marker',
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
		'optimized' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.optimized',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'default' => 1,
			),
		),
		'animation' => array (
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.animation',
			'exclude' => true,
			'l10n_display' => $excludeProperties,
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.animation.none', ''),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.animation.drop', Tx_AdGoogleMaps_MapBuilder_API_Overlay_Marker::ANIMATION_DROP),
					array('LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.animation.bounce', Tx_AdGoogleMaps_MapBuilder_API_Overlay_Marker::ANIMATION_BOUNCE),
				),
			)
		),
		'zindex' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.zindex',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
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
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
		'flat' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.flat',
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
			),
		),
		'info_window_keep_open' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowKeepOpen',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'default' => 0,
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.enable',
					),
				),
			),
		),
		'info_window_close_on_click' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowCloseOnClick',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'default' => 0,
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.enable',
					),
				),
			),
		),
		'info_window_disable_auto_pan' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowDisableAutoPan',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'check',
				'default' => 0,
				'items' => array (
					'1'	=> array(
						'0' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model.enable',
					),
				),
			),
		),
		'info_window_max_width' => array(
			'label' => 'LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.infoWindowMaxWidth',
			'exclude' => true,
			'l10n_mode' => $excludeProperties,
			'config' => array(
				'type' => 'input',
				'default' => '0',
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
				'size' => 7,
				'eval' => 'num,int,trim',
			),
		),
	),
	'palettes' => array(
		'recordSettings' => array('canNotCollapse' => 1, 'showitem' => 'type, sys_language_uid, l18n_parent, --linebreak--, title'),
		'markerTitleArrangement' => array('showitem' => 'marker_title_object_number'),
		'markerProperties' => array('showitem' => 'visible, clickable, draggable, raise_on_drag, optimized, --linebreak--, animation, zindex'),
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
		'visibility' => array('canNotCollapse' => 1, 'showitem' => 'hidden;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.label'),
		'access' => array('canNotCollapse' => 1, 'showitem' => 'starttime;LLL:EXT:cms/locallang_ttc.xml:starttime_formlabel, endtime;LLL:EXT:cms/locallang_ttc.xml:endtime_formlabel, --linebreak--, fe_group;LLL:EXT:cms/locallang_ttc.xml:fe_group_formlabel'),
	),
	'types' => array(
		'Tx_AdGoogleMaps_MapManager_LayerProcessor_Marker' => array(
			'showitem' => '
					--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.paletteTitle.recordSettings;recordSettings, 
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
						--palette--;;shadowFlat, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.paletteTitle.shadowArrangement;shadowArrangement, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.paletteTitle.shadowDimensions;shadowDimensions, 
						--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_layer.paletteTitle.shadowPosition;shadowPosition, 
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

?>