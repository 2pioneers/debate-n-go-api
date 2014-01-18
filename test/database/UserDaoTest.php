<?php namespace Test\Database;

/**
 * User dao test cases.
 */
class UserDaoTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 * The user dao data connection.
	 */
	private $userDao;
	
	/**
	 * Stores the created user id to pass
	 */
	private $storedCreatedUserId;
	
	/**
	 * Test url for know id=1 user.
	 */
	private $knownTestUserUrl = "pqr91g";
	
	/**
	 * Sets up the test.
	 */
	protected function setUp() {
		$this->userDao = new \Main\Database\UserDao();
	}
	
	/**
	 * Resets data for next test.
	 */
	protected function tearDown() {
		$this->storedCreatedUserId = null;
	}
	
	/**
	 * Tests that simple user data gets loaded.
	 * 
	 * @test
	 * @dataProvider userListProvider
	 */
	public function canLoadTestUserData($testUserList) {
		$results = $this->userDao->loadUsers($testUserList);
		$this->assertEquals(count($testUserList), iterator_count($results));
		
		foreach($results as $document) {
			$this->assertContains($document['_id']->__toString(), $testUserList);
		}
	}
	
	/**
	 * Provider method with sample user ids.
	 * Series of sample data to test.
	 * 
	 * @return array An array of arrays housings lists of the test ids. 
	 */
	public function userListProvider() {
		return array(
			array(array()),
			array(array(new \MongoId("000000000000000000000001"))),
			array(array(new \MongoId("000000000000000000000002"))),
			array(array(new \MongoId("000000000000000000000001"), new \MongoId("000000000000000000000002")))
		);
	}
	
	/**
	 * Tests that we can pull the sample user by the unique url.
	 * 
	 * @test
	 */
	public function canPullSampleUserByUniqueUrl() {
		$result = $this->userDao->searchUserByUrlExtension($this->knownTestUserUrl);
		
		$this->assertEquals(new \MongoId("000000000000000000000001"), $result->getId());
	}
	
	/**
	 * Verifies that the searchUserByUrlExtension returns null with invalid url code.
	 * 
	 * @test
	 */
	public function pullingUserbyUrlWithoutExistingUrlReturnsNull() {
		$uniqueId = "";
		$result = $this->userDao->searchUserByUrlExtension($uniqueId);
		
		$this->assertNull($result);
	}
	
	/**
	 * Can create a user in the database then deletes that user.
	 * To make sure there isn't issues later on this also immediately deletes the made user.
	 * 
	 * @test
	 */
	public function canCreateAndDeleteUser() {
		$userData = new \Main\To\UserData(null, "69 East", "69 Eastbound Down Road Atlanta, GA 22222", "PQW2d", "random@user.na");
		$this->storedCreatedUserId = $this->userDao->createUser($userData);
		
		$this->canLoadTestUserData(array($this->storedCreatedUserId));
		
		$deleteResult = $this->userDao->deleteUser($this->storedCreatedUserId);
		$this->assertEquals(1, $deleteResult["ok"]);
	}
	
	/**
	 * Verifies that users nickname can be updated in the db.
	 * 
	 * @test
	 */
	public function canUpdateUsersNickname() {
		$temporaryName = "Whiskey Sour";
		
		$originalUser = $this->userDao->searchUserByUrlExtension($this->knownTestUserUrl);
		
		$this->userDao->updateUsersNickname($originalUser, $temporaryName);
		$updatedUser = $this->userDao->searchUserByUrlExtension($this->knownTestUserUrl);
		
		$this->assertEquals(0, strcmp($temporaryName, $updatedUser->getNickname()));
		$this->assertNotEquals(0, strcmp($originalUser->getNickname(), $updatedUser->getNickname()));
		
		$this->userDao->updateUsersNickname($updatedUser, $originalUser->getNickname());
	}
	
	/**
	 * Verifies that the single user lookup wrapper function valid.
	 * 
	 * @test
	 */
	public function canLookupSingleUserViaId() {
		$knownUserId = new \MongoId("000000000000000000000001");
		$foundUser = $this->userDao->lookupSingleUserById($knownUserId);
		
		$this->assertNotNull($foundUser);
		$this->assertEquals(0, strcmp($knownUserId->__toString(), $foundUser->getId()->__toString()));
	}
}

?>