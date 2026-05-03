<?php
/**
 * Sakher Hospitality theme functions
 */
defined( 'ABSPATH' ) || exit;

if ( ! defined( 'SAKHER_VERSION' ) ) {
	define( 'SAKHER_VERSION', '1.0.0' );
}

/* ─── Theme setup ─────────────────────────────────────────── */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form', 'gallery', 'caption', 'style', 'script' ] );
	add_theme_support( 'custom-logo', [
		'height'      => 96,
		'width'       => 320,
		'flex-height' => true,
		'flex-width'  => true,
	] );
	register_nav_menu( 'primary', __( 'Primary Navigation', 'sakher' ) );
	load_theme_textdomain( 'sakher', get_template_directory() . '/languages' );
} );

/* ─── Enqueue assets ──────────────────────────────────────── */
add_action( 'wp_enqueue_scripts', function () {
	// Google Fonts
	wp_enqueue_style(
		'sakher-fonts',
		'https://fonts.googleapis.com/css2?family=El+Messiri:wght@400;500;600;700&family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap',
		[],
		null
	);

	// Theme stylesheet
	wp_enqueue_style(
		'sakher-style',
		get_stylesheet_uri(),
		[ 'sakher-fonts' ],
		SAKHER_VERSION
	);

	// Theme JS
	wp_enqueue_script(
		'sakher-main',
		get_template_directory_uri() . '/assets/js/main.js',
		[],
		SAKHER_VERSION,
		true
	);

	// Pass REST URL + nonce to JS
	wp_localize_script( 'sakher-main', 'sakherTheme', [
		'apiUrl'    => esc_url_raw( rest_url( 'sakher/v1' ) ),
		'nonce'     => wp_create_nonce( 'wp_rest' ),
		'whatsapp'  => apply_filters( 'sakher_whatsapp_number', '966535563801' ),
	] );
} );

/* ─── Include modules ─────────────────────────────────────── */
require_once get_template_directory() . '/inc/leads.php';

/* ─── WhatsApp helper (used in templates) ────────────────── */
function sakher_whatsapp_number() {
	return apply_filters( 'sakher_whatsapp_number', '966535563801' );
}
function sakher_whatsapp_url() {
	return 'https://wa.me/' . sakher_whatsapp_number();
}

/* ─── Editor styles (optional) ────────────────────────────── */
add_action( 'after_setup_theme', function () {
	add_editor_style( 'style.css' );
} );
