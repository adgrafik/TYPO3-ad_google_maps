<?php

########################################################################
# Extension Manager/Repository config file for ext "ad_google_maps".
#
# Auto generated 01-07-2011 14:53
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
	'version' => '1.1.1',
	'dependencies' => 'extbase,fluid',
	'conflicts' => 'dbal',
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
			'typo3' => '4.5.0-0.0.0',
			'extbase' => '1.3.0-',
			'fluid' => '1.3.0-',
		),
		'conflicts' => array(
			'dbal' => '0.0.0-',
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:140:{s:9:"ChangeLog";s:4:"e937";s:20:"class.ext_update.php";s:4:"5304";s:16:"ext_autoload.php";s:4:"8b1c";s:21:"ext_conf_template.txt";s:4:"b4e9";s:12:"ext_icon.gif";s:4:"2650";s:17:"ext_localconf.php";s:4:"f08b";s:14:"ext_tables.php";s:4:"e855";s:14:"ext_tables.sql";s:4:"1ec0";s:21:"Classes/Exception.php";s:4:"eb3a";s:22:"Classes/Api/Bounds.php";s:4:"847d";s:22:"Classes/Api/LatLng.php";s:4:"5881";s:27:"Classes/Api/LatLngArray.php";s:4:"f77c";s:19:"Classes/Api/Map.php";s:4:"1cde";s:27:"Classes/Api/MarkerImage.php";s:4:"19b2";s:27:"Classes/Api/MarkerShape.php";s:4:"7059";s:21:"Classes/Api/Point.php";s:4:"c350";s:20:"Classes/Api/Size.php";s:4:"cef1";s:53:"Classes/Api/ControlOptions/AbstractControlOptions.php";s:4:"77bf";s:38:"Classes/Api/ControlOptions/MapType.php";s:4:"d934";s:41:"Classes/Api/ControlOptions/Navigation.php";s:4:"0ff1";s:34:"Classes/Api/ControlOptions/Pan.php";s:4:"6709";s:36:"Classes/Api/ControlOptions/Scale.php";s:4:"7bd2";s:41:"Classes/Api/ControlOptions/StreetView.php";s:4:"423a";s:35:"Classes/Api/ControlOptions/Zoom.php";s:4:"b4d7";s:35:"Classes/Api/Layer/AbstractLayer.php";s:4:"8def";s:32:"Classes/Api/Layer/InfoWindow.php";s:4:"6aaa";s:36:"Classes/Api/Layer/LayerInterface.php";s:4:"cd56";s:28:"Classes/Api/Layer/Marker.php";s:4:"4502";s:41:"Classes/Controller/AbstractController.php";s:4:"8182";s:43:"Classes/Controller/GoogleMapsController.php";s:4:"66f7";s:39:"Classes/Domain/Model/AbstractEntity.php";s:4:"54e4";s:33:"Classes/Domain/Model/Category.php";s:4:"ff13";s:29:"Classes/Domain/Model/Item.php";s:4:"688b";s:30:"Classes/Domain/Model/Layer.php";s:4:"d8cb";s:28:"Classes/Domain/Model/Map.php";s:4:"6a35";s:45:"Classes/Domain/Model/Layer/LayerInterface.php";s:4:"f6c5";s:37:"Classes/Domain/Model/Layer/Marker.php";s:4:"d932";s:48:"Classes/Domain/Repository/CategoryRepository.php";s:4:"0d99";s:45:"Classes/Domain/Repository/LayerRepository.php";s:4:"065d";s:43:"Classes/Domain/Repository/MapRepository.php";s:4:"4159";s:32:"Classes/MapBuilder/Exception.php";s:4:"1c99";s:33:"Classes/MapBuilder/MapBuilder.php";s:4:"64c4";s:70:"Classes/MapBuilder/CoordinatesProvider/AbstractCoordinatesProvider.php";s:4:"bbf2";s:71:"Classes/MapBuilder/CoordinatesProvider/CoordinatesProviderInterface.php";s:4:"4b36";s:52:"Classes/MapBuilder/CoordinatesProvider/MapDrawer.php";s:4:"64bb";s:42:"Classes/MapBuilder/Layer/AbstractLayer.php";s:4:"14f5";s:39:"Classes/MapBuilder/Layer/InfoWindow.php";s:4:"6bc4";s:43:"Classes/MapBuilder/Layer/LayerInterface.php";s:4:"dfca";s:35:"Classes/MapBuilder/Layer/Marker.php";s:4:"778e";s:31:"Classes/MapDrawer/Exception.php";s:4:"817c";s:34:"Classes/MapDrawer/MapDrawerApi.php";s:4:"01a3";s:41:"Classes/MapDrawer/Layer/AbstractLayer.php";s:4:"fc01";s:34:"Classes/MapDrawer/Layer/Marker.php";s:4:"3964";s:29:"Classes/Plugin/GoogleMaps.php";s:4:"b32a";s:26:"Classes/Plugin/Options.php";s:4:"9d8d";s:37:"Classes/Plugin/Options/MapControl.php";s:4:"4db7";s:46:"Classes/Plugin/Options/Layer/AbstractLayer.php";s:4:"318f";s:43:"Classes/Plugin/Options/Layer/InfoWindow.php";s:4:"9fc8";s:47:"Classes/Plugin/Options/Layer/LayerInterface.php";s:4:"fa86";s:39:"Classes/Plugin/Options/Layer/Marker.php";s:4:"5da2";s:45:"Classes/Service/FlexFormTemplateSelection.php";s:4:"394b";s:27:"Classes/Utility/BackEnd.php";s:4:"5c80";s:28:"Classes/Utility/FrontEnd.php";s:4:"5e88";s:36:"Configuration/FlexForms/flexform.xml";s:4:"b9d6";s:25:"Configuration/TCA/tca.php";s:4:"a59f";s:38:"Configuration/TypoScript/constants.txt";s:4:"76e9";s:34:"Configuration/TypoScript/setup.txt";s:4:"bb29";s:50:"Resources/Private/Language/locallang_constants.xml";s:4:"fa99";s:48:"Resources/Private/Language/locallang_extconf.xml";s:4:"9c8b";s:50:"Resources/Private/Language/locallang_extupdate.xml";s:4:"c08e";s:49:"Resources/Private/Language/locallang_flexform.xml";s:4:"535e";s:53:"Resources/Private/Language/locallang_flexform_csh.xml";s:4:"d920";s:44:"Resources/Private/Language/locallang_tca.xml";s:4:"8ce0";s:57:"Resources/Private/Language/locallang_tca_csh_category.xml";s:4:"146e";s:54:"Resources/Private/Language/locallang_tca_csh_layer.xml";s:4:"a0de";s:52:"Resources/Private/Language/locallang_tca_csh_map.xml";s:4:"2f71";s:50:"Resources/Private/Language/MapDrawer/locallang.xml";s:4:"a3cb";s:44:"Resources/Private/Partials/CategoryList.html";s:4:"64ae";s:54:"Resources/Private/Templates/GoogleMaps/GoogleMaps.html";s:4:"76b4";s:52:"Resources/Private/Templates/GoogleMaps/ListView.html";s:4:"487f";s:56:"Resources/Private/Templates/GoogleMaps/SimpleSearch.html";s:4:"9d95";s:49:"Resources/Private/Templates/GoogleMaps/index.html";s:4:"39bf";s:48:"Resources/Private/Templates/MapDrawer/index.html";s:4:"b22a";s:43:"Resources/Public/Icons/MapDrawer/marker.png";s:4:"edef";s:49:"Resources/Public/Icons/MapDrawer/searchMarker.gif";s:4:"87c3";s:41:"Resources/Public/Icons/Marker/airport.png";s:4:"b796";s:38:"Resources/Public/Icons/Marker/bank.png";s:4:"7942";s:42:"Resources/Public/Icons/Marker/boatramp.png";s:4:"1ece";s:42:"Resources/Public/Icons/Marker/building.png";s:4:"c9aa";s:44:"Resources/Public/Icons/Marker/campground.png";s:4:"4c04";s:38:"Resources/Public/Icons/Marker/dive.png";s:4:"97fc";s:40:"Resources/Public/Icons/Marker/drinks.png";s:4:"9fa4";s:43:"Resources/Public/Icons/Marker/entertain.png";s:4:"d8c6";s:41:"Resources/Public/Icons/Marker/fishing.png";s:4:"1356";s:38:"Resources/Public/Icons/Marker/food.png";s:4:"975f";s:37:"Resources/Public/Icons/Marker/gas.png";s:4:"b976";s:38:"Resources/Public/Icons/Marker/golf.png";s:4:"b518";s:38:"Resources/Public/Icons/Marker/hike.png";s:4:"d645";s:39:"Resources/Public/Icons/Marker/hotel.png";s:4:"6f47";s:39:"Resources/Public/Icons/Marker/house.png";s:4:"e037";s:41:"Resources/Public/Icons/Marker/hunting.png";s:4:"423c";s:38:"Resources/Public/Icons/Marker/info.png";s:4:"edcd";s:40:"Resources/Public/Icons/Marker/marina.png";s:4:"670a";s:40:"Resources/Public/Icons/Marker/markers.ai";s:4:"fcd5";s:41:"Resources/Public/Icons/Marker/medical.png";s:4:"b33b";s:43:"Resources/Public/Icons/Marker/parachute.png";s:4:"6998";s:38:"Resources/Public/Icons/Marker/park.png";s:4:"3be9";s:40:"Resources/Public/Icons/Marker/picnic.png";s:4:"3952";s:40:"Resources/Public/Icons/Marker/scenic.png";s:4:"60d0";s:37:"Resources/Public/Icons/Marker/spa.png";s:4:"6de7";s:38:"Resources/Public/Icons/Marker/sski.png";s:4:"18fe";s:38:"Resources/Public/Icons/Marker/swim.png";s:4:"30e5";s:38:"Resources/Public/Icons/Marker/wski.png";s:4:"20dc";s:47:"Resources/Public/Icons/MarkerCluster/conv30.png";s:4:"3b2d";s:47:"Resources/Public/Icons/MarkerCluster/conv40.png";s:4:"c116";s:47:"Resources/Public/Icons/MarkerCluster/conv50.png";s:4:"dfae";s:48:"Resources/Public/Icons/MarkerCluster/heart30.png";s:4:"676e";s:48:"Resources/Public/Icons/MarkerCluster/heart40.png";s:4:"97e5";s:48:"Resources/Public/Icons/MarkerCluster/heart50.png";s:4:"50c5";s:43:"Resources/Public/Icons/MarkerCluster/m1.png";s:4:"fe95";s:43:"Resources/Public/Icons/MarkerCluster/m2.png";s:4:"5588";s:43:"Resources/Public/Icons/MarkerCluster/m3.png";s:4:"4c6a";s:43:"Resources/Public/Icons/MarkerCluster/m4.png";s:4:"dc81";s:43:"Resources/Public/Icons/MarkerCluster/m5.png";s:4:"52cc";s:49:"Resources/Public/Icons/MarkerCluster/people35.png";s:4:"13bb";s:49:"Resources/Public/Icons/MarkerCluster/people45.png";s:4:"85ff";s:49:"Resources/Public/Icons/MarkerCluster/people55.png";s:4:"d144";s:40:"Resources/Public/Icons/Shadow/shadow.png";s:4:"1499";s:45:"Resources/Public/Icons/TCA/IconInfoWindow.gif";s:4:"1b8b";s:42:"Resources/Public/Icons/TCA/IconMarkers.gif";s:4:"123d";s:43:"Resources/Public/Icons/TCA/iconCategory.gif";s:4:"9421";s:40:"Resources/Public/Icons/TCA/iconLayer.gif";s:4:"52c0";s:38:"Resources/Public/Icons/TCA/iconMap.gif";s:4:"2650";s:66:"Resources/Public/JavaScript/MapDrawer/Tx_AdGoogleMaps_MapDrawer.js";s:4:"e828";s:79:"Resources/Public/JavaScript/MapDrawer/Tx_AdGoogleMaps_MapDrawer_Layer_Marker.js";s:4:"821e";s:64:"Resources/Public/JavaScript/Plugin/Tx_AdGoogleMaps_InfoWindow.js";s:4:"b086";s:60:"Resources/Public/JavaScript/Plugin/Tx_AdGoogleMaps_Marker.js";s:4:"d157";s:60:"Resources/Public/JavaScript/Plugin/Tx_AdGoogleMaps_Plugin.js";s:4:"d73a";s:66:"Resources/Public/JavaScript/Plugin/Tx_AdGoogleMaps_SimpleSearch.js";s:4:"8a58";s:14:"doc/manual.sxw";s:4:"6463";}',
	'suggests' => array(
	),
);

?>