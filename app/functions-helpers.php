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

function get_mandatory_fields() {
	$fields = array( 'fe-post-title', 'fe-post-content', 'fe-post-image', 'fe-post-excerpt', 'fe-post-type' );
	return apply_filters( 'fes_mandatory_post_fields', $fields );
}