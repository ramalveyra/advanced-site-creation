<?php

/**
 * Unit test for the advanced site creation plugin
 *
 * @package advanced-site-creation
 */

class WP_Test_WordPress_Plugin_Advanced_Site_Creation extends WP_UnitTestCase {

	/** 
	 * A reference to the plugin
	 * @access private
	 * @var Advance_Site_Creation_Manager instance 
	 */
	private $asc;

	/** 
	 * References to dependent plugins 
	 * @access private
	 * @var array
	 */
	private $dependent_plugins = array(
	);

	/**
	 * Used for testing admin functions
	 * @access private
	 * @var int
	 */
	protected $administrator_id;

	/** 
	 * Set and initiate the plugins here 
	 */
	public function setUp() {
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

	/**
	 * On test end
	 */
	public function tearDown() {
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
	public function test_wp_version() {

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
	public function test_plugin_activated() {
		$this->assertTrue(is_plugin_active('advanced-site-creation/advanced_site_creation.php'));
	}

	/**
	 * Verifies that the plugin isn't null and was properly retrieved.
	 */
	function test_plugin_init() {
		$this->assertFalse( null == $this->asc );
	}

	/**
	 * Check dependent plugins
	 * @todo Complete the function to check dependent plugins 
	 */
	function test_dependent_plugins_activated(){
		//$this->markTestSkipped();
		/* Supply dependent plugin by adding slugs here */
		$_plugins = array(
			'wordpress-mu-domain-mapping/domain_mapping.php',
		);

		foreach ($_plugins as $key => $plugin) {
			if(is_plugin_active($plugin)==FALSE){
				$this->fail('The dependent plugin "'. $plugin .'" was not active');
			}
		}
	}

	/**
	 * The plugin core functionality tests 
	 * 
	 * Add tests here for the plugins core functionalities
	 *
	 */
	/** 
	 * function test_plugin_menu_added
	 * Check if the menu has been added correctly
	 */
	function test_plugin_menu_added(){
		
		//Arrange
		//set the variables
		global $advanced_site_creation_menu;


		$expected_menu = 'admin_page_site-new-advanced';

		
		//Act
		// Create the plugin menu
		$this->asc->add_advanced_site_creation_menu();
		

		
		// Assert
		// Check for existence
		$this->assertNotNull($advanced_site_creation_menu);
		$this->assertEquals($expected_menu,$advanced_site_creation_menu);

	}

	/**
	 * Check if the Javascripts have been loaded
	 */
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
				$this->fail('The required javascript "'. $js .'" was not loaded');
			}
		}
	}

	/**
	 * Check the plugin settings
	 */
	/**
 	 * function test_has_no_settings
 	 * Test that by default, the plugin has no settings	
	 */
	function test_has_no_settings(){
		$this->assertFalse($this->asc->network_settings);
	}

	/**
	 * Should return null if no post is set
	 */
	function test_post_empty(){

		//Act
		$this->asc->saveNetworkSettings();
		
		//Assert
		$this->assertFalse($this->asc->network_settings);
	}

	/** 
	 * Should not set settings if $_POST value is not for plugin settings
	 */
	function test_filter_posts(){
		//Arrange
		$_POST['random'] = 'dummy';

		//Act
		$this->asc->saveNetworkSettings();

		//Assert
		$this->assertFalse($this->asc->network_settings);
	}

	
	/** 
	 * Check if plugin uses nonce
	 */
	function test_plugin_settings_nonce_check(){
		//Arrange
		$_POST['network_settings'] = array();
		$nonce_checked = false;

		//Act
		try {
           $this->asc->saveNetworkSettings();
        } catch (WPDieException $e) {
        	//Function failed, means its looking for nonce
        	$nonce_checked = true;
        }

        //Assert
        $this->assertTrue($nonce_checked,'Nonce not being checked.');
	}

	/**
	 * Check if plugin sanitize fields
	 */
	function test_plugin_settings_field_sanitize(){
		//Arrange
		//Create nonce
		$_POST['network_settings'] = array();
		$nonce = wp_create_nonce('save-network-settings');
		$_REQUEST['asc-settings-network-plugin'] = $nonce;

		//Create unsanitized value;
		$unsanitized_field = '<??>';

		$_POST['network_settings']['unsanitized_field'] = $unsanitized_field;
			
		//Act
		$this->asc->saveNetworkSettings();
		$options = get_site_option('asc_network_settings');
		
		//Assert
		$this->assertNotEquals($unsanitized_field, $options['unsanitized_field'], 'Fields not being sanitized.');
	}

