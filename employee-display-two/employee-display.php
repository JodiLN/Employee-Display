<?php
/*
Plugin Name: Employee Display
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

// Load Scripts, CPT, Settings, Fields, Reorder, and Shortcodes
require_once(plugin_dir_path(__FILE__) . '/includes/employee-display-scripts.php');
//require_once(plugin_dir_path(__FILE__) . '/includes/employee-display-cpt.php');
//require_once(plugin_dir_path(__FILE__) . '/includes/employee-display-settings.php');
//require_once(plugin_dir_path(__FILE__) . '/includes/employee-display-fields.php');
//require_once(plugin_dir_path(__FILE__) . '/includes/employee-display-reorder.php');


//require_once(plugin_dir_path(__FILE__) . '/includes/employee-diplay-shortcodes.php');
