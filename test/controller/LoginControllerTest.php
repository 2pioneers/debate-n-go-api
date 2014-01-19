<?php namespace Test\Controller;

/**
 * Tests the login processes.
 */
class LoginControllerTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 * Attempts to log in with a valid url
	 * 
	 * @param string $expectedResponse The JSON encoded response.
	 * @param LoginController $loginController The mocked dao object with expected response.
	 * 
	 * @test
	 * @dataProvider attemptedLoginProvider
	 */
	public function canAttemptLoginWithValidUrl($expectedResponse, $loginController) {
		$jsonResult = $loginController->attemptLogin();
		//var_dump($jsonResult);
		$this->assertEquals(0, strcmp($expectedResponse, $jsonResult));
	}
	
	/**
	 * Builds sample url data and gets the expected response.
	 * 
	 * @return array Arrays of testing parameters.
	 */
	public function attemptedLoginProvider() {
		$dataSet = array();
		
		$successExpected = new \Main\To\UserData(new \MongoId("000000000000000000000001"), "69 East", "69 Eastbound Down Road Atlanta, GA 22222", "PQW2d", "random@user.na");
		$successVotingTopicExpected = new \Main\To\VotingTopicData(new \MongoId("000000000000000000000001"), "", "", array(), array());
		
		//Fully successful
		$successUserMock = $this->getMock('Main\Database\UserDao', array('searchUserByUrlExtension'));
		$successUserMock->expects($this->once())
			->method('searchUserByUrlExtension')
			->with($successExpected->getUniqueUrlExtension())
			->will($this->returnValue($successExpected));
			
		$successVoteMock = $this->getMock('Main\Database\VotingTopicDao', array('lookupTopicViaUserId'));
		$successVoteMock->expects($this->once())
			->method('lookupTopicViaUserId')
			->with($successExpected->getId())
			->will($this->returnValue($successVotingTopicExpected));
		
		$successController = new \Main\Controller\LoginController($successExpected->getUniqueUrlExtension());
		$successController->setUserDao($successUserMock);
		$successController->setVotingTopicDao($successVoteMock);
		$successSet = array(json_encode(array('status' => 'ok', 'userData' => $successExpected, 'votingTopic' => $successVotingTopicExpected)), $successController);
		
		//Fails because of url
		$fakeurl = "fakeurl";
		$userFailUserMock = $this->getMock('Main\Database\UserDao', array('searchUserByUrlExtension'));
		$userFailUserMock->expects($this->once())
			->method('searchUserByUrlExtension')
			->with($fakeurl)
			->will($this->returnValue(null));
		$userFailController = new \Main\Controller\LoginController($fakeurl);
		$userFailController->setUserDao($userFailUserMock);
		$userFailSet = array(json_encode(array('status' => '404', 'message' => "User was not found. Do you have the wrong url?")), $userFailController);
		
		//Fails because of voting topic
		$voteFailUserMock = $this->getMock('Main\Database\UserDao', array('searchUserByUrlExtension'));
		$voteFailUserMock->expects($this->once())
			->method('searchUserByUrlExtension')
			->with($successExpected->getUniqueUrlExtension())
			->will($this->returnValue($successExpected));
		
		$voteTopicFailMock = $this->getMock('Main\Database\VotingTopicDao', array('lookupTopicViaUserId'));
		$voteTopicFailMock->expects($this->once())
			->method('lookupTopicViaUserId')
			->with($successExpected->getId())
			->will($this->returnValue(null));
		
		$voteTopicFailController = new \Main\Controller\LoginController($successExpected->getUniqueUrlExtension());
		$voteTopicFailController->setUserDao($voteFailUserMock);
		$voteTopicFailController->setVotingTopicDao($voteTopicFailMock);
		$votingTopicFailSet = array(json_encode(array('status' => '404', 'message' => "Voting topic was not found, it may be deactivated?")), $voteTopicFailController);
		
		array_push($dataSet, $successSet, $userFailSet, $votingTopicFailSet);
		return $dataSet;
	}
}

?>