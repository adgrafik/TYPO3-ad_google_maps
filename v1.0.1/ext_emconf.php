<?php

########################################################################
# Extension Manager/Repository config file for ext "ad_google_maps".
#
# Auto generated 15-01-2011 16:17
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'ad: Google Maps',
	'description' => 'Google Maps for TYPO3. Powerful extension with all configurable options of Google Maps API V3. Based on extbase and flud v1.2.1. Please test and response ;)',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '1.0.1',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'alpha',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Arno Dudek',
	'author_email' => 'webmaster@adgrafik.at',
	'author_company' => 'ad:grafik',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.4.5-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:73:{s:9:"ChangeLog";s:4:"fadf";s:21:"ext_conf_template.txt";s:4:"9bde";s:12:"ext_icon.gif";s:4:"2650";s:17:"ext_localconf.php";s:4:"a873";s:14:"ext_tables.php";s:4:"d95d";s:14:"ext_tables.sql";s:4:"cfb9";s:21:"Classes/Exception.php";s:4:"eb3a";s:43:"Classes/Controller/GoogleMapsController.php";s:4:"daf7";s:32:"Classes/Domain/Model/Address.php";s:4:"0a04";s:37:"Classes/Domain/Model/AddressGroup.php";s:4:"1b8c";s:33:"Classes/Domain/Model/Category.php";s:4:"d3e9";s:29:"Classes/Domain/Model/Item.php";s:4:"102d";s:30:"Classes/Domain/Model/Layer.php";s:4:"5485";s:28:"Classes/Domain/Model/Map.php";s:4:"5587";s:52:"Classes/Domain/Repository/AddressGroupRepository.php";s:4:"7a24";s:47:"Classes/Domain/Repository/AddressRepository.php";s:4:"dfd7";s:48:"Classes/Domain/Repository/CategoryRepository.php";s:4:"87dd";s:45:"Classes/Domain/Repository/LayerRepository.php";s:4:"065d";s:43:"Classes/Domain/Repository/MapRepository.php";s:4:"4159";s:36:"Classes/Service/MapPluginAdapter.php";s:4:"e923";s:25:"Classes/Tools/BackEnd.php";s:4:"813a";s:36:"Configuration/FlexForms/flexform.xml";s:4:"065b";s:25:"Configuration/TCA/tca.php";s:4:"9dc4";s:38:"Configuration/TypoScript/constants.txt";s:4:"803e";s:34:"Configuration/TypoScript/setup.txt";s:4:"3b77";s:49:"Resources/Private/Language/locallang_flexform.xml";s:4:"6260";s:53:"Resources/Private/Language/locallang_flexform_csh.xml";s:4:"8be2";s:44:"Resources/Private/Language/locallang_tca.xml";s:4:"69fd";s:57:"Resources/Private/Language/locallang_tca_csh_category.xml";s:4:"03fd";s:54:"Resources/Private/Language/locallang_tca_csh_layer.xml";s:4:"a36c";s:52:"Resources/Private/Language/locallang_tca_csh_map.xml";s:4:"b41c";s:44:"Resources/Private/Partials/CategoryList.html";s:4:"2eb3";s:49:"Resources/Private/Templates/GoogleMaps/index.html";s:4:"ab6a";s:38:"Resources/Public/Icons/TCA/IconKml.gif";s:4:"4460";s:42:"Resources/Public/Icons/TCA/IconMarkers.gif";s:4:"123d";s:42:"Resources/Public/Icons/TCA/IconPolygon.gif";s:4:"1a1d";s:43:"Resources/Public/Icons/TCA/IconPolyline.gif";s:4:"7226";s:44:"Resources/Public/Icons/TCA/icon_category.gif";s:4:"9421";s:41:"Resources/Public/Icons/TCA/icon_layer.gif";s:4:"52c0";s:39:"Resources/Public/Icons/TCA/icon_map.gif";s:4:"2650";s:44:"Resources/Public/Icons/TCA/icon_relation.gif";s:4:"6bd2";s:46:"Resources/Public/Uploads/Category/facebook.png";s:4:"8186";s:36:"Resources/Public/Uploads/KML/cta.kml";s:4:"62b2";s:43:"Resources/Public/Uploads/Marker/airport.png";s:4:"b796";s:40:"Resources/Public/Uploads/Marker/bank.png";s:4:"7942";s:44:"Resources/Public/Uploads/Marker/boatramp.png";s:4:"1ece";s:44:"Resources/Public/Uploads/Marker/building.png";s:4:"c9aa";s:46:"Resources/Public/Uploads/Marker/campground.png";s:4:"4c04";s:40:"Resources/Public/Uploads/Marker/dive.png";s:4:"97fc";s:42:"Resources/Public/Uploads/Marker/drinks.png";s:4:"9fa4";s:45:"Resources/Public/Uploads/Marker/entertain.png";s:4:"d8c6";s:43:"Resources/Public/Uploads/Marker/fishing.png";s:4:"1356";s:40:"Resources/Public/Uploads/Marker/food.png";s:4:"975f";s:39:"Resources/Public/Uploads/Marker/gas.png";s:4:"b976";s:40:"Resources/Public/Uploads/Marker/golf.png";s:4:"b518";s:40:"Resources/Public/Uploads/Marker/hike.png";s:4:"d645";s:41:"Resources/Public/Uploads/Marker/hotel.png";s:4:"6f47";s:41:"Resources/Public/Uploads/Marker/house.png";s:4:"e037";s:43:"Resources/Public/Uploads/Marker/hunting.png";s:4:"423c";s:40:"Resources/Public/Uploads/Marker/info.png";s:4:"edcd";s:42:"Resources/Public/Uploads/Marker/marina.png";s:4:"670a";s:42:"Resources/Public/Uploads/Marker/markers.ai";s:4:"fcd5";s:43:"Resources/Public/Uploads/Marker/medical.png";s:4:"b33b";s:45:"Resources/Public/Uploads/Marker/parachute.png";s:4:"6998";s:40:"Resources/Public/Uploads/Marker/park.png";s:4:"3be9";s:42:"Resources/Public/Uploads/Marker/picnic.png";s:4:"3952";s:42:"Resources/Public/Uploads/Marker/scenic.png";s:4:"60d0";s:39:"Resources/Public/Uploads/Marker/spa.png";s:4:"6de7";s:40:"Resources/Public/Uploads/Marker/sski.png";s:4:"18fe";s:40:"Resources/Public/Uploads/Marker/swim.png";s:4:"30e5";s:40:"Resources/Public/Uploads/Marker/wski.png";s:4:"20dc";s:42:"Resources/Public/Uploads/Shadow/shadow.png";s:4:"1499";s:14:"doc/manual.sxw";s:4:"9ce0";}',
);

?>