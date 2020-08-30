<?php
/**
 * Application class.
 *
 * This is the main class that is initiated first which has
 * everything necessary for the plugin to boot
 *
 * @package   FeSubmission
 * @author    bplv
 */

namespace FES\Core;

use FES\Interfaces\Bootable;

/**
 * Main Application Plugin Class.
 *
 * @since  1.0.0
 * @access public
 */
class Application implements Bootable {

	/**
	 * The current version of the plugin.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	const VERSION = '1.0.0';

	/**
	 * Array of classes to instanciate.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    array
	 */
	protected $classes = array();

	/**
	 * Initiates the class.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {
		$this->registerDefaultManagers();
		$this->registerManagers();
		$this->bootClasses();
	}

	/**
	 * Registers the classes.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param string $class Name of the class to register.
	 * @return void
	 */
	public function registerClass( $class ) {
		if ( is_string( $class ) ) {
			$class = $this->resolveManagers( $class );
		}
		$this->classes[] = $class;
	}

	/**
	 * Register default managers
	 *
	 * @since  1.0.0
	 * @access protected
	 * @return void
	 */
	protected function registerDefaultManagers() {
		array_map(
			function( $class ) {
				$this->registerClass( $class );
			},
			array(
				\FES\Manager\AdminManager::class,
				\FES\Manager\PublicManager::class,
			)
		);
	}

	/**
	 * Creates a new instance of a manager class.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @param string $class Name of the class to resolve.
	 * @return object
	 */
	protected function resolveManagers( $class ) {
		return new $class( $this );
	}

	/**
	 * Resolve the classes.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @param string $class Name of the class to resolve.
	 * @return object
	 */
	public function resolve( $class ) {
		return new $class();
	}

	/**
	 * Calls a `boot()` method if it exists.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @param string $class Name of the class to boot.
	 * @return void
	 */
	protected function bootClass( $class ) {
		if ( method_exists( $class, 'boot' ) ) {
			$class->boot();
		}
	}

	/**
	 * Calls a `register()` method if it exists.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @param string $class Name of the class to boot.
	 * @return void
	 */
	protected function registerManager( $class ) {
		if ( method_exists( $class, 'register' ) ) {
			$class->register();
		}
	}

	/**
	 * Returns an array of classes.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @return array
	 */
	protected function getClasses() {
		return $this->classes;
	}

	/**
	 * Calls the `register()`
	 *
	 * @since  1.0.0
	 * @access protected
	 * @return void
	 */
	protected function registerManagers() {
		foreach ( $this->getClasses() as $class ) {
			$this->registerManager( $class );
		}
	}

	/**
	 * Calls the `boot()` method
	 *
	 * @since  1.0.0
	 * @access protected
	 * @return void
	 */
	protected function bootClasses() {
		foreach ( $this->getClasses() as $class ) {
			$this->bootClass( $class );
		}
	}

}
