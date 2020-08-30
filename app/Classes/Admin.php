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

}
