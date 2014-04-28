<?php
if ( ! defined( 'ABSPATH' ) ) exit('No direct script access allowed'); // Exit if accessed directly

define('BSS_TABLE_NAME', 'asc_build_site_tbl');
/**
 * Class to handle the Build Site feature
 */

class Advanced_Site_Creation_Site_Builder
{
	public $_settings = array(
		'general' => array(
		 ),
		'discussions' => array(
		),
		'themes' => array(
		)
	);
	public $_default_values;

	public function __construct(){
		//create the settings DB

		//check if there are saved values, if there's none load the default
	}

	public function setDefault(){

	}
}