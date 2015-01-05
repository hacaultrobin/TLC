<?php
// Requirements
define('__ROOT__', dirname(dirname(__FILE__)));
require_once 'AdModel.class.php';

class AdvertsService {
	
	function __construct() {
		require_once __ROOT__.'/datastore_connect/config.php';
		require_once __ROOT__.'/datastore_connect/DatastoreService.php';
		
		// Init the connection parameters to Google Cloud Datastore
		DatastoreService::setInstance(new DatastoreService($google_api_config));
    }
    
	function getAllAds() {
		return AdModel::all();
	}
	
	function searchAd($title, $minPrice, $maxPrice) {
		return "Not implemented";
	}
	
	function deleteAd($id) {
		$ad_model_fetched = AdModel::fetch_by_name($id);
		if (sizeof($ad_model_fetched) > 0) {
			$ad_model_fetched[0]->delete();
		}		
	}

	function addAd($title, $price) {
		$new_ad = new AdModel($title, $price, date('Y-m-d H:i:s'));
		$new_ad->put();
	}
}
?>
