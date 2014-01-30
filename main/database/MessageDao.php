<?php namespace Main\Database;

/**
 * Message data access layer.
 */
class MessageDao {

	/**
	 * Core Dao.
	 */
	private $coreDao;
	
	/**
	 * Constructs the Message dao.
	 */
	public function __construct() {
		$this->coreDao = CoreDao::getInstance();
	}
	
	/**
	 * Loads all the messages from the list of ids.
	 * 
	 * @param array $messageIds The list of messages.
	 * @return mixed Iterator of returned Mongo documents.
	 */
	public function loadMessages($messageIds) {
		if(empty($messageIds)) {
			return new \EmptyIterator();
		}
		
		//return $this->coreDao->getMessages()->find();
		return $this->coreDao->getMessages()->find(array(
	    		'_id' => array('$in' => $messageIds)));
		//var_dump($messageIds);
	}
	
	/**
	 * Loads the messages and converts them to local objects.
	 * 
	 * @param array $messageIds The list of messages.
	 * @return array List of messages.
	 */
	public function loadAndConvertMessages($messageIds) {
		$result = $this->loadMessages($messageIds);
		$messages = array();
		
		foreach($result as $message) {
			
			$message = \Main\Database\MessageDao::convertMessageDataDocToMessageData($message);
			array_push($messages, $message);
		}
		
		return $messages;
	}
	
	/**
	 * Gets single message by id.
	 * 
	 * @param MongoId $messageId The message.
	 * @return null|MessageData The Message data.
	 */
	public function getMessageById($messageId) {
		$result = $this->coreDao->getMessages()->findOne(array("_id" => $messageId));
		return MessageDao::convertMessageDataDocToMessageData($result);
	}
	
	/**
	 * Converts mongo message document array to MessageData.
	 * 
	 * @param array $messageDataDoc The mongoDocument version of the MessageData doc.
	 * @return null|MessageData The converted message data.
	 */
	 public static function convertMessageDataDocToMessageData($messageDataDoc) {
	 	$messageData = null;
	 	if(!empty($messageDataDoc)) {
	 		$messageData = new \Main\To\MessageData(
				$messageDataDoc["_id"],
				$messageDataDoc["user"],
				$messageDataDoc["message"],
				$messageDataDoc["postDate"],
				$messageDataDoc["children"]
			);
		}
		return $messageData;
	 }
	 
	 /**
	  * Stores a new message in the database.
	  * 
	  * @param MongoId $userId The new user id.
	  * @param string $message The message to set.
	  */
	 public function storeMessage($userId, $message) {
	 	$this->coreDao->getMessages()->insert(
	 		array("_id" => new \MongoId(), 
				"user" => $userId, 
				"message" => $message, 
				"postDate" => new \MongoDate(), 
				"children" => array()
			)
		);
	 }
	 
	 /**
	  * Stores a new child message.
	  * 
	  * @param MongoId $userId The new user id.
	  * @param MongoId $parentId the parent id to set.
	  * @param string $message The message to set.
	  */
	 public function storeChildMessage($userId, $parentId, $message) {
	 	$userDao = new \Main\Database\UserDao();
		$userResult = $userDao->lookupSingleUserById($userId);
	 	if(!is_null($userResult)) {
	 		$this->coreDao->getOptions()->update(array("_id" => $parentId), 
	 			array(
	 				'$push' => array(
		 				"users" => $userId,
		 				"response" => $message,
		 				"postDate" => new \MongoDate()
					)
				)
			);
		}
	 }
}

?>