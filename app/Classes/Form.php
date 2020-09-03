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
			$post_id = $this->save_post( $data );

			// If post not insert proper.
			if( is_wp_error( $post_id ) ) {
				$error = array( 'message' => $post_id->get_error_message() );
				wp_send_json_error( $error );
			}

			// If post inserted successfully insert image.
			$this->insert_featured_image( $post_id, $data['fe-post-image'] );

			// Send success email.
			$this->send_success_email( $post_id );

			// If all okay send success.
			wp_send_json_success();

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
		$error            = array();
		$fields           = array();
		$mandatory_fields = \FES\get_mandatory_fields();

		// Check for empty Data.
		if( empty( $data ) ) {
			$error = array( 'message' => __( 'Oops, empty data', 'fe-submission' ) );
		}

		foreach( $data as $key => $value ) {
			if( empty( $value ) && in_array( $key, $mandatory_fields ) ) {
				$fields[] = $key;
			}

			// A little step further for image field.
			if( 'fe-post-image' === $key && empty( $data[$key]['tmp_name'] ) ) {
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
		// After all the validation here we are.
		// Last place to change the data if needed through extensions.
		$data = apply_filters( 'fes_insert_post_data', $data );

		// Post data array.
		$post_data_array = array(
			'post_title'   => \sanitize_text_field( $data['fe-post-title'] ),
			'post_content' => \wp_kses_post( $data['fe-post-content'] ),
			'post_excerpt' => \sanitize_text_field( $data['fe-post-excerpt'] ),
			'post_type'    => \sanitize_text_field( $data['fe-post-type'] )
		);

		// Insert post.
		return wp_insert_post( $post_data_array, true );
	}

	/**
	 * Add featured image to the post.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function insert_featured_image( $post_id, $image ) {

		// If not met requirements, bail.
		if( ! $post_id || ! $image ) {
			return;
		}

		$image_name = sanitize_file_name( $image['name'] );
		$file       = $image['tmp_name'];

		$upload_file = wp_upload_bits( $image_name, null, @file_get_contents( $file ) );
		if ( ! $upload_file['error'] ) {

			$wp_filetype = wp_check_filetype( $image_name, null );

			$attachment = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_parent'    => $post_id,
				'post_title'     => preg_replace( '/\.[^.]+$/', '', $image_name ),
				'post_content'   => '',
				'post_status'    => 'inherit'
			);

			$attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $post_id );

			if ( ! is_wp_error( $attachment_id ) ) {
				// if attachment post was successfully created, insert it as a thumbnail to the post $post_id.
				require_once(ABSPATH . "wp-admin" . '/includes/image.php');

				$attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );

				wp_update_attachment_metadata( $attachment_id,  $attachment_data );
				set_post_thumbnail( $post_id, $attachment_id );
			}
		}
	}


	/**
	 * Add featured image to the post.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function send_success_email( $post_id ) {
		$email_details = \FES\get_email_details();
		$post_url      = esc_url( get_post_permalink( $post_id ) );
		$post_edit_url = esc_url( get_edit_post_link( $post_id ) );
		$replace       = array( $post_url, $post_edit_url );
		$str           = array( '{post_url}', '{post_edit_url}' );
		extract( $email_details );

		$message = str_replace( $str, $replace, $message );
		wp_mail( $to, $subject, $message, $headers );
	}
}