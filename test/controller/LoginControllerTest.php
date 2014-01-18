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
		$successMock = $this->getMock('Main\Database\UserDao', array('searchUserByUrlExtension'));
		$successMock->expects($this->once())
			->method('searchUserByUrlExtension')
			->with($successExpected->getUniqueUrlExtension())
			->will($this->returnValue($successExpected));
		$successController = new \Main\Controller\LoginController($successExpected->getUniqueUrlExtension());
		$successController->setUserDao($successMock);
		$successSet = array(json_encode(array('status' => 'ok', 'userData' => $successExpected)), $successController);
		
		$fakeurl = "fakeurl";
		$failMock = $this->getMock('Main\Database\UserDao', array('searchUserByUrlExtension'));
		$failMock->expects($this->once())
			->method('searchUserByUrlExtension')
			->with($fakeurl)
			->will($this->returnValue(null));
		$failController = new \Main\Controller\LoginController($fakeurl);
		$failController->setUserDao($failMock);
		$failSet = array(json_encode(array('status' => '404', 'message' => "User was not found. Do you have the wrong url?")), $failController);
		
		array_push($dataSet, $successSet, $failSet);
		return $dataSet;
	}
}

?>