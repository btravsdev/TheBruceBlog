<?php
/** Asset loading for chesperry. */
defined( 'ABSPATH' ) || exit;

function chesperry_setup() {
	add_editor_style( 'assets/css/chesperry.css' );
}
add_action( 'after_setup_theme', 'chesperry_setup' );

/** Load Adobe fonts in both the front end and block-editor content. */
function chesperry_fonts() {
	wp_enqueue_style( 'chesperry-adobe-fonts', 'https://use.typekit.net/pto1oll.css', array(), null );
}
add_action( 'enqueue_block_assets', 'chesperry_fonts' );

function chesperry_styles() {
	$file = 'assets/css/chesperry.css';
	wp_enqueue_style( 'chesperry', get_theme_file_uri( $file ), array(), (string) filemtime( get_theme_file_path( $file ) ) );
}
add_action( 'wp_enqueue_scripts', 'chesperry_styles' );

/** Header site title → sleepy-baby logo only. Footer title stays text. */
function chesperry_header_logo( $block_content, $block ) {
	$class = $block['attrs']['className'] ?? '';
	if ( ! str_contains( $class, 'chesperry-logo' ) ) {
		return $block_content;
	}

	$home = esc_url( home_url( '/' ) );
	$src  = esc_url( get_theme_file_uri( 'assets/images/bruce-sleepy-baby-icon.svg' ) );
	$name = esc_attr( get_bloginfo( 'name', 'display' ) );

	return sprintf(
		'<p class="wp-block-site-title chesperry-logo"><a href="%1$s" rel="home"><img src="%2$s" alt="%3$s" width="56" height="56" decoding="async" /></a></p>',
		$home,
		$src,
		$name
	);
}
add_filter( 'render_block_core/site-title', 'chesperry_header_logo', 10, 2 );

/** Point the header search icon at the real search URL. */
function chesperry_header_search_link( $block_content, $block ) {
	if ( ( $block['blockName'] ?? '' ) !== 'core/html' || ! str_contains( $block_content, 'chesperry-search' ) ) {
		return $block_content;
	}

	return preg_replace(
		'/href="[^"]*"/',
		'href="' . esc_url( home_url( '/?s=' ) ) . '"',
		$block_content,
		1
	);
}
add_filter( 'render_block', 'chesperry_header_search_link', 10, 2 );

/** Theme favicon from sleepy-baby assets; skips if a Site Icon is set in WP. */
function chesperry_favicon() {
	if ( has_site_icon() ) {
		return;
	}

	$svg = esc_url( get_theme_file_uri( 'assets/images/bruce-sleepy-baby-icon.svg' ) );
	$png = esc_url( get_theme_file_uri( 'assets/images/bruce-sleepy-baby-icon-32.png' ) );
	$touch = esc_url( get_theme_file_uri( 'assets/images/bruce-sleepy-baby-icon-64.png' ) );

	printf( '<link rel="icon" href="%s" sizes="32x32" />' . "\n", $png );
	printf( '<link rel="icon" href="%s" type="image/svg+xml" />' . "\n", $svg );
	printf( '<link rel="apple-touch-icon" href="%s" />' . "\n", $touch );
}
add_action( 'wp_head', 'chesperry_favicon', 2 );
