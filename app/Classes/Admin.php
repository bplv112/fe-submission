<?php
/**
 * Admin class.
 *
 * This is the place where we handle admin pages
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
class Admin implements Bootable {

	/**
	 * Option name.
	 *
	 * @since  2.0.0
	 * @access public
	 * @var    string
	 */
	public $menu_page;

	/**
	 * Initiates the class.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		add_filter( 'admin_body_class', array( $this, 'add_sui_body_class' ) );
	}

	/**
	 * Activation method.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_script(
			'blc-js',
			BLC_URL . 'assets/js/blc-admin.min.js',
			array( 'jquery' ),
			'1.2.0',
			false
		);

		// Enqueue style.
		wp_enqueue_style( 'blc-main-css', BLC_URL . 'assets/css/blc-admin.min.css', array(), '1.3' );
	}

}
