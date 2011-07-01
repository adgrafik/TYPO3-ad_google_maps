<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi1',
	array(
		'GoogleMaps' => 'index',
	),
	array( // don't cache some actions
		'GoogleMaps' => '',
	)
);

?>