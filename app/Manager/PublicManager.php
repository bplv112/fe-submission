<?php
/**
 * Public manager class.
 *
 * This is the main class that handles the classes for Admin.
 *
 * @package   FeSubmission
 * @author    bplv
 */

namespace FES\Manager;

use FES\Abstracts\Manager;

/**
 * Public Manager.
 *
 * @since  1.0.0
 * @access public
 */
class PublicManager extends Manager {

	/**
	 * Boot the classes that are handled by this manager.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {
		// Boot the Admin class instance.
		self::$classes['Form']->boot();
		self::$classes['PostList']->boot();
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
		self::$classes['Form'] = $this->app->resolve( \FES\Classes\Form::class );
		self::$classes['PostList'] = $this->app->resolve( \FES\Classes\PostList::class );

	}
}
