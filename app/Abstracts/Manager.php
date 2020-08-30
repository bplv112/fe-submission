<?php
/**
 * Base manager class.
 *
 * This is the base manager class.
 * Extend to create new dependent class for the application.
 *
 * @package   FeSubmission
 * @author    bplv
 */

namespace FES\Abstracts;

use FES\Core\Application;

/**
 * Manager class.
 *
 * @since  1.0.0
 * @access public
 */
abstract class Manager {

	/**
	 * Application instance.
	 * Since Application class is responsible for binding
	 * use that class to bind the managed classes
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    Application
	 */
	protected $app;

	/**
	 * Class instances.
	 * The instances of classes handled by this manager
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    Application
	 */
	public static $classes;

	/**
	 * Accepts the application and sets it to the `$app` property.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object Application $app Application class.
	 * @return void
	 */
	public function __construct( Application $app ) {
		$this->app = $app;
	}

	/**
	 * Boot the classes that are handled by the manager.
	 *
	 * We can use this to omit the construction.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {}

	/**
	 * Register the classes that are handled by the manager.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register() {}
}