	/** 
	 * Check if plugin settings are saved 
	 */
	function test_plugin_settings_set_fields(){
		//Arrange
		//Create nonce
		$_POST['network_settings'] = array();
		$nonce = wp_create_nonce('save-network-settings');
		$_REQUEST['asc-settings-network-plugin'] = $nonce;
		//test field values
		$_POST['network_settings']['themedisplay']  ='default';
		$_POST['network_settings']['plugindisplay'] ='default';
		$_POST['network_settings']['themesperpage'] = 5;
		$_POST['network_settings']['pluginsperpage'] = 5;

		//Act
		$this->asc->saveNetworkSettings();
		$options = get_site_option('asc_network_settings');

		//Assert
		$this->assertTrue(is_array($options));
		foreach ($options as $key => $value) {
			$this->assertEquals($_POST['network_settings'][$key],$value);
		}
	}

	/**
	 * Plugin's core functionality tests
	 */
	/**
	 * function test_get_themes_default
	 * Check if the themes are fetched (default settings)
	 */
	function test_get_themes_default(){
		//Act
		$this->asc->getThemes();

		//Assert
		//Must return a theme
		$this->assertTrue(is_array($this->asc->themes));

		//Must not be empty
		$this->assertFalse(empty($this->asc->themes));

		//Must be an instance of WP_Theme
		foreach($this->asc->themes as $theme){
			$this->assertEquals(get_class($theme),'WP_Theme');
		}
	}

	/**
	 * Check if the plugin limits the themes fetched
	 */
	function test_get_themes_limit_on_view_default(){
		//Arrange
		$this->asc->network_settings['themedisplay']='default';
		$this->asc->network_settings['themesperpage'] = 1;
		//get the total of wordpress themes
		$wp_themes =  wp_get_themes();

		//Act
		$this->asc->getThemes();

		//Assert
		$this->assertTrue(count($this->asc->themes)==1,'Theme limit not working');
		$this->assertFalse(count($this->asc->themes) > count($wp_themes));
	}

	/**
	 * Check whether pagination works (default settings)
	 */
	function test_get_themes_pagination_on_view_default(){
		//Arrange
		$this->asc->network_settings['themedisplay']='default';
		$this->asc->network_settings['themesperpage'] = 1;

		//get the total of wordpress themes
		$wp_themes =  wp_get_themes();

		//Act
		//only if there are more than 1 default theme
		if(is_array($wp_themes) && count($wp_themes) > 1){
			$options = array();
			$options['page'] = 2;

			$this->asc->getThemes($options);

			//Assert
			$this->assertTrue(count($this->asc->themes)==1,'Pagination not working');
		}
	}

	/**
	 * Check whether search works
	 *
	 * This assumes that the test is running on wordpress develop trunk
	 * git://develop.git.wordpress.org - which contains themes out of the box
	 * testing agianst default installed theme 'twentythirteen'
	 */
	function test_get_themes_search_on_view_default(){
		//Arrange
		$this->asc->network_settings['themedisplay']='default';
		$this->asc->network_settings['themesperpage'] = 1;

		//get wordpress themes
		$wp_themes =  wp_get_themes();
		//select a theme to search
		$theme_search_query = 'twentythirteen';

		//Act	
		if(is_array($wp_themes) && count($wp_themes) > 1){
			foreach ($wp_themes as $key => $value) {
				if($key==$theme_search_query){
					//theme found, do the same search for getThemes
					$options = array();
					$options['search'] = $theme_search_query;

					$this->asc->getThemes($options);

					//Assert
					$this->assertTrue(is_array($this->asc->themes),'No themes array returned.');
					$this->assertTrue(count($this->asc->themes)==1,'Function returned 0 results to evaluate.'); // A theme was fetched
					//verify if there is one valid search
					$found_theme = false;
					foreach ($this->asc->themes as $key => $value) {
						if($key==$theme_search_query){
							$found_theme = true;
							break;
						}
					}
					$this->assertTrue($found_theme,'No theme was found using the search');

					break;
				}
			}
		}
	}

	/**
	 * Check plugins fetching
	 */
	/**
	 * function test_get_plugins
	 * Check whether plugins are being returned.
	 */
	public function test_get_plugins(){
		//Arrange
		//fetch if there are plugins within wordpress
		$wp_plugins = get_plugins();
		$plugin_name = plugin_basename(ASC_PLUGIN_PATH);

		//fail if empty
		$this->assertFalse(empty($wp_plugins));

		//Act
		$this->asc->getPlugins();

		//Assert
		//Must return a plugin
		$this->assertFalse(empty($this->asc->allowedPlugins));
		
		//This plugin should not be included
		foreach($this->asc->allowedPlugins as $key=>$plugin){
			$this->assertNotEquals($key,$plugin_name);
		}

	}

	/**
	 * Check if limit and pagination for fetching plugin
	 */
	public function test_get_plugins_limit_on_view_default(){
		//Arrange
		$this->asc->network_settings['plugindisplay']='default';
		$this->asc->network_settings['pluginsperpage'] = 1;
		
		//get the total of wordpress default plugins
		$wp_plugins = get_plugins();

		//Act
		$this->asc->getPlugins();

		//Assert
		$this->assertTrue(count($this->asc->allowedPlugins)==1,'Plugins limit not working');
		$this->assertFalse(count($this->asc->allowedPlugins) > count($wp_plugins));
	}

	/**
	 * Check whether pagination works for plugins (default settings)
	 */
	function test_get_plugins_pagination_on_view_default(){
		//Arrange
		$this->asc->network_settings['plugindisplay']='default';
		$this->asc->network_settings['pluginsperpage'] = 1;

		//get the total of wordpress default plugins
		$wp_plugins = get_plugins();

		//Act
		//only if there are more than 1 plugin
		if(is_array($wp_plugins) && count($wp_plugins) > 1){
			$options = array();
			$options['page'] = 2;

			$this->asc->getPlugins($options);

			//Assert
			$this->assertTrue(count($this->asc->allowedPlugins)==1,'Pagination not working');
		}
	}

	/**
	 * Check whether search for plugin works
	 *
	 * This assumes that the test is running on wordpress develop trunk
	 * git://develop.git.wordpress.org which contains plugins out of the box
	 * testing agianst default installed plugin 'hello.php'
	 */
	function test_get_plugins_search_on_view_default(){
		//Arrange
		$this->asc->network_settings['plugindisplay']='default';
		$this->asc->network_settings['pluginsperpage'] = 1;

		//get wordpress plugins
		$wp_plugins = get_plugins();

		//select a plugin to search
		$plugin_search_query = 'hello';
		$plugin_search_slug = 'hello.php';

		//Act	
		if(is_array($wp_plugins) && count($wp_plugins) > 1){
			foreach ($wp_plugins as $key => $wp_plugins) {
				if($key==$plugin_search_slug){
					//plugin found, do the same search for getPlugins
					$options = array();
					$options['search'] = $plugin_search_query;

					$this->asc->getPlugins($options);

					//Assert
					$this->assertTrue(is_array($this->asc->allowedPlugins),'No plugins array returned.'); //returned some results
					$this->assertTrue(count($this->asc->allowedPlugins)==1, 'Function returned 0 results to evaluate.'); // A plugin was fetched
					//verify if there is one valid search
					$found_plugin = false;

					foreach ($this->asc->allowedPlugins as $key => $value) {
						if($key==$plugin_search_slug){
							$found_plugin = true;
							break;
						}
					}
					$this->assertTrue($found_plugin,'No plugin was found using the search');

					break;
				}
			}
		}
	}

	/**
	 * function test_plugin_blog_creation
	 *
	 * Checks whether blog creation with advanced site creation works.
	 * This assumes that the test is running on wordpress develop trunk
	 * git://develop.git.wordpress.org which contains themes out of the box
	 * testing agianst default theme included 'twentythirteen'
	 * note that auto settings of plugins are not checked as the test does not dynamically create wp_{blog_id}_options for newly created site (multisite)
	 * and plugins are automatically activated via tests 'bootstrap.php'
	 */
	function test_plugin_blog_creation(){
		//Arrange
		$user_id = $this->administrator_id;
		$test_path = '/test_blogname';
		$test_title = 'Created blog';
		$set_theme = 'twentythirteen';
		$_POST['theme-id'] = $set_theme; //Assume that 'twentythirteen' has been selected by the plugin
		
		//Act
		$blog_id = $this->factory->blog->create( array( 'user_id' => $user_id, 'title' => $test_title ));
		
		//Assert 
		$this->assertTrue(is_int($blog_id)); //site was created;

		//check theme
		switch_to_blog($blog_id);
		$this->assertEquals(get_bloginfo('template_url'),'http://example.org/wp-content/themes/'.$set_theme);
		restore_current_blog();
	}

}
