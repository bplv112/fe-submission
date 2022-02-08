<?php

/**
 * Custom Post Type class.
 *
 * This is the place where we handle custom post types.
 *
 * @package   FeSubmission
 * @author    bplv
 */

namespace FES\Classes;

use FES\Interfaces\Bootable;

/**
 * Plugin Class handling admin pages.
 *
 * @since  2.0.0
 * @access public
 */
class WC implements Bootable {

	/**
	 * Initiates the class.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {
		$options = get_option( 'fes_collins_settings' );
		add_action( $options['privacy_hook_name'], array( $this, 'print_privacy_notice' ) );
	}

	/**
	 * Enqueue method.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function print_privacy_notice() {
		$lang    = ICL_LANGUAGE_CODE;
		$options = get_option( 'fes_collins_settings' );

		echo $options [$lang];
	}

}


