<?php
/**
 * Integration tests for the NQLLT plugin.
 */

namespace NExT\QueryLoopLinkTarget\Tests\Integration;

use WP_UnitTestCase;

/**
 * Tests for basic plugin activation.
 */
class PluginActiveTest extends WP_UnitTestCase {

	/**
	 * プラグインが有効化されている.
	 */
	public function test_plugin_is_active(): void {
		$this->assertTrue(
			is_plugin_active( 'NExT-Query-Loop-Link-Target/nqllt.php' )
		);
	}

	/**
	 * render_block_core/query フィルターが登録されている.
	 */
	public function test_render_filter_is_registered(): void {
		$this->assertGreaterThan(
			0,
			has_filter( 'render_block_core/query', 'nqllt_render_query_block' )
		);
	}
}
