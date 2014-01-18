<?php namespace Main\Database\Database;

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
		$this->uniqueLoginUrl = $uniqueLoginUrl;
		$this->checkSessionForUser();
	}
	
	/**
	 * 
	 */
	private function checkSessionForUser() {
		if(isset($_SESSION['userData'])) {
			
		}
	}
}

?>