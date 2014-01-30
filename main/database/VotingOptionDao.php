<?php namespace Main\Database;

/**
 * Manages database interactions for vote options.
 */
class VotingOptionDao {
	
	/**
	 * Core Dao.
	 */
	private $coreDao;
	
	/**
	 * Constructs the Voting options dao.
	 */
	public function __construct() {
		$this->coreDao = CoreDao::getInstance();
	}
	
	/**
	 * Loads all the options from the list of ids.
	 * 
	 * @param array $votingOptionsIdList The list of voting options id list.
	 * @return mixed Iterator of returned Mongo documents.
	 */
	public function loadOptions($votingOptionsIdList) {
		if(empty($votingOptionsIdList)) {
			return new \EmptyIterator();
		}
		
		return $this->coreDao->getOptions()->find(array(
	    		'_id' => array('$in' => $votingOptionsIdList)));
	}
	
	/**
	 * Wrapper around loadOptions to parse out the list]
	 * 
	 * @param array $votingOptionsIdList The list of voting options id list.
	 * @return array array of returned options.
	 */
	public function loadAndConvertOptions($votingOptionsIdList) {
		$results = $this->loadOptions($votingOptionsIdList);
		$options = array();
		foreach($results as $option) {
			$option = \Main\Database\VotingOptionDao::convertVotingOptionsDataDocToVotingOptionsData($option);
			array_push($options, $option);
		}
		
		return $options;
	}
	
	/**
	 * Gets single option by id.
	 * 
	 * @param MongoId $optionId The options id.
	 * @return null|VotingOptionsData The Voting Option information.
	 */
	public function getOptionById($optionId) {
		$result = $this->coreDao->getOptions()->findOne(array("_id" => $optionId));
		return VotingOptionDao::convertVotingOptionsDataDocToVotingOptionsData($result);
	}
	
	/**
	 * Converts mongo options document array to VotingOptionsData.
	 * 
	 * @param array $votingOptionsDataDoc The mongoDocument version of the VotingTopicData doc.
	 * @return null|VotingOptionsData The converted Voting options object.
	 */
	 public static function convertVotingOptionsDataDocToVotingOptionsData($votingOptionsDataDoc) {
	 	$votingOptionsData = null;
	 	if(!empty($votingOptionsDataDoc)) {
	 		$votingOptionsData = new \Main\To\VotingOptionsData(
				$votingOptionsDataDoc["_id"],
				$votingOptionsDataDoc["description"],
				$votingOptionsDataDoc["users"],
				$votingOptionsDataDoc["messages"]
			);
		}
		
		return $votingOptionsData;
	 }
}

?>