<?php
$extensionClassesPath = t3lib_extMgm::extPath('ad_google_maps') . 'Classes/';
return array(
	'tx_adgooglemaps_exception' => $extensionClassesPath . 'Exception.php',
	'tx_adgooglemaps_utility_backend' => $extensionClassesPath . 'Utility/BackEnd.php',
	'tx_adgooglemaps_utility_frontend' => $extensionClassesPath . 'Utility/FrontEnd.php',

	'tx_adgooglemaps_api_control_abstractcontrol' => $extensionClassesPath . 'Api/Control/AbstractControl.php',
	'tx_adgooglemaps_api_control_maptype' => $extensionClassesPath . 'Api/Control/MapType.php',
	'tx_adgooglemaps_api_control_rotate' => $extensionClassesPath . 'Api/Control/Rotate.php',
	'tx_adgooglemaps_api_control_pan' => $extensionClassesPath . 'Api/Control/Pan.php',
	'tx_adgooglemaps_api_control_scale' => $extensionClassesPath . 'Api/Control/Scale.php',
	'tx_adgooglemaps_api_control_zoom' => $extensionClassesPath . 'Api/Control/Zoom.php',
	'tx_adgooglemaps_api_control_streetview' => $extensionClassesPath . 'Api/Control/StreetView.php',
	'tx_adgooglemaps_api_overlay_overlayinterface' => $extensionClassesPath . 'Api/Overlay/OverlayInterface.php',
	'tx_adgooglemaps_api_overlay_abstractoverlay' => $extensionClassesPath . 'Api/Overlay/AbstractOverlay.php',
	'tx_adgooglemaps_api_overlay_infowindow' => $extensionClassesPath . 'Api/Overlay/InfoWindow.php',
	'tx_adgooglemaps_api_overlay_marker' => $extensionClassesPath . 'Api/Overlay/Marker.php',
	'tx_adgooglemaps_api_base_latlng' => $extensionClassesPath . 'Api/Base/LatLng.php',

	'tx_adgooglemaps_domain_model_abstractentity' => $extensionClassesPath . 'Domain/Model/AbstractEntity.php',
	'tx_adgooglemaps_mapdrawer_exception' => $extensionClassesPath . 'MapDrawer/Exception.php',
	'tx_adgooglemaps_mapdrawer_layer_abstractlayer' => $extensionClassesPath . 'MapDrawer/Layer/AbstractLayer.php',
	'tx_adgooglemaps_mapdrawer_layer_marker' => $extensionClassesPath . 'MapDrawer/Layer/Marker.php',
);
?>