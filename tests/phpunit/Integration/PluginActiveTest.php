<?php
/**
 * Integration tests for the NQLLT plugin.
 */

namespace NExT\QueryLoopLinkTarget\Tests\Integration;

use WP_UnitTestCase;

/**
 * Tests for basic plugin loading.
 */
class PluginActiveTest extends WP_UnitTestCase {

	/**
	 * プラグインのメイン関数が定義されている（bootstrap でロード済み）.
	 */
	public function test_plugin_functions_are_defined(): void {
		$this->assertTrue( function_exists( 'nqllt_register_scripts' ) );
		$this->assertTrue( function_exists( 'nqllt_render_query_block' ) );
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
