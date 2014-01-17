<?php namespace Test\Database;

/**
 * User dao test cases.
 */
class UserDaoTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 * Tests loadUsers to see if nothing is returned when nothing is passed in.
	 * 
	 * @test
	 */
	public function passingEmptyArrayToLoadUserDataReturnsEmptyIterator() {
		
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
			var_dump($document);
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
}

?>