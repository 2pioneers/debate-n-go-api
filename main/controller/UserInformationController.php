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
	public function updateUsername($newUsername) {
		if($this->checkSession()) {
			if($this->userDao->updateUsersNickname($_SESSION['userData'], $newUsername)) {
				return(json_encode(array('status' => 'ok')));
			}
			else {
				return(json_encode(array('status' => '404', 'message' => "There was an issue with the database, please log in with unique url and try again.")));
			}
		}
		else {
			return(json_encode(array('status' => '404', 'message' => "User not in session. Please log in with unique url.")));
		}
	}
	
	/**
	 * Checks the session data and verifies the user is the one in the system.
	 * 
	 * @return bool true if the user data is in the session.
	 */
	public function checkSession() {
		if(isset($_SESSION['userData'])) {
			return true;
		}
		return false;
	}
}

?>