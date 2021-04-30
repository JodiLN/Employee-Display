<?php
// For Reading settings under Settings in Admin area
function ed_employee_display_settings(){
	add_settings_section( // Call add_settings_section and add parameters
		'ed_setting_section',
		'Employee Display Settings', // Human readable name
		'ed_setting_section_callback', // Callback
		'reading'// Put it in the Settings reading section
	);

	add_settings_field( // Add field and parameters
		'ed_setting_show_editor',
		'Show Editor', // Human readable name
		'ed_setting_show_editor_callback', // Callback
		'reading', // Put it in the Settings reading section
		'ed_setting_section' // Put it in this section
	);

	register_setting('reading', 'ed_setting_show_editor'); // Call register setting, put it in reading, pass in ed_setting_show_editor
  // Media buttons settings
	add_settings_field(
		'ed_setting_show_media_buttons',
		'Show Media Buttons',
		'ed_setting_show_media_buttons_callback',
		'reading',
		'ed_setting_section'
	);

	register_setting('reading', 'ed_setting_show_media_buttons');  // register field
}

add_action('admin_init', 'ed_employee_display_settings');  // add action with admin_init hook
// Get the content and display it with echo
function ed_setting_section_callback(){
	echo '<p>Settings for the Employee Display plugin</p>';
}
// concatinate checked function below class="code"
function ed_setting_show_editor_callback(){
	echo '<input
	name="ed_setting_show_editor"
	id="ed_setting_show_editor"
	type="checkbox"
	value="1"
	class="code"

	' . checked(1, get_option('ed_setting_show_editor'), false).' />
	Choose if details should be in editor';
}
// Same function but for media buttons
function ed_setting_show_media_buttons_callback(){
	echo '<input
	name="ed_setting_show_media_buttons"
	id="ed_setting_show_media_buttons"
	type="checkbox"
	value="1"
	class="code"
	' . checked(1, get_option('ed_setting_show_media_buttons'), false).' />
	Choose if media buttons should be enabled';
}
