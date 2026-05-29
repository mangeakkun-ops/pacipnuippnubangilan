<?php
/**
 * Custom post types and taxonomies.
 *
 * @package PACIPNUIPPNu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function pacipnuippnu_register_post_types() {
	register_post_type(
		'agenda',
		array(
			'labels' => array(
				'name'          => __( 'Agenda', 'pac-ipnu-ippnu' ),
				'singular_name' => __( 'Agenda', 'pac-ipnu-ippnu' ),
				'add_new_item'  => __( 'Tambah Agenda', 'pac-ipnu-ippnu' ),
				'edit_item'     => __( 'Edit Agenda', 'pac-ipnu-ippnu' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'agenda' ),
			'menu_icon'    => 'dashicons-calendar-alt',
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author', 'comments' ),
			'show_in_rest' => true,
		)
	);

	register_post_type(
		'galeri',
		array(
			'labels' => array(
				'name'          => __( 'Galeri', 'pac-ipnu-ippnu' ),
				'singular_name' => __( 'Galeri', 'pac-ipnu-ippnu' ),
				'add_new_item'  => __( 'Tambah Galeri', 'pac-ipnu-ippnu' ),
				'edit_item'     => __( 'Edit Galeri', 'pac-ipnu-ippnu' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'galeri' ),
			'menu_icon'    => 'dashicons-format-gallery',
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author' ),
			'show_in_rest' => true,
		)
	);

	register_post_type(
		'arsip',
		array(
			'labels' => array(
				'name'          => __( 'Arsip Dokumen', 'pac-ipnu-ippnu' ),
				'singular_name' => __( 'Arsip', 'pac-ipnu-ippnu' ),
				'add_new_item'  => __( 'Tambah Arsip', 'pac-ipnu-ippnu' ),
				'edit_item'     => __( 'Edit Arsip', 'pac-ipnu-ippnu' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'arsip' ),
			'menu_icon'    => 'dashicons-media-document',
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author' ),
			'show_in_rest' => true,
		)
	);


	register_post_type(
		'pengurus',
		array(
			'labels' => array(
				'name'               => __( 'Struktur Pengurus', 'pac-ipnu-ippnu' ),
				'singular_name'      => __( 'Data Pengurus', 'pac-ipnu-ippnu' ),
				'menu_name'          => __( 'Struktur Pengurus', 'pac-ipnu-ippnu' ),
				'add_new'           => __( 'Tambah Data', 'pac-ipnu-ippnu' ),
				'add_new_item'       => __( 'Tambah Data Pengurus', 'pac-ipnu-ippnu' ),
				'edit_item'          => __( 'Edit Data Pengurus', 'pac-ipnu-ippnu' ),
				'new_item'           => __( 'Data Pengurus Baru', 'pac-ipnu-ippnu' ),
				'all_items'          => __( 'Semua Data Pengurus', 'pac-ipnu-ippnu' ),
				'view_item'          => __( 'Lihat Data Pengurus', 'pac-ipnu-ippnu' ),
				'search_items'       => __( 'Cari Data Pengurus', 'pac-ipnu-ippnu' ),
				'not_found'          => __( 'Belum ada pengurus', 'pac-ipnu-ippnu' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'exclude_from_search' => true,
			'menu_icon'           => 'dashicons-groups',
			'supports'            => array( 'title', 'page-attributes' ),
			'show_in_rest'        => true,
		)
	);

	register_post_type(
		'surat_request',
		array(
			'labels' => array(
				'name'          => __( 'Request Surat', 'pac-ipnu-ippnu' ),
				'singular_name' => __( 'Request Surat', 'pac-ipnu-ippnu' ),
				'add_new_item'  => __( 'Tambah Request Surat', 'pac-ipnu-ippnu' ),
				'edit_item'     => __( 'Kelola Request Surat', 'pac-ipnu-ippnu' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'exclude_from_search' => true,
			'capability_type'     => 'post',
			'menu_icon'           => 'dashicons-email-alt2',
			'supports'            => array( 'title', 'editor', 'author' ),
			'show_in_rest'        => false,
		)
	);
}
add_action( 'init', 'pacipnuippnu_register_post_types' );

function pacipnuippnu_register_taxonomies() {
	$taxonomies = array(
		'kategori_agenda' => array(
			'post_type' => 'agenda',
			'slug'      => 'kategori-agenda',
			'name'      => __( 'Kategori Agenda', 'pac-ipnu-ippnu' ),
			'singular'  => __( 'Kategori Agenda', 'pac-ipnu-ippnu' ),
		),
		'kategori_galeri' => array(
			'post_type' => 'galeri',
			'slug'      => 'kategori-galeri',
			'name'      => __( 'Kategori Galeri', 'pac-ipnu-ippnu' ),
			'singular'  => __( 'Kategori Galeri', 'pac-ipnu-ippnu' ),
		),
		'kategori_arsip'  => array(
			'post_type' => 'arsip',
			'slug'      => 'kategori-arsip',
			'name'      => __( 'Kategori Arsip', 'pac-ipnu-ippnu' ),
			'singular'  => __( 'Kategori Arsip', 'pac-ipnu-ippnu' ),
		),
	);

	foreach ( $taxonomies as $taxonomy => $config ) {
		register_taxonomy(
			$taxonomy,
			$config['post_type'],
			array(
				'labels'       => array(
					'name'          => $config['name'],
					'singular_name' => $config['singular'],
				),
				'hierarchical' => true,
				'public'       => true,
				'rewrite'      => array( 'slug' => $config['slug'] ),
				'show_in_rest' => true,
			)
		);
	}
}
add_action( 'init', 'pacipnuippnu_register_taxonomies' );

