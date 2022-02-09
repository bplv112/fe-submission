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
			'promo_banner_en'    => '',
			'promo_banner_fr'    => '',
			'fe_enable_banner'   => "0",
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
		$options      = get_option( 'fes_collins_settings' );
		$defaults     = array(
			'en'                 => '',
			'fr'                 => '',
			'privacy_hook_name'  => '',
			'promo_banner_en'    => '',
			'promo_banner_fr'    => '',
			'fe_enable_banner'   => '0',
		);
		$options = wp_parse_args( $options, $defaults );
		
		$options[ 'fe_enable_banner' ]  = isset( $_POST['fe-enable-banner'] ) ? esc_html( $_POST['fe-enable-banner'] ) : '0';
		$options[ 'fr' ]                = isset( $_POST['fe-post-content-fr'] ) ? wp_kses_post( $_POST['fe-post-content-fr'] ) : $options['fr'];
		$options[ 'en' ]                = isset( $_POST['fe-post-content-en'] ) ? wp_kses_post( $_POST['fe-post-content-en'] ) : $options['en'];
		$options[ 'privacy_hook_name' ] = isset( $_POST['fe-post-hook'] ) ? esc_html( $_POST['fe-post-hook'] ) : $options['fe-post-hook'];
		$options['promo_banner_en']     = isset( $_FILES['fe-post-image-en'] ) && '' !== $_FILES['fe-post-image-en']['name'] ? $this->get_attachment( $_FILES['fe-post-image-en'] ) : $options['promo_banner_en'];
		$options['promo_banner_fr']     = isset( $_FILES['fe-post-image-fr'] ) && '' !== $_FILES['fe-post-image-fr']['name'] ? $this->get_attachment( $_FILES['fe-post-image-fr'] ) : $options['promo_banner_fr'];
		
		update_option( 'fes_collins_settings', $options);
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
		wp_enqueue_style( 'fes-main-css', FES_URL . 'assets/css/fes-admin.min.css', array(), '1.3.3' );

		// Script
		wp_enqueue_script(
			'fes-js',
			FES_URL . 'assets/js/fes-admin.min.js',
			array( 'jquery' ),
			'1.2.3',
			true
		);
	}


	/**
	 * Add featured image to the post.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function get_attachment( $image ) {

		// If not met requirements, bail.
		if( ! $image ) {
			return;
		}

		$image_name = sanitize_file_name( $image['name'] );
		$file       = $image['tmp_name'];

		$upload_file = wp_upload_bits( $image_name, null, @file_get_contents( $file ) );
		if ( ! $upload_file['error'] ) {

			$wp_filetype = wp_check_filetype( $image_name, null );

			$attachment = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', $image_name ),
				'post_content'   => '',
				'post_status'    => 'inherit'
			);

			$attachment_id = wp_insert_attachment( $attachment, $upload_file['file'] );
			
			if ( ! is_wp_error( $attachment_id ) ) {
				return wp_get_attachment_url( $attachment_id );
			}

			return;
		}
	}

}


