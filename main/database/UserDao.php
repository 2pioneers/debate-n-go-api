<?php namespace Main\Database;

/**
 * User Data access functions.
 */
class UserDao {
	
	/**
	 * Core Dao.
	 */
	private $coreDao;
	
	/**
	 * Constructs the user dao
	 */
	public function __construct() {
		$this->coreDao = CoreDao::getInstance();
	}
	
	/**
	 * Loads the users based on the list of id's.
	 */
	public function loadUsers($userIdList) {
		return $this->coreDao->getUser()->find(array(
    		'id' => array('$in' => $userIdList)));
	}
}

?>