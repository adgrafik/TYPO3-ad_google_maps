<?php
$extensionClassesPath = t3lib_extMgm::extPath('ad_google_maps') . 'Classes/';
return array(
	'tx_adgooglemaps_exception' => $extensionClassesPath . 'Exception.php',
	'tx_adgooglemaps_mapdrawer_exception' => $extensionClassesPath . 'MapDrawer/Exception.php',
	'tx_adgooglemaps_mapdrawer_layer_abstractlayer' => $extensionClassesPath . 'MapDrawer/Layer/AbstractLayer.php',
	'tx_adgooglemaps_mapdrawer_layer_marker' => $extensionClassesPath . 'MapDrawer/Layer/Marker.php',
);
?>