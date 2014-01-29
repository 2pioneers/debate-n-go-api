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
	 * Looks up the topic by the user id.
	 * 
	 * @param MongoId $userId User id to lookup by.
	 * @return null|VotingTopicDao The voting topics object.
	 */
	public function lookupTopicViaUserId($userId) {
		$userDao = new \Main\Database\UserDao();
		$result = $this->coreDao->getVoting_topics()->findOne(array("users" => $userId));
		$convertedResult = $this->convertVotingTopicDataDocToVotingTopicData($result);
		if(!is_null($convertedResult)) {
			//Load base users
			$usersIter = $userDao->loadUsers($convertedResult->getUsers());
			$users = $this->convertUserIteratorToUserDataArray($usersIter);
			//$convertedResult["users"] = $users;
			
			//Load options
			$votingOptionDao = new \Main\Database\VotingOptionDao();
			$optionsIter = $votingOptionDao->loadOptions($convertedResult->getOptions());
			$options = $this->injectUsersIntoOptions($users, $optionsIter);
			
			//Load messages
			$messageDao = new \Main\Database\MessageDao();
			$messagesIter = $messageDao->loadMessages($convertedResult->getMessages());
			//var_dump($messagesIter);
			$messages = $this->injectUsersIntoMessages($users, $messagesIter);
			
			echo json_encode($messages);
			$convertedResult->setMessages($messages);
			
			$options = $this->injectMessagesIntoOptions($messages, $options);
			
			$convertedResult->setOptions($options);
			$convertedResult->setUsers(array());
		}
		return $convertedResult;
	}
	
	private function injectMessagesIntoOptions($messages, $options) {
		$newOptions = array();
		
		foreach ($options as $option) {
			$newMessages = array();
			foreach ($option->getMessages() as $message) {
				foreach($messages as $fullMessage) {
					if($message == $fullMessage->getId()) {
						array_push($newMessages, $fullMessage);
						break;
					}
				}
			}
			$option->setMessages($newMessages);
			array_push($newOptions, $option);
		}
		
		return $newOptions;
	}
	
	/**
	 * Injects the users into the Options objects.
	 * 
	 * @param array $users Pool of users to inject from.
	 * @param mixed $optionsIter Cursor/Iterator of options.
	 * 
	 * @return array The options converted from the Cursor with the user injected.
	 */
	private function injectUsersIntoOptions($users, $optionsIter) {
		$options = array();
		
		foreach($optionsIter as $option) {
			
			$option = \Main\Database\VotingOptionDao::convertVotingOptionsDataDocToVotingOptionsData($option);
			$optionUserList = array();
			foreach($option->getUsers() as $optionUserId) {
				foreach($users as $user) {
					if($optionUserId == $user->getId()) {
						array_push($optionUserList, $user);
					}
				}
			}
			$option->setUsers($optionUserList);
			array_push($options, $option);
		}
		
		return $options;
	}
	
	/**
	 * Injects the users into the message objects.
	 * 
	 * @param array $users Pool of users to inject from.
	 * @param mixed $messagesIter Cursor/Iterator of messages.
	 * 
	 * @return array The messages converted from the Cursor with the user injected.
	 */
	private function injectUsersIntoMessages($users, $messagesIter) {
		$messages = array();
			
		foreach($messagesIter as $messageDataDoc) {
			
			$messageData = \Main\Database\MessageDao::convertMessageDataDocToMessageData($messageDataDoc);
			
			$messageUserId = $messageData->getUser();
			foreach($users as $user) {
				if($messageUserId == $user->getId()) {
					$messageData->setUser($user);
					break;
				}
			}
			
			//Convert user to data
			$updatedChildren = array();
			foreach ($messageData->getChildren() as $child) {
				foreach($users as $user) {
					if($messageUserId == $user->getId()) {
						$child["user"] = $user;
						array_push($updatedChildren, $child);
						break;
					}
				}
			}
			
			$messageData->setChildren($updatedChildren);
			array_push($messages, $messageData);
		}
		
		//var_dump($messages);
		
		return $messages;
	}
	
	/**
	 * Maps the iterator results to an array of UserData objects.
	 * 
	 * @param Iterator $usersIter The iterator version of the user objects.
	 * @return array A converted array of user objects.
	 */
	private function convertUserIteratorToUserDataArray($usersIter) {
		$convertedUsers = array();
		
		foreach($usersIter as $userDataDoc) {
			$user = UserDao::convertUserDataDocToUserData($userDataDoc);
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
				$votingTopicDataDoc["users"],
				$votingTopicDataDoc["messages"]
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
	  * Removes the users vote from any option.
	  * @param VotingTopicData $votinTopicData The current voting topic.
	  * @param MongoId $userId The user's id number.
	  * @return bool false if there was a database issue.
	  */
	 private function removeUserVote($votingTopicData, $userId) {
	 	$this->coreDao->getOptions()->update(array("users" => $userId), array('$pull' => array("users" => $userId)));
	 }
	 
	 /**
	  * Removes the users vote from an option.
	  * @param MongoId $optionId The voting topic option id.
	  * @param MongoId $userId The user's id number.
	  * @return bool false if there was a database issue.
	  */
	 private function addUserVote($optionId, $userId) {
	 	$this->coreDao->getOptions()->update(array("_id" => $optionId), array('$push' => array("users" => $userId)));
	 }
}

?>