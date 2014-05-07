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
		/*'show_on_front' => array(
			'values' => 'page',
			'is_included' => TRUE, 
			'is_rand' => FALSE
		),*/
		'posts_per_page' => array(
			'min' => 1,
			'max' => 10,
			'is_included' => TRUE, 
			'is_rand' => TRUE,
			
		),
		'posts_per_rss' => array(
			'min' => 1,
			'max' => 10,
			'is_included' => TRUE, 
			'is_rand' => TRUE,
			
		),
		'rss_use_excerpt' => array(
			'values' => array(
				array('value'=>0, 'text'=>'Full text'),
				array('value'=>1, 'text'=>'Summary')
			),
			'is_included' => TRUE, 
			'is_rand' => TRUE,
			
		),
		'blog_public' => array(
			'values' => array(
				array('value'=>0,'text'=>'No'),
				array('value'=>1,'text'=>'Yes'),
			),
			'is_rand' => FALSE,
			'is_included' => TRUE,
			
		),
		//discussion
		'default_pingback_flag' => array(
			'values' => array(
				array('value'=>1,'text'=>'Yes'),
				array('value'=>0,'text'=>'No')
			),
			'is_rand' => TRUE,
			'is_included' => TRUE,
			//'group' => 'article_settings' 
		),
		'default_ping_status' => array(
			'values' => array(
				array('value'=>'','text'=>'No'),
				array('value'=>'open','text'=>'Yes'),
			),
			'is_included' => TRUE, 
			'is_rand' => TRUE,
			//'group' => 'article_settings'
		),
		'default_comment_status' => array(
			'values' => array(
				array('value'=>'','text'=>'No'),
				array('value'=>'open','text'=>'Yes'),
			),
			'is_included' => TRUE, 
			'is_rand' => TRUE,
			//'group' => 'article_settings'
		),
		'comments_notify' => array(
			'values' => array(
				array('value'=>1,'text'=>'Yes'),
				array('value'=>0,'text'=>'No'),
			),
			'is_included' => TRUE, 
			'is_rand' => TRUE,
			//'group' => 'email'
		),
		'moderation_notify' => array(
			'values' => array(
				array('value'=>1,'text'=>'Yes'),
				array('value'=>0,'text'=>'No'),
			),
			'is_included' => TRUE, 
			'is_rand' => TRUE,
			//'group' => 'email'
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

	public $site_settings;

	public $is_build_setting_configured = FALSE;

	public function __construct(){
		//check if there are saved values, if there's none load the default
		$asc_settings = get_site_option('asc_build_site_settings');

		if(isset($asc_settings['build_site_settings'])){
			//set the settings to this
			$this->_user_settings = $asc_settings['build_site_settings'];
			$this->is_build_setting_configured = TRUE;
		}

		//handle plugins
		if(class_exists('L7_Plugin_Settings')){
			$this->plugin_settings_map = new L7_Plugin_Settings;
		}
	}

	public function setThemeOption(){

	}

	public function getSettings($key, $option_id){
		if(isset($this->_default_settings[$option_id])){
			if(isset($this->_default_settings[$option_id][$key])){
				return $this->getUserSettings($key, $option_id, $this->_default_settings[$option_id][$key]);
			}else{
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
		$asc_settings = get_site_option('asc_build_site_settings');
		//set the new settings
		$asc_settings['build_site_settings'] = $this->_user_settings;
		//update the options table
		update_site_option( 'asc_build_site_settings', $asc_settings);
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

	/**
	 * setups the site settings
	 */
	public function setSiteSettings($rand = false){
		//if there are no user config saved, use the default
		if($this->_user_settings === NULL){
			$this->_user_settings = $this->_default_settings;
		}

		foreach($this->_user_settings as $key=> $setting){
			//check if included
			if($setting['is_included']){
				if(isset($setting['values'])){
					if(is_array($setting['values'])){
						if($rand && $setting['is_rand']){
							//$this->site_settings[$key] = array_rand($setting['values']);
							$rand_keys = array_rand($setting['values'],1);
							$this->site_settings[$key] = $setting['values'][$rand_keys];
						}else{
							$this->site_settings[$key] = array_shift($setting['values']);
						}
						//convert if no user setting has been set
						$this->site_settings[$key] = (is_array($this->site_settings[$key]))?$this->site_settings[$key]['value'] : $this->site_settings[$key];
					}else{
						//a text group
						if($setting['values']!==''){
							$text_options = preg_split('/[\r\n]+/', $setting['values'], -1, PREG_SPLIT_NO_EMPTY);
							$rand_keys = array_rand($text_options,1);
							$this->site_settings[$key] = $text_options[$rand_keys];	
						}else{
							$this->site_settings[$key] = '';
						}
					}
				}else{
					//falls into min/max
					if($rand && $setting['is_rand']){
						$min = ($setting['min'] > $setting['max']) ? $setting['max'] :  $setting['min'];
						$max = ($setting['min'] > $setting['max']) ? $setting['min'] :  $setting['max'];
						$this->site_settings[$key] = rand($min, $max); 
					}else{
						$this->site_settings[$key] = 10;
					}
				}
			}
		}
		//for permalinks, select between pre-defined structure or custom structure
		$this->site_settings['permalink_structure'] = (rand(0,1)==0)?$this->site_settings['permalink_structure'] : $this->site_settings['permalink_structure_custom'];
	}

	public function getSiteSetting($key){
		if(isset($this->site_settings[$key])){
			return $this->site_settings[$key];
		}
		return NULL;
	}

	/**
	 * Function for getting random value from assoc arrays;
	 */
	function array_random_assoc($arr, $num = 1) {
	    $keys = array_keys($arr);
	    shuffle($keys);
	    
	    $r = array();
	    for ($i = 0; $i < $num; $i++) {
	        $r[$keys[$i]] = $arr[$keys[$i]];
	    }
	    return $r;
	}

	/** 
	 * Permutation functions
	 * set of functions to handle permutations 
	 */

	function power_perms($arr) {
	    $power_set = $this->power_set($arr);
	    $result = array();
	    foreach($power_set as $set) {
	        $perms = $this->perms($set);
	        $result = array_merge($result,$perms);
	    }
	    return $result;
	}

	function power_set($in,$minLength = 1) {
	   $count = count($in);
	   $members = pow(2,$count);
	   $return = array();
	   for ($i = 0; $i < $members; $i++) {
	      $b = sprintf("%0".$count."b",$i);
	      $out = array();
	      for ($j = 0; $j < $count; $j++) {
	         if ($b{$j} == '1') $out[] = $in[$j];
	      }
	      if (count($out) >= $minLength) {
	         $return[] = $out;
	      }
	   }

	   //usort($return,"cmp");  //can sort here by length
	   return $return;
	}

	function factorial($int){
	   if($int < 2) {
	       return 1;
	   }

	   for($f = 2; $int-1 > 1; $f *= $int--);

	   return $f;
	}

	function perm($arr, $nth = null) {

	    if ($nth === null) {
	        return $this->perms($arr);
	    }

	    $result = array();
	    $length = count($arr);

	    while ($length--) {
	        $f = $this->factorial($length);
	        $p = floor($nth / $f);
	        $result[] = $arr[$p];
	        $this->array_delete_by_key($arr, $p);
	        $nth -= $p * $f;
	    }

	    $result = array_merge($result,$arr);
	    return $result;
	}

	function perms($arr) {
	    $p = array();
	    for ($i=0; $i < $this->factorial(count($arr)); $i++) {
	        $p[] = $this->perm($arr, $i);
	    }
	    return $p;
	}

	function array_delete_by_key(&$array, $delete_key, $use_old_keys = FALSE) {

	    unset($array[$delete_key]);

	    if(!$use_old_keys) {
	        $array = array_values($array);
	    }

	    return TRUE;
	}
}