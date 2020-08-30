<?php
/**
 * Bootable interface.
 *
 * Defines the contract that bootable classes should utilize. Bootable classes
 * should have a `boot()` method with the singular purpose of "booting" the
 * action and filter hooks for that class. This keeps action/filter calls out of
 * the class constructor. Most bootable classes are meant to be single-instance
 * classes that get loaded once per page request.
 * Derived from HybridFramework because this
 * is of great convinience and easy to manage
 *
 * @package   FeSubmission
 * @author    bplv
 */

namespace FES\Interfaces;

/**
 * Bootable interface.
 *
 * @since  1.0.0
 * @access public
 */
interface Bootable {

	/**
	 * Boots the class by running `add_action()` and `add_filter()` calls.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function boot();
}
