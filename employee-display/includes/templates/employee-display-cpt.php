<?php

// Create employee display Custom Post Type
function ed_register_employee_display() {
    $singular_name = apply_filters('ed_label_single', 'employee display');
    $plural_name = apply_filters('ed_label_plural', 'employee displays');

    $labels = array(
        'name'                  => $plural_name,
        'singular_name'         => $singular_name,
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New '.$singular_name,
        'edit'                  => 'Edit',
        'edit_item'             => 'Edit '.$singular_name,
        'new_item'              => 'New '.$singular_name,
        'view'                  => 'View',
        'view_item'             => 'View '.$singular_name,
        'search_items'          => 'Search '.$plural_name,
        'not_found'             => 'No '.$plural_name.' Found',
        'not_found_in_trash'    => 'No '.$plural_name.' Found',
        'parent_item_colon'     => 'Parent '.$singular_name,
        'menu_name'             => $plural_name,
    );
    
    // Create arguments
    $args = apply_filters('ed_employee_display_args', array(
        'labels'                => $labels,
        'hierarchical'          => true,
        'description'           => 'employee displays by job-title',
        'taxonomies'            => array( 'job-titles' ),
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-video-alt2',
        'show_in_nav_menus'     => true,
        'publicly_queryable'    => true,
        'exclude_from_search'   => false,
        'has_archive'           => true,
        'query_var'             => true,
        'can_export'            => true,
        'rewrite'               => array('slug' => 'employee_display', 'with_front' => FALSE),
        'capability_type'       => 'post',
        'supports'              => array(
            'title',
            'thumbnail'
        )
    ));

    // Register The employee display Post Type
    register_post_type( 'employee_display', $args );
    flush_rewrite_rules();
}

add_action( 'init', 'ed_register_employee_display' );

// Create job-titles Taxonomy
function ed_job-titles_taxonomy(){
    register_taxonomy(
        'job-titles',
        'employee_display',
        array(
            'label' => 'job-titles',
            'hierarchical'          => true,
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'job-title',
                'with_front' => false
            )
        )
    );
}

add_action('init', 'ed_job-titles_taxonomy');

// Load Template
function ed_load_templates($template){
    if(get_query_var('post_type') == 'employee_display'){
        $new_template = plugin_dir_path(__FILE__). 'templates/single-employee-display.php';
        if('' != $new_template){
            return $new_template;
        }
    }

    return $template;
}

add_filter('template_include', 'ed_load_templates');
