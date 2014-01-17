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
	 * @param array $userIdList simple list of user ids.
	 * @return array list of users that can be iterated through using
	 */
	public function loadUsers($userIdList) {
		if(empty($userIdList)) {
			return new \EmptyIterator();
		}
		
		return $this->coreDao->getUser()->find(array(
    		'id' => array('$in' => $userIdList)));
	}
}

?>