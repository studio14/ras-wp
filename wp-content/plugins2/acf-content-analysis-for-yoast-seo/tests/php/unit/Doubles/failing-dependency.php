<?php

namespace Yoast\AcfAnalysis\Tests\Doubles;

/**
 * Class Failing_Dependency
 */
class Failing_Dependency implements \Yoast_ACF_Analysis_Dependency {

	/**
	 * Checks if this dependency is met.
	 *
	 * @return bool True when met, false when not met.
	 */
	public function is_met() {
		return false;
	}

	/**
	 * Registers the notifications to communicate the depedency is not met.
	 *
	 * @return void
	 */
	public function register_notifications() {
	}
}
