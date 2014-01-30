<?php namespace Main\Controller;

/**
 * Controller that manages the user updating of information.
 */
class UserInformationController {
	
	/**
	 * User data access object.
	 */
	private $userDao;
	
	/**
	 * Sets up the controller.
	 */
	public function __construct() {
		$this->userDao = new \Main\Database\UserDao();
	}
	
	/**
	 * Updates the user's username if the user is actually logged in.
	 * 
	 * @param string $newUsername The new alias to update.
	 * @return string JSON string with the status of the update.
	 */
	public function updateUsername($userId, $newUsername) {
		if($this->checkSession($userId)) {
			if($this->userDao->updateUsersNickname($_SESSION['userData'], $newUsername)) {
				return(json_encode(array('status' => 'ok')));
			}
			else {
				return(json_encode(array('status' => '404', 'message' => "There was an issue with the database, please log in with unique url and try again.")));
			}
		}
		else {
			return(json_encode(array('status' => '403', 'message' => "User not in session. Please log in with unique url.")));
		}
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