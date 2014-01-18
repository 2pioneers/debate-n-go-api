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
	 * Constructs the user dao
	 */
	public function __construct() {
		$this->coreDao = CoreDao::getInstance();
	}
	
}

?>