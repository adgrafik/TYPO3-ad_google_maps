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

$TCA['tx_adgooglemaps_domain_model_category'] = array(
	'ctrl' => $TCA['tx_adgooglemaps_domain_model_category']['ctrl'],
	'feInterface' => $TCA['tx_adgooglemaps_domain_model_category']['feInterface'],
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
		'recordSettings' => array('canNotCollapse' => 1, 'showitem' => 'title, sys_language_uid, l18n_parent'),
		'iconDimensions' => array('showitem' => 'icon_width, icon_height'),
		'rte' => array('canNotCollapse' => true, 'showitem' => 'rte_enabled'),
		'visibility' => array('canNotCollapse' => 1, 'showitem' => 'hidden;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_category.label'),
		'access' => array('canNotCollapse' => 1, 'showitem' => 'starttime;LLL:EXT:cms/locallang_ttc.xml:starttime_formlabel, endtime;LLL:EXT:cms/locallang_ttc.xml:endtime_formlabel, --linebreak--, fe_group;LLL:EXT:cms/locallang_ttc.xml:fe_group_formlabel'),
	),
	'types' => array(
		'1' => array(
			'showitem' => '
					--palette--;LLL:EXT:ad_google_maps/Resources/Private/Language/locallang_tca.xml:tx_adgooglemaps_domain_model_category.paletteTitle.recordSettings;recordSettings, 
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

?>