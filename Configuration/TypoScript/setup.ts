###
# This is the default TS-setup
##

plugin.tx_adgooglemaps {
	settings {

		# Configuration for map record. Values will be override the record values if set. 
		map {

			# The initial height. Required.
			height = {$plugin.tx_adgooglemaps.settings.map.height}
		}

		# Configuration for layer record. Values will be override the record values if set. 
		layer {

			shadowAnchorX = 15
			shadowAnchorY = 30

			# To set a user defined function, set a key and the value. The function can be insert 
			# with the key in the template as "item.mapControllFunctions.userFunction".
			# You can also override existing functions like "openInfoWindow", "panTo" or "fitBounds".
			mapControllFunctions {
				userFunction = alert('Layer Item Key: ###ITEM_KEY###')
			}

			# Content rendering for the info window.
			infoWindowRenderConfiguration < tt_content
		}
	}

	persistence {

		storagePid = {$plugin.tx_adgooglemaps.persistence.storagePid}

		classes {
			Tx_AdGoogleMaps_Domain_Model_Address.mapping {
				tableName = tt_address
				recordType = Tx_AdGoogleMaps_Domain_Model_Address
				columns {
					addressgroup.foreignClass = Tx_AdGoogleMaps_Domain_Model_AddressGroup
				}
			}

			Tx_AdGoogleMaps_Domain_Model_AddressGroup.mapping {
				tableName = tt_address_group
			}
		}
	}

	view {
		templateRootPath = {$plugin.tx_adgooglemaps.view.templateRootPath}
		partialRootPath = {$plugin.tx_adgooglemaps.view.partialRootPath}
		layoutRootPath = {$plugin.tx_adgooglemaps.view.layoutRootPath}
	}
}

###
# Override plugin.tx_adgooglemapsapi settings.
##

plugin.tx_adgooglemapsapi {
	settings {
		mapPlugin {
			canvas = tx_adgooglemaps_canvas_uid###UID###
		}

		mapDrawer {
			mapping {
				tx_adgooglemaps_domain_model_layer {
					fieldNames {
						type = type
						coordinates = coordinates
					}

					optionsFieldMapping {
						geodesic = geodesic
						strokeColor = stroke_color
						strokeWeight = stroke_weight
						strokeOpacity = stroke_opacity
						fillColor = fill_color
						fillOpacity = fill_opacity
					}
				}

				tt_address {
					fieldNames {
						type = tx_adgooglemapsapi_layers_marker
						coordinates = tx_adgooglemaps_coordinates
					}

					onlyOneMarker = 1
				}
			}
		}
	}
}