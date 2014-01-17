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
	
	/**
	 * Obtains a user by searching for the unique url given to the user.
	 * 
	 * @param string $uniqueUrl The unique url sent to the user.
	 * @return UserData The user object associated to the url.
	 */
	public function searchUserbyUrlExtension($uniqueUrl) {
		$userData = null;
		$result = $this->coreDao->getUser()->findOne(array("unique_url_extension" => $uniqueUrl));
		if(!empty($result)) {
			$userData = new \Main\To\UserData(
				$result["id"],
				$result["nickname"],
				$result["street address"],
				$result["unique_url_extension"],
				$result["email"]
			);
		}
		return($userData);
	}
}

?>