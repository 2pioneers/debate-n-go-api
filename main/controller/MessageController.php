<?php namespace Main\Controller;

class MessageController {
	
	 /**
	  * Creates a new message.
	  */
	 public function leaveMessage($body) {
	 	/*
		 * 1. create new message object.
		 * 2. insert message.
		 * 3. store id in votingtopic.
		 * 4. store in each voting option.
		 * 5. Return all options and messages
		 */
		$response = null;
		if(property_exists($body,'user_id') && 
			property_exists($body,'message') && 
			property_exists($body,'vote_options') && 
			property_exists($body, 'vote_topic_id')) {
			$userId = new \MongoId($body->user_id);
			if($this->checkSession($userId)) {
				$voteTopicId = new \MongoId($body->vote_topic_id);
				$optionIds = array();
				foreach($body->vote_options as $option) {
					array_push($optionIds, new \MongoId($option));
				}
				
				$messageDao = new \Main\Database\MessageDao();
				$messageId = $messageDao->storeMessage($userId, $body->message);
				
				$voteTopicId = new \Main\Database\VotingTopicDao();
				$voteTopicId->storeNewMessage($voteTopicId, $messageId);
				
				$votingOptionDao = new \Main\Database\VotingOptionDao();
				$votingOptionDao->storeMessageInOptions($messageId, $optionIds);
				
				$response = array('status' => 'ok');
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