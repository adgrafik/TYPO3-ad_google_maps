<?php

########################################################################
# Extension Manager/Repository config file for ext "ad_google_maps".
#
# Auto generated 03-03-2011 12:55
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'ad: Google Maps',
	'description' => 'Google Maps for TYPO3. Lego-based and powerful extension with all configurable options of Google Maps API V3. Including a MapDrawer to set markers, polylines and polygons and a plugin to integrate on a page. Based on extbase and fluid v1.2.1. Please test and response ;)',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '1.0.5',
	'dependencies' => 'extbase,fluid,ad_google_maps_api',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Arno Dudek',
	'author_email' => 'webmaster@adgrafik.at',
	'author_company' => 'ad:grafik',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.4.5-0.0.0',
			'extbase' => '1.2.1-',
			'fluid' => '1.2.1-',
			'ad_google_maps_api' => '1.1.0-',
		),
		'conflicts' => array(
			'dbal' => '0.0.0-',
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:104:{s:9:"ChangeLog";s:4:"ef67";s:21:"ext_conf_template.txt";s:4:"2d34";s:12:"ext_icon.gif";s:4:"2650";s:17:"ext_localconf.php";s:4:"6006";s:14:"ext_tables.php";s:4:"cb43";s:14:"ext_tables.sql";s:4:"14c2";s:21:"Classes/Exception.php";s:4:"eb3a";s:43:"Classes/Controller/GoogleMapsController.php";s:4:"7941";s:32:"Classes/Domain/Model/Address.php";s:4:"4cc3";s:37:"Classes/Domain/Model/AddressGroup.php";s:4:"bef5";s:33:"Classes/Domain/Model/Category.php";s:4:"ff91";s:29:"Classes/Domain/Model/Item.php";s:4:"ee96";s:30:"Classes/Domain/Model/Layer.php";s:4:"1e0a";s:28:"Classes/Domain/Model/Map.php";s:4:"87b8";s:44:"Classes/Domain/Model/Layer/AbstractLayer.php";s:4:"4533";s:45:"Classes/Domain/Model/Layer/LayerInterface.php";s:4:"f6c5";s:37:"Classes/Domain/Model/Layer/Marker.php";s:4:"08f8";s:38:"Classes/Domain/Model/Layer/Polygon.php";s:4:"dbf6";s:39:"Classes/Domain/Model/Layer/Polyline.php";s:4:"f948";s:52:"Classes/Domain/Repository/AddressGroupRepository.php";s:4:"7a24";s:47:"Classes/Domain/Repository/AddressRepository.php";s:4:"dfd7";s:48:"Classes/Domain/Repository/CategoryRepository.php";s:4:"0d99";s:45:"Classes/Domain/Repository/LayerRepository.php";s:4:"065d";s:43:"Classes/Domain/Repository/MapRepository.php";s:4:"4159";s:35:"Classes/PluginAdapter/Exception.php";s:4:"1f66";s:36:"Classes/PluginAdapter/MapBuilder.php";s:4:"f1af";s:59:"Classes/PluginAdapter/CoordinatesProvider/AbstractCoordinatesProvider.php";s:4:"2418";s:51:"Classes/PluginAdapter/CoordinatesProvider/AddressGroup.php";s:4:"e5dd";s:48:"Classes/PluginAdapter/CoordinatesProvider/Addresses.php";s:4:"72ca";s:60:"Classes/PluginAdapter/CoordinatesProvider/CoordinatesProviderInterface.php";s:4:"b796";s:48:"Classes/PluginAdapter/CoordinatesProvider/MapDrawer.php";s:4:"4241";s:59:"Classes/PluginAdapter/LayerBuilder/AbstractLayerBuilder.php";s:4:"dc01";s:49:"Classes/PluginAdapter/LayerBuilder/InfoWindow.php";s:4:"56d6";s:60:"Classes/PluginAdapter/LayerBuilder/LayerBuilderInterface.php";s:4:"7d0f";s:45:"Classes/PluginAdapter/LayerBuilder/Marker.php";s:4:"3733";s:46:"Classes/PluginAdapter/LayerBuilder/Polygon.php";s:4:"9885";s:47:"Classes/PluginAdapter/LayerBuilder/Polyline.php";s:4:"7a85";s:38:"Classes/Service/AddressPostProcess.php";s:4:"9569";s:27:"Classes/Utility/BackEnd.php";s:4:"4fc1";s:36:"Configuration/FlexForms/flexform.xml";s:4:"e162";s:25:"Configuration/TCA/tca.php";s:4:"88ef";s:38:"Configuration/TypoScript/constants.txt";s:4:"7356";s:34:"Configuration/TypoScript/setup.txt";s:4:"f4c9";s:50:"Resources/Private/Language/locallang_constants.xml";s:4:"cda8";s:48:"Resources/Private/Language/locallang_extconf.xml";s:4:"5acf";s:49:"Resources/Private/Language/locallang_flexform.xml";s:4:"535e";s:53:"Resources/Private/Language/locallang_flexform_csh.xml";s:4:"d920";s:44:"Resources/Private/Language/locallang_tca.xml";s:4:"e0e1";s:57:"Resources/Private/Language/locallang_tca_csh_category.xml";s:4:"146e";s:54:"Resources/Private/Language/locallang_tca_csh_layer.xml";s:4:"5e0f";s:52:"Resources/Private/Language/locallang_tca_csh_map.xml";s:4:"3319";s:44:"Resources/Private/Partials/CategoryList.html";s:4:"6a61";s:49:"Resources/Private/Templates/GoogleMaps/index.html";s:4:"135d";s:41:"Resources/Public/Icons/Marker/airport.png";s:4:"b796";s:38:"Resources/Public/Icons/Marker/bank.png";s:4:"7942";s:42:"Resources/Public/Icons/Marker/boatramp.png";s:4:"1ece";s:42:"Resources/Public/Icons/Marker/building.png";s:4:"c9aa";s:44:"Resources/Public/Icons/Marker/campground.png";s:4:"4c04";s:38:"Resources/Public/Icons/Marker/dive.png";s:4:"97fc";s:40:"Resources/Public/Icons/Marker/drinks.png";s:4:"9fa4";s:43:"Resources/Public/Icons/Marker/entertain.png";s:4:"d8c6";s:41:"Resources/Public/Icons/Marker/fishing.png";s:4:"1356";s:38:"Resources/Public/Icons/Marker/food.png";s:4:"975f";s:37:"Resources/Public/Icons/Marker/gas.png";s:4:"b976";s:38:"Resources/Public/Icons/Marker/golf.png";s:4:"b518";s:38:"Resources/Public/Icons/Marker/hike.png";s:4:"d645";s:39:"Resources/Public/Icons/Marker/hotel.png";s:4:"6f47";s:39:"Resources/Public/Icons/Marker/house.png";s:4:"e037";s:41:"Resources/Public/Icons/Marker/hunting.png";s:4:"423c";s:38:"Resources/Public/Icons/Marker/info.png";s:4:"edcd";s:40:"Resources/Public/Icons/Marker/marina.png";s:4:"670a";s:40:"Resources/Public/Icons/Marker/markers.ai";s:4:"fcd5";s:41:"Resources/Public/Icons/Marker/medical.png";s:4:"b33b";s:43:"Resources/Public/Icons/Marker/parachute.png";s:4:"6998";s:38:"Resources/Public/Icons/Marker/park.png";s:4:"3be9";s:40:"Resources/Public/Icons/Marker/picnic.png";s:4:"3952";s:40:"Resources/Public/Icons/Marker/scenic.png";s:4:"60d0";s:37:"Resources/Public/Icons/Marker/spa.png";s:4:"6de7";s:38:"Resources/Public/Icons/Marker/sski.png";s:4:"18fe";s:38:"Resources/Public/Icons/Marker/swim.png";s:4:"30e5";s:38:"Resources/Public/Icons/Marker/wski.png";s:4:"20dc";s:47:"Resources/Public/Icons/MarkerCluster/conv30.png";s:4:"3b2d";s:47:"Resources/Public/Icons/MarkerCluster/conv40.png";s:4:"c116";s:47:"Resources/Public/Icons/MarkerCluster/conv50.png";s:4:"dfae";s:48:"Resources/Public/Icons/MarkerCluster/heart30.png";s:4:"676e";s:48:"Resources/Public/Icons/MarkerCluster/heart40.png";s:4:"97e5";s:48:"Resources/Public/Icons/MarkerCluster/heart50.png";s:4:"50c5";s:43:"Resources/Public/Icons/MarkerCluster/m1.png";s:4:"fe95";s:43:"Resources/Public/Icons/MarkerCluster/m2.png";s:4:"5588";s:43:"Resources/Public/Icons/MarkerCluster/m3.png";s:4:"4c6a";s:43:"Resources/Public/Icons/MarkerCluster/m4.png";s:4:"dc81";s:43:"Resources/Public/Icons/MarkerCluster/m5.png";s:4:"52cc";s:49:"Resources/Public/Icons/MarkerCluster/people35.png";s:4:"13bb";s:49:"Resources/Public/Icons/MarkerCluster/people45.png";s:4:"85ff";s:49:"Resources/Public/Icons/MarkerCluster/people55.png";s:4:"d144";s:40:"Resources/Public/Icons/Shadow/shadow.png";s:4:"1499";s:45:"Resources/Public/Icons/TCA/IconInfoWindow.gif";s:4:"1b8b";s:42:"Resources/Public/Icons/TCA/IconMarkers.gif";s:4:"123d";s:42:"Resources/Public/Icons/TCA/IconPolygon.gif";s:4:"1a1d";s:43:"Resources/Public/Icons/TCA/IconPolyline.gif";s:4:"7226";s:43:"Resources/Public/Icons/TCA/iconCategory.gif";s:4:"9421";s:40:"Resources/Public/Icons/TCA/iconLayer.gif";s:4:"52c0";s:38:"Resources/Public/Icons/TCA/iconMap.gif";s:4:"2650";s:14:"doc/manual.sxw";s:4:"f437";}',
	'suggests' => array(
	),
);

?>