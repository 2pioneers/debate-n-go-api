<?php
require 'vendor/autoload.php';

$lifetime = 0;
session_set_cookie_params($lifetime);
session_start();

$app = new \Slim\Slim();
		
$app->get('/login/:uniqueurl', function($uniqueUrl) {
	$loginController = new \Main\Controller\LoginController($uniqueUrl);
	$response = $loginController->attemptLogin();
	$app->response()->header("Content-Type", "application/json");
	echo($response);
});

$app->get('/updateUsername/:newUsername', function($newUsername) {
	$userInformationController = new Main\Controller\UserInformationController();
	$response = $userInformationController->updateUsername($newUsername);
	$app->response()->header("Content-Type", "application/json");
	echo($response);
});

$app->run();

?>
