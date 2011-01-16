###
# This are the default TS-constants
##

plugin.tx_adgooglemaps {
	settings {

		# Default configuration for map record. Values will be overridden by record fields. 
		map {

			# cat=ad: Google Maps/enable/10; type=string; label= The initial height. Required.
			height = 400
		}
	}

	persistence {
		 # cat=ad: Google Maps/enable/10; type=string; label= Storage PID: Default storage PID
		storagePid = 
	}

	view {
		 # cat=ad: Google Maps/file/10; type=string; label= Path to template root (FE)
		templateRootPath = EXT:ad_google_maps/Resources/Private/Templates/

		 # cat=ad: Google Maps/file/20; type=string; label= Path to template partials (FE)
		partialRootPath = EXT:ad_google_maps/Resources/Private/Partials/

		 # cat=ad: Google Maps/file/30; type=string; label= Path to template layouts (FE)
		layoutRootPath = EXT:ad_google_maps/Resources/Private/Layouts/
	}
}