<?php
// Shortcode to show emplyee display on front end
// List Employees
// atts = attributes, content will be null by default
function ed_list_employees($atts, $content = null){
  // Create the available attributes
  // shortcode_atts will be an array with a handful of default values
	$atts = shortcode_atts(array(
		'title' => 'Current Employees',
		'count' => 12, // Limit the count to 12
		'job-title' => 'all',
		'pagination' => 'off' // To show pagination on page, change to on, then next and previous links will show
	), $atts);
  // Set variable pagination equal to atts ['pagination'] is equal to:
  // if it's one then false, else true
	$pagination = $atts['pagination'] == 'on' ? false : true;
  // to limit results coming back and displaying, define paged variable
  // get_query_var, otherwise equal to 1
  $paged = get_query_var('paged') ? get_query_var('paged') : 1;

  // Check job-title attribute
  // if job-title is equal to all then set terms variable to nothing...
  // else, if it's not equal to all, then set the terms variable to an array that has an array

  if($atts['job-title'] == 'all'){
    $terms = '';
  } else {
    $terms = array(array(
      // The taxonomy we're checking is job-titles
      'taxonomy' => 'job-titles',
      // The field is slug
      'field'    => 'slug',
      // Whatever the job-title attribute is
      'terms'	   => $atts['job-title']
    ));
  }

  // Set Query Arguments
  $args = array(
    'post_type' => 'employee_display',
    'post_status'	=> 'publish',
    'orderby' => 'menu_order',
    // Set order to ascending
    'order'		=> 'ASC',
    'no_found_rows'	=> $pagination,
    'posts_per_page'=> $atts['count'],
    'paged'			=> $paged,
    // Taxonomy Query
    'tax_query'		=> $terms
  );

  // Get employees From DB, pass in args
  $employees = new WP_Query($args);

  // Check For employees
  // If there are employees, then get the job-title slug
  if($employees->have_posts()){
    // Get job-title Slug with string replace function
    // Replace space with a dash and then the job-title
    $job-title = str_replace('-', ' ', $atts['job-title']);
    // Build output variable
      $output = '<div class="employee-list">';
      // Loop through all of the posts
      while($employees->have_posts()){
        $employees->the_post();
        // Get field values
        $image = wp_get_attachment_image_src(get_post_thumbnail_id(),'single-post-thumbnail'); // Get the featured image
        // Continue with building output
        // Use dot equals to append to the output variable (i.e. we're not replacing output, but appending to it)
        $output .= '<div class="employee-col">';  // Each employee will have a class of employee
        $output .= '<img class="feat-image" src="'.$image[0].'"'; // Class of featured (shortened to feat)-image
        $output .= '<h5 class="employee-title">'.get_the_title().'</h5><br>';  // Use dots to concatinate
        $output .= '<a href="'.get_permalink().'">View Details</a>'; //  link to bring us to employee display page, use WordPress function get_permalink
        $output .= '</div>';
      }
      $output .= '</div>';

      // Clear Float
      $output .= '<div style="clear:both"></div>';

      // Reset Post Data
      wp_reset_postdata();

      // Pagination
    if($employees->max_num_pages > 1 && is_page()){ // if max num of pages is greater than 1 and it's a page, then...
      // Next
      $output .= '<nav class="prev-next-posts">'; // then output a nav bar
      $output .= '<div class="nav-previous">';
      $output .= get_next_posts_link(__('<span class="meta-nav">&larr;</span> Previous'), $employees->max_num_pages);
      $output .= '</div>';
      //Previous
      $output .= '<div class="next-posts-link">';
      $output .= get_previous_posts_link(__('<span class="meta-nav">&rarr;</span> Next'));
      $output .= '</div>';
      $output .= '</nav';
    }
    // Return the output
      return $output;
  } else {
    // otherwise, if there are no employees, return "No employees found"
    return '<p>No employees found</p>';
  }
  }
  // Employee shortcode, call ed_list_employees function
  add_shortcode('employees', 'ed_list_employees');
