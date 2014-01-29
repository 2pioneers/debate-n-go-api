<?php namespace Test\Database;

/**
 * Test cases for the core dao object.
 */
class CoreDaoTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 * Verifies the singleton nature of the mongodb connector.
	 */
	public function testCoreDaoIsSingleton() {
		$originalCoreDao = \Main\Database\CoreDao::getInstance();
		$newCoreDao = \Main\Database\CoreDao::getInstance();
		
		$this->assertEquals($originalCoreDao, $newCoreDao);
	}
	
	/**
	 * Verifies the connection by querying test data.
	 */
	public function testSampleCollectionsAreQueried() {
		$coreDao = \Main\Database\CoreDao::getInstance();
		$this->assertNotEmpty($coreDao->getVoting_topics());
		$this->assertNotEmpty($coreDao->getUsers());
		$this->assertNotEmpty($coreDao->getMessages());
		$this->assertNotEmpty($coreDao->getOptions());
	} 
}

?>