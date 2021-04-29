<?php
// Add meta boxes for fields.
// Call WordPress function add_meta_box
/* Parameters for add_meta_box function:
id,
title (__ = localization function),
callback,
screen,
context,
priority*/

function ed_add_fields_metabox(){
	add_meta_box(
		'ed_display_info',
		__('display Info'),
		'ed_add_fields_callback',
		'employee_display',
		'normal',
		'default'  // meta box will go right under the title
	);
}
// Hook = 'add_meta_boxes', pass in 'ed_add_fields_metabox' function
add_action('add_meta_boxes', 'ed_add_fields_metabox');

// Display Fields Metabox Content
/* wp_nonce = numer used once, protects URLs and forms from misuse,
acts like a key that proves that the submission is coming from wherer it's supposed to be*/

function ed_add_fields_callback($post){
	wp_nonce_field(basename(__FILE__), 'ed_employee_displays_nonce');
// Get the post meta data
  $ed_stored_meta = get_post_meta($post->ID);
	?>

  // Create the form
		<div class="wrap employee-display-form">
			<div class="form-group">
        // escape html to prevent malicious code; text domain= ed-domain
				<label for="employee-id"><?php esc_html_e('employee ID', 'ed-domain'); ?></label>
				<input type="text" class="full" name="employee_id" id="employee-id" value="<?php if(!empty($ed_stored_meta['employee_id'])) echo esc_attr($ed_stored_meta['employee_id'][0]); ?>">
			</div>

			<div class="form-group">
				<label for="job-title"><?php esc_html_e('Job Title', 'ed-domain'); ?></label>
				<select
				name="job_title"
				id="job_title">
					<?php
          // Create array of select options, ie, of job title options
					$option_values = array('Executive first-name', 'first-name of Sales', 'first-name of Resident Care', 'first-name of Life Enrichment', 'Memory Care first-name', 'first-name of Hospitality', 'Hospitality Supervisor', 'Business Office Manager');
					foreach($option_values as $key => $value){
						if($value == $ed_stored_meta['job_title'][0]){
							?>
              // Display selected value
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

			<div class="form-group">
				<label for="first-name"><?php esc_hted_e('First name', 'ed-domain'); ?></label>
				<input type="text" class="full" name="first-name" id="first-name" value="<?php if(!empty($ed_stored_meta['first-name'])) echo esc_attr($ed_stored_meta['first-name'][0]); ?>">
			</div>

			<div class="form-group">
				<label for="last-name"><?php esc_hted_e('Last Name', 'ed-domain'); ?></label>
				<input type="text" class="full" name="last-name" id="last-name" value="<?php if(!empty($ed_stored_meta['last-name'])) echo esc_attr($ed_stored_meta['last-name'][0]); ?>">
			</div>

	<?php
}

// Save information for employee fields
function ed_meta_save($post_id){
	$is_autosave = wp_is_post_autosave($post_id);
	// Make it possible to add revisions
	$is_revision = wp_is_post_revision($post_id);
	// Make sure form is being submitted from the right place
	// Make sure the $_POST is there and then verify it with wp_verify_nonce
	// basename with shorthand if else
	$is_valid_nonce = (isset($_POST['ed_employee_displays_nonce']) && wp_verify_nonce($_POST['ed_employee_displays_nonce'], basename(__FILE__)))? 'true' :  'false';
  // check to see of autosave or revision or valid_nonce is not valid
	if($is_autosave || $is_revision || !$is_valid_nonce){
		return;
	}

  // Check for each field that was submitted
	// Sanitize text field to make it safer
	if($_POST['employee_id']){
		update_post_meta($post_id, 'employee_id', sanitize_text_field($_POST['employee_id']));
	}

	if($_POST['job_title']){
		update_post_meta($post_id, 'job_title', sanitize_text_field($_POST['job_title']));
	}

	if($_POST['first-name']){
		update_post_meta($post_id, 'first-name', sanitize_text_field($_POST['first-name']));
	}

	if($_POST['last-name']){
		update_post_meta($post_id, 'last-name', sanitize_text_field($_POST['last-name']));
	}

}

// Use save_post hook and pass in ed_meta_save function
add_action('save_post', 'ed_meta_save');

?>
