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
	 * @return Iterator List of users that can be iterated through using
	 */
	public function loadUsers($userIdList) {
		if(empty($userIdList)) {
			return new \EmptyIterator();
		}
		
		return $this->coreDao->getUsers()->find(array(
    		'_id' => array('$in' => $userIdList)));
	}
	
	/**
	 * Loads the users based on the list of id's. Converts them to a list.
	 * 
	 * @param array $userIdList simple list of user ids.
	 * @return array List of users.
	 */
	public function loadAndConvertUsers($userIdList) {
		$result = $this->loadUsers($userIdList);
		$users = array();
		
		foreach($result as $user) {
			$user = UserDao::convertUserDataDocToUserData($user);
			$user->setUniqueUrlExtension(null);
			array_push($users, $user);
		}
		
		return $users;
	}
	
	/**
	 * Obtains a user by searching for the unique url given to the user.
	 * 
	 * @param string $uniqueUrl The unique url sent to the user.
	 * @return null|UserData The user object associated to the url.
	 */
	public function searchUserByUrlExtension($uniqueUrl) {
		$result = $this->coreDao->getUsers()->findOne(array("unique_url_extension" => $uniqueUrl));
		return UserDao::convertUserDataDocToUserData($result);
	}
	
	/**
	 * Converts mongo document array to UserData.
	 * 
	 * @param array $userDataDoc The mongoDocument version of the userdata doc.
	 * @return null|UserData The converted user object.
	 */
	 public static function convertUserDataDocToUserData($userDataDoc) {
	 	$userData = null;
	 	if(!empty($userDataDoc)) {
	 		$userData = new \Main\To\UserData(
				$userDataDoc["_id"],
				$userDataDoc["nickname"],
				$userDataDoc["street address"],
				$userDataDoc["unique_url_extension"],
				$userDataDoc["email"]
			);
		}
		
		return $userData;
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
	
	/**
	 * Updates the users nickname.
	 * 
	 * @param UserData $userData The user's data object.
	 * @param string $newNickname The new nickname to be given to the user.
	 * 
	 * @return bool returns false if there was an issue inserting into the database.
	 */
	 public function updateUsersNickname($userData, $newNickname) {
	 	try {
		 	$this->coreDao->getUsers()->update(array("_id" => $userData->getId()), 
		 		array('$set' => array("nickname" => $newNickname)));
		}
		catch(MongoException $er) {
			//TODO: Do some error logging here.
			return false;
		}
		return true;
	 }
	 
	 /**
	  * Wrapper around the users lookup by ids to allow for a single query.
	  * 
	  * @param MongoId $userId The user id to look up.
	  * @return null|UserData
	  */
	 public function lookupSingleUserById($userId) {
	 	$userData = null;
	 	$results = $this->loadUsers(array($userId));
		
		if(iterator_count($results) > 0) {
			$userDataDoc = array_shift(iterator_to_array($results));
			$userData = $this->convertUserDataDocToUserData($userDataDoc);
		}
		
		return $userData;
	 }
}

?>