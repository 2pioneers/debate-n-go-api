<?php namespace Main\Controller;

/**
 * Manages the login controls.
 */
class LoginController {
	
	/**
	 * The user database connection.
	 */
	private $userDao;
	
	/**
	 * The user data.
	 */
	 private $userData;
	
	/**
	 * The voting topic dao.
	 */
	private $votingTopicDao;
	
	/**
	 * The unique login url to be given to an employee.
	 */
	private $uniqueLoginUrl;
	
	/**
	 * Constructs the controller for use.
	 */
	public function __construct($uniqueLoginUrl) {
		$this->userData = null;
		$this->userDao = new \Main\Database\UserDao();
		$this->votingTopicDao = new \Main\Database\VotingTopicDao();
		$this->uniqueLoginUrl = $uniqueLoginUrl;
	}
	
	/**
	 * Tries to log in via the user.
	 * 
	 * @return string JSON encoded string with either a data-filled response or an error response.
	 */
	public function attemptLogin() {
		$returnJsonArray = array();
		$this->userData = $this->searchUserData();
		if(!is_null($userData)) {
			$votingTopicData = $this->votingTopicDao->lookupTopicViaUserId($userData->getId());
			if(!is_null($votingTopicData)) {
				$returnJsonArray = array('status' => 'ok');
				$returnJsonArray["userData"] = $userData;
				$returnJsonArray["votingTopic"] = $votingTopicData;
				$this->refreshSession($returnJsonArray);
			}
			else {
				$returnJsonArray = $this->createErrorArray("Voting topic was not found, it may be deactivated?");
			}
		}
		else {
			$returnJsonArray = $this->createErrorArray("User was not found. Do you have the wrong url?");
		}
		
		return json_encode($returnJsonArray);
	}
	
	private function createErrorArray($message) {
		return array('status' => '404', 'message' => $message);
	}
	
	/**
	 * Searches the database for the user based on the url.
	 * 
	 * @return null|UserData The user data if present.
	 */
	private function searchUserData() {
		return $this->userDao->searchUserByUrlExtension($this->uniqueLoginUrl);
	}
	
	/**
	 * Refreshes the session variable with passed in data.
	 */
	public function refreshSession() {
		if(!is_null($this->userData)) {
			$_SESSION["userData"] = $this->userData;
		}
	}
	
	/**
	 * Sets the userdao for testing.
	 * 
	 * @param UserDao $userDao The user dao to set.
	 */
	public function setUserDao($userDao) {
		$this->userDao = $userDao;
	}
	
	/**
	 * Sets the Voting Topic dao.
	 * 
	 * @param VotingTopicDao $votingTopicDao The voting topic dao to set.
	 */
	public function setVotingTopicDao($votingTopicDao) {
		$this->votingTopicDao = $votingTopicDao;
	}
}

?>