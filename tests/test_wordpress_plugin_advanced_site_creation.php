<?php

/**
 * Tests to test that that testing framework is testing tests. Meta, huh?
 *
 * @package wordpress-plugins-tests
 */

class WP_Test_WordPress_Plugin_Advanced_Site_Creation extends WP_UnitTestCase {

	/* A reference to the plugin */
	private $asc;

	/* References to dependent plugins */
	private $dependent_plugins = array(
	);

	protected $administrator_id;

	/* Set and initiate the plugins here */
	function setUp() {
		parent::setUp();

		// create a super-admin
		$current_user = get_current_user_id();
		wp_set_current_user( $this->factory->user->create( array( 'role' => 'administrator' ) ) );
		$this->administrator_id = $current_user;
		if ( is_multisite() ){
			grant_super_admin( $this->administrator_id);
		}

		$this->asc = new Advance_Site_Creation_Manager;

		//TODO: dependencies
		//Set Wordpress Multisite Domain mapping plugin to test plugin dependencies
	}

	function tearDown() {
		if ( is_multisite() )
			revoke_super_admin( $this->administrator_id );

		parent::tearDown();
	}

	/**
	 * If these tests are being run on Travis CI, verify that the version of
	 * WordPress installed is the version that we requested.
	 *
	 * @requires PHP 5.3
	 */
	function test_wp_version() {

		if ( !getenv( 'TRAVIS' ) )
			$this->markTestSkipped( 'Test skipped since Travis CI was not detected.' );

		$requested_version = getenv( 'WP_VERSION' ) . '-src';

		// The "master" version requires special handling.
		if ( $requested_version == 'master-src' ) {
			$file = file_get_contents( 'https://raw.github.com/tierra/wordpress/master/src/wp-includes/version.php' );
			preg_match( '#\$wp_version = \'([^\']+)\';#', $file, $matches );
			$requested_version = $matches[1];
		}
		$this->assertEquals( get_bloginfo( 'version' ), $requested_version );
	}

	/**
	 * Ensure that the plugin has been installed and activated.
	 */
	function test_plugin_activated() {
		$this->assertTrue(is_plugin_active('advanced-site-creation/advanced_site_creation.php'));
	}

	/**
	 * Verifies that the plugin isn't null and was properly retrieved.
	 */
	function test_plugin_init() {
		$this->assertFalse( null == $this->asc );
	}

	/**
	 * TODO: Check dependent plugins
	 * Skip this for now
	 */
	function test_dependent_plugins_activated(){
		$this->markTestSkipped();
		/* Supply dependent plugin by adding slugs here */
		$_plugins = array(
			'wordpress-mu-domain-mapping/domain_mapping.php',
		);

		foreach ($_plugins as $key => $plugin) {
			if(is_plugin_active($plugin)==FALSE){
				$this->fail();
			}
		}
	}

	/**
	 * The plugin core functionality tests 
	 * Add tests here for the plugins core functionalities
	 */

	// Check if the menu has been added correctly
	function test_plugin_menu_added(){
		/** 
		 * -- Arrange --
		 * set the variables
		 */
		global $advanced_site_creation_menu;


		$expected_menu = 'admin_page_site-new-advanced';

		//set_current_screen( 'dashboard-network' );
		/** 
		 * -- Act --
		 */
		// Create the plugin menu
		$this->asc->add_advanced_site_creation_menu();
		

		/** 
		 * -- Assert --
		 * Check for existence
		 */
		
		$this->assertNotNull($advanced_site_creation_menu);
		$this->assertEquals($expected_menu,$advanced_site_creation_menu);

	}

	function test_plugin_js_loaded(){
		//Arrange
		//list javascript used by plugin
		$plugin_js = array(
			'advanced_site_creation.js', //core	
			'select2.js' //lib
			);

		//Act
		//load the js
		$this->asc->loadJS();

		//Assert
		foreach($plugin_js as $js){
			if(wp_script_is($js)===FALSE){
				$this->fail();
			}
		}
	}


	
}
