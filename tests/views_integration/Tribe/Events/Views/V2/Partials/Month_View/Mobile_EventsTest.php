<?php

namespace Tribe\Events\Views\V2\Partials\Month_View;

use Tribe\Test\PHPUnit\Traits\With_Post_Remapping;
use Tribe\Test\Products\WPBrowser\Views\V2\HtmlPartialTestCase;

class Mobile_EventsTest extends HtmlPartialTestCase
{
	use With_Post_Remapping;

	protected $partial_path = 'month/mobile-events';

	/**
	 * Test render with empty days
	 */
	public function test_render_with_empty_days() {
		$this->assertMatchesSnapshot( $this->get_partial_html( [
			'days'       => [],
			'today_url'  => 'http://test.tri.be',
			'prev_url'   => 'http://test.tri.be',
			'next_url'   => 'http://test.tri.be',
			'prev_label' => 'May',
			'next_label' => 'July',
		] ) );
	}

	/**
	 * Test render with days with no found events
	 */
	public function test_render_with_days_with_no_found_events() {
		$this->assertMatchesSnapshot( $this->get_partial_html( [
			'days'       => [
				'2018-06-01' => [
					'found_events' => 0,
				],
				'2018-06-02' => [
					'found_events' => 0,
				],
			],
			'today_url'  => 'http://test.tri.be',
			'prev_url'   => 'http://test.tri.be',
			'next_url'   => 'http://test.tri.be',
			'prev_label' => 'May',
			'next_label' => 'July',
		] ) );
	}

	/**
	 * Test render with days with found events
	 */
	public function test_render_with_days_with_found_events() {
		$event_1 = $this->get_mock_event( 'events/featured/1.json' );
		$event_2 = $this->get_mock_event( 'events/single/1.json' );
		$this->assertMatchesSnapshot( $this->get_partial_html( [
			'days'       => [
				'2018-06-20' => [
					'found_events'    => 2,
					'year_number'     => '2018',
					'month_number'    => '06',
					'day_number'      => '20',
					'events'          => [],
					'multiday_events' => [
						$event_1,
						$event_2,
					],
				],
			],
			'today_date'       => '2018-06-01',
			'today_url'        => 'http://test.tri.be',
			'prev_url'         => 'http://test.tri.be',
			'next_url'         => 'http://test.tri.be',
			'prev_label'       => 'May',
			'next_label'       => 'July',
		] ) );
	}
}
