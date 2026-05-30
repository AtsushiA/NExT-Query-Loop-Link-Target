<?php
/**
 * Unit tests for nqllt_render_query_block().
 */

namespace NExT\QueryLoopLinkTarget\Tests\Unit;

use Yoast\WPTestUtils\BrainMonkey\TestCase;

/**
 * Tests for nqllt_render_query_block().
 */
class RenderQueryBlockTest extends TestCase {

	/**
	 * nqlltOpenInNewTab が false の場合はコンテンツをそのまま返す.
	 */
	public function test_returns_content_unchanged_when_attr_is_false(): void {
		require_once dirname( __DIR__, 3 ) . '/nqllt.php';

		$html  = '<a href="/page">リンク</a>';
		$block = array( 'attrs' => array( 'nqlltOpenInNewTab' => false ) );

		$result = nqllt_render_query_block( $html, $block, null );

		$this->assertSame( $html, $result );
	}

	/**
	 * nqlltOpenInNewTab が true の場合はリンクに target="_blank" を付与する.
	 */
	public function test_adds_target_blank_when_attr_is_true(): void {
		require_once dirname( __DIR__, 3 ) . '/nqllt.php';

		$html  = '<a href="/page">リンク</a>';
		$block = array( 'attrs' => array( 'nqlltOpenInNewTab' => true ) );

		$result = nqllt_render_query_block( $html, $block, null );

		$this->assertStringContainsString( 'target="_blank"', $result );
		$this->assertStringContainsString( 'rel="noopener noreferrer"', $result );
	}

	/**
	 * すでに target 属性があるリンクは target="_blank" に置換される.
	 */
	public function test_replaces_existing_target_attribute(): void {
		require_once dirname( __DIR__, 3 ) . '/nqllt.php';

		$html  = '<a href="/page" target="_self">リンク</a>';
		$block = array( 'attrs' => array( 'nqlltOpenInNewTab' => true ) );

		$result = nqllt_render_query_block( $html, $block, null );

		$this->assertStringContainsString( 'target="_blank"', $result );
		$this->assertStringNotContainsString( 'target="_self"', $result );
	}
}
