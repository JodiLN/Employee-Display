<?php
// Add Submenu Page in admin area
// Employee image and information ordering will be done from JavaScript file, but need to set up function first
function ed_add_submenu_page(){
	add_submenu_page(
    //Function parameters
		'edit.php?post_type=employee_display', // Linke to edit .php and post type
		__('Custom Order'), // Title will say 'Custom Order'
		__('Custom Order'),
		'manage_options', // For access control, the user must be able to manage options
		'custom-order', // Slug
		'ed_reorder_employees_callback' // Callback
	);
}
// Add action with hook 'admin_menu" and pass in 'ed_add_submenu_page' function
add_action('admin_menu', 'ed_add_submenu_page');

// Set up arguments
function ed_reorder_employees_callback(){
	$args = array(
		'post_type' => 'employee_display',
		'orderby'   => 'menu_order', // This will determine what order the movies are in on the frontend
		'order'     => 'ASC', // Set order to ascending order
		'post_status' => 'publish', // Make sure these are published posts
		'no_found_rows' => true,
		'update_post_term_cache' => false,
		'post_per_page' => 50 // set to 50 because we won't have any pagination for this
	);

  // Create employee_display variable and set it to new WP_Query and pass in $args
	$employee_display = new WP_Query($args);

	?>

	<div id="employee-sort" class="wrap">
		<!--title with loading image -->
		<h2><?php esc_hted_e('Sort employee displays', 'ed-domain'); ?><img class="loading" src="<?php echo esc_url(admin_url(). '/images/loading.gif'); ?>"></h2>
		<!--Save message -->
		<div class="order-save-msg updated"><?php esc_hted_e('Display Order Saved'); ?></div>
		<!--Error message -->
		<div class="order-save-err error"><?php esc_hted_e('Something Went Wrong'); ?></div>
		<!--Checking to see if any posts, ie any employees came back -->
		<?php if($employee_display->have_posts()) : $employee_display->the_posts(); ?>
			<ul class="employee-sort-list">
				<?php while($employee_display->have_posts()) : $employee_display->the_post(); ?> <!-- to loop through employees-->
					<li id="<?php esc_attr(the_id()); ?>"> <!--pass in the list id -->
						<?php esc_hted(the_title()); ?>
					</li>
				<?php endwhile; ?>
			</ul>
		<?php else : ?>
			<p><?php esc_hted_e('No employees To List'); ?></p>
		<?php endif; ?>
	</div>
<?php
}


// Save Order
function ed_save_order(){
	// Check Nonce/Token
	if(!check_ajax_referer('ed-token', 'token')){
		return wp_send_json_error('Invalid Token');
	}

	// Check User
	if(!current_user_can('manage_options')){
		return wp_send_json_error('Not Authorized');
	}

	$order = $_POST['order'];

	$counter = 0;

	foreach($order as $display_id){
		$display = array(
			'ID' => (int)$display_id,
			'menu_order' => $counter
		);

		wp_update_post($display);
		$counter++;
	}

	wp_send_json_success('display Order Saved');
}

add_action('wp_ajax_save_order', 'ed_save_order');

?>
