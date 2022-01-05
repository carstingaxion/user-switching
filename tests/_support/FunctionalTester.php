<?php

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 */
class FunctionalTester extends \Codeception\Actor {
	use _generated\FunctionalTesterActions;

	/**
	 * Switch to the specified user
	 *
	 * @param string $user_login
	 */
	public function switchToUser( $user_login ) {
		$user_id = $this->grabUserIdFromDatabase( $user_login );

		$this->amOnAdminPage( sprintf( 'user-edit.php?user_id=%d', $user_id ) );
		$this->click( '#user_switching_switcher' );
	}

	/**
	 * Switch off
	 */
	public function switchOff() {
		$this->amOnAdminPage( '/' );
		$this->click( 'Switch Off' );
	}

	/**
	 * Switch back to the original user
	 *
	 * @param string $user_login
	 */
	public function switchBack( $user_login ) {
		$display_name = $this->grabFromDatabase(
			$this->grabUsersTableName(),
			'display_name',
			[
				'user_login' => $user_login,
			]
		);

		$this->click( sprintf(
			'Switch back to %1$s (%2$s)',
			$display_name,
			$user_login
		) );
	}

	/**
	 * Verify that the user is logged in as the specified user
	 *
	 * @param string $user_login
	 */
	public function loggedInAs( $user_login ) {
		$display_name = $this->grabFromDatabase(
			$this->grabUsersTableName(),
			'display_name',
			[
				'user_login' => $user_login,
			]
		);

		$this->see(
			$display_name,
			'#wpadminbar .display-name'
		);
	}

	/**
	 * Verify that the user is logged out
	 */
	public function loggedOut() {
		$this->cantSeeElement( '#wpadminbar .display-name' );
	}

	/**
	 * Verify the page language
	 *
	 * @param string $lang
	 */
	public function thePageLanguageShouldBe( $lang ) {
		throw new \Exception( 'Not implemented' );
	}

	/**
	 * Verify the language of an element
	 *
	 * @param string $selector
	 * @param string $lang
	 */
	public function theElementLanguageShouldBe( $selector, $lang ) {
		throw new \Exception( 'Not implemented' );
	}

	/**
	 * Checks that the current page contains an admin success notice.
	 *
	 * @param string $text The message text to search for.
	 */
	public function seeAdminSuccessNotice( string $text ) {
		return $this->see( $text, '.notice-success' );
	}

	/**
	 * Checks that the current page contains an admin success notice.
	 *
	 * @param string $text The message text to search for.
	 */
	public function seeAdminWarningNotice( string $text ) {
		return $this->see( $text, '.notice-warning' );
	}

	/**
	 * Checks that the current page contains an admin success notice.
	 *
	 * @param string $text The message text to search for.
	 */
	public function seeAdminErrorNotice( string $text ) {
		return $this->see( $text, '.notice-error' );
	}

	/**
	 * Checks that the current page contains an admin success notice.
	 *
	 * @param string $text The message text to search for.
	 */
	public function seeAdminInfoNotice( string $text ) {
		return $this->see( $text, '.notice-info' );
	}
}
