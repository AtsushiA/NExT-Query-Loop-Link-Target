<?php
/**
 * Plugin Name: NExT Query Loop Link Target
 * Description: クエリーループブロックにリンクを target="_blank" で開くコントロールを追加します。
 * Version:     1.0.0
 * Author:      NExT-Season
 * Author URI: https://next-season.net
 * License:     GPL-2.0-or-later
 * Text Domain: nqllt
 * Domain Path: /languages
 * Requires at least: 6.1
 * Requires PHP:      7.4
 *
 * @package NExT_Query_Loop_Link_Target
 */

defined( 'ABSPATH' ) || exit;

/**
 * エディター用スクリプトを登録する。
 */
function nqllt_register_scripts() {
	$asset_file = plugin_dir_path( __FILE__ ) . 'build/index.asset.php';

	if ( ! file_exists( $asset_file ) ) {
		return;
	}

	$asset = require $asset_file;

	wp_register_script(
		'nqllt-editor',
		plugin_dir_url( __FILE__ ) . 'build/index.js',
		$asset['dependencies'],
		$asset['version'],
		true
	);

	wp_set_script_translations( 'nqllt-editor', 'nqllt' );
}
add_action( 'init', 'nqllt_register_scripts' );

/**
 * エディター用スクリプトをエンキューする。
 */
function nqllt_enqueue_editor_scripts() {
	wp_enqueue_script( 'nqllt-editor' );
}
add_action( 'enqueue_block_editor_assets', 'nqllt_enqueue_editor_scripts' );

/**
 * クエリーループブロックのレンダリング時に、
 * nqlltOpenInNewTab 属性が true の場合、すべてのリンクに
 * target="_blank" rel="noopener noreferrer" を付与する。
 *
 * @param string   $block_content レンダリング済み HTML.
 * @param array    $block         ブロックデータ.
 * @param WP_Block $instance      ブロックインスタンス.
 * @return string 加工済み HTML.
 */
function nqllt_render_query_block( $block_content, $block, $instance ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	if ( ( $block['attrs']['nqlltOpenInNewTab'] ?? false ) !== true ) {
		return $block_content;
	}

	$block_content = preg_replace_callback(
		'/<a\b([^>]*)>/i',
		static function ( $matches ) {
			$attrs = $matches[1];

			// すでに target 属性がある場合は値を _blank に置換する.
			// （core/post-title などが target="_self" を付与するため上書きが必要）.
			if ( preg_match( '/\btarget\s*=/i', $attrs ) ) {
				$attrs = preg_replace(
					'/\btarget\s*=\s*(?:"[^"]*"|\'[^\']*\'|\S+)/i',
					'target="_blank"',
					$attrs
				);
				// rel がない場合は noopener noreferrer を追加する（reverse tabnabbing 対策）.
				if ( ! preg_match( '/\brel\s*=/i', $attrs ) ) {
					$attrs .= ' rel="noopener noreferrer"';
				}
				return '<a' . $attrs . '>';
			}

			// rel 属性がない場合は noopener noreferrer を追加する.
			if ( ! preg_match( '/\brel\s*=/i', $attrs ) ) {
				return '<a' . $attrs . ' target="_blank" rel="noopener noreferrer">';
			}

			return '<a' . $attrs . ' target="_blank">';
		},
		$block_content
	);

	return $block_content;
}
add_filter( 'render_block_core/query', 'nqllt_render_query_block', 10, 3 );
