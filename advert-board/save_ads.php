<?php
// Requirements
require_once 'class/AdvertsService.class.php';

// Create a new adverts service
$adsService = new AdvertsService();

foreach($_POST['title'] as $key => $title) {
	if($title != "") {
		$price = $_POST['price'][$key];
		if($price == "") {
			$price = "0";
		}
		$adsService->addAd($title, $price);
	}
}

header('Location: /');
?>
