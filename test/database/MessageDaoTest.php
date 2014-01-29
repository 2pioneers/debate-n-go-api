<?php namespace Test\Database;

/**
 * Message Dao test cases.
 */
class MessageDaoTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 * The message dao data connection.
	 */
	private $messageDao;
	
	/**
	 * Sets up the test.
	 */
	protected function setUp() {
		$this->messageDao = new \Main\Database\MessageDao();
	}
	
	/**
	 * Tests that simple message data gets loaded.
	 * 
	 * @test
	 * @dataProvider messageListProvider
	 */
	public function canLoadTestMessageData($testMessageList) {
		$results = $this->messageDao->loadMessages($testMessageList);
		$this->assertEquals(count($testMessageList), iterator_count($results));
		foreach($results as $document) {
			$this->assertContains($document['_id']->__toString(), $testMessageList);
		}
	}
	
	/**
	 * Provider method with sample message ids.
	 * Series of sample data to test.
	 * 
	 * @return array An array of arrays housings lists of the test ids. 
	 */
	public function messageListProvider() {
		return array(
			array(array()),
			array(array(new \MongoId("000000000000000000000003")))
		);
	}
	

	// /**
	 // * Can create a user in the database then deletes that user.
	 // * To make sure there isn't issues later on this also immediately deletes the made user.
	 // * 
	 // * @test
	 // */
	// public function canCreateAndDeleteUser() {
		// $userData = new \Main\To\UserData(null, "69 East", "69 Eastbound Down Road Atlanta, GA 22222", "PQW2d", "random@user.na");
		// $this->storedCreatedUserId = $this->userDao->createUser($userData);
// 		
		// $this->canLoadTestUserData(array($this->storedCreatedUserId));
// 		
		// $deleteResult = $this->userDao->deleteUser($this->storedCreatedUserId);
		// $this->assertEquals(1, $deleteResult["ok"]);
	// }
// 	
	// /**
	 // * Verifies that users nickname can be updated in the db.
	 // * 
	 // * @test
	 // */
	// public function canUpdateUsersNickname() {
		// $temporaryName = "Whiskey Sour";
// 		
		// $originalUser = $this->userDao->searchUserByUrlExtension($this->knownTestUserUrl);
// 		
		// $this->userDao->updateUsersNickname($originalUser, $temporaryName);
		// $updatedUser = $this->userDao->searchUserByUrlExtension($this->knownTestUserUrl);
// 		
		// $this->assertEquals(0, strcmp($temporaryName, $updatedUser->getNickname()));
		// $this->assertNotEquals(0, strcmp($originalUser->getNickname(), $updatedUser->getNickname()));
// 		
		// $this->userDao->updateUsersNickname($updatedUser, $originalUser->getNickname());
	// }
// 	
	// /**
	 // * Verifies that the single user lookup wrapper function valid.
	 // * 
	 // * @test
	 // */
	// public function canLookupSingleUserViaId() {
		// $knownUserId = new \MongoId("000000000000000000000001");
		// $foundUser = $this->userDao->lookupSingleUserById($knownUserId);
// 		
		// $this->assertNotNull($foundUser);
		// $this->assertEquals(0, strcmp($knownUserId->__toString(), $foundUser->getId()->__toString()));
	// }
}

?>