<?php namespace Main\Database;

/**
 * Core data access functions.
 */
class CoreDao {
	
	/**
	 * The singleton instance.
	 */
	private static $_instance;
	
	/**
	 * The voting_topics collection access point.
	 */
	private $voting_topics;
	
	/**
	 * The users collection access point.
	 */
	private $users;
	
	/**
	 * The messages collection access point.
	 */
	private $messages;
	
	/**
	 * The Voting topic options.
	 */
	private $options;
	
	/**
	 * Closed off the constructor from use.
	 */
	private function __construct() {
		$this->loadCollections();
	}
	
	/**
	 * Closed off the cloning abilities.
	 */
	private function __clone() { }
	
	/**
	 * Creates an instance of the mongodb connection.
	 * 
	 * @return CoreDao Singleton instance of this CoreDao object.
	 */
	public static function getInstance() {
		if(!self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 * Loads the collections for the database.
	 */
	public function loadCollections() {
		$client = new \MongoClient();
		$db = $client->HOA;
		
		$this->voting_topics = $db->voting_topics;
		$this->users = $db->users;
		$this->messages = $db->messages;
		$this->options = $db->options;
	}
	
	/**
	 * Gets the voting topics collection.
	 * 
	 * @return mixed voting topics collection object.
	 */
	public function getVoting_topics() {
		return $this->voting_topics;
	}
	
	/**
	 * Gets the users collection.
	 * 
	 * @return mixed users collection object.
	 */
	public function getUsers() {
		return $this->users;
	}
	
	/**
	 * Gets the messages collection.
	 * 
	 * @return mixed messages collection object.
	 */
	public function getMessages() {
		return $this->messages;
	}
	
	/**
	 * Gets the voting topic options.
	 * 
	 * @return mixed options collection object.
	 */
	public function getOptions() {
		return $this->options;
	}
}

?>