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

$app->post('/updateUsername/', function() use($app) {
	$body = $app->request()->getBody();
	$response = null;
	if(isset($body['user_id']) && isset($body['new_username'])) {
		$userId = new \MongoId($body['user_id']);
		$newUsername = $body['new_username'];
		
		$userInformationController = new Main\Controller\UserInformationController();
		$response = $userInformationController->updateUsername($userId, $newUsername);
	}
	else {
		$response = json_encode(array('status' => '400', 'message' => "Missing input data."));
	}
	$app->response()->header("Content-Type", "application/json");
	echo($response);
});

$app->post('/userVote', function() use($app) {
	$body = $app->request()->getBody();
	//Should be getting {"user_id": "asjhfjasglakhjsdlghasgkjas", "option_id": "asjlghasfklghflgkjfgkls"}
	$app->response()->header("Content-Type", "application/json");
	echo("");
	//Will be returning basically log in information.
});

$app->post('/leaveComment', function() use($app) {
	$body = $app->request()->getBody();
	//Should be getting {"user_id": "shlashgaklj", "message":"hi ho diddly", "vote_options": ["id1, id2, id3"]}
	$app->response()->header("Content-Type", "application/json");
	echo("");
});

$app->post('/leaveReply', function() use($app) {
	$body = $app->request()->getBody();
	//Should be getting {"user_id": "shlashgaklj", "message":"hi ho diddly", "parent_id": "jskjhalshjg"}
	$app->response()->header("Content-Type", "application/json");
	echo("");
});

$app->run();

?>
