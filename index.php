<?php
ini_set("log_errors", 1);
ini_set("error_log", "/tmp/php-error.log");

require 'vendor/autoload.php';

$lifetime = 0;
session_set_cookie_params($lifetime);
session_start();

$app = new \Slim\Slim();
		
$app->get('/login/:uniqueurl', function($uniqueUrl) use($app) {
	$loginController = new \Main\Controller\LoginController($uniqueUrl);
	$response = $loginController->attemptLogin();
	if(isset($response['userData'])) {
		$_SESSION['userData'] = $response['userData'];
	}
	$app->response()->header("Content-Type", "application/json");
	echo(json_encode($response));
});

$app->post('/updateUsername/', function() use($app) {
	$body = $app->request()->getBody();
	$body = json_decode($body);
	$response = null;
	if(property_exists($body,'user_id') && property_exists($body,'new_username')) {
		$userId = new \MongoId($body->user_id);
		$newUsername = $body->new_username;
		
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
	$body = json_decode($body);
	$response = null;
	if(property_exists($body,'user_id') && property_exists($body,'option_id') && property_exists($body,'vote_options')) {
		$userId = new \MongoId($body->user_id);
		$optionId = new \MongoId($body->option_id);
		$optionIds = array();
		foreach($body->vote_options as $option) {
			array_push($optionIds, new \MongoId($option));
		}
		
		$votingTopicData = new \Main\Database\VotingTopicDao();
		$votingTopicData->updateUserVote($optionId, $userId);
		$votingOptionDao = new \Main\Database\VotingOptionDao();
		$response = $votingOptionDao->loadAndConvertOptions($votingOptionsIdList);
	}
	else {
		$response = json_encode(array('status' => '400', 'message' => "Missing input data."));
	}
	$app->response()->header("Content-Type", "application/json");
	echo(json_encode($response));
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
