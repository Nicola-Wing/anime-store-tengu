<?php
/**
 * Plugin Name: AST Gutenberg Notice Block
 * Author: Vero, Ni
 * Description: A notice box with a few predefined styles that accepts arbitrary text input. Developed for AST Theme.
 * Version: 1.0
 */

// Load assets for wp-admin when editor is active
function ast_gutenberg_notice_block_admin() {
	wp_enqueue_script(
		'ast-gutenberg-notice-block-editor',
		plugins_url( 'block.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	);

	wp_enqueue_style(
		'ast-gutenberg-notice-block-editor',
		plugins_url( 'block.css', __FILE__ ),
		array()
	);
}
add_action( 'enqueue_block_editor_assets', 'ast_gutenberg_notice_block_admin' );

// Load assets for frontend
function ast_gutenberg_notice_block_frontend() {

	wp_enqueue_style(
		'ast-gutenberg-notice-block-editor',
		plugins_url( 'block.css', __FILE__ ),
		array()
	);
}
add_action( 'wp_enqueue_scripts', 'ast_gutenberg_notice_block_frontend' );

