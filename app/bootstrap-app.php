<?php
/**
 * Autoload bootstrap file.
 *
 * This file is used to autoload classes and functions necessary for the theme
 * to run. Classes utilize the PSR-4 autoloader in Composer which is defined in
 * `composer.json`.
 *
 * @package   FeSubmission
 * @author    bplv
 */

namespace FES;

// Composer Autoloader.
if ( file_exists( FES_DIRECTORY . 'vendor/autoload.php' ) ) {
	require_once FES_DIRECTORY . 'vendor/autoload.php';
}

$fes = new Core\Application();

// load function files here.
array_map(
	function( $file ) {
		require_once FES_DIRECTORY . "app/{$file}.php";
	},
	array(
		'functions-helpers',
	)
);

/**
 * Action hook after the plugin has been bootstrapped
 *
 * @since 1.0.0
 * @param Obj $app an instance of the plugin/application
 */

do_action( 'FES_bootstrap', $fes );

$fes->boot();