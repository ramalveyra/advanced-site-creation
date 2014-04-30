<?php
if ( ! defined( 'ABSPATH' ) ) exit('No direct script access allowed'); // Exit if accessed directly

define('BSS_TABLE_NAME', 'asc_build_site_tbl');
/**
 * Class to handle the Build Site feature
 */

class Advanced_Site_Creation_Site_Builder
{
	public $plugin_settings_map;

	public $notice_iserror = FALSE;

	public $_default_settings = array(
		//reading
		'show_on_front' => array(
			'values' => 'page',
			'is_included' => TRUE, 
			'is_rand' => FALSE
		),
		'posts_per_page' => array(
			'min' => 10,
			'max' => 10,
			'is_included' => TRUE, 
			'is_rand' => TRUE
		),
		'posts_per_rss' => array(
			'min' => 10,
			'max' => 10,
			'is_included' => TRUE, 
			'is_rand' => TRUE
		),
		'rss_use_excerpt' => array(
			'values' => array(
				array('value'=>0, 'text'=>'Full text'),
				array('value'=>1, 'text'=>'Summary')
			),
			'is_included' => TRUE, 
			'is_rand' => TRUE
		),
		'blog_public' => array(
			'values' => array(
				array('value'=>0,'text'=>'No'),
				array('value'=>1,'text'=>'Yes'),
			),
			'is_rand' => FALSE,
			'is_included' => TRUE
		),
		//discussion
		'default_pingback_flag' => array(
			'values' => array(
				array('value'=>0,'text'=>'No'),
				array('value'=>1,'text'=>'Yes'),
			),
			'is_rand' => TRUE,
			'is_included' => TRUE, 
		),
		'default_ping_status' => array(
			'values' => array(
				array('value'=>0,'text'=>'No'),
				array('value'=>1,'text'=>'Yes'),
			),
			'is_included' => TRUE, 
			'is_rand' => TRUE
		),
		'default_comment_status' => array(
			'values' => array(
				array('value'=>0,'text'=>'No'),
				array('value'=>1,'text'=>'Yes'),
			),
			'is_included' => TRUE, 
			'is_rand' => TRUE
		),
		'comments_notify' => array(
			'values' => array(
				array('value'=>0,'text'=>'No'),
				array('value'=>1,'text'=>'Yes'),
			),
			'is_included' => TRUE, 
			'is_rand' => TRUE
		),
		'moderation_notify' => array(
			'values' => array(
				array('value'=>0,'text'=>'No'),
				array('value'=>1,'text'=>'Yes'),
			),
			'is_included' => TRUE, 
			'is_rand' => TRUE
		),
		//permalinks
		'permalink_structure' => array(
			'values'=>array(
				array('value' => '','text' => "Default"),
				array('value' =>'/%year%/%monthnum%/%day%/%postname%/', 'text' => 'Day and name'),
				array('value'=> '/archives/%post_id%', 'text' => 'Month and name'),
				array('value' =>'/%postname%/','text' => 'Post name')
			),
			'is_included' => TRUE, 
			'is_rand' => TRUE
		),
		'permalink_structure_custom' => array(
			'values'=>'',
			'multiple' => true,
			'is_included' => TRUE, 
			'is_rand' => TRUE
		),
		'custom_selection' => array(
			'values' => '',
			'is_included' => TRUE, 
			'is_rand' => TRUE
		),
		'category_base' => array(
			'values' => '',
			'multiple' => true,
			'is_included' => TRUE, 
			'is_rand' => TRUE	
		),
		'tag_base' => array(
			'values' => '',
			'multiple' => true,
			'is_included' => TRUE, 
			'is_rand' => TRUE
		),
		'themes'=>array(
			'values'=>array(),
			'multiple' => true,
			'is_rand'=>TRUE,
			'is_included' => TRUE
		),
		'plugins'=>array(
			'values'=>array(),
			'multiple' => true,
			'is_rand'=>TRUE,
			'is_included' => TRUE
		)
	);

	public $_user_settings;

	public function __construct(){
		//check if there are saved values, if there's none load the default
		$asc_settings = get_site_option('asc_network_settings');
		if(isset($asc_settings['build_site_settings'])){
			//var_dump($asc_settings['build_site_settings']);
			//set the settings to this
			$this->_user_settings = $asc_settings['build_site_settings'];
		}

		//handle themes

		//handle plugins
		if(class_exists('L7_Plugin_Settings')){
			$this->plugin_settings_map = new L7_Plugin_Settings;
			//var_dump($this->plugin_settings_map->plugin_json_files);
			//var_dump($this->plugin_settings_map->get_plugin_info('virtual-pages-with-templates'));
		}
	}

	public function setThemeOption(){

	}

	public function getSettings($key, $option_id){
		if(isset($this->_default_settings[$option_id])){
			if(isset($this->_default_settings[$option_id][$key])){
				return $this->getUserSettings($key, $option_id, $this->_default_settings[$option_id][$key]);
			}else{
				//return $this->_user_settings[$option_id][$key];
				return null;
			}
		}else{
			return null;
		}
	}

	public function getUserSettings($key, $option_id, $default){
		$default_orig_val = $default;
		if(isset($this->_user_settings[$option_id])){
			if(isset($this->_user_settings[$option_id][$key])){
				if(is_array($this->_user_settings[$option_id][$key])){
					$items_excluded = 0;
					foreach($default as $k => $val){
						//var_dump($val['value'], array_search($val['value'], $this->_user_settings[$option_id][$key]));
						if(array_search($val['value'], $this->_user_settings[$option_id][$key])===false){
							$items_excluded+=1;
							$default[$k]['excluded'] = 'true';
						}
					}
					//must not exclude all, if theres non left revert the orig
					if($items_excluded == count($default)){
						$default = $default_orig_val;
					}
					return $default;
				}else{
					return $this->_user_settings[$option_id][$key];
				}
			}else{
				return $default;
			}
		}else{
			return $default;
		}
	}

	public function saveUserSettings($data){
		$this->_user_settings = $this->_default_settings;
		foreach($this->_default_settings as $default_setting_key=>$default_setting_val){
			if(isset($data[$default_setting_key])){
				if(isset($default_setting_val['values'])){
					//check if array (for select options)
					if(is_array($default_setting_val['values'])){
						$this->_user_settings[$default_setting_key]['values'] =  $data[$default_setting_key];
					}else{
						$this->_user_settings[$default_setting_key]['values'] = $data[$default_setting_key];
					}
				}
				//is_included
				$this->_user_settings[$default_setting_key]['is_included'] = $this->checkIfEnabled($data, $default_setting_key, '_is_included');
				//is_rand
				$this->_user_settings[$default_setting_key]['is_rand'] = $this->checkIfEnabled($data, $default_setting_key, '_is_rand');
				
			}else{
				//min/max
				if(isset($data[$default_setting_key.'_min'])){
					$this->_user_settings[$default_setting_key]['min'] = $data[$default_setting_key.'_min'];
				}
				if(isset($data[$default_setting_key.'_max'])){
					$this->_user_settings[$default_setting_key]['max'] = $data[$default_setting_key.'_max'];
				}
				//is_included
				$this->_user_settings[$default_setting_key]['is_included'] = $this->checkIfEnabled($data, $default_setting_key, '_is_included');
				//is_rand
				$this->_user_settings[$default_setting_key]['is_rand'] = $this->checkIfEnabled($data, $default_setting_key, '_is_rand');
			}
		}
		
		//save the user settings
		//get the current settings
		$asc_settings = get_site_option('asc_network_settings');
		//set the new settings
		$asc_settings['build_site_settings'] = $this->_user_settings;
		//update the options table
		update_site_option( 'asc_network_settings', $asc_settings);
		$this->notice = 'Site Option Settings Updated.';
		add_action( 'network_admin_notices', array($this,'build_site_settings_page_admin_notice' ));
	}

	public function build_site_settings_page_admin_notice(){
		if($this->notice_iserror) {
			echo '<div id="message" class="error">';
		}
		else {
			echo '<div id="message" class="updated fade">';
		}

		echo '<p><strong>' . $this->notice . '</strong></p></div>';
	}

	public function checkIfEnabled($data, $key, $suffix){
		if(isset($data[$key.$suffix])){
			if($data[$key.$suffix]==1){
				return TRUE;
			}
			return FALSE;
		}
		return FALSE;
	}

	public function setThemeOptions($themes){
		if(!empty($themes)){
			foreach($themes as $theme){
				$this->_default_settings['themes']['values'][]=array(
					'value' => $theme->get_stylesheet(),
					'text'  => $theme->display('Name')
				);
			}
		}
	}
	public function setPluginOptions($plugins){
		if(!empty($plugins)){
			foreach($plugins as $key=>$plugin){
				$plugin_id = substr($key,0,strpos($key, '/'))==''?$key:substr($key,0,strpos($key, '/'));
				$this->_default_settings['plugins']['values'][]=array(
					'value' => $key,
					'text'  => $plugin['Name']
				);
			}
		}
	}
}