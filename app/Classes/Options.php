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
class Options implements Bootable {

	/**
	 * Initiates the class.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {
		add_action( 'admin_menu', array( $this, 'fes_add_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
	}

	public function fes_add_menu() {
		$hook = add_menu_page(
			__( 'Collins Advanced Settings', 'opn' ),
			__( 'Collins Advanced Settings', 'opn' ),
			'manage_options',
			'collins',
			array( $this, 'fes_main' ),
			'dashicons-smiley',
			100
		);
	}

	public function fes_main() {

		// Save option.
		if( isset( $_POST['fe-options-save'] ) && 1 === absint( $_POST['fe-options-save'] ) ) {
			$this->fes_main_process_save();
		}
		$options      = get_option( 'fes_collins_settings' );
		$defaults     = array(
			'en'                 => '',
			'fr'                 => '',
			'privacy_hook_name'  => '',
		);
		$options         = wp_parse_args( $options, $defaults );
		$current_page = admin_url( "admin.php?page=".$_GET["page"] );
		$params       = [
			'current_page' => $current_page,
			'options'      => $options,
		];

		echo AdminManager::$classes['Admin']->render( 'settings', $params, true );
	}

	public function fes_main_process_save() {
		$option[ 'fr' ]                = wp_kses_post( $_POST['fe-post-content-fr'] );
		$option[ 'en' ]                = wp_kses_post( $_POST['fe-post-content-en'] );
		$option[ 'privacy_hook_name' ] = wp_kses_post( $_POST['fe-post-hook'] );
		update_option( 'fes_collins_settings', $option);
	}

	/**
	 * Enqueue method.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		// Enqueue style.
		wp_enqueue_style( 'fes-main-css', FES_URL . 'assets/css/fes-admin.min.css', array(), '1.3' );
	}

}


