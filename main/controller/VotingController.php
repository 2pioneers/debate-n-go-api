<?php namespace Main\Controller;

class VotingController {
	
	/**
	 * Places a vote for the specified user id.
	 * 
	 * @param MongoId $userId the user's id.
	 * @param MongoId $optionId The vot option id.
	 * @return array array ready to encode into json.
	 */
	public function placeVote($body) {
		$response = null;
		if(property_exists($body,'user_id') && property_exists($body,'option_id') && property_exists($body,'vote_options')) {
			$userId = new \MongoId($body->user_id);
			if($this->checkSession($userId)) {
				$optionId = new \MongoId($body->option_id);
				$optionIds = array();
				foreach($body->vote_options as $option) {
					array_push($optionIds, new \MongoId($option));
				}
				
				$votingTopicData = new \Main\Database\VotingTopicDao();
				$votingTopicData->updateUserVote($optionId, $userId);
				$votingOptionDao = new \Main\Database\VotingOptionDao();
				$response = $votingOptionDao->loadAndConvertOptions($optionIds);
			}
			else {
				$response = array('status' => '403', 'message' => "Forbidden");
			}
		}
		else {
			$response = array('status' => '400', 'message' => "Missing input data.");
		}
		return $response;
	}
	
	/**
	 * Checks the session data and verifies the user is the one in the system.
	 * 
	 * @param UserId $userId The supplied id to verify is in session.
	 * @return bool true if the user data is in the session.
	 */
	private function checkSession($userId) {
		if(isset($_SESSION['userData']) && $userId == $_SESSION['userData']->getId()) {
			return true;
		}
		return false;
	}
}

?>