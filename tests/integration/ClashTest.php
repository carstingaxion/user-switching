<?php declare(strict_types = 1);

namespace UserSwitching\Tests;

use user_switching;
use WP_Session_Tokens;

final class ClashTest extends Test {
	/**
	 * @covers \user_switching::detect_session_clash
	 */
	public function testSessionClashIsDetected(): void {
		$admin = self::$testers['admin'];

		// Set up the admin session manager with a session
		$admin_manager = WP_Session_Tokens::get_instance( $admin->ID );
		$admin_token = $admin_manager->create( time() + DAY_IN_SECONDS );

		// Set up the admin user state
		wp_set_current_user( $admin->ID );
		wp_set_auth_cookie( $admin->ID, false, '', $admin_token );

		// Verify that there is no session clash
		self::assertNull( user_switching::detect_session_clash( self::$users['author'] ) );

		// Switch the admin to author
		switch_to_user( self::$users['author']->ID );

		// Verify that the session clash is detected
		self::assertIsArray( user_switching::detect_session_clash( self::$users['author'] ) );

		// Verify that no session clash is detected for another user
		self::assertNull( user_switching::detect_session_clash( self::$users['editor'] ) );

		// Switch the admin back to their admin account
		switch_to_user( $admin->ID, false, false );

		// Verify that there is now no session clash
		self::assertNull( user_switching::detect_session_clash( self::$users['author'] ) );
	}
}
