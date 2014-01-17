<?php namespace Test\Database;

/**
 * User dao test cases.
 */
class UserDaoTest extends \PHPUnit_Framework_TestCase {
	
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
			$this->assertContains($document['id'], $testUserList);
		}
	}
	
	/**
	 * Provider method with sample user ids.
	 * Series of sample data to test.
	 */
	public function userListProvider() {
		return array(
			array(array()),
			array(array("1")),
			array(array("2")),
			array(array("1", "2"))
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
		
		$this->assertEquals(1, $result->getId());
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
}

?>