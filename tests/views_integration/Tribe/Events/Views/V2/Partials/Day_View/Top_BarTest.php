<?php

namespace Tribe\Events\Views\V2\Partials\Day_View;

use Tribe\Test\Products\WPBrowser\Views\V2\HtmlPartialTestCase;

class Top_BarTest extends HtmlPartialTestCase
{

	protected $partial_path = 'day/top-bar';

	/**
	 * Test render with context
	 */
	public function test_render_with_context() {
		$this->assertMatchesSnapshot( $this->get_partial_html( [
			'today_url' => '#',
		] ) );
	}
}
