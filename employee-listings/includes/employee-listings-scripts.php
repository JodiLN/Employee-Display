<?php

// Add Admin Scripts
function ed_add_admin_scripts(){
		wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css');
    	wp_enqueue_style('ed-style', plugins_url() . '/employee-listings/css/style-admin.css');
    	wp_enqueue_script('ed-script',plugins_url().'/employee-listings/js/main.js', array('jquery','jquery-ui-sortable'));
    	wp_localize_script('ed-script','ED_EMPLOYEE_LISTING', array(
    		'token' => wp_create_nonce('ed-token')
    	));
}

add_action('admin_init','ed_add_admin_scripts');


// Add Scripts
function ed_add_scripts(){
    wp_enqueue_style('ed-style', plugins_url() . '/employee-listings/css/style.css');
    wp_enqueue_script('ed-script',plugins_url().'/employee-listings/js/main.js', array('jquery'));
}

add_action('wp_enqueue_scripts','ed_add_scripts');
