<?php
/**
 * Bootstrap the plugin unit testing environment.
 *
 * Edit 'active_plugins' setting below to point to your main plugin file.
 *
 * @package wordpress-plugin-tests
 */

// Activates this plugin in WordPress so it can be tested.
// Activate dependent plugin as well
$GLOBALS['wp_tests_options'] = array(
	'active_plugins' => array( 'advanced-site-creation/advanced_site_creation.php','wordpress-mu-domain-mapping/domain_mapping.php'),
);

//Enable multisite
define( 'WP_TESTS_MULTISITE', true );

// If the develop repo location is defined (as WP_DEVELOP_DIR), use that
// location. Otherwise, we'll just assume that this plugin is installed in a
// WordPress develop SVN checkout.

if( false !== getenv( 'WP_DEVELOP_DIR' ) ) {
	require getenv( 'WP_DEVELOP_DIR' ) . '/tests/phpunit/includes/bootstrap.php';
} else {
	require '../../../../tests/phpunit/includes/bootstrap.php';
}
