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
use FES\Manager\AdminManager;

/**
 * Plugin Class handling admin pages.
 *
 * @since  2.0.0
 * @access public
 */
class Banners implements Bootable {

	/**
	 * Initiates the class.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {
		add_action( 'fes_before_content', array( $this, 'print_privacy_notice' ) );
	}

	/**
	 * Enqueue method.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function print_privacy_notice() {

		$lang    = ICL_LANGUAGE_CODE ? ICL_LANGUAGE_CODE : 'fr';
		$options = get_option( 'fes_collins_settings' );
		$params  = [
			'options' => $options,
			'lang'	  => $lang,		
		];

		if( '1' !== $options['fe_enable_banner'] ) {
			return;
		}

		echo AdminManager::$classes['Admin']->render( 'promo', $params, true );
	}

}


