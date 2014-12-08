<?php

// Requirements
require_once("class/AdvertsService.class.php");
require_once("class/AdModel.class.php");

// Init the connection parameters to Google Cloud Datastore
DatastoreService::setInstance(new DatastoreService($google_api_config));

$adsService = new AdvertsService();

$adsService->deleteAd($_GET['id']);

header('Location: /');

?>
