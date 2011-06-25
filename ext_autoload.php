<?php
$extensionClassesPath = t3lib_extMgm::extPath('ad_google_maps') . 'Classes/';
return array(
	'tx_adgooglemaps_exception' => $extensionClassesPath . 'Exception.php',
	'tx_adgooglemaps_utility_backend' => $extensionClassesPath . 'Utility/BackEnd.php',
	'tx_adgooglemaps_utility_frontend' => $extensionClassesPath . 'Utility/FrontEnd.php',

	'tx_adgooglemaps_mapbuilder_api_controloptions_abstractcontroloptions' => $extensionClassesPath . 'MapBuilder/Api/ControlOptions/AbstractControlOptions.php',
	'tx_adgooglemaps_mapbuilder_api_controloptions_maptype' => $extensionClassesPath . 'MapBuilder/Api/ControlOptions/MapType.php',
	'tx_adgooglemaps_mapbuilder_api_controloptions_navigation' => $extensionClassesPath . 'MapBuilder/Api/ControlOptions/Navigation.php',
	'tx_adgooglemaps_mapbuilder_api_controloptions_pan' => $extensionClassesPath . 'MapBuilder/Api/ControlOptions/Pan.php',
	'tx_adgooglemaps_mapbuilder_api_controloptions_scale' => $extensionClassesPath . 'MapBuilder/Api/ControlOptions/Scale.php',
	'tx_adgooglemaps_mapbuilder_api_controloptions_zoom' => $extensionClassesPath . 'MapBuilder/Api/ControlOptions/Zoom.php',
	'tx_adgooglemaps_mapbuilder_api_controloptions_streetview' => $extensionClassesPath . 'MapBuilder/Api/ControlOptions/StreetView.php',
	'tx_adgooglemaps_mapbuilder_api_layers_layerinterface' => $extensionClassesPath . 'MapBuilder/Api/Layers/LayerInterface.php',
	'tx_adgooglemaps_mapbuilder_api_layers_abstractlayer' => $extensionClassesPath . 'MapBuilder/Api/Layers/AbstractLayer.php',
	'tx_adgooglemaps_mapbuilder_api_layers_infowindow' => $extensionClassesPath . 'MapBuilder/Api/Layers/InfoWindow.php',
	'tx_adgooglemaps_mapbuilder_api_layers_marker' => $extensionClassesPath . 'MapBuilder/Api/Layers/Marker.php',
	'tx_adgooglemaps_mapbuilder_api_latlng' => $extensionClassesPath . 'MapBuilder/Api/LatLng.php',

	'tx_adgooglemaps_domain_model_abstractentity' => $extensionClassesPath . 'Domain/Model/AbstractEntity.php',
	'tx_adgooglemaps_mapdrawer_exception' => $extensionClassesPath . 'MapDrawer/Exception.php',
	'tx_adgooglemaps_mapdrawer_layer_abstractlayer' => $extensionClassesPath . 'MapDrawer/Layer/AbstractLayer.php',
	'tx_adgooglemaps_mapdrawer_layer_marker' => $extensionClassesPath . 'MapDrawer/Layer/Marker.php',
	'tx_adgooglemaps_service_flexformtemplateselection' => $extensionClassesPath . 'Service/FlexFormTemplateSelection.php',
);
?>