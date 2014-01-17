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
	 * The user collection access point.
	 */
	private $user;
	
	/**
	 * The messages collection access point.
	 */
	private $messages;
	
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
		$client = new MongoClient();
		$db = $client->HOA;
		
		$this->voting_topics = $db->voting_topics;
		$this->user = $db->user;
		$this->messages = $db->messages;
	}
}

?>