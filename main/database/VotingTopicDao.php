<?php namespace Main\Database;

/**
 * Voting topic data functions.
 */
class VotingTopicDao {
	
	/**
	 * Core Dao.
	 */
	private $coreDao;
	
	/**
	 * Constructs the user dao.
	 */
	public function __construct() {
		$this->coreDao = CoreDao::getInstance();
	}
	
	/**
	 * Looks up the topic by the user id and injects itself with the known objects.
	 * 
	 * @param MongoId $userId User id to lookup by.
	 * @return null|VotingTopicDao The voting topics object.
	 */
	public function lookupTopicViaUserId($userId) {
		$result = $this->coreDao->getVoting_topics()->findOne(array("users" => $userId));
		$convertedResult = $this->convertVotingTopicDataDocToVotingTopicData($result);
		if(!is_null($convertedResult)) {
			//Load base users
			$userDao = new \Main\Database\UserDao();
			$users = $userDao->loadAndConvertUsers($convertedResult->getUsers());
			$convertedResult->setUsers($users);
			
			//Load options
			$votingOptionDao = new \Main\Database\VotingOptionDao();
			$options = $votingOptionDao->loadAndConvertOptions($convertedResult->getOptions());
			$convertedResult->setOptions($options);
			
			//Load messages
			$messageDao = new \Main\Database\MessageDao();
			$messages = $messageDao->loadAndConvertMessages($convertedResult->getMessages());
			$convertedResult->setMessages($messages);
		}
		return $convertedResult;
	}
	
	/**
	 * Converts mongo document array to VotingTopicData.
	 * 
	 * @param array $votingTopicDataDoc The mongoDocument version of the VotingTopicData doc.
	 * @return null|VotingTopicData The converted Voting Topic  object.
	 */
	 private function convertVotingTopicDataDocToVotingTopicData($votingTopicDataDoc) {
	 	$votingTopicData = null;
	 	if(!empty($votingTopicDataDoc)) {
	 		$votingTopicData = new \Main\To\VotingTopicData(
				$votingTopicDataDoc["_id"],
				$votingTopicDataDoc["description"],
				$votingTopicDataDoc["status"],
				$votingTopicDataDoc["options"],
				$votingTopicDataDoc["users"],
				$votingTopicDataDoc["messages"]
			);
		}
		
		return $votingTopicData;
	 }
	 
	 /**
	  * Changes a user's vote in the system.
	  * 
	  * @param MongoId $optionId The current voting topic.
	  * @param UserData $userData The user's information.
	  * @param string $newVote The new option to switch the user to.
	  */
	 public function updateUserVote($optionId, $userData) {
	 	$this->removeUserVote($userData);
		$this->addUserVote($optionId, $userData);
	 }
	 
	 /**
	  * Removes the users vote from any option.
	  * @param VotingTopicData $votinTopicData The current voting topic.
	  * @param MongoId $userId The user's id number.
	  * @return bool false if there was a database issue.
	  */
	 private function removeUserVote($userId) {
	 	$this->coreDao->getOptions()->update(array("users" => $userId), array('$pull' => array("users" => $userId)));
	 }
	 
	 /**
	  * Removes the users vote from an option.
	  * @param MongoId $optionId The voting topic option id.
	  * @param MongoId $userId The user's id number.
	  * @return bool false if there was a database issue.
	  */
	 private function addUserVote($optionId, $userId) {
	 	$userDao = new \Main\Database\UserDao();
		$userResult = $userDao->lookupSingleUserById($userId);
	 	if(!is_null($userResult)) {
	 		$this->coreDao->getOptions()->update(array("_id" => $optionId), array('$push' => array("users" => $userId)));
		}
	 }
}

?>