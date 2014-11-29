<?php

require_once 'datastore_connect/config.php';
require_once 'datastore_connect/DatastoreService.php';
require_once 'AdModel.class.php';

class AdvertsService {

	function getAllAds() {
		return AdModel::all();
	}	

}

?>
