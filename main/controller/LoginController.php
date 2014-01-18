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
	 * The unique login url to be given to an employee.
	 */
	private $uniqueLoginUrl;
	
	/**
	 * Constructs the controller for use.
	 */
	public function __construct($uniqueLoginUrl) {
		$this->userDao = new \Main\Database\UserDao();
		$this->uniqueLoginUrl = $uniqueLoginUrl;
	}
	
	/**
	 * Tries to log in via the user.
	 * 
	 * @return string JSON encoded string with either a data-filled response or an error response.
	 */
	public function attemptLogin() {
		$returnJsonArray = array();
		$userData = $this->searchUserData();
		if(!is_null($userData)) {
			$returnJsonArray = array('status' => 'ok');
			$returnJsonArray["userData"] = $userData;
			//TODO: logic to establish associated voting options.
			
			//Quickly setup the session for future use.
			$this->refreshSession($returnJsonArray);
			
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
	 * 
	 * @param array $newSessionData The data to be loaded into session.
	 */
	private function refreshSession($newSessionData) {		
		$_SESSION["userData"] = $newSessionData["userData"];
	}
	
	/**
	 * Sets the userdao for testing.
	 * 
	 * @param UserDao $userDao The user dao to set.
	 */
	public function setUserDao($userDao) {
		$this->userDao = $userDao;
	}
}

?>