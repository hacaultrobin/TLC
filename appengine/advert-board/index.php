<?php

// Requirements
require_once 'datastore_connect/config.php';
require_once 'datastore_connect/DatastoreService.php';
require_once 'class/AdModel.class.php';
require_once "class/AdvertsService.class.php";

// Init the connection parameters to Google Cloud Datastore
DatastoreService::setInstance(new DatastoreService($google_api_config));
// Create a new adverts service
$adsService = new AdvertsService();

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Liste d'annonces</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<header>
			<form>
				<span>Titre</span>
				<input id="searchText" type="text"/>
				<span>Prix min</span>
				<input id="minPrice" type="number"/>
				<span>Prix max</span>
				<input id="maxPrice" type="number"/>
				<input type="button" value="Go"/>
			</form>
			<a id="create_ads_link" href="create_ads"><button>Cr&eacute;er</button></a>
		</header>
		<section>
			<ul>
				<?php
				foreach ($adsService->getAllAds() as $ad) {
					echo 
					"<li>" .
							"<span>" . $ad->getTitle() . "</span>" .
							"<span>(" . $ad->getDate() . ")</span>" .
							"<span>Prix : " . $ad->getPrice() . "$</span>" .
							"<a href='delete_ad?id=" . sha1($ad->getTitle()) . "'><button>Supprimer</button></a>" .
					"</li>";
				}
				?>
			<ul>
		</section>
	</body>
</html>

