<?php
/**
 * Demo data seeding.
 *
 * @package PACIPNUIPPNu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function pacipnuippnu_create_demo_page( $slug, $title, $content, $template = '' ) {
	$page = get_page_by_path( $slug );
	if ( $page ) {
		return (int) $page->ID;
	}

	$page_id = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_content' => $content,
		)
	);

	if ( $page_id && ! is_wp_error( $page_id ) && $template ) {
		update_post_meta( $page_id, '_wp_page_template', $template );
	}

	return (int) $page_id;
}

function pacipnuippnu_seed_demo_data() {
	if ( get_option( 'pacipnuippnu_demo_seeded' ) ) {
		return;
	}

	$home_id = pacipnuippnu_create_demo_page( 'beranda', 'Beranda', 'Halaman depan otomatis menggunakan front-page.php.' );
	$blog_id = pacipnuippnu_create_demo_page( 'berita', 'Berita', 'Arsip berita organisasi PAC IPNU IPPNU.' );
	pacipnuippnu_create_demo_page( 'profil-organisasi', 'Profil Organisasi', 'Profil lengkap organisasi PAC IPNU IPPNU.', 'page-templates/profil-organisasi.php' );
	pacipnuippnu_create_demo_page( 'login', 'Login Anggota', 'Halaman login anggota.', 'page-templates/login.php' );
	pacipnuippnu_create_demo_page( 'dashboard-anggota', 'Dashboard Anggota', 'Dashboard anggota.', 'page-templates/dashboard-anggota.php' );
	pacipnuippnu_create_demo_page( 'dashboard-pengurus', 'Dashboard Pengurus', 'Dashboard pengurus.', 'page-templates/dashboard-pengurus.php' );

	if ( $home_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}
	if ( $blog_id ) {
		update_option( 'page_for_posts', $blog_id );
	}

	if ( ! function_exists( 'wp_create_category' ) ) {
    	require_once ABSPATH . 'wp-admin/includes/taxonomy.php';
	}

	$category_id = wp_create_category( 'Kabar Organisasi' );
	$posts       = array(
		array( 'Rapat Koordinasi PAC IPNU IPPNU', 'Rapat koordinasi menjadi ruang menyatukan program kerja, pembagian tugas, dan agenda kaderisasi pelajar NU di tingkat kecamatan.' ),
		array( 'Pelatihan Administrasi dan Digitalisasi Organisasi', 'Kegiatan ini menguatkan kapasitas pengurus dalam pengelolaan arsip, publikasi digital, dan pelayanan administrasi anggota.' ),
		array( 'Makesta dan Penguatan Ideologi Pelajar NU', 'Makesta diselenggarakan sebagai pintu awal kaderisasi, pengenalan nilai keaswajaan, dan pembentukan karakter pelajar.' ),
	);

	foreach ( $posts as $item ) {
		if ( ! get_page_by_title( $item[0], OBJECT, 'post' ) ) {
			wp_insert_post(
				array(
					'post_type'    => 'post',
					'post_status'  => 'publish',
					'post_title'   => $item[0],
					'post_content' => $item[1] . "\n\n" . 'Konten dummy ini dapat diganti melalui editor WordPress sesuai kebutuhan publikasi organisasi.',
					'post_excerpt' => $item[1],
					'post_category' => array( $category_id ),
				)
			);
		}
	}

	$agenda_items = array(
		array( 'Makesta Raya PAC', '+10 days', '08:00', 'Aula Kecamatan', 'upcoming' ),
		array( 'Rapat Kerja Pengurus', '+20 days', '19:30', 'Sekretariat PAC', 'upcoming' ),
		array( 'Ziarah dan Bakti Sosial', '+32 days', '06:30', 'Rute makam ulama setempat', 'upcoming' ),
	);

	foreach ( $agenda_items as $item ) {
		if ( ! get_page_by_title( $item[0], OBJECT, 'agenda' ) ) {
			$id = wp_insert_post(
				array(
					'post_type'    => 'agenda',
					'post_status'  => 'publish',
					'post_title'   => $item[0],
					'post_content' => 'Agenda contoh untuk kalender kegiatan PAC IPNU IPPNU.',
				)
			);
			update_post_meta( $id, '_pac_agenda_date', gmdate( 'Y-m-d', strtotime( $item[1] ) ) );
			update_post_meta( $id, '_pac_agenda_time', $item[2] );
			update_post_meta( $id, '_pac_agenda_location', $item[3] );
			update_post_meta( $id, '_pac_agenda_status', $item[4] );
		}
	}

	if ( ! get_page_by_title( 'Dokumentasi Makesta', OBJECT, 'galeri' ) ) {
		wp_insert_post(
			array(
				'post_type'    => 'galeri',
				'post_status'  => 'publish',
				'post_title'   => 'Dokumentasi Makesta',
				'post_content' => 'Galeri contoh kegiatan kaderisasi pelajar NU.',
			)
		);
	}

	if ( ! get_page_by_title( 'AD ART Organisasi', OBJECT, 'arsip' ) ) {
		$id = wp_insert_post(
			array(
				'post_type'    => 'arsip',
				'post_status'  => 'publish',
				'post_title'   => 'AD ART Organisasi',
				'post_content' => 'Dokumen dasar organisasi yang dapat diunduh oleh anggota.',
			)
		);
		update_post_meta( $id, '_pac_archive_type', 'PDF' );
		update_post_meta( $id, '_pac_archive_number', '001/ARSIP/PAC' );
		update_post_meta( $id, '_pac_archive_file_url', home_url( '/wp-content/uploads/contoh-ad-art.pdf' ) );
	}

	$menu_id = wp_create_nav_menu( 'Menu Utama PAC' );
	if ( ! is_wp_error( $menu_id ) ) {
		$links = array(
			array( 'Beranda', home_url( '/' ) ),
			array( 'Profil', home_url( '/profil-organisasi/' ) ),
			array( 'Berita', home_url( '/berita/' ) ),
			array( 'Agenda', get_post_type_archive_link( 'agenda' ) ?: home_url( '/agenda/' ) ),
			array( 'Galeri', get_post_type_archive_link( 'galeri' ) ?: home_url( '/galeri/' ) ),
			array( 'Arsip', get_post_type_archive_link( 'arsip' ) ?: home_url( '/arsip/' ) ),
		);
		foreach ( $links as $link ) {
			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title'  => $link[0],
					'menu-item-url'    => $link[1],
					'menu-item-status' => 'publish',
				)
			);
		}
		$locations            = get_theme_mod( 'nav_menu_locations', array() );
		$locations['primary'] = $menu_id;
		$locations['footer']  = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	update_option( 'pacipnuippnu_demo_seeded', 1 );
}
add_action( 'after_switch_theme', 'pacipnuippnu_seed_demo_data', 20 );
