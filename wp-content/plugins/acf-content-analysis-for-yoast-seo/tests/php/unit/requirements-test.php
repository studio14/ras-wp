<?php

namespace Yoast\AcfAnalysis\Tests\Configuration;

use Brain\Monkey;
use Brain\Monkey\Functions;
use Brain\Monkey\Filters;
use Yoast\AcfAnalysis\Tests\Doubles\Passing_Dependency;
use Yoast\AcfAnalysis\Tests\Doubles\Failing_Dependency;

/**
 * Class Requirements_Test
 */
class Requirements_Test extends \PHPUnit_Framework_TestCase {

	/**
	 * Sets up test fixtures.
	 */
	protected function setUp() {
		parent::setUp();
		Monkey\setUp();

		Functions\expect( 'current_user_can' )->andReturn( true );
	}

	/**
	 * Tears down test fixtures previously set up.
	 */
	protected function tearDown() {
		Monkey\tearDown();
		parent::tearDown();
	}

	/**
	 * Tests the situation where there are no dependencies.
	 *
	 * @return void
	 */
	public function testNoDependencies() {
		$testee = new \Yoast_ACF_Analysis_Requirements();
		$this->assertTrue( $testee->are_met() );
	}

	/**
	 * Tests that requirements are met when a valid dependency is added.
	 *
	 * @return void
	 */
	public function testPassingDependency() {
		$testee = new \Yoast_ACF_Analysis_Requirements();
		$testee->add_dependency( new Passing_Dependency() );

		$this->assertTrue( $testee->are_met() );
	}

	/**
	 * Tests that requirements are not met when an invalid dependency is added.
	 *
	 * @return void
	 */
	public function testFailingDependency() {
		$testee = new \Yoast_ACF_Analysis_Requirements();
		$testee->add_dependency( new Failing_Dependency() );

		$this->assertFalse( $testee->are_met() );
	}

	/**
	 * Tests that requirements are not met when a mix of valid and invalid dependencies are added.
	 *
	 * @return void
	 */
	public function testMixedDependencies() {
		$testee = new \Yoast_ACF_Analysis_Requirements();
		$testee->add_dependency( new Failing_Dependency() );
		$testee->add_dependency( new Passing_Dependency() );

		$this->assertFalse( $testee->are_met() );
	}
}
