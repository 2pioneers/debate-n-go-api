<?php namespace Test\Database;

/**
 * User dao test cases.
 */
class UserDaoTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 * Stores the created user id to pass
	 */
	private $storedCreatedUserId;
	
	/**
	 * Resets data for next test.
	 */
	public function tearDown() {
		$this->storedCreatedUserId = null;
	}
	
	/**
	 * Tests that simple user data gets loaded.
	 * 
	 * @test
	 * @dataProvider userListProvider
	 */
	public function canLoadTestUserData($testUserList) {
		$userDao = new \Main\Database\UserDao();
		$results = $userDao->loadUsers($testUserList);
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
		$uniqueId = "pqr91g";
		$userDao = new \Main\Database\UserDao();
		$result = $userDao->searchUserbyUrlExtension($uniqueId);
		
		$this->assertEquals(new \MongoId("000000000000000000000001"), $result->getId());
	}
	
	/**
	 * Verifies that the searchUserbyUrlExtension returns null with invalid url code.
	 * 
	 * @test
	 */
	public function pullingUserbyUrlWithoutExistingUrlReturnsNull() {
		$uniqueId = "";
		$userDao = new \Main\Database\UserDao();
		$result = $userDao->searchUserbyUrlExtension($uniqueId);
		
		$this->assertNull($result);
	}
	
	/**
	 * Can create a user in the database then deletes that user.
	 * To make sure there isn't issues later on this also immediately deletes the made user.
	 * 
	 * @test
	 */
	public function canCreateUser() {
		$userData = new \Main\To\UserData(null, "69 East", "69 Eastbound Down Road Atlanta, GA 22222", "PQW2d", "random@user.na");
		$userDao = new \Main\Database\UserDao();
		$this->storedCreatedUserId = $userDao->createUser($userData);
		
		$this->canLoadTestUserData(array($this->storedCreatedUserId));
		
		$deleteResult = $userDao->deleteUser($this->storedCreatedUserId);
		$this->assertEquals(1, $deleteResult["ok"]);
	}
}

?>