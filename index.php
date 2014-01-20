<?php
require 'vendor/autoload.php';

$liftime = 0;
session_set_cookie_params($lifetime);
session_start();

$app = new \Slim\Slim();
		
$app->get('/login/:uniqueurl', function($uniqueUrl) {
	$loginController = new \Main\Controller\LoginController($uniqueUrl);
	$app->response()->header("Content-Type", "application/json");
	echo($loginController->attemptLogin());
});

$app->get('/updateUsername/:newUsername', function($newUsername) {
	//TODO: write controller logic to update the user's nickname.
});

$app->run();

?>
