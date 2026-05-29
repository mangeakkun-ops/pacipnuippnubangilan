<?php
/**
 * Asset enqueue.
 *
 * @package PACIPNUIPPNu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function pacipnuippnu_enqueue_assets() {
	wp_enqueue_style( 'pacipnuippnu-style', get_stylesheet_uri(), array(), PACIPNUIPPNu_VERSION );
	wp_enqueue_style( 'pacipnuippnu-main', PACIPNUIPPNu_URI . 'assets/css/main.css', array(), PACIPNUIPPNu_VERSION );
	wp_enqueue_style( 'pacipnuippnu-dashboard', PACIPNUIPPNu_URI . 'assets/css/dashboard.css', array( 'pacipnuippnu-main' ), PACIPNUIPPNu_VERSION );

	wp_enqueue_script( 'pacipnuippnu-main', PACIPNUIPPNu_URI . 'assets/js/main.js', array(), PACIPNUIPPNu_VERSION, true );
	wp_enqueue_script( 'pacipnuippnu-dashboard', PACIPNUIPPNu_URI . 'assets/js/dashboard.js', array( 'pacipnuippnu-main' ), PACIPNUIPPNu_VERSION, true );

	wp_localize_script(
		'pacipnuippnu-main',
		'pacTheme',
		array(
			'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'pacipnuippnu_nonce' ),
			'homeUrl'  => home_url( '/' ),
			'i18n'     => array(
				'loading' => __( 'Memproses...', 'pac-ipnu-ippnu' ),
				'success' => __( 'Berhasil diproses.', 'pac-ipnu-ippnu' ),
				'error'   => __( 'Terjadi kendala. Periksa kembali data Anda.', 'pac-ipnu-ippnu' ),
			),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'pacipnuippnu_enqueue_assets' );

function pacipnuippnu_preload_assets() {
	printf(
		'<link rel="preload" href="%s" as="image" type="image/svg+xml">',
		esc_url( PACIPNUIPPNu_URI . 'assets/images/hero-bg.svg' )
	);
}
add_action( 'wp_head', 'pacipnuippnu_preload_assets', 1 );

