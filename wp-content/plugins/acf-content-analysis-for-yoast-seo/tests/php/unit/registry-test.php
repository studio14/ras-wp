<?php

namespace Yoast\AcfAnalysis\Tests\Configuration;

/**
 * Class Registry_Test
 */
class Registry_Test extends \PHPUnit_Framework_TestCase {

	/**
	 * Tests that the singleton instance is properly set and that every call to the registry, is the same instance.
	 *
	 * Also checks that the content is the same when adding items to the registry and calling the instance.
	 *
	 * @return void
	 */
	public function testSingleton() {

		$first  = \Yoast_ACF_Analysis_Facade::get_registry();
		$second = \Yoast_ACF_Analysis_Facade::get_registry();

		$this->assertSame( $first, $second );

		$first->add(
			'id',
			new \Yoast_ACF_Analysis_Configuration(
				new \Yoast_ACF_Analysis_String_Store(),
				new \Yoast_ACF_Analysis_String_Store(),
				new \Yoast_ACF_Analysis_String_Store()
			)
		);

		$this->assertSame( $first, $second );
	}

	/**
	 * Tests that adding a non-existing item to the registy, succeeds and that the item can be found based on its ID.
	 *
	 * @return void
	 */
	public function testAdd() {

		$id      = 'add';
		$content = 'something';

		$registry = new \Yoast_ACF_Analysis_Registry();

		$this->assertNull( $registry->get( $id ) );

		$registry->add( $id, $content );

		$this->assertSame( $content, $registry->get( $id ) );
	}
}
