<?php
/**
 * Front-end form class.
 *
 * This is the place where we handle front end form.
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
 * @since  1.0.0
 * @access public
 */
class Form implements Bootable {

	/**
	 * Initiates the class.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {
		add_shortcode( 'display_fe_form', array( $this, 'display_form' ) );
	}

	/**
	 * Enqueue method.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_script(
			'fes-js',
			FES_URL . 'assets/js/fes-admin.min.js',
			array( 'jquery' ),
			'1.2.0',
			false
		);

		// Enqueue style.
		wp_enqueue_style( 'fes-main-css', FES_URL . 'assets/css/fes-admin.min.css', array(), '1.3' );
	}

	/**
	 * Display the fe-form.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function display_form() {

		//only enqueue style when shortcode is active.
		$this->enqueue();
		AdminManager::$classes['Admin']->render( 'form' );
	}

	/**
	 * Check if we have cap to show the form.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function has_caps() {
	}
}