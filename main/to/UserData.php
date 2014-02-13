<?php namespace Main\To;

/**
 * Simple user data object.
 */
class UserData implements \JsonSerializable {
	
	/**
	 * The id of the user.
	 */
	private $id;
	
	/**
	 * The nickname of the user.
	 */
	private $nickname;
	
	/**
	 * The full street address of the user.
	 */
	private $streetAddress;
	
	/**
	 * The system generated unique url ending for the user.
	 */
	private $uniqueUrlExtension;
	
	/**
	 * The email of the user
	 */
	private $email;
	
	/**
	 * Builds the user object.
	 * @param string $id the user's id.
	 * @param string $nickname the user's nickname.
	 * @param string $streetAddress The address of the user.
	 * @param string $uniqueUrlExtension the url key sent the user.
	 * @param string $email The user's email.
	 */
	public function __construct($id, $nickname, $streetAddress, $uniqueUrlExtension, $email) {
		$this->id = $id;
		$this->nickname = $nickname;
		$this->streetAddress = $streetAddress;
		$this->uniqueUrlExtension = $uniqueUrlExtension;
		$this->email = $email;
	}
	
	/**
	 * Encodes the TO so that it can be serialized and passed over json.
	 * 
	 * @return array array representation of the data object.
	 */
	public function jsonSerialize() {
		return array(
			$this->getId()->__toString() => array (
			'id' => $this->getId()->__toString(),
			'nickname' => $this->getNickname(),
			'streetAddress' => $this->getStreetAddress(),
			'uniqueUrlExtension' => $this->getUniqueUrlExtension(),
			'email' => $this->getEmail()
		));
	}
	
	/**
	 * Gets the id.
	 * @return MongoId The id.
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Sets the id.
	 * @param MongoId $id the id to set. 
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * Gets the nickname.
	 * @return string the Nickname
	 */
	public function getNickname() {
		return $this->nickname;
	}
	
	/**
	 * Sets the nickname.
	 * @param string $nickname The nickname to set.
	 */
	public function setNickname($nickname) {
		$this->nickname = $nickname;
	}
	
	/**
	 * Gets the address.
	 * @return string The address.
	 */
	public function getStreetAddress() {
		return $this->streetAddress;
	}
	
	/**
	 * Sets the address.
	 * @param string $streetAddress The street address to set.
	 */
	public function setStreetAddress($streetAddress) {
		$this->streetAddress = $streetAddress;
	}
	
	/**
	 * Gets the unique url.
	 * @return string the unique url.
	 */
	public function getUniqueUrlExtension() {
		return $this->uniqueUrlExtension;
	}
	
	/**
	 * Sets the unique url.
	 * @param string $uniqueUrlExtension The unique url to set.
	 */
	public function setUniqueUrlExtension($uniqueUrlExtension) {
		$this->uniqueUrlExtension = $uniqueUrlExtension;
	}
	
	/**
	 * Gets the email address.
	 * @return string the email address.
	 */
	public function getEmail() {
		return $this->email;
	}
	
	/**
	 * Sets the email address.
	 * @param string $email the email address to set.
	 */
	public function setEmail($email) {
		$this->email = $email;
	}
}

?>