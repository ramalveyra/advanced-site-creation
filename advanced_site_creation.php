<?php
/**
 * Plugin Name: Advanced Site Creation Plugin
 * Plugin URI: https://github.com/Link7/advanced-site-creation
 * Description: A plugin to customise Wordpress MU site creation
 * Version: 1.1
 * Author: Link7
 * Author URI: https://github.com/Link7
 * License: GPL3
 * License URI: http://www.gnu.org/licenses/gpl.html
 * Credits: 
 *	Donncha O Caoimh http://ocaoimh.ie/ for WordPress MU Domain Mapping (http://ocaoimh.ie/wordpress-mu-domain-mapping/) 
 *	Igor Vaynberg http://ivaynberg.github.io/select2/ for select2 library
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 */

/** Load WordPress Administration Bootstrap */
require_once(ABSPATH.'/wp-admin/includes/admin.php');
require_once(ABSPATH.'/wp-admin/includes/theme.php');


if ( ! is_multisite() )
	wp_die( __( 'Multisite support is not enabled.' ) );

define('ASC_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define('ASC_PLUGIN_PATH', __FILE__);

class Advance_Site_Creation_Manager
{
	public $themes;
	public $plugins;
	public $allowedPlugins = array();
	public $network_settings = array();
	public $paginate = array();
	public $search;

	/**
	 * public site_creation_method
	 * 
	 * sets the default site creation
	 * set as 'clone' to default the feature to site cloning
	 * set as 'default' for the default site creation settings
	 */
	public $site_creation_method = 'clone';

	/**
	* Set the way plugins are handled e.g. Admin only, required etc.
	* exclude - exclude the plugin from the list of plugins that can be automatically activated to a site
	* required - for some site creation feature to work, 'required' plugins must be installed 
	*/
	public $plugin_config = array(
		'advanced-site-creation/advanced_site_creation.php' => array('exclude'),
		'wordpress-mu-domain-mapping/domain_mapping.php' => array('exclude','required')
	);

	public function __construct(){
		add_action( 'network_admin_menu', array( $this,'add_advanced_site_creation_menu' ));
		add_action('wpmu_new_blog', array($this,'advanced_site_configs'));
		add_action('admin_print_scripts-sites_page_site-new-advanced', array($this,'loadJS'));

		// option values
	 	add_action( 'admin_init', array($this,'saveNetworkSettings'));

	 	//Uninstall hook
	 	register_uninstall_hook(__FILE__, array('Advance_Site_Creation_Manager','advanced_site_creation_uninstall_plugin'));

	 	// creating Ajax call for Themes and Plugins
   		add_action( 'wp_ajax_nopriv_get_themes_ajax', array($this,'get_themes_ajax'));  
   		add_action( 'wp_ajax_get_themes_ajax', array($this,'get_themes_ajax'));
   		add_action( 'wp_ajax_nopriv_get_plugins_ajax', array($this,'get_plugins_ajax'));  
   		add_action( 'wp_ajax_get_plugins_ajax', array($this,'get_plugins_ajax'));

   		//Ajax call for cloning site
   		add_action( 'wp_ajax_nopriv_clone_site_ajax', array($this,'clone_site_ajax'));  
   		add_action( 'wp_ajax_clone_site_ajax', array($this,'clone_site_ajax'));

	 	//load the settings values
	 	$this->network_settings = get_site_option( 'asc_network_settings');
		$this->getPlugins();
		 
	}
	public function loadJS(){
		wp_register_script( 'advanced_site_creation.js', ASC_PLUGIN_URL .DIRECTORY_SEPARATOR. 'advanced_site_creation.js');
        wp_enqueue_script( 'advanced_site_creation.js' );
        wp_register_script( 'select2.js', ASC_PLUGIN_URL .DIRECTORY_SEPARATOR. 'lib' . DIRECTORY_SEPARATOR . 'select2-3.4.5' . DIRECTORY_SEPARATOR .'select2.js');
        wp_enqueue_script( 'select2.js' );
        wp_enqueue_style( 'select2.css', ASC_PLUGIN_URL .DIRECTORY_SEPARATOR. 'lib' . DIRECTORY_SEPARATOR . 'select2-3.4.5' . DIRECTORY_SEPARATOR .'select2.css' );
        wp_localize_script( 'advanced_site_creation.js', 'asc_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ))); 
    }

	/**
	* Function to add the "Add Site" menu and Advanced Site Creation settings page
	*/
	public function add_advanced_site_creation_menu(){
		global $advanced_site_creation_menu;
		if(isset($this->network_settings['removedefaultadd'])){
	 		if($this->network_settings['removedefaultadd']=='on'){
	 			add_filter('admin_head-site-new.php',array($this,'redirectToASC'));
	 			remove_submenu_page('sites.php','site-new.php');
	 		}
	 	}
		$advanced_site_creation_menu = add_submenu_page( 'sites.php', 'Add New (Advanced)','Add New (Advanced)', 'manage_options', 'site-new-advanced', array(&$this, 'site_new_custom') );

  		//add the settings menu
  		add_submenu_page(
	       'settings.php',
	       'Advanced Site Creation: Settings',
	       'Advanced Site Creation Settings',
	       'manage_network_options',
	       'asc_network_settings',
	       array($this,'setPluginSettings')
  		);
  		add_action("load-$advanced_site_creation_menu", array($this,'getThemes'));
	}
	public function redirectToASC($blog_id)
	{
		if(isset($_GET['advanced'])){
			if($_GET['advanced']==true && $blog_id!==''){
				wp_redirect( admin_url( 'network/sites.php?page=site-new-advanced&update=added&id='.$blog_id)); 
	    		exit;
			}	
		}else{
			if(isset($this->network_settings['removedefaultadd'])){
	 			if($this->network_settings['removedefaultadd']=='on'){
	 				wp_redirect(admin_url( 'network/sites.php?page=site-new-advanced')); 
	 				exit;
	 			}
	 		}
		}
	}

	/**
	*	Function used for the new site creation page
	*
	*/
	public function site_new_custom(){

		// check the type of creation option
		if($this->site_creation_method == 'clone'){

			// fetch existing blogs
			global $wpdb;

			$error = NULL;

			if ( is_multisite() ) { $subdomain_install = is_subdomain_install(); }

			// fetch existing blogs
			//$the_blogs = get_blog_list( 1, 'all' ); could this also work? ->later
			$tbl_blogs = $wpdb->prefix ."blogs";
			$the_blogs = $wpdb->get_results( "SELECT blog_id, domain, path FROM $tbl_blogs WHERE blog_id <> '1'" );

			if (!$subdomain_install) {
				// trim each value in the array from slashes (subdirs)
				function removeslash(&$value) { $value = str_replace("/", "", $value); } 
				for ( $i = 0; $i < sizeof( $the_blogs ); $i++ ) {
					array_walk($the_blogs[$i], 'removeslash');
				}
			}

			// fetch existing users
			$tbl_users = $wpdb->prefix ."users";
			$the_users = $wpdb->get_results( "SELECT ID, user_login FROM $tbl_users" );

			// check for errors
			if(!$the_blogs) { $error['blogs'] = "there are no templates to choose from"; }
			if(!$the_users) { $error['users'] = "there are no users, which is impossible.."; }

			if(!$error) {
				$form_action = network_admin_url('sites.php?page=site-new-advanced');
			}else{
				$form_action = network_admin_url('site-new.php?action=add-site&advanced=true');
				$this->site_creation_method = 'default';	
			}
		}else{
			$form_action = network_admin_url('site-new.php?action=add-site&advanced=true');
		}

		$current_site = get_current_site();
		include_once('include/add_site_form.php');
	}
	
	public function getThemes($options = null){
		$themes_per_page = (int)10; //default
		$page = 1; //default
		$search = null;
		$this->paginate['themes'] = array(); //refresh the pagination

		$this->themes = wp_get_themes();

		//check if default is selected
		if(isset($this->network_settings['themedisplay'])){
			if($this->network_settings['themedisplay']=='default'){
				//check if per page has been set
				if(isset($this->network_settings['themesperpage'])){
					$themes_per_page = $this->network_settings['themesperpage'];
				}
			}	
		}

		if(is_array($options)){
			if(isset($options['page'])){
				$page = $options['page'];
			}
			if(isset($options['search'])){
				$search = $options['search'];
			}
		}

		//do search (search and pagination are patterned based on worpdress way for themes)
		if(!is_null($search) && $search!==''){
			$this->search = $search;
			$this->themes = array_filter($this->themes, array( $this, '_search_callback_theme' ));
		}

		$totalthemes = count($this->themes);
		
		$pages = ceil($totalthemes/$themes_per_page);

		//filters
		if($page < 1){
			$page = 1;
		}else if($page > $pages){
			$page = $pages;
		}

		$start = ( $page - 1 ) * $themes_per_page;

		if ( $totalthemes > $themes_per_page ){
			$this->themes = array_slice( $this->themes, $start, $themes_per_page, true);
			$this->paginate['themes'] = array(
				'total'=>$totalthemes, 
				'per_page'=>$themes_per_page, 
				'pages'=>$pages,
				'current_page'=>$page);
		}

	}

	/**
	* Function handling the Themes search and pagination
	*/
	public function get_themes_ajax(){
		//security
		if ( !wp_verify_nonce( $_REQUEST['nonce'], "theme-search")) {
      		exit('error');
   		}
   		//setup pagination
   		$current_page = sanitize_text_field($_REQUEST['current_page']);
   		$page_action = $_REQUEST['page_action'];
   		$total_pages = $_REQUEST['total_pages'];
   		$search =  sanitize_text_field($_REQUEST['search_query']);


   		if($page_action == 'prev-page'){
   			$page = $current_page - 1;
   		}else if($page_action == 'first-page'){
   			$page = 1;
   		}else if($page_action == 'next-page'){
   			$page = $current_page + 1;
   		}else if($page_action == 'last-page'){
   			$page = $total_pages;
   		}else{
   			$page = $current_page;
   		}

   		$options = array(
   			'page' => $page,
   			'search' => $search
   		);

   		$this->getThemes($options);
   		include_once('include/theme-inc.php');
   		die();
	}

	/**
	* Function handling the Plugins search and pagination
	*/
	public function get_plugins_ajax(){
		//security
		if ( !wp_verify_nonce( $_REQUEST['nonce'], "plugins-search")) {
      		exit('error');
   		}

   		//setup pagination
   		$current_page = sanitize_text_field($_REQUEST['current_page']);
   		$page_action = $_REQUEST['page_action'];
   		$total_pages = $_REQUEST['total_pages'];
   		$search =  sanitize_text_field($_REQUEST['search_query']);


   		if($page_action == 'prev-page'){
   			$page = $current_page - 1;
   		}else if($page_action == 'first-page'){
   			$page = 1;
   		}else if($page_action == 'next-page'){
   			$page = $current_page + 1;
   		}else if($page_action == 'last-page'){
   			$page = $total_pages;
   		}else{
   			$page = $current_page;
   		}

   		$options = array(
   			'page' => $page,
   			'search' => $search
   		);

   		$this->getPlugins($options);
   		include_once('include/plugins-inc.php');
   		die();
	}

	/**
	 * function to handle ajax when cloning site
	 * 
	 * this function is mostly taken from Add Cloned Sites for WPMU (batch)
	 * @credits Frits Jan van Kempen
	 */
	public function clone_site_ajax(){
		//security
		if ( !wp_verify_nonce( $_REQUEST['nonce'], "clone-site")) {
      		exit('error');
   		}

   		global $wpdb;
   		
   		$response = Array(
   			'success' => true,
   			'message' => ''
   		);

   		// start timing
		$time_start = microtime(true);
		$error = NULL;
		$cloned = NULL;
		$failed = NULL;

		//prepare values
		// check for subdir or subdomain install
		if ( is_multisite() ) { $subdomain_install = is_subdomain_install(); }

		// Get POST data
		$template_id = $_POST['values']['site_template'];
		$user_id = $_POST['values']['site_user'];
		$include_uploads = $_POST['values']['include_uploads'];

		
		//check for domain name
		if(empty($_POST['values']['domain_name'])){
			$domainmap = FALSE;
		}
		if (!$this->is_valid_domain_name($_POST['values']['domain_name'])){
		 	$domainmap = FALSE;
		}else{
			$domainmap = TRUE;
			$domain_name = $_POST['values']['domain_name'];
		}

		//TODO: Check clone with image
		$copy_images = FALSE;

		$pluginUrl = ASC_PLUGIN_URL;

		// get admin email
		$admin_info = get_userdata($user_id);

		if(!$admin_info){
			$response['message'] = 'Unable to clone site.'.PHP_EOL;
			$response['message'].= 'ERR: Invalid user.';
			$response['success'] = false;
			header('Content-Type: application/json');
			echo json_encode($response);
	   		die();
		}

		$admin_email = $admin_info->user_email;

		//assign values
		$siteurl = $_POST['values']['domain'];
		$blogname = $_POST['values']['title'];

		//validation
		//check for template blog
		if(!$wpdb->get_var("SELECT blog_id FROM $wpdb->blogs WHERE blog_id = '$template_id'")) {
			$response['message'] = 'Unable to clone site.'.PHP_EOL;
			$response['message'].= 'ERR: Template site does not exist.';
			$response['success'] = false;
			header('Content-Type: application/json');
			echo json_encode($response);
	   		die();
		}

		//Get the description
		switch_to_blog($template_id);
	 	$blogdescription = get_bloginfo('description');
    	restore_current_blog();

		$site_array[0][0] = $siteurl;
		$site_array[0][1] = $blogdescription;
		$site_array[0][2] = $blogname;
		$site_array[0][3] = $user_id;
		$site_array[0][4] = $admin_email;
		$site_array[0][5] = $template_id;

		// trim each value in the array from whitespaces and left comma's
		for ( $i = 0; $i < sizeof( $site_array ); $i++ ) {
			array_walk($site_array[$i], array($this,'acswpmu_trim_value'));
		}

		if ($subdomain_install) {
			$domain = $siteurl . "." . get_blog_details(1)->domain; 
			$fulldomain = $domain;
			$path = "/";
		} else {
			$domain = get_blog_details(1)->domain;
			$fulldomain = get_blog_details(1)->domain . "/" . $siteurl; 
			$path = "/" . $domain; 
		}

		//invalid domain
		if(!$this->is_valid_domain_name($domain)){
			$response['message'] = 'Unable to clone site.'.PHP_EOL;
			$response['message'].= 'ERR: Invalid site address';
			$response['success'] = false;
			header('Content-Type: application/json');
			echo json_encode($response);
	   		die();
		}

		//Add some info
		$message = '';
		$message.= 'New Site Address: '.$domain.PHP_EOL;
		$message.= 'New Site Title: '.$blogname.PHP_EOL;

		// Check first if domain already exists then add a new site
		if ($subdomain_install){
			if($exist_id = $wpdb->get_var("SELECT blog_id FROM $wpdb->blogs WHERE domain = '$fulldomain'")) {
				$response['message'] = 'Unable to clone site.'.PHP_EOL;
				$response['message'].= "The URL $fulldomain already exists.";
				$response['success'] = false;
				header('Content-Type: application/json');
				echo json_encode($response);
		   		die();
			} else {
				// Start with adding the new blog to the blogs table
				$new_blog_id = insert_blog( $domain, $path, '1');
				if(is_integer($new_blog_id)) {
					$message.= "New site created with id: $new_blog_id" . PHP_EOL;
				} else {
					$response['message'] = 'Unable to clone site.'.PHP_EOL;
					$response['message'].= "The URL $fulldomain already exist";
					$response['success'] = false;
					header('Content-Type: application/json');
					echo json_encode($response);
			   		die();		
				}
			}
		//TODO: Check this functionality for sub folder installs	
		} else {
			if($exist_id = $wpdb->get_var("SELECT blog_id FROM $wpdb->blogs WHERE path = '$path/'")) {
				$response['message'] = 'Unable to clone site.'.PHP_EOL;
				$response['message'].= "The URL $fulldomain already exist";
				$response['success'] = false;
				header('Content-Type: application/json');
				echo json_encode($response);
		   		die();		
			} else {
				// Start with adding the new blog to the blogs table
				$new_blog_id = insert_blog( $domain, $path, '1');
				if(is_integer($new_blog_id)) {
					$message.= "New site created with id: $new_blog_id" . PHP_EOL;
				} else {
					$response['message'] = 'Unable to clone site.'.PHP_EOL;
					$response['message'].= "The URL $fulldomain already exist";
					$response['success'] = false;
					header('Content-Type: application/json');
					echo json_encode($response);
			   		die();
				}
			}
		}

		//Next duplicate all tables from the template
		
		$template_like = $wpdb->prefix . $template_id . "_"; 
		$template_new = $wpdb->prefix . $new_blog_id . "_";
		$temp_like = str_replace('_', '\_', $template_like); //escape the _ for correct sql!!
		$template_tables = $wpdb->get_results( "SHOW TABLES LIKE '$temp_like%'", ARRAY_N );
		
		foreach ($template_tables as $old_table) {
			$new_table = str_replace($template_like, $template_new, $old_table[0]); 
			// check if table already exists
			if($wpdb->get_var("SHOW TABLES LIKE '$new_table'") != $new_table) {
				// duplicate the old table structure
				$result = $wpdb->query( "CREATE TABLE $new_table LIKE $old_table[0]" );
				if($result === FALSE) { 
					$response['message'] = 'Unable to clone site.'.PHP_EOL;
					$response['message'].= "Failed to create $new_table.";
					$response['success'] = false;
					header('Content-Type: application/json');
					echo json_encode($response);
			   		die();
				} else { 
					$message.= "Table created: $new_table." . PHP_EOL;
					// copy data from old_table to new_table
					$result = $wpdb->query( "INSERT INTO $new_table SELECT * FROM $old_table[0]" );
					if($result === FALSE) {
						$response['message'] = 'Unable to clone site.'.PHP_EOL;
						$response['message'].= "Failed to copy data from $old_table[0] to $new_table.";
						$response['success'] = false;
						header('Content-Type: application/json');
						echo json_encode($response);
				   		die();
					} else {
						$message.= "Copied data from $old_table[0] to $new_table." . PHP_EOL;
					}						
				}
			} else {
				$response['message'] = 'Unable to clone site.'.PHP_EOL;
				$response['message'].= "The table $new_table already existed.";
				$response['success'] = false;
				header('Content-Type: application/json');
				echo json_encode($response);
		   		die();
			}
		}
		
		// Then add user to the new blog
		$role = "administrator";
		if ( add_user_to_blog( $new_blog_id, $user_id, $role ) ) {
			$message.= 'Added user '.$user_id.' as '.$role.' to site '.$new_blog_id.'.' . PHP_EOL;
		} else {
			$response['message'] = 'Unable to clone site.'.PHP_EOL;
			$response['message'].= 'Failed to add user '.$user_id.' as '.$role.' to site '.$new_blog_id.'.';
			$response['success'] = false;
			header('Content-Type: application/json');
			echo json_encode($response);
	   		die();
		}

		// Add custom data to newly duplicated blog
		$full_url = "http://" . $fulldomain;
		if(!$blogname) { $blogname = $siteurl; }
		$fileupload_url = $full_url . "/files";
		
		// update the cloned table with the new data and blog_id
		update_blog_option ($new_blog_id, 'siteurl', $full_url);
		update_blog_option ($new_blog_id, 'blogname', $blogname);
		update_blog_option ($new_blog_id, 'blogdescription', $blogdescription);
		update_blog_option ($new_blog_id, 'admin_email', $admin_email);
		update_blog_option ($new_blog_id, 'home', $full_url);
		update_blog_option ($new_blog_id, 'fileupload_url', $fileupload_url);
		update_blog_option ($new_blog_id, 'upload_path', 'wp-content/blogs.dir/' . $new_blog_id . '/files');
		$new_options_table = $wpdb->prefix . $new_blog_id . '_options';
		$old_name = $wpdb->prefix . $template_id . '_user_roles';
		$new_name = $wpdb->prefix . $new_blog_id . '_user_roles';
		$result = $wpdb->update( $new_options_table, array('option_name' => $new_name), array('option_name' => $old_name));
		
		// 'check' if it went ok - NOTE: is just a basic check could give an error anyway...
		if(get_blog_option($new_blog_id, 'blogdescription') != $blogdescription) { 
			//$error = TRUE; 
			//_e("<span class=\"error\">Maybe we had an error updating the options table with the new data.</span>", 'acswpmu_trdom' );
			$response['message'] = 'Unable to clone site.'.PHP_EOL;
			$response['message'].= 'An error occured while updating the options table with the new data.';
			$response['success'] = false;
			header('Content-Type: application/json');
			echo json_encode($response);
	   		die();
		} else { 
			//_e("Updated the options table with cloned data<br>", 'acswpmu_trdom' );
			$message.= "Updated the options table with cloned data." . PHP_EOL;
		}

		// add template_id to option table for later reference
		$savearray = array ('template-id' => $template_id, 'lasttime' => time());
		add_blog_option ($new_blog_id, 'add-cloned-sites', serialize($savearray));

		// Domainmap the newly cloned site
		if($domainmap AND $domain_name){
			//check if Wordpress MU Domain mapping plugin installed and active
			if(array_key_exists('wordpress-mu-domain-mapping/domain_mapping.php', $this->plugins)){
				$domain = strtolower($domain_name);
				if ( $new_blog_id != 0 AND 
						$new_blog_id != 1 AND 
						null == $wpdb->get_var( $wpdb->prepare( "SELECT domain FROM {$wpdb->dmtable} WHERE blog_id != %d AND domain = %s", $new_blog_id, $domain ) ) 
					) {
					$result = $wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->dmtable} ( `blog_id`, `domain`, `active` ) VALUES ( %d, %s, %d )", $new_blog_id, $domain,1) );
					//echo "<p><strong>" . __( 'Domain Add', 'wordpress-mu-domain-mapping' ) . "</strong></p>";
					if($result) { 
						$message.= "New site mapped to domain: $domain." . PHP_EOL;
					} else { 
						$message.= "Domain mapping for $siteurl failed." . PHP_EOL;
					}	
				}
			}else{
				$message.= "Domain not mapped because the required plugin is missing" . PHP_EOL;
			}
		}

		//TODO: Copy images and uploads

		//reset permalink structure
		switch_to_blog($new_blog_id);
		//_e("Switched from here to $new_blog_id to reset permalinks<br>", 'acswpmu_trdom' );
		global $wp_rewrite;
		$wp_rewrite->init();
		$wp_rewrite->flush_rules();
		//now that we are here, update the date of the new site
		wpmu_update_blogs_date( );
		//go back to admin
		restore_current_blog();
		$message.= "Permalinks updated." . PHP_EOL;

		//Done cloning! show reports
		$time_end = microtime(true);
		$time = $time_end - $time_start;
		$time = round($time, 4);

		$message.= "Done cloning site." . PHP_EOL;
		$message.= "Time elapsed: $time. seconds" . PHP_EOL;

		
		$response['message'] = $message;

		header('Content-Type: application/json');
		echo json_encode($response);
   		die();
	}

	/**
	* Get the plugins available including code plugins needed by the site
	*/
	public function getPlugins($options = null){
		$plugins_per_page = (int)10; //default
		$page = 1; //default
		$search = null;
		$this->paginate['plugins'] = array(); //refresh the pagination
		$this->plugins = get_plugins();
		$activePlugins = array_keys(get_site_option("active_sitewide_plugins"));
		
		/*foreach($availablePlugins as $key=>$plugin){
			if(array_search($key,$activePlugins)!== false){
				$this->plugins[$key]=$plugin;
			}
		}*/
		// before adding to list of allowed plugins for new sites, remove exluded and network activated plugins
        foreach($this->plugins as $key=>$plugin){
        	if(array_key_exists($key, $this->plugin_config)){
        		if(array_search('exclude',$this->plugin_config[$key])===FALSE){
        			if(array_search($key,$activePlugins)===FALSE){
        				$this->allowedPlugins[$key]=$plugin;	
        			}
        			
        		}
        	}else{
        		if(array_search($key,$activePlugins)===FALSE){
        			$this->allowedPlugins[$key]=$plugin;	
        		}
        	}
        }

        //filters and pagination
        //check if default is selected
		if(isset($this->network_settings['plugindisplay'])){
			if($this->network_settings['plugindisplay']=='default'){
				//check if per page has been set
				if(isset($this->network_settings['pluginsperpage'])){
					$plugins_per_page = $this->network_settings['pluginsperpage'];
				}
			}	
		}

		if(is_array($options)){
			if(isset($options['page'])){
				$page = $options['page'];
			}
			if(isset($options['search'])){
				$search = $options['search'];
			}
		}

		//do search (search and pagination are patterned based on worpdress way for plugins)
		if(!is_null($search) && $search!==''){
			$this->search = $search;
			$this->allowedPlugins = array_filter($this->allowedPlugins, array( $this, '_search_callback_plugins' ));
		}

		$totalplugins = count($this->allowedPlugins);
		
		$pages = ceil($totalplugins/$plugins_per_page);

		//filters
		if($page < 1){
			$page = 1;
		}else if($page > $pages){
			$page = $pages;
		}

		$start = ( $page - 1 ) * $plugins_per_page;

		if ($totalplugins > $plugins_per_page ){
			$this->allowedPlugins = array_slice( $this->allowedPlugins, $start, $plugins_per_page, true);
			$this->paginate['plugins'] = array(
				'total'=>$totalplugins, 
				'per_page'=>$plugins_per_page, 
				'pages'=>$pages,
				'current_page'=>$page);
		}
	}

	/**
	* the funky part
	*	Do actions here for the site after it has been created
	*/
	public function advanced_site_configs($blog_id){
	 	// Make sure the user can perform this action and the request came from the correct page.
	 	if(current_user_can('manage_options')){
	 		//automatically set domain mapping
	 		$this->setDomainMap($blog_id);
	 		
	 		//set the theme
	 		$this->setTheme($blog_id);
	 		
	 		//set the plugins
	 		$this->setPlugins($blog_id);

	 		//set the custom settings
	 		$this->setCustomSettings($blog_id);

	 		//remove default post/page
	 		$this->removeCustomPostPage($blog_id);

	 		//redirect
	 		$this->redirectToASC($blog_id);		
	 	}
	 }

	 public function setPluginSettings(){

	 	$removedefaultadd = ( ! empty( $this->network_settings['removedefaultadd'] ) ) 
                ? $this->network_settings['removedefaultadd'] : '';
        
	 	//build the settings form
	 	include_once('include/asc_settings_form.php');
	 	
	 }

	 public function saveNetworkSettings(){
	 	//if network settings are being saved, process it
	    if ( isset( $_POST['network_settings'] ) ) {
	        
	        //check nonce for security
	        check_admin_referer( 'save-network-settings', 'asc-settings-network-plugin' );
	        
	        //store option values in a variable
	        $this->network_settings = $_POST['network_settings'];
	        
	        //use array map function to sanitize option values
	        $this->network_settings = array_map( 'sanitize_text_field', $this->network_settings );
	        

	        //apply settings for default menu
	        if(isset($this->network_settings['removedefaultadd'])){
		 		if($this->network_settings['removedefaultadd']=='on'){
		 			add_filter('admin_head-site-new.php',array($this,'redirectToASC'));
		 			remove_submenu_page('sites.php','site-new.php');
		 		}
	 		}else{
	 			global $submenu;
	 			$hasDefault = false;
	 			if(isset($submenu['sites.php'])){
	 				foreach ($submenu['sites.php'] as $menu) {
	 					foreach ($menu as $val) {
	 						if($val=='site-new.php'){
	 							$hasDefault = true;
	 						}
	 					}
	 				}
	 				if(!$hasDefault){
	 					$page_hook_suffix = add_submenu_page( 'sites.php', 'Add New','Add New', 'manage_options', 'site-new.php', '');
	 				}
	 			}
	 		}
	        //save option values
	        update_site_option( 'asc_network_settings', $this->network_settings );

	        
	    }
	 }

	 /**
	 * Automatically sets a domain mapping to the new created site
	 * function has been borrowed from Wordpress mu domain mapping plugin and must be installed first
	 * 
	 */
	 private function setDomainMap($blog_id){
	 	global $wpdb, $current_site;
	 	//check if Wordpress MU Domain mapping plugin installed and active
		if(array_key_exists('wordpress-mu-domain-mapping/domain_mapping.php', $this->plugins)){
			//check for domain name
			if(empty($_POST['blog']['domain_name'])){
				return;
			}
			if (!$this->is_valid_domain_name($_POST['blog']['domain_name'])){
			 	wp_die( __('Missing or invalid domain name. Site was added but domain was not mapped.'));
			}
			$domain = strtolower($_POST['blog']['domain_name']);
			if ( $blog_id != 0 AND 
					$blog_id != 1 AND 
					null == $wpdb->get_var( $wpdb->prepare( "SELECT domain FROM {$wpdb->dmtable} WHERE blog_id != %d AND domain = %s", $blog_id, $domain ) ) 
				) {
				$wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->dmtable} ( `blog_id`, `domain`, `active` ) VALUES ( %d, %s, %d )", $blog_id, $domain,1) );
				echo "<p><strong>" . __( 'Domain Add', 'wordpress-mu-domain-mapping' ) . "</strong></p>";
					
			}
		}
	 }

	 private function setTheme($blog_id){
	 	if (!empty($_POST['theme-id'])) {
	 		switch_to_blog($blog_id);
	 		switch_theme($_POST['theme-id'],$_POST['theme-id']); 
    		restore_current_blog();
	 	}
	 }

	 private function setPlugins($blog_id){
	 	if (!empty($_POST['blog']['checked-plugins'])) {
	 		switch_to_blog($blog_id);
	 		$selected_plugins = $_POST['blog']['checked-plugins'];
	 		foreach($selected_plugins as $sp){
	 			if(array_key_exists($sp, $this->allowedPlugins)){
	 				activate_plugin($sp);
	 			}
	 		}
	 		restore_current_blog();
	 	}
	 }

	 /**
	  * Sets the sites custom settings
	  */
	 private function setCustomSettings($blog_id){
	 	if (!empty($_POST['blog']['disable_comments']) && $_POST['blog']['disable_comments']=='on') {
	 		switch_to_blog($blog_id);
	 		update_option('default_ping_status', 'closed');
	 		update_option('default_comment_status', 'closed');
	 		restore_current_blog();
	 	}
	 }

	 /**
	  * Removes the sites default post/page	
	  */
	 private function removeCustomPostPage($blog_id){
	 	if (!empty($_POST['blog']['remove_default_postpage']) && $_POST['blog']['remove_default_postpage']=='on') {
	 		switch_to_blog($blog_id);
	 		wp_delete_post(1,TRUE);//Hello World - remove from trash
	 		wp_delete_post(2,TRUE);//Sample page - remove from trash
	 		restore_current_blog();
	 	}
	 }

	 /* Some libraries */
	 public function is_valid_domain_name($domain_name){
    	return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
            && preg_match("/^.{1,253}$/", $domain_name) //overall length check
            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)   ); //length of each label
	}

	public function acswpmu_trim_value(&$value) { $value = trim(trim($value), ' ,');}

	
	/**
	* advanced_site_creation_uninstall_plugin
	* 
	* completely removes the plugin installation
	*
	* @access public 
	* @return void
	*/
  	public function advanced_site_creation_uninstall_plugin(){
  		delete_site_option('asc_network_settings');
  	}

	/** 
	* Function to filter Themes. 
	* Reference: class-wp-ms-themes-list-table.php
	*/
	private function _search_callback_theme($theme) {
		static $term;
		if ( is_null( $term ) )
			$term = wp_unslash( $this->search );
		//change the field filters
		// default: 'Name', 'Description', 'Author', 'Author', 'AuthorURI' 
		foreach ( array( 'Name') as $field ) {
			// Don't mark up; Do translate.
			if ( false !== stripos( $theme->display( $field, false, true ), $term ) )
				return true;
		}

		if ( false !== stripos( $theme->get_stylesheet(), $term ) )
			return true;

		if ( false !== stripos( $theme->get_template(), $term ) )
			return true;

		return false;
	}

	private function _search_callback_plugins( $plugin ) {
		static $term;
		if ( is_null( $term ) )
			$term = wp_unslash($this->search);

		foreach ( $plugin as $value )
			if ( stripos( $value, $term ) !== false )
				return true;

		return false;
	}
}

$site_manager = new Advance_Site_Creation_Manager;
