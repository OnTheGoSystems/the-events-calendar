<?php

namespace Tribe\Events\Views\V2;

use Tribe__Context as Context;

class UrlTest extends \Codeception\TestCase\WPTestCase {

	/**
	 * @test
	 * it should be instantiatable
	 */
	public function it_should_be_instantiatable() {
		$sut = $this->make_instance();

		$this->assertInstanceOf( Url::class, $sut );
	}

	/**
	 * @return Url
	 */
	private function make_instance() {
		return new Url();
	}

	/**
	 * It should return default if view slug not found in URL
	 *
	 * @test
	 */
	public function should_return_default_if_view_slug_not_found_in_url() {
		$url = new Url( 'http://example.com' );
		$this->assertEquals( 'default', $url->get_view_slug() );
	}

	/**
	 * It should correctly read the view slug from the url if provided
	 *
	 * @test
	 * @dataProvider test_urls
	 */
	public function should_correctly_read_the_view_slug_from_the_url_if_provided( $test_url ) {
		$url = new Url( $test_url );
		$this->assertEquals( 'test', $url->get_view_slug() );
	}

	public function test_urls() {
		return [
			'w_slash'             => [ trailingslashit( home_url() ) . '/?view=test' ],
			'wo_slash'            => [ trailingslashit( home_url() ) . '?view=test' ],
			'w_other_args_first'  => [ trailingslashit( home_url() ) . '?view=test&foo=bar' ],
			'w_other_args_last'   => [ trailingslashit( home_url() ) . '?foo=bar&view=test' ],
			'w_other_args_middle' => [ trailingslashit( home_url() ) . '?foo=bar&view=test&bar=baz' ],
		];
	}

	public function get_query_arg_alias_of_data_set() {
		return [
			'empty_query_args'                => [ [], 'test', false ],
			'not_set_query_arg'               => [ [ 'animal' => 'camel', 'color' => 'yellow' ], 'car', false ],
			'set_query_arg_w_first_location'  => [
				[ 'carriage' => 'golf', 'color' => 'yellow' ],
				'car',
				'carriage',
			],
			'set_query_arg_w_second_location' => [
				[ 'vehicle' => 'golf', 'color' => 'yellow' ],
				'car',
				'vehicle',
			],
			'set_query_arg_w_third_location'  => [
				[ 'transport' => 'golf', 'color' => 'yellow' ],
				'car',
				'transport',
			],
			'set_query_arg_w_key_name'        => [
				[ 'car' => 'golf', 'color' => 'yellow' ],
				'car',
				'car',
			],
			'set_query_arg_and_other_w_same_value'        => [
				[ 'game' => 'golf', 'color' => 'yellow', 'transport' => 'golf', ],
				'car',
				'transport',
			],
		];
	}
	/**
	 * Test get_query_arg_alias_of
	 *
	 * @dataProvider  get_query_arg_alias_of_data_set
	 */
	public function test_get_query_arg_alias_of($query_args,$key, $expected) {
		$url = new Url( add_query_arg( $query_args, home_url( '/foo/bar' ) ) );
		/** @var Context $context */
		$context = tribe_context()->set_locations( [
			'car' => [
				'read' => [
					Context::QUERY_VAR => [ 'carriage', 'vehicle', 'transport' ],
				],
			],
		], false );

		$found = $url->get_query_arg_alias_of( $key, $context );

		$this->assertEquals( $expected, $found );
	}

	/**
	 * It should build the URL as __construct would when providing empty params
	 *
	 * @test
	 */
	public function should_build_the_url_as_construct_would_when_providing_empty_params() {
		$input_url     = add_query_arg( [ 'one' => 23, 'two' => 89 ], home_url( '/foo/bar' ) );
		$construct_url = new Url( $input_url );
		$params_url    = Url::from_url_and_params( $input_url, [] );

		$this->assertEquals( (string) $construct_url, (string) $params_url );
	}

	/**
	 * It should update the URL when providing tribe-bar- view data
	 *
	 * @test
	 */
	public function should_update_the_url_when_providing_tribe_bar_view_data() {
		$input_url     = add_query_arg( [
			'tribe-bar-location' => 'paris' ,
			'tribe-bar-date' => '2019-03-23' ,
		], home_url( '/foo/bar' ) );
		$construct_url = new Url( $input_url );
		$params_url    = Url::from_url_and_params( $input_url, [
			'view_data' => [
				'tribe-bar-location' => 'cairo',
				'tribe-bar-date' => '',
			],
		] );

		$this->assertNotEquals( (string) $construct_url, (string) $params_url );
		$expected = add_query_arg( [ 'tribe-bar-location' => 'cairo' ], home_url( '/foo/bar' ) );
		$this->assertEquals( $expected, (string) $params_url );
	}
}