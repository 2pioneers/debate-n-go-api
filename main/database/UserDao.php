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
	 * 
	 * @param array $userIdList simple list of user ids.
	 * @return array list of users that can be iterated through using
	 */
	public function loadUsers($userIdList) {
		if(empty($userIdList)) {
			return new \EmptyIterator();
		}
		
		return $this->coreDao->getUsers()->find(array(
    		'_id' => array('$in' => $userIdList)));
	}
	
	/**
	 * Obtains a user by searching for the unique url given to the user.
	 * 
	 * @param string $uniqueUrl The unique url sent to the user.
	 * @return UserData The user object associated to the url.
	 */
	public function searchUserbyUrlExtension($uniqueUrl) {
		$userData = null;
		$result = $this->coreDao->getUsers()->findOne(array("unique_url_extension" => $uniqueUrl));
		if(!empty($result)) {
			$userData = new \Main\To\UserData(
				$result["_id"],
				$result["nickname"],
				$result["street address"],
				$result["unique_url_extension"],
				$result["email"]
			);
		}
		return($userData);
	}
	
	/**
	 * Inserts a new user into the database.
	 * 
	 * @param UserData $userData A new user object.
	 * @return string The newly created document id.
	 */
	public function createUser($userData) {
		$userData->setId(new \MongoId());
		$insertItem = array("_id" => $userData->getId(),
			"nickname" => $userData->getNickname(),
			"street address" => $userData->getStreetAddress(),
			"unique_url_extension" => $userData->getUniqueUrlExtension(),
			"email" => $userData->getEmail());
		$this->coreDao->getUsers()->insert($insertItem);
		return($userData->getId());
	}
	
	/**
	 * Removes a user from the collection.
	 * 
	 * @param MongoId $userId The object user id.
	 */
	public function deleteUser($userId) {
		return $this->coreDao->getUsers()->remove(array("_id" => $userId));
	}
}

?>