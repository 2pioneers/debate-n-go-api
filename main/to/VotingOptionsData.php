<?php namespace Main\To;

/**
 * TO to hold voting options data.
 */
class VotingOptionsData implements \JsonSerializable {
	
	/**
	 * The id of the option.
	 */
	private $id;
	
	/**
	 * The description of the option.
	 */
	private $description;
	
	/**
	 * The users who've voted for this option.
	 */
	private $users;
	
	/**
	 * The ids of the messages associated with this.
	 */
	private $messages;
	
	/**
	 * Builds the option object.
	 * @param string $id the option's id.
	 * @param string $description The description of the vote.
	 * @param string $users The users who for the option.
	 * @param string $messages The messages for the option.
	 */
	public function __construct($id, $description, $users, $messages) {
		$this->id = $id;
		$this->description = $description;
		$this->users = $users;
		$this->messages = $messages;
	}
	
	/**
	 * Encodes the TO so that it can be serialized and passed over json.
	 * 
	 * @return array array representation of the data object.
	 */
	public function jsonSerialize() {
		return array(
			'id' => $this->getId()->__toString(),
			'description' => $this->getDescription(),
			'users' => $this->getUsers(),
			'messages' => $this->getMessages()
		);
	}
	
	/**
	 * Sets the id of option.
	 * 
	 * @param MongoId $id the id to set.
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * Gets the option id
	 * 
	 * @return MongoId The option id.
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Sets the description of the option.
	 * 
	 * @param string $description The description to set.
	 */
	public function setDescription($description) {
		$this->description = $description;
	}
	
	/**
	 * Gets the description of the option.
	 * 
	 * @return string The desription of the option.
	 */
	public function getDescription() {
		return $this->description;
	}
	
	/**
	 * Sets the list of users who've selected this option.
	 * 
	 * @param array $users The users to set.
	 */
	public function setUsers($users) {
		$this->users = $users;
	}
	
	/**
	 * Gets the list of users.
	 * 
	 * @return array The list of users associated with the object.
	 */
	public function getUsers() {
		return $this->users;
	}
	
	/**
	 * Sets the messages for the option.
	 * 
	 * @param array $messages The array of messages to set.
	 */
	public function setMessages($messages) {
		$this->messages = $messages;
	}
	
	/**
	 * Gets the messages for the option.
	 * 
	 * @return array The array of messages associated with this object.
	 */
	public function getMessages() {
		return $this->messages;
	}
}

?>