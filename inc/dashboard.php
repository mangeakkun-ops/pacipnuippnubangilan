<?php
/**
 * Dashboard helpers and export handlers.
 *
 * @package PACIPNUIPPNu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function pacipnuippnu_require_login() {
	if ( ! is_user_logged_in() ) {
		wp_safe_redirect( pacipnuippnu_login_url() );
		exit;
	}
}

function pacipnuippnu_require_manager() {
	pacipnuippnu_require_login();
	if ( ! pacipnuippnu_can_manage_organization() ) {
		wp_safe_redirect( pacipnuippnu_dashboard_url() );
		exit;
	}
}

function pacipnuippnu_get_member_requests( $user_id, $limit = -1 ) {
	return new WP_Query(
		array(
			'post_type'      => 'surat_request',
			'post_status'    => 'publish',
			'author'         => $user_id,
			'posts_per_page' => $limit,
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);
}

function pacipnuippnu_get_dashboard_counts() {
	$users = new WP_User_Query(
		array(
			'role__in' => array( 'anggota', 'pengurus' ),
			'fields'   => 'ID',
		)
	);

	return array(
		'anggota' => (int) $users->get_total(),
		'berita'  => (int) wp_count_posts( 'post' )->publish,
		'agenda'  => (int) wp_count_posts( 'agenda' )->publish,
		'galeri'  => (int) wp_count_posts( 'galeri' )->publish,
		'arsip'   => (int) wp_count_posts( 'arsip' )->publish,
	);
}

function pacipnuippnu_get_members( $limit = 20 ) {
	return get_users(
		array(
			'role__in' => array( 'anggota', 'pengurus' ),
			'number'   => $limit,
			'orderby'  => 'registered',
			'order'    => 'DESC',
		)
	);
}

function pacipnuippnu_export_members() {
	pacipnuippnu_require_manager();
	check_admin_referer( 'pac_export_members' );

	header( 'Content-Type: text/csv; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=anggota-pac-ipnu-ippnu.csv' );

	$output = fopen( 'php://output', 'w' );
	fputcsv( $output, array( 'ID', 'Nama', 'Email', 'Role', 'NIK/NIS', 'Komisariat', 'Nomor HP', 'Tanggal Registrasi' ) );

	foreach ( pacipnuippnu_get_members( 9999 ) as $user ) {
		fputcsv(
			$output,
			array(
				$user->ID,
				$user->display_name,
				$user->user_email,
				implode( ',', $user->roles ),
				get_user_meta( $user->ID, 'pac_nik', true ),
				get_user_meta( $user->ID, 'pac_komisariat', true ),
				get_user_meta( $user->ID, 'pac_hp', true ),
				$user->user_registered,
			)
		);
	}

	fclose( $output );
	exit;
}
add_action( 'admin_post_pacipnuippnu_export_members', 'pacipnuippnu_export_members' );

function pacipnuippnu_export_surat() {
	pacipnuippnu_require_manager();
	check_admin_referer( 'pac_export_surat' );

	header( 'Content-Type: text/csv; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=request-surat-pac-ipnu-ippnu.csv' );

	$output = fopen( 'php://output', 'w' );
	fputcsv( $output, array( 'ID', 'Nama', 'Jenis', 'Komisariat', 'Email', 'Status', 'Nomor Surat', 'Tanggal' ) );

	$query = new WP_Query(
		array(
			'post_type'      => 'surat_request',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		)
	);

	while ( $query->have_posts() ) {
		$query->the_post();
		fputcsv(
			$output,
			array(
				get_the_ID(),
				get_post_meta( get_the_ID(), '_pac_surat_nama', true ),
				get_post_meta( get_the_ID(), '_pac_surat_jenis', true ),
				get_post_meta( get_the_ID(), '_pac_surat_komisariat', true ),
				get_post_meta( get_the_ID(), '_pac_surat_email', true ),
				get_post_meta( get_the_ID(), '_pac_surat_status', true ),
				get_post_meta( get_the_ID(), '_pac_surat_nomor', true ),
				get_the_date( 'Y-m-d H:i:s' ),
			)
		);
	}
	wp_reset_postdata();

	fclose( $output );
	exit;
}
add_action( 'admin_post_pacipnuippnu_export_surat', 'pacipnuippnu_export_surat' );

