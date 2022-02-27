<?php
/**
 * @package Frontend_Submission
 * @version 1.0.0
 */
/*
Plugin Name: Collins helper
Description: Collins helper plugin by bplv
Author: Bplv
Version: 1.0.0
*/
// Path to this file.
if ( ! defined( 'FES_PLUGIN_FILE' ) ) {
	define( 'FES_PLUGIN_FILE', __FILE__ );
}

// Path to the plugin's directory.
if ( ! defined( 'FES_DIRECTORY' ) ) {
	define( 'FES_DIRECTORY', trailingslashit( dirname( __FILE__ ) ) );
}

// Path to the Plugin Base File.
if ( ! defined( 'FES_BASE_FILE' ) ) {
	define( 'FES_BASE_FILE', plugin_basename( __FILE__ ) );
}

// Plugin URL.
if ( ! defined( 'FES_URL' ) ) {
	define( 'FES_URL', plugin_dir_url( FES_BASE_FILE ) );
}

// Tempate path.
if ( ! defined( 'FES_TEMPLATE' ) ) {
	define( 'FES_TEMPLATE', FES_DIRECTORY . 'app/Views/' );
}

if ( ! class_exists( 'SitePress' ) ) {
	define( 'ICL_LANGUAGE_CODE', 'en' );
}

require 'app/bootstrap-app.php';