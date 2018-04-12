<?php
/*
Plugin Name: transale-array
Description: Tranlate by text arrays all manuals inserts
Version: 1.0
Author: https://github.com/ajd01
Author URI: https://github.com/ajd01
*/
// function to create the DB / Options / Defaults
function le_install() {

    global $wpdb;

    $table_name = $wpdb->prefix . "translate_array";
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
			`key` varchar(255) CHARACTER SET utf8 NOT NULL,
			`lang` varchar(255) CHARACTER SET utf8 NOT NULL,
			`text` varchar(255) CHARACTER SET utf8 NOT NULL,
			PRIMARY KEY (`id`)
		  ) $charset_collate; ";
		  
	error_log($sql);

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);
}

// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'le_install');

//menu items
add_action('admin_menu','add_menu');
function add_menu() {
	
	//this is the main item for the menu
	add_menu_page('Translate', //page title
	'Translate List', //menu title
	'manage_options', //capabilities
	'translate_list', //menu slug
	'translate_list', //function
	'dashicons-admin-site' //icon
	);
	
	//this is a submenu
	add_submenu_page('translate_list', //parent slug
	'Add New Key', //page title
	'Add New', //menu title
	'manage_options', //capability
	'translate_add', //menu slug
	'translate_add'); //function
	
	//this submenu is HIDDEN, however, we need to add it anyways
	add_submenu_page(null, //parent slug
	'Update', //page title
	'Update', //menu title
	'manage_options', //capability
	'translate_update', //menu slug
	'translate_update'); //function
}
define('ROOTDIR', plugin_dir_path(__FILE__));
require_once(ROOTDIR . 'translate-list.php');
require_once(ROOTDIR . 'translate-create.php');
require_once(ROOTDIR . 'translate-update.php');

require_once(ROOTDIR . 'translate-footer-fucntion.php');




