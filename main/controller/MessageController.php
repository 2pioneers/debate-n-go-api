<?php namespace Main\Controller;

class MessageController {
	
	 /**
	  * Creates a new message.
	  */
	 public function leaveMessage($body) {
	 	/*
		 * 1. create new message object.
		 * 2. insert message.
		 * 3. store id in votingtopic.
		 * 4. store in each voting option.
		 */
		
	 }
	 
	 /**
	 * Checks the session data and verifies the user is the one in the system.
	 * 
	 * @param UserId $userId The supplied id to verify is in session.
	 * @return bool true if the user data is in the session.
	 */
	private function checkSession($userId) {
		if(isset($_SESSION['userData']) && $userId == $_SESSION['userData']->getId()) {
			return true;
		}
		return false;
	}
}

?>