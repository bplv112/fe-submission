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
use FES\Manager\PublicManager as PublicManager;

/**
 * Plugin Class handling admin pages.
 *
 * @since  1.0.0
 * @access public
 */
class Admin implements Bootable {

	/**
	 * Option name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $menu_page;

	/**
	 * Initiates the class.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {
	}

	/**
	 * Renders a view file with static call
	 *
	 * @param string     $file   The file to render.
	 * @param array      $params The params to send to view.
	 * @param bool|false $return Wether to render or return.
	 * @return void|string
	 */
	public function render( $file, $params = array(), $return = false ) {
		$params = array_merge( $params );
		$blc_template = $file;
		extract( $params, EXTR_OVERWRITE ); // phpcs:ignore

		if ( $return ) {
			ob_start();
		}

		$template_file = FES_TEMPLATE . $blc_template . '.php';

		if ( ! file_exists( $template_file ) ) {
			return;
		}

		// include the template if exists.
		include $template_file;

		if ( $return ) {
			return ob_get_clean();
		}

		if ( ! empty( $params ) ) {
			foreach ( $params as $param ) {
				unset( $param );
			}
		}
	}
}
