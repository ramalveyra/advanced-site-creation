<?php
/**
 * Plugin Name: Advanced Site Creation Plugin
 * Plugin URI: https://github.com/Link7/wp-plugins/tree/develop/advanced-site-creation
 * Description: A plugin to customise Wordpress MU site creation
 * Version: 1.1
 * Author: Link7
 * Author URI: http://github.com/Link7
 * License: GPL3
 * License URI: https://www.gnu.org/copyleft/gpl.html
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

class Advance_Site_Creation_Manager
{
	public $themes;
	public $plugins;
	public $allowedPlugins = array();
	public $network_settings = array();
	public $paginate = array();
	public $search;

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

	 	// creating Ajax call for Themes and Plugins
   		add_action( 'wp_ajax_nopriv_get_themes_ajax', array($this,'get_themes_ajax'));  
   		add_action( 'wp_ajax_get_themes_ajax', array($this,'get_themes_ajax'));
   		add_action( 'wp_ajax_nopriv_get_plugins_ajax', array($this,'get_plugins_ajax'));  
   		add_action( 'wp_ajax_get_plugins_ajax', array($this,'get_plugins_ajax'));

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

	 /* Some libraries */
	 public function is_valid_domain_name($domain_name){
    	return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
            && preg_match("/^.{1,253}$/", $domain_name) //overall length check
            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)   ); //length of each label
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