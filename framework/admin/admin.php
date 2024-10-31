<?php
/* Initialize the theme admin functionality. */
add_action('init', 'seoplugins_admin_init' );


// Initializes the theme administration functions. Makes sure we have a theme settings page and a meta box on the edit post/page screen.
function seoplugins_admin_init() {
	global $seoplugins;
	$prefix = $seoplugins->prefix;

	/* Initialize the theme settings page. */
	add_action('admin_menu', 'seoplugins_settings_page_init');
	
	/* Initialize the admin head js,css. Call seoplugins_admin_head() from options/init_options.php */
	add_action('admin_head', 'seoplugins_admin_head');
	
	/* Initialize the admin option fields. Call admin_option_fields() from options/admin_options.php */
	add_action('admin_head', 'admin_option_fields');
	add_action('admin_head', 'seoplugins_save_admin_options');
}

/* Initializes plugin settings */
function seoplugins_settings_page_init() {
	global $seoplugins;
	
	/* get plugin information. */
	$utils = $seoplugins->utils;

	/* Create the theme settings page. */
	add_object_page('Page Title', $utils['shortname'], 2,'seoplugins', 'seoplugins_create_settings_page', PLUGIN_URI . $utils['icon']);
	add_submenu_page('seoplugins', 'AdminMenu', 'Configuration', 'administrator', 'seoplugins', 'seoplugins_create_settings_page');
	add_submenu_page('seoplugins', 'Suport', 'Support', 'administrator', 'support', 'seoplugins_create_support_page');
}