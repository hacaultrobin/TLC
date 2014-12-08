<?php
// Requirements
require_once 'class/AdvertsService.class.php';

$adsService = new AdvertsService();
$adsService->deleteAd($_GET['id']);

header('Location: /');
?>
