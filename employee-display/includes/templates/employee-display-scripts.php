<?php
/*Add scripts.  To prevent plugin conflicts, prefix 'ed' added to functions and variables
ed stands for employee display
ENQUEUE STYLE
In the function called ed_add_scripts, call the function wp_enqueue_style so that a CSS file can be included.
plugins_url will take us to the plugins directory, use . to concatinate
ENQUEUE SCRIPT
Next, call function wp_enqueue_style
*/
//  Check if admin and add admin Scripts
if (is_admin()) {
	//Add Admin Scripts
	function ed_add_admin_scripts(){
		wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css'); //css for reorder function.
		wp_enqueue_style('ed-style',plugins_url() . '/employee-display/css/style-admin.css');
		wp_enqueue_script('ed-script',plugins_url().'/employee-display/js/main.js');
	}
}
 /*To place scripts in WordPress flow, add a Hook.  admin-init says when the
 admin side initializes, call the function 'ed_add_scripts'*/
 add_action('admin-init','ed_add_admin_scripts');
 //Add scripts
 //add jquery as a dependency array('jquery')
function ed_add_scripts(){
	wp_enqueue_style('ed-style',plugins_url().'employee-display/css/style.css');
	wp_enqueue_script('ed-script',plugins_url().'employee-display/js/main.js', array('jquery','jquery-ui-sortable');//jQueryUI sortable() method to reorder elements
}

add_action('wp_enqueue_scripts',ed_add_scripts);
 ?>
