<?php namespace Main\Database;

/**
 * Voting topic data functions.
 */
class VotingTopicDao implements \JsonSerializable {
	
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
	 * Looks up the topic by the user id.
	 * 
	 * @param MongoId $userId User id to lookup by.
	 * @return null|VotingTopicDao The voting topics object.
	 */
	public function lookupTopicViaUserId($userId) {
		$result = $this->coreDao->getVoting_topics()->findOne(array("users" => $userId));
		$convertedResult = $this->convertVotingTopicDataDocToVotingTopicData($result);
		
		$usersIter = $this->userDao->loadUsers($convertedResult["users"]);
		$users = $this->convertUserIteratorToIdStrippedArray($usersIter);
		$convertedResult["users"] = $users;
		
		
	}
	
	/**
	 * Strips the mongoid from all the passed in user objects.
	 * 
	 * @param Iterator $usersIter The iterator version of the user objects.
	 * @return array A converted array of user objects with id stripped.
	 */
	private function convertUserIteratorToIdStrippedArray($usersIter) {
		$convertedUsers = array();
		
		foreach($usersIter as $userDataDoc) {
			$user = UserDao::convertUserDataDocToUserData($userDataDoc);
			$user->setId(null);
			array_push($convertedUsers, $user);
		}
		
		return $convertedUsers;
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
				$votingTopicDataDoc["users"]
			);
		}
		
		return $votingTopicData;
	 }
	 
	 /**
	  * Changes a user's vote in the system.
	  * 
	  * @param VotingTopicData $votinTopicData The current voting topic.
	  * @param UserData $userData The user's information.
	  * @param string $newVote The new option to switch the user to.
	  * @return array The updated list of options.
	  */
	 public function updateUserVote($votingTopicData, $userData, $newVote) {
	 	$this->removeUserVote($votingTopicData, $userData);
		$this->addUserVote($votingTopicData, $userData, $newVote);
		$this->getVotingTopicOptions($votingTopicData);
	 }
	 
	 /**
	  * Removes the users vote from an option.
	  * @param VotingTopicData $votinTopicData The current voting topic.
	  * @param UserData $userData The user's information.
	  * @return bool false if there was a database issue.
	  */
	 private function removeUserVote($votingTopicData, $userData) {
	 	//TODO: Update user options
	 	//$this->coreDao->getOptions()->update(array("users" => $votingTopicData->));
		//{"users": ObjectId("000000000000000000000001")}, { $pull: {"users": ObjectId("000000000000000000000001")}})
	 }
	 
	 /**
	  * Removes the users vote from an option.
	  * @param VotingTopicData $votinTopicData The current voting topic.
	  * @param UserData $userData The user's information.
	  * @param string $newVote The new option to switch the user to.
	  * @return bool false if there was a database issue.
	  */
	 private function addUserVote($votingTopicData, $userData, $newVote) {
		//db.options.update({"_id": ObjectId("000000000000000000000006")}, { $push: {"users": ObjectId("000000000000000000000001")}})
	 }
	 
	 /**
	  * Removes the users vote from an option.
	  * @param VotingTopicData $votinTopicData The current voting topic.
	  * @return array The updated list of options.
	  */
	 private function getVotingTopicOptions($votingTopicData) {
	 	
	 }
}

?>