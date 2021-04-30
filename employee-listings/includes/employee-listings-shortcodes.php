<?php

// List employees
function ed_list_employees($atts, $content = null){
	$atts = shortcode_atts(array(
		'title' => 'Latest employees',
		'count' => 12,
		'genre' => 'all',
		'pagination' => 'off'
	), $atts);

	$pagination = $atts['pagination'] == 'on' ? false : true;
	$paged = get_query_var('paged') ? get_query_var('paged') : 1;

	// Check genre
	if($atts['genre'] == 'all'){
		$terms = '';
	} else {
		$terms = array(array(
			'taxonomy' => 'job-title',
			'field'    => 'slug',
			'terms'	   => $atts['genre']
		));
	}

	// Query Args
	$args = array(
		'post_type' => 'employee_listing',
		'post_status'	=> 'publish',
		'orderby' => 'menu_order',
		'order'		=> 'ASC',
		'no_found_rows'	=> $pagination,
		'posts_per_page'=> $atts['count'],
		'paged'			=> $paged,
		'tax_query'		=> $terms
	);

	// Get employees From DB
	$employees = new WP_Query($args);

	// Check For employees
	if($employees->have_posts()){
		// Get genre Slug
		$genre = str_replace('-', ' ', $atts['genre']);
			$output = '<div class="employee-list">';
			while($employees->have_posts()){
				$employees->the_post();
				$image = wp_get_attachment_image_src(get_post_thumbnail_id(),'single-post-thumbnail');

				$output .= '<div class="employee-col">';
				$output .= '<img class="feat-image" src="'.$image[0].'"';
				$output .= '<h5 class="employee-first-name">'.get_the_title().'</h5><br>';
				$output .= '<a href="'.get_permalink().'">View Bio</a>';
				$output .= '</div>';
			}
			$output .= '</div>';

			// Clear Float
			$output .= '<div style="clear:both"></div>';

			// Reset Post Data
			wp_reset_postdata();

			// Pagination
		if($employees->max_num_pages > 1 && is_page()){
			$output .= '<nav class="prev-next-posts">';
			$output .= '<div class="nav-previous">';
			$output .= get_next_posts_link(__('<span class="meta-nav">&larr;</span> Previous'), $employees->max_num_pages);
			$output .= '</div>';

			$output .= '<div class="next-posts-link">';
			$output .= get_previous_posts_link(__('<span class="meta-nav">&rarr;</span> Next'));
			$output .= '</div>';
			$output .= '</nav';
		}

			return $output;
	} else {
		return '<p>No employees Found</p>';
	}
}

add_shortcode('employees', 'ed_list_employees');
