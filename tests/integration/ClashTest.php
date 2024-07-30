<?php declare(strict_types = 1);

namespace UserSwitching\Tests;

use user_switching;
use WP_Session_Tokens;

final class ClashTest extends Test {
	/**
	 * @covers \user_switching::detect_session_clash
	 */
	public function testSessionClashIsDetected(): void {
		$admin1 = self::$testers['admin'];
		$admin2 = self::factory()->user->create_and_get( array(
			'role' => 'administrator',
		) );

		// Set up the first admin session manager with a session
		$admin1_manager = WP_Session_Tokens::get_instance( $admin1->ID );
		$admin1_token = $admin1_manager->create( time() + DAY_IN_SECONDS );

		// Set up the second admin session manager with a session
		$admin2_manager = WP_Session_Tokens::get_instance( $admin2->ID );
		$admin2_token = $admin2_manager->create( time() + DAY_IN_SECONDS );

		// Verify that there is no session clash
		self::assertNull( user_switching::detect_session_clash( self::$users['author'] ) );

		// Set up the first admin user state
		wp_set_current_user( $admin1->ID );
		wp_set_auth_cookie( $admin1->ID, false, '', $admin1_token );

		// Switch the first admin to author
		switch_to_user( self::$users['author']->ID );

		// Set up the second admin user state
		wp_set_current_user( $admin2->ID );
		wp_set_auth_cookie( $admin2->ID, false, '', $admin2_token );

		// Verify that the session clash is detected
		self::assertIsArray( user_switching::detect_session_clash( self::$users['author'] ) );
	}
}
