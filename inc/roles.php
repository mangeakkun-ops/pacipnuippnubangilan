<?php
/**
 * Custom roles and capabilities.
 *
 * @package PACIPNUIPPNu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function pacipnuippnu_add_roles() {
	add_role(
		'anggota',
		__( 'Anggota', 'pac-ipnu-ippnu' ),
		array(
			'read'         => true,
			'upload_files' => true,
		)
	);

	add_role(
		'pengurus',
		__( 'Pengurus', 'pac-ipnu-ippnu' ),
		array(
			'read'                 => true,
			'upload_files'         => true,
			'edit_posts'           => true,
			'edit_published_posts' => true,
			'publish_posts'        => true,
			'delete_posts'         => true,
			'edit_pages'           => true,
			'edit_others_posts'    => true,
			'manage_categories'    => true,
		)
	);

	$anggota = get_role( 'anggota' );
	if ( $anggota ) {
		foreach ( array( 'read', 'upload_files' ) as $cap ) {
			$anggota->add_cap( $cap );
		}
	}

	$pengurus = get_role( 'pengurus' );
	if ( $pengurus ) {
		foreach ( array( 'read', 'upload_files', 'edit_posts', 'edit_published_posts', 'publish_posts', 'delete_posts', 'edit_pages', 'edit_others_posts', 'manage_categories' ) as $cap ) {
			$pengurus->add_cap( $cap );
		}
	}
}

function pacipnuippnu_theme_activation() {
	pacipnuippnu_add_roles();
	pacipnuippnu_register_post_types();
	pacipnuippnu_register_taxonomies();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'pacipnuippnu_theme_activation' );

function pacipnuippnu_theme_deactivation() {
	flush_rewrite_rules();
}
add_action( 'switch_theme', 'pacipnuippnu_theme_deactivation' );

function pacipnuippnu_register_user_meta( $user_id ) {
	if ( isset( $_POST['pac_komisariat'] ) ) {
		update_user_meta( $user_id, 'pac_komisariat', sanitize_text_field( wp_unslash( $_POST['pac_komisariat'] ) ) );
	}
	if ( isset( $_POST['pac_nik'] ) ) {
		update_user_meta( $user_id, 'pac_nik', sanitize_text_field( wp_unslash( $_POST['pac_nik'] ) ) );
	}
	if ( isset( $_POST['pac_hp'] ) ) {
		update_user_meta( $user_id, 'pac_hp', sanitize_text_field( wp_unslash( $_POST['pac_hp'] ) ) );
	}
}
add_action( 'user_register', 'pacipnuippnu_register_user_meta' );

function pacipnuippnu_hide_admin_bar_for_members( $show ) {
	if ( current_user_can( 'manage_options' ) || pacipnuippnu_can_manage_organization() ) {
		return $show;
	}

	return false;
}
add_filter( 'show_admin_bar', 'pacipnuippnu_hide_admin_bar_for_members' );
