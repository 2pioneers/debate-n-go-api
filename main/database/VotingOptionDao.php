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
	
	/**
	 * Gets single option by id.
	 * 
	 * @param MongoId $optionId The options id.
	 * @return null|VotingOptionsData The Voting Option information.
	 */
	public function getOptionById($optionId) {
		$result = $this->coreDao->getOptions()->findOne(array("_id" => $uniqueUrl));
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