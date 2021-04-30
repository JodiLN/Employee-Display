<?php
function ed_add_fields_metabox(){
	add_meta_box(
		'ed_listing_info',
		__('Listing Info'),
		'ed_add_fields_callback',
		'employee_listing',
		'normal',
		'default'
	);
}

add_action('add_meta_boxes', 'ed_add_fields_metabox');

function ed_add_fields_callback($post){
	wp_nonce_field(basename(__FILE__), 'ed_employee_listings_nonce');
	$ed_stored_meta = get_post_meta($post->ID);
	?>
		<div class="wrap employee-listing-form">

			<div class="form-group">
				<label for="job-title"><?php esc_html_e('Job Title', 'ed-domain'); ?></label>
				<select
				name="job_title"
				id="job_title">
					<?php
					$option_values = array('Executive Director', 'Director of Sales', 'Director of Resident Care', 'Director of Life Enrichment', 'Memory Care Director', 'Director of Hospitality', 'Hospitality Supervisor', 'Business Office Manager');
					foreach($option_values as $key => $value){
						if($value == $ed_stored_meta['job_title'][0]){
							?>
								<option selected><?php echo $value; ?></option>
							<?php
						} else {
							?>
								<option><?php echo $value; ?></option>
							<?php
						}
					}
					?>
				</select>
			</div>

			<?php if(get_settings('ed_setting_show_editor')) : ?>
			<div class="form-group">
				<label for="details"><?php esc_html_e('Details', 'ed-domain'); ?></label>
				<?php
					$content = get_post_meta($post->ID, 'details', true);
					$editor = 'details';
					$settings = array(
						'textarea_rows' => 5,
						'media_buttons' => get_settings('ed_setting_show_media_buttons')
					);

					wp_editor($content, $editor, $settings);
				?>
			</div>
			<?php else : ?>
				<div class="form-group">
					<label for="details"><?php esc_html_e('Details', 'ed-domain'); ?></label>
					<textarea class="full" name="details" id="details">
						<?php if(!empty($ed_stored_meta['details'])) echo esc_html($ed_stored_meta['details'][0]); ?>
					</textarea>
				</div>
			<?php endif; ?>

			<div class="form-group">
				<label for="first-name"><?php esc_html_e('First Name', 'ed-domain'); ?></label>
				<input type="text" class="full" name="first_name" id="first_name" value="<?php if(!empty($ed_stored_meta['first_name'])) echo esc_attr($ed_stored_meta['first_name'][0]); ?>">
			</div>

			<div class="form-group">
				<label for="last-name"><?php esc_html_e('Last Name', 'ed-domain'); ?></label>
				<input type="text" class="full" name="last_name" id="last_name" value="<?php if(!empty($ed_stored_meta['last_name'])) echo esc_attr($ed_stored_meta['last_name'][0]); ?>">
			</div>
		</div>
	<?php
}

function ed_meta_save($post_id){
	$is_autosave = wp_is_post_autosave($post_id);
	$is_revision = wp_is_post_revision($post_id);
	$is_valid_nonce = (isset($_POST['ed_employee_listings_nonce']) && wp_verify_nonce($_POST['ed_employee_listings_nonce'], basename(__FILE__)))? 'true' :  'false';

	if($is_autosave || $is_revision || !$is_valid_nonce){
		return;
	}

	if($_POST['job_title']){
		update_post_meta($post_id, 'job_title', sanitize_text_field($_POST['job_title']));
	}

	if($_POST['details']){
		update_post_meta($post_id, 'details', sanitize_text_field($_POST['details']));
	}

	if($_POST['first_name']){
		update_post_meta($post_id, 'first_name', sanitize_text_field($_POST['first_name']));
	}

	if($_POST['last_name']){
		update_post_meta($post_id, 'last_name', sanitize_text_field($_POST['last_name']));
	}
}

add_action('save_post', 'ed_meta_save');

?>
