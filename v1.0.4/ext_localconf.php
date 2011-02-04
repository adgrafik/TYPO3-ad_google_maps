<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi1',
	array(
		'GoogleMaps' => 'index'
	),
	array( // don't cache some actions
		'GoogleMaps' => ''
	)
);

$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['processDatamap_postProcessFieldArray'] = 'EXT:ad_google_maps/Classes/Service/AddressPostProcess.php:tx_AdGoogleMaps_Service_AddressPostProcess';

?>