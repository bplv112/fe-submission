<?php
/**
 * Custom helper functions.
 *
 * Helper functions for the plugin.
 *
 * @package   FeSubmission
 * @author    bplv
 */

namespace FES;

/**
 * Get mandatory fields
 *
 * @since  1.0.0
 * @return array
 */
function get_mandatory_fields() {
	$fields = array( 'fe-post-title', 'fe-post-content', 'fe-post-image', 'fe-post-excerpt', 'fe-post-type' );
	return apply_filters( 'fes_mandatory_post_fields', $fields );
}

/**
 * Get details for email after post success.
 *
 * @since  1.0.0
 * @return array
 */
function get_email_details() {
	$email_details                 = array();
	$email_details['headers']      = array( 'Content-Type: text/html; charset=UTF-8' );
	$email_details['to']           = sanitize_email( get_option( 'admin_email' ) );
	$email_details['subject']      = __( 'New post submission', 'fe-submission' );
	$email_details['message']      = __( 'Hello, <br><br> You have a new post submission. You can view the post here {post_url} . <br><br> You can approve or edit the post here {post_edit_url} . <br><br> ', 'fe-submission' );

	return apply_filters( 'fes_new_post_email_details', $email_details );

}