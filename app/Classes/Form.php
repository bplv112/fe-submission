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
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
		add_shortcode( 'display_fe_form', array( $this, 'display_form' ) );
		add_filter( 'body_class', array( $this, 'add_body_class' ) );
		add_action( 'wp_ajax_fes_submit_post', array( $this, 'process_form' ) );
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

	/**
	 * Add body class if form is present.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function add_body_class( $classes ) {
		global $post;
		if( isset( $post->post_content ) && has_shortcode( $post->post_content, 'display_fe_form' ) ) {
			$classes[] = 'fes-form-fe';
		}
		return $classes;
	}

	/**
	 * Process the post submit form.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function process_form() {

		// Do nothing if function was called incorrectly.
		if ( empty( $_REQUEST['action'] ) ) {
			wp_send_json_error(
				array( 'message' => __( 'Required field missing', 'fe-submission' ) )
			);
			exit;
		}

		$nonce = $_REQUEST['fes_submit_post_nonce']; //phpcs:ignore

		// Do nothing if the nonce is invalid.
		if ( ! wp_verify_nonce( $nonce, $_REQUEST['action'] ) ) {
			wp_send_json_error(
				array( 'message' => __( 'Oops, security breach', 'fe-submission' ) )
			);
			exit;
		}

		// get request data.
		$data = $_REQUEST;
		// store image on the same var.
		$data['fe-post-image'] = isset( $_FILES['fe-post-image'] ) ? $_FILES['fe-post-image'] : '';

		// get request data.
		$form_validation = $this->validate_form( $data );

		if( empty( $form_validation ) ) {
			var_dump( $data );
			// $this->save_post( $data );
		} else {
			wp_send_json_error( $form_validation );
		}
	}

	/**
	 * Validate the form.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function validate_form( $data ) {
		$error = array();
		$mandatory_fields = \FES\get_mandatory_fields();

		// Check for empty Data.
		if( empty( $data ) ) {
			$error = array( 'message' => __( 'Oops, empty data', 'fe-submission' ) );
		}

		foreach( $data as $key => $value ) {
			if( empty( $value ) && in_array( $key, $mandatory_fields ) ) {
				$fields[] = $key;
			}
		}

		if( $fields ) {
			$error = array( 'message' => __( 'Oops, mandatory fields missing', 'fe-submission' ) );
			$error['fields'] = $fields;
			$error['fields_message'] = __( 'Please fill out this field, it is mandatory and cannot be left empty', 'fe-submission' );
		}

		return $error;
	}

	/**
	 * Save the form.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function save_post( $data ) {

	}

}