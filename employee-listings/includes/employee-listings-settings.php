<?php

function ed_employee_listings_settings(){
	add_settings_section(
		'ed_setting_section',
		'employee Listings Settings',
		'ed_setting_section_callback',
		'reading'
	);

	add_settings_field(
		'ed_setting_show_editor',
		'Show Editor',
		'ed_setting_show_editor_callback',
		'reading',
		'ed_setting_section'
	);

	register_setting('reading', 'ed_setting_show_editor');

	add_settings_field(
		'ed_setting_show_media_buttons',
		'Show Media Buttons',
		'ed_setting_show_media_buttons_callback',
		'reading',
		'ed_setting_section'
	);

	register_setting('reading', 'ed_setting_show_media_buttons');
}

add_action('admin_init', 'ed_employee_listings_settings');

function ed_setting_section_callback(){
	echo '<p>Settings for the Employee Listings plugin</p>';
}

function ed_setting_show_editor_callback(){
	echo '<input
	name="ed_setting_show_editor"
	id="ed_setting_show_editor"
	type="checkbox"
	value="1"
	class="code"
	' . checked(1, get_option('ed_setting_show_editor'), false).' />
	Choose if details should be an editor';
}

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
