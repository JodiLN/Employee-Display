<?php

function ed_add_submenu_page(){
	add_submenu_page(
		'edit.php?post_type=employee_listing',
		__('Custom Order'),
		__('Custom Order'),
		'manage_options',
		'custom-order',
		'ed_reorder_employees_callback'
	);
}

add_action('admin_menu', 'ed_add_submenu_page');

function ed_reorder_employees_callback(){
	$args = array(
		'post_type' => 'employee_listing',
		'orderby'   => 'menu_order',
		'order'     => 'ASC',
		'post_status' => 'publish',
		'no_found_rows' => true,
		'update_post_term_cache' => false,
		'post_per_page' => 50
	);

	$employee_listing = new WP_Query($args);

	?>

	<div id="employee-sort" class="wrap">
		<h2><?php esc_html_e('Sort Employee Listings', 'ed-domain'); ?><img class="loading" src="<?php echo esc_url(admin_url(). '/images/loading.gif'); ?>"></h2>
		<div class="order-save-msg updated"><?php esc_html_e('Listing Order Saved'); ?></div>
		<div class="order-save-err error"><?php esc_html_e('Something Went Wrong'); ?></div>
		<?php if($employee_listing->have_posts()) : $employee_listing->the_posts(); ?>
			<ul class="employee-sort-list">
				<?php while($employee_listing->have_posts()) : $employee_listing->the_post(); ?>
					<li id="<?php esc_attr(the_id()); ?>">
						<?php esc_html(the_title()); ?>
					</li>
				<?php endwhile; ?>
			</ul>
		<?php else : ?>
			<p><?php esc_html_e('No Employees To List'); ?></p>
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

	foreach($order as $listing_id){
		$listing = array(
			'ID' => (int)$listing_id,
			'menu_order' => $counter
		);

		wp_update_post($listing);
		$counter++;
	}

	wp_send_json_success('Listing Order Saved');
}

add_action('wp_ajax_save_order', 'ed_save_order');

?>
