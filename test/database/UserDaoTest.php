<?php namespace Test\Database;

class UserDaoTest extends \PHPUnit_Framework_TestCase {
	
	public function testLoadTestUserData() {
		$userDao = new \Main\Database\UserDao();
		$testUserList = array("1");
		$results = $userDao->loadUsers($testUserList);
		
		foreach ($results as $document) {
			var_dump($document);
		}
		$this->assertEquals(1, count($results));
	}
}

?>