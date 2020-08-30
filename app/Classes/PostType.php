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
class PostType implements Bootable {

	/**
	 * Initiates the class.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {
		add_filter( 'post_updated_messages',  array( $this, 'guest_post_updated_messages' ) );
		add_action( 'init',  array( $this, 'guest_post_init' ) );

	}

	/**
	 * Registers the `guest_post` post type.
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function guest_post_init() {
		register_post_type( 'guest-post', array(
			'labels'                => array(
				'name'                  => __( 'Guest Posts', 'fe-submission' ),
				'singular_name'         => __( 'Guest Posts', 'fe-submission' ),
				'all_items'             => __( 'All Guest Posts', 'fe-submission' ),
				'archives'              => __( 'Guest Posts Archives', 'fe-submission' ),
				'attributes'            => __( 'Guest Posts Attributes', 'fe-submission' ),
				'insert_into_item'      => __( 'Insert into Guest Posts', 'fe-submission' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Guest Posts', 'fe-submission' ),
				'featured_image'        => _x( 'Featured Image', 'guest-post', 'fe-submission' ),
				'set_featured_image'    => _x( 'Set featured image', 'guest-post', 'fe-submission' ),
				'remove_featured_image' => _x( 'Remove featured image', 'guest-post', 'fe-submission' ),
				'use_featured_image'    => _x( 'Use as featured image', 'guest-post', 'fe-submission' ),
				'filter_items_list'     => __( 'Filter Guest Posts list', 'fe-submission' ),
				'items_list_navigation' => __( 'Guest Posts list navigation', 'fe-submission' ),
				'items_list'            => __( 'Guest Posts list', 'fe-submission' ),
				'new_item'              => __( 'New Guest Posts', 'fe-submission' ),
				'add_new'               => __( 'Add New', 'fe-submission' ),
				'add_new_item'          => __( 'Add New Guest Posts', 'fe-submission' ),
				'edit_item'             => __( 'Edit Guest Posts', 'fe-submission' ),
				'view_item'             => __( 'View Guest Posts', 'fe-submission' ),
				'view_items'            => __( 'View Guest Posts', 'fe-submission' ),
				'search_items'          => __( 'Search Guest Posts', 'fe-submission' ),
				'not_found'             => __( 'No Guest Posts found', 'fe-submission' ),
				'not_found_in_trash'    => __( 'No Guest Posts found in trash', 'fe-submission' ),
				'parent_item_colon'     => __( 'Parent Guest Posts:', 'fe-submission' ),
				'menu_name'             => __( 'Guest Posts', 'fe-submission' ),
			),
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => array( 'title', 'editor' ),
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-admin-post',
			'show_in_rest'          => true,
			'rest_base'             => 'guest-post',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		) );

	}

	/**
	 * Sets the post updated messages for the `guest_post` post type.
	 *
	 * @since  1.0.0
	 * @param  array $messages Post updated messages.
	 * @return array Messages for the `guest_post` post type.
	 */
	public function guest_post_updated_messages( $messages ) {
		global $post;

		$permalink = \get_permalink( $post );

		$messages['guest-post'] = array(
			0  => '', // Unused. Messages start at index 1.
			/* translators: %s: post permalink */
			1  => sprintf( __( 'Guest Posts updated. <a target="_blank" href="%s">View Guest Posts</a>', 'fe-submission' ), esc_url( $permalink ) ),
			2  => __( 'Custom field updated.', 'fe-submission' ),
			3  => __( 'Custom field deleted.', 'fe-submission' ),
			4  => __( 'Guest Posts updated.', 'fe-submission' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Guest Posts restored to revision from %s', 'fe-submission' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			/* translators: %s: post permalink */
			6  => sprintf( __( 'Guest Posts published. <a href="%s">View Guest Posts</a>', 'fe-submission' ), esc_url( $permalink ) ),
			7  => __( 'Guest Posts saved.', 'fe-submission' ),
			/* translators: %s: post permalink */
			8  => sprintf( __( 'Guest Posts submitted. <a target="_blank" href="%s">Preview Guest Posts</a>', 'fe-submission' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
			/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
			9  => sprintf( __( 'Guest Posts scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Guest Posts</a>', 'fe-submission' ),
			date_i18n( __( 'M j, Y @ G:i', 'fe-submission' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
			/* translators: %s: post permalink */
			10 => sprintf( __( 'Guest Posts draft updated. <a target="_blank" href="%s">Preview Guest Posts</a>', 'fe-submission' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		);

		return $messages;
	}
}




