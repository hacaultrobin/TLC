<?php

require_once 'datastore_connect/config.php';
require_once 'datastore_connect/DatastoreService.php';
require_once 'AdModel.class.php';

class AdvertsService {

	function getAllAds() {
		return AdModel::all();
	}

	function deleteAd($id) {
		$ad_model_fetched = AdModel::fetch_by_name($id);
		if (sizeof($ad_model_fetched) > 0) {
			$ad_model_fetched[0]->delete();
		}		
	}	

}

?>
