<?php
/*
Plugin Name: Employee Listings
Description: Lists employee's picture and info (name and job title)
Version: 1.0.0
Author: Jodi Neal
Author URI: https://www.growmarkentum.com/
License: GPLv2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wpplugin
Domain Path:  /languages
*/
// Exit If Accessed Directly (so that no one can directly access these files)
if(!defined('ABSPATH')){
    exit;
}

require_once(plugin_dir_path(__FILE__) . '/includes/employee-listings-scripts.php');
require_once(plugin_dir_path(__FILE__) . '/includes/employee-listings-cpt.php');
require_once(plugin_dir_path(__FILE__) . '/includes/employee-listings-settings.php');
require_once(plugin_dir_path(__FILE__) . '/includes/employee-listings-fields.php');
require_once(plugin_dir_path(__FILE__) . '/includes/employee-listings-reorder.php');


require_once(plugin_dir_path(__FILE__) . '/includes/employee-listings-shortcodes.php');
