<?php namespace Test\Database;

/**
 * Tests for the topic dao data.
 */
class VotingTopicDaoTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 * The Voting topic dao object.
	 */
	private $votingTopicDao;
	
	/**
	 * Sets up the test.
	 */
	protected function setUp() {
		$this->votingTopicDao = new \Main\Database\VotingTopicDao();
	}
	
	/**
	 * Tests that we can pull the voting topic by the User Id.
	 * 
	 * @test
	 */
	public function canPullVotingTopicByUserId() {
		$result = $this->votingTopicDao->lookupTopicViaUserId(new \MongoId("000000000000000000000001"));
		$this->assertEquals(new \MongoId("000000000000000000000004"), $result->getId());
	}
	
	/**
	 * Tests that we get null back when passing invalid id to voting topic lookup.
	 * 
	 * @test
	 */
	public function passingInvalidUserIdToVotingTopicReturnsNull() {
		$result = $this->votingTopicDao->lookupTopicViaUserId(new \MongoId("100000000000000000000000"));
		$this->assertNull($result);
	}
}

?>