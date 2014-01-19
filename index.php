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

$app->run();

?>
