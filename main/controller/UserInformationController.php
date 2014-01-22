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
	 */
	public function updateUsername($newUsername) {
		$this->userDao->updateUsersNickname($_SESSION['userData'], $newUsername);
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