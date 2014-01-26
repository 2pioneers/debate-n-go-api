<?php namespace Main\To;

/**
 * Manages database interactions for vote options.
 */
class VotingOptionDao {
	
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
	
	public function getOptionById() {}
}

?>