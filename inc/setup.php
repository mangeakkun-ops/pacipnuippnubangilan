<?php
/**
 * Theme setup.
 *
 * @package PACIPNUIPPNu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function pacipnuippnu_setup() {
	load_theme_textdomain( 'pac-ipnu-ippnu', PACIPNUIPPNu_DIR . 'languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 96,
			'width'       => 96,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_image_size( 'pac-card', 720, 520, true );
	add_image_size( 'pac-hero', 1600, 900, true );
	add_image_size( 'pac-avatar', 360, 360, true );

	register_nav_menus(
		array(
			'primary'   => __( 'Menu Utama', 'pac-ipnu-ippnu' ),
			'footer'    => __( 'Menu Footer', 'pac-ipnu-ippnu' ),
			'dashboard' => __( 'Menu Dashboard', 'pac-ipnu-ippnu' ),
		)
	);
}
add_action( 'after_setup_theme', 'pacipnuippnu_setup' );

function pacipnuippnu_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar Berita', 'pac-ipnu-ippnu' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Widget untuk arsip, single post, dan pencarian.', 'pac-ipnu-ippnu' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer Kolom Tambahan', 'pac-ipnu-ippnu' ),
			'id'            => 'footer-extra',
			'description'   => __( 'Widget tambahan di area footer.', 'pac-ipnu-ippnu' ),
			'before_widget' => '<section id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'pacipnuippnu_widgets_init' );

function pacipnuippnu_excerpt_length( $length ) {
	return 24;
}
add_filter( 'excerpt_length', 'pacipnuippnu_excerpt_length' );

function pacipnuippnu_excerpt_more() {
	return '...';
}
add_filter( 'excerpt_more', 'pacipnuippnu_excerpt_more' );

