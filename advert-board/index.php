<?php
// Requirements
require_once 'class/AdvertsService.class.php';

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
			<form action="/" method="POST">
				<label for="searchText">Titre</label><input id="searchText" name="searchText" type="text"/>
				<label for="minPrice">Prix min</label><input id="minPrice" name="minPrice" type="number"/>
				<label for="maxPrice">Prix max</label><input id="maxPrice" name="maxPrice" type="number"/>
				<input type="submit" value="Go"/>
			</form>
			<a id="create_ads_link" href="create_ads"><button>Cr&eacute;er</button></a>
		</header>
		<section>
			<ul>
				<?php
				if (isset($_POST['searchText']) || isset($_POST['minPrice']) || isset($_POST['maxPrice'])) {
					$minPrice = (is_numeric($_POST['minPrice']) ? $_POST['minPrice'] : 0);
					$maxPrice = (is_numeric($_POST['maxPrice']) ? $_POST['maxPrice'] : -1);
					$ads = $adsService->searchAd($_POST['searchText'], $minPrice, $maxPrice);
					echo "<h4>$ads</h4>";
				} else {
					$ads = $adsService->getAllAds();
				}
				foreach ($ads as $ad) {
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

