<?php namespace Main\To;

/**
 * Container object for the voting topic data.
 */
class VotingTopicData implements \JsonSerializable {

	/**
	 * The voting topic id.
	 */
	private $id;
	
	/**
	 * The description of the voting topic.
	 */
	private $description;
	
	/**
	 * The status of the voting topic.
	 */
	private $status;
	
	/**
	 * The list of options associated with this object.
	 */
	private $options;
	
	/**
	 * The list of users associated with this topic.
	 */
	private $users;
	
	/**
	 * Constructs the object with data.
	 * 
	 * @param MongoId $id The voting topic id.
	 * @param string $description The description of the voting topic.
	 * @param string $status The status of the object.
	 * @param array $options The options allowed for the user to choose.
	 * @param array $users The users that are associated with the voting topic.
	 */
	public function __construct($id, $description, $status, $options, $users) {
		$this->id = $id;
		$this->description = $description;
		$this->status = $status;
		$this->options = $options;
		$this->users = $users;
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
			'status' => $this->getStatus(),
			'options' => $this->getOptions(),
			'users' => $this->getUsers()
		);
	}
	
	/**
	 * Gets the id.
	 * @return MongoId The id.
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Sets the id.
	 * @param MongoId $id the id to set. 
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	
	/**
	 * Gets the description.
	 * @return string The description.
	 */
	public function getDescription() {
		return $this->description;
	}
	
	/**
	 * Sets the description.
	 * @param string $description the description to set. 
	 */
	public function setDescription($description) {
		$this->description = $description;
	}
	/**
	 * Gets the status.
	 * @return string The status.
	 */
	public function getStatus() {
		return $this->status;
	}
	
	/**
	 * Sets the status.
	 * @param string $status the status to set. 
	 */
	public function setStatus($status) {
		$this->status = $status;
	}
	
	/**
	 * Gets the options.
	 * @return array The options.
	 */
	public function getOptions() {
		return $this->options;
	}
	
	/**
	 * Sets the options.
	 * @param MongoId $options the options to set. 
	 */
	public function setOptions($options) {
		$this->options = $options;
	}
	
	/**
	 * Gets the users.
	 * @return array The users.
	 */
	public function getUsers() {
		return $this->users;
	}
	
	/**
	 * Sets the users.
	 * @param array $users the users to set. 
	 */
	public function setUsers($users) {
		$this->users = $users;
	}
}

?>