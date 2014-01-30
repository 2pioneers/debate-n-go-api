<?php namespace Main\Controller;

class VotingController {
	
	/**
	 * Places a vote for the specified user id.
	 * 
	 * @param MongoId $userId the user's id.
	 * @param MongoId $optionId The vot option id.
	 * @return 
	 */
	public function placeVote($userId, $optionId) {
		
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