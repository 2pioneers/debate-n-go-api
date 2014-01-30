<?php
// ini_set("log_errors", 1);
// ini_set("error_log", "/tmp/php-error.log");

require 'vendor/autoload.php';

$lifetime = 0;
session_set_cookie_params($lifetime);
session_start();

$app = new \Slim\Slim();
		
$app->get('/login/:uniqueurl', function($uniqueUrl) use($app) {
	$loginController = new \Main\Controller\LoginController($uniqueUrl);
	$response = $loginController->attemptLogin();
	$app->response()->header("Content-Type", "application/json");
	echo($response);
});

$app->post('/updateUsername/:newUsername', function($newUsername) use($app) {
	$userInformationController = new Main\Controller\UserInformationController();
	$response = $userInformationController->updateUsername($newUsername);
	$app->response()->header("Content-Type", "application/json");
	echo($response);
});

$app->post('/userVote', function() use($app) {
	$body = $app->request()->getBody();
	//Should be getting {"userId": "asjhfjasglakhjsdlghasgkjas", "optionId": "asjlghasfklghflgkjfgkls"}
	$app->response()->header("Content-Type", "application/json");
	echo("");
	//Will be returning basically log in information.
});

$app->post('/leaveComment', function() use($app) {
	$body = $app->request()->getBody();
	//Should be getting {"userId": "shlashgaklj", "message":"hi ho diddly", "vote_options": ["id1, id2, id3"]}
	$app->response()->header("Content-Type", "application/json");
	echo("");
});

$app->post('/leaveReply', function() use($app) {
	$body = $app->request()->getBody();
	//Should be getting {"userId": "shlashgaklj", "message":"hi ho diddly", "parent_id": "jskjhalshjg"}
	$app->response()->header("Content-Type", "application/json");
	echo("");
});

$app->run();

?>
