<?php namespace Main\To;

/**
 * Message data TO
 */
class MessageData {
	
	/**
	 * The id of the message.
	 */
	private $id;
	
	/**
	 * The id/UserData of the user.
	 */
	private $user;
	
	/**
	 * The message for the option.
	 */
	private $message;
	
	/**
	 * Date of the message.
	 */
	private $postDate;
	
	/**
	 * The child message/response and user of the message.
	 */
	private $children;
	
	/**
	 * Constructs the message TO
	 * 
	 * @param MongoId $id The message's id.
	 * @param mixed $user The User's data. First the Id then the UserData -id.
	 * @param string $message The message.
	 * @param MongoDate $postDate The posting date.
	 * @param array $children The responses to the message.
	 */
	public function __construct($id, $user, $message, $postDate, $children) {
		$this->id = $id;
		$this->user = $user;
		$this->message = $message;
		$this->postDate = $postDate;
		$this->children = $children;
	}
	
	/**
	 * Gets the id.
	 * 
	 * @return MongoId The id of the message.
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Sets the id.
	 * 
	 * @param MongoId $id The id of the message to set.
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * Gets the user.
	 * 
	 * @return mixed The user data.
	 */
	public function getUser() {
		return $this->user;
	}
	
	/**
	 * Sets the user.
	 * 
	 * @param mixed $user The user data to set.
	 */
	public function setUser($user) {
		$this->user = $user;
	}
	
	/**
	 * Gets the message.
	 * 
	 * @return string The message.
	 */
	public function getMessage() {
		return $this->message;
	}
	
	/**
	 * Sets the message.
	 * 
	 * @param string $message The message to set.
	 */
	public function setMessage($message) {
		$this->message = $message;
	}
	
	/**
	 * Gets the posting date.
	 * 
	 * @return MongoDate The message.
	 */
	public function getPostDate() {
		return $this->postDate;
	}
	
	/**
	 * Sets the posting date.
	 * 
	 * @param MongoDate $postDate The posting date to set.
	 */
	public function setPostDate($postDate) {
		$this->postDate = $postDate;
	}
	
	/**
	 * Gets the children.
	 * 
	 * @return array The responses.
	 */
	public function getChildren() {
		return $this->children;
	}
	
	/**
	 * Sets the children.
	 * 
	 * @param array $children The responses to set.
	 */
	public function setChildren($children) {
		$this->children = $children;
	}
}

?>