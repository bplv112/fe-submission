<?php
/**
 * Admin manager class.
 *
 * This is the main class that handles the classes for Admin.
 *
 * @package   FeSubmission
 * @author    bplv
 */

namespace FES\Manager;

use FES\Abstracts\Manager;

/**
 * Admin Manager.
 *
 * @since  1.0.0
 * @access public
 */
class AdminManager extends Manager {

	/**
	 * Boot the classes that are handled by this manager.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {
		// Boot the Admin class instance.
		self::$classes['Admin']->boot();

		// Boot the PostType class instance.
		self::$classes['PostType']->boot();
	}

	/**
	 * Register the classes that are handled by the manager.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register() {
		// Register the Admin Interface class instance.
		self::$classes['Admin'] = $this->app->resolve( \FES\Classes\Admin::class );

		// Register the Options class instance.
		self::$classes['PostType'] = $this->app->resolve( \FES\Classes\PostType::class );

	}
}
