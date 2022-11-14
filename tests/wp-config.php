<?php
/**
 * This is the configuration file that's used for the acceptance tests and WP-CLI commands.
 */

mysqli_report( MYSQLI_REPORT_OFF );

$_root_dir = dirname( __DIR__ );
$_env_dir = __DIR__;

require_once $_root_dir . '/vendor/autoload.php';

if ( is_readable( $_env_dir . '/.env' ) ) {
	$dotenv = Dotenv\Dotenv::create( $_env_dir );
	$dotenv->load();
}

// Disable debug mode as it can cause "headers already sent" if there are deprecations
define( 'WP_DEBUG', false );

// Prevent WP-Cron doing its thing during testing.
define( 'DISABLE_WP_CRON', true );

define( 'WP_PLUGIN_DIR', dirname( dirname( __DIR__ ) ) );

// WARNING WARNING WARNING!
// These tests will DROP ALL TABLES in the database with the prefix named below.
// DO NOT use a production database or one that is shared with something else.
define( 'DB_NAME',     getenv( 'WP_TESTS_DB_NAME' ) ?: 'wordpress_test' );
define( 'DB_USER',     getenv( 'WP_TESTS_DB_USER' ) ?: 'root' );
define( 'DB_PASSWORD', getenv( 'WP_TESTS_DB_PASS' ) ?: '' );
define( 'DB_HOST',     getenv( 'WP_TESTS_DB_HOST' ) ?: 'localhost' );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
