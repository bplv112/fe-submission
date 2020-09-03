<?php
/**
 * Front-end post list class.
 *
 * This is the place where we handle front end post list.
 *
 * @package   FeSubmission
 * @author    bplv
 */

namespace FES\Classes;

use FES\Interfaces\Bootable;
use FES\Manager\AdminManager;


/**
 * Plugin Class handling post list.
 *
 * @since  1.0.0
 * @access public
 */
class PostList implements Bootable {

	/**
	 * Initiates the class.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {
		add_shortcode( 'display_fe_post_list', array( $this, 'list_post' ) );
	}

	/**
	 * List the pending review posts.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function list_post() {
		$params = array();

		if( ! $this->has_caps() ){
			return;
		}

		$params['post_params'] = $this->get_posts_query();
		AdminManager::$classes['Admin']->render( 'list', $params );
	}

	/**
	 * Check if we have cap to show the shortcode.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return bool
	 */
	public function has_caps() {
		$user  = \wp_get_current_user();
		$roles = array( 'administrator', 'author' );
		$current_user_cap = ( count( array_intersect( $roles, (array) $user->roles ) ) > 0 );

		// Current we're only checking for author & admin role.
		// For extending you can use this feature to check caps.
		$user_role = apply_filters( 'fes_extend_user_role_page_list', $current_user_cap , $user );

		if( is_user_logged_in() && $user_role ) {
			return true;
		}

		return false;
	}

	/**
	 * Get posts.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public function get_posts_query() {
		$posts_per_page = apply_filters( 'fes_post_per_page_list', 10 );
		$post_args = array(
			'meta_key'       => 'is_fes_draft',
			'post_type'      => 'any',
			'post_status'    => 'draft',
			'posts_per_page' => $posts_per_page,
			'orderby' 		 => 'date',
            'order'   		 => 'ASC',
		);

		$user = \wp_get_current_user();

		// Current we're only checking for author role.
		// For extending you can use this feature to check caps.
		$user_role = apply_filters( 'fes_extend_user_role', in_array( 'author', (array) $user->roles ) );
		if( in_array( 'author', (array) $user->roles ) ) {
			$post_args['author'] = get_current_user_id();
		}

		return $post_args;
	}

	/**
	 * Get Pagination.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public static function pagination(  $max_page = '' )
	{
		global $wp_query;

		$paged = isset( $_GET['fes-list-page'] ) ? absint( $_GET['fes-list-page'] ) : 1;

		if( ! $max_page ) {
			$max_page = $wp_query->max_num_pages;
		}

		echo \paginate_links( array(
			'base'       => esc_url_raw( add_query_arg( 'fes-list-page', '%#%', false ) ),
			'format'     => '?fes-list-page=%#%',
			'current'    => max( 1, $paged ),
			'total'      => $max_page,
			'mid_size'   => 1,
			'prev_text'  => __('←'),
			'next_text'  => __('→'),
			'type'       => 'list'
		) );
	}

}