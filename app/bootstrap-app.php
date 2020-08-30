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

namespace BLC;

// Composer Autoloader.
if ( file_exists( BLC_DIRECTORY . 'vendor/autoload.php' ) ) {
	require_once BLC_DIRECTORY . 'vendor/autoload.php';
}

$blc = new Core\Application();

// load function files here.
array_map(
	function( $file ) {
		require_once BLC_DIRECTORY . "app/{$file}.php";
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

do_action( 'blc_bootstrap', $blc );

$blc->boot();

/*
**********************************************
				Debugging stuff
***********************************************
*/
// define( 'BLC_DEBUG', false ); .

/***********************************************
				Constants
************************************************/

/**
* For performance, some internal APIs used for retrieving multiple links, instances or containers
* can take an optional "$purpose" argument. Those APIs will try to use this argument to pre-load
* any DB data required for the specified purpose ahead of time.

* For example, if you're loading a bunch of link containers for the purposes of parsing them and
* thus set $purpose to BLC_FOR_PARSING, the relevant container managers will (if applicable) precache
* the parse-able fields in each returned container object. Still, setting $purpose to any particular
* value does not *guarantee* any data will be preloaded - it's only a suggestion that it should.

* The currently supported values for the $purpose argument are :
*/
// define( 'BLC_FOR_EDITING', 'edit' );
// define( 'BLC_FOR_PARSING', 'parse' );
// define( 'BLC_FOR_DISPLAY', 'display' );
// define( 'BLC_DATABASE_VERSION', 16 );

