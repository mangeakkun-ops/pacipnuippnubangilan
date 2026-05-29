<?php
/**
 * AJAX and front-end submissions.
 *
 * @package PACIPNUIPPNu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function pacipnuippnu_verify_ajax_nonce() {
	check_ajax_referer( 'pacipnuippnu_nonce', 'nonce' );
}

function pacipnuippnu_handle_file_upload( $field, $allowed_mimes = array() ) {
	if ( empty( $_FILES[ $field ]['name'] ) ) {
		return '';
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';

	$default_mimes = array(
		'pdf'  => 'application/pdf',
		'doc'  => 'application/msword',
		'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
		'jpg'  => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'png'  => 'image/png',
	);

	$upload = wp_handle_upload(
		$_FILES[ $field ],
		array(
			'test_form' => false,
			'mimes'     => $allowed_mimes ? $allowed_mimes : $default_mimes,
		)
	);

	if ( isset( $upload['error'] ) ) {
		return new WP_Error( 'upload_failed', $upload['error'] );
	}

	return isset( $upload['url'] ) ? esc_url_raw( $upload['url'] ) : '';
}

function pacipnuippnu_ajax_request_surat() {
	pacipnuippnu_verify_ajax_nonce();

	if ( ! is_user_logged_in() ) {
		wp_send_json_error( array( 'message' => __( 'Silakan login terlebih dahulu untuk mengajukan surat.', 'pac-ipnu-ippnu' ) ), 401 );
	}

	if ( ! empty( $_POST['website'] ) ) {
		wp_send_json_error( array( 'message' => __( 'Permohonan ditolak karena terindikasi spam.', 'pac-ipnu-ippnu' ) ), 400 );
	}

	$required = array( 'nama', 'nik', 'komisariat', 'hp', 'email', 'jenis', 'keperluan' );
	$data     = array();

	foreach ( $required as $field ) {
		$value = isset( $_POST[ $field ] ) ? sanitize_textarea_field( wp_unslash( $_POST[ $field ] ) ) : '';
		if ( '' === trim( $value ) ) {
			wp_send_json_error( array( 'message' => __( 'Semua field wajib harus diisi.', 'pac-ipnu-ippnu' ) ), 422 );
		}
		$data[ $field ] = $value;
	}

	$data['email'] = sanitize_email( $data['email'] );
	if ( ! is_email( $data['email'] ) ) {
		wp_send_json_error( array( 'message' => __( 'Format email tidak valid.', 'pac-ipnu-ippnu' ) ), 422 );
	}

	$support_file = pacipnuippnu_handle_file_upload( 'file_pendukung' );
	if ( is_wp_error( $support_file ) ) {
		wp_send_json_error( array( 'message' => $support_file->get_error_message() ), 422 );
	}

	$title = sprintf(
		/* translators: 1: letter type, 2: requester name. */
		__( '%1$s - %2$s', 'pac-ipnu-ippnu' ),
		ucwords( str_replace( '-', ' ', $data['jenis'] ) ),
		$data['nama']
	);

	$post_id = wp_insert_post(
		array(
			'post_type'    => 'surat_request',
			'post_title'   => $title,
			'post_content' => $data['keperluan'],
			'post_status'  => 'publish',
			'post_author'  => get_current_user_id(),
		),
		true
	);

	if ( is_wp_error( $post_id ) ) {
		wp_send_json_error( array( 'message' => __( 'Permohonan belum dapat disimpan.', 'pac-ipnu-ippnu' ) ), 500 );
	}

	foreach ( $data as $key => $value ) {
		update_post_meta( $post_id, '_pac_surat_' . $key, $value );
	}

	update_post_meta( $post_id, '_pac_surat_status', 'menunggu' );
	update_post_meta( $post_id, '_pac_surat_support_file', $support_file );
	update_post_meta( $post_id, '_pac_surat_nomor', '' );
	update_post_meta( $post_id, '_pac_surat_note', '' );
	update_post_meta( $post_id, '_pac_surat_file_url', '' );

	wp_mail(
		get_option( 'admin_email' ),
		sprintf( __( 'Request surat baru: %s', 'pac-ipnu-ippnu' ), $data['nama'] ),
		sprintf( __( "Jenis: %1\$s\nNama: %2\$s\nKomisariat: %3\$s\nEmail: %4\$s\n\nSilakan kelola melalui dashboard WordPress.", 'pac-ipnu-ippnu' ), $data['jenis'], $data['nama'], $data['komisariat'], $data['email'] )
	);

	wp_send_json_success(
		array(
			'message' => __( 'Permohonan surat berhasil dikirim. Status dapat dipantau melalui dashboard anggota.', 'pac-ipnu-ippnu' ),
			'id'      => $post_id,
		)
	);
}
add_action( 'wp_ajax_pacipnuippnu_request_surat', 'pacipnuippnu_ajax_request_surat' );
add_action( 'wp_ajax_nopriv_pacipnuippnu_request_surat', 'pacipnuippnu_ajax_request_surat' );

function pacipnuippnu_ajax_contact() {
	pacipnuippnu_verify_ajax_nonce();

	if ( ! empty( $_POST['website'] ) ) {
		wp_send_json_error( array( 'message' => __( 'Pesan ditolak karena terindikasi spam.', 'pac-ipnu-ippnu' ) ), 400 );
	}

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( ! $name || ! is_email( $email ) || ! $message ) {
		wp_send_json_error( array( 'message' => __( 'Nama, email, dan pesan wajib valid.', 'pac-ipnu-ippnu' ) ), 422 );
	}

	wp_mail(
		get_option( 'admin_email' ),
		sprintf( __( 'Pesan kontak dari %s', 'pac-ipnu-ippnu' ), $name ),
		$message,
		array( 'Reply-To: ' . $name . ' <' . $email . '>' )
	);

	wp_send_json_success( array( 'message' => __( 'Pesan berhasil dikirim.', 'pac-ipnu-ippnu' ) ) );
}
add_action( 'wp_ajax_pacipnuippnu_contact', 'pacipnuippnu_ajax_contact' );
add_action( 'wp_ajax_nopriv_pacipnuippnu_contact', 'pacipnuippnu_ajax_contact' );

function pacipnuippnu_ajax_update_profile() {
	pacipnuippnu_verify_ajax_nonce();

	if ( ! is_user_logged_in() ) {
		wp_send_json_error( array( 'message' => __( 'Silakan login terlebih dahulu.', 'pac-ipnu-ippnu' ) ), 401 );
	}

	$user_id = get_current_user_id();
	$fields  = array(
		'first_name'      => 'first_name',
		'last_name'       => 'last_name',
		'pac_nik'         => 'pac_nik',
		'pac_komisariat'  => 'pac_komisariat',
		'pac_hp'          => 'pac_hp',
		'pac_status_keanggotaan' => 'pac_status_keanggotaan',
	);

	foreach ( $fields as $post_key => $meta_key ) {
		if ( ! isset( $_POST[ $post_key ] ) ) {
			continue;
		}
		$value = sanitize_text_field( wp_unslash( $_POST[ $post_key ] ) );
		if ( in_array( $post_key, array( 'first_name', 'last_name' ), true ) ) {
			wp_update_user(
				array(
					'ID'       => $user_id,
					$post_key => $value,
				)
			);
		} else {
			update_user_meta( $user_id, $meta_key, $value );
		}
	}

	$avatar = pacipnuippnu_handle_file_upload(
		'avatar',
		array(
			'jpg'  => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'png'  => 'image/png',
			'webp' => 'image/webp',
		)
	);

	if ( is_wp_error( $avatar ) ) {
		wp_send_json_error( array( 'message' => $avatar->get_error_message() ), 422 );
	}

	if ( $avatar ) {
		update_user_meta( $user_id, 'pac_avatar_url', $avatar );
	}

	wp_send_json_success( array( 'message' => __( 'Profil berhasil diperbarui.', 'pac-ipnu-ippnu' ) ) );
}
add_action( 'wp_ajax_pacipnuippnu_update_profile', 'pacipnuippnu_ajax_update_profile' );

function pacipnuippnu_ajax_update_surat_status() {
	pacipnuippnu_verify_ajax_nonce();

	if ( ! pacipnuippnu_can_manage_organization() ) {
		wp_send_json_error( array( 'message' => __( 'Anda tidak memiliki akses.', 'pac-ipnu-ippnu' ) ), 403 );
	}

	$post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;
	$status  = isset( $_POST['status'] ) ? sanitize_key( wp_unslash( $_POST['status'] ) ) : '';
	$note    = isset( $_POST['note'] ) ? sanitize_textarea_field( wp_unslash( $_POST['note'] ) ) : '';

	if ( ! $post_id || 'surat_request' !== get_post_type( $post_id ) || ! array_key_exists( $status, pacipnuippnu_get_request_statuses() ) ) {
		wp_send_json_error( array( 'message' => __( 'Data permohonan tidak valid.', 'pac-ipnu-ippnu' ) ), 422 );
	}

	$nomor = get_post_meta( $post_id, '_pac_surat_nomor', true );
	if ( 'disetujui' === $status && ! $nomor ) {
		$nomor = pacipnuippnu_generate_nomor_surat();
		update_post_meta( $post_id, '_pac_surat_nomor', $nomor );
	}

	update_post_meta( $post_id, '_pac_surat_status', $status );
	update_post_meta( $post_id, '_pac_surat_note', $note );

	wp_send_json_success(
		array(
			'message' => __( 'Status permohonan diperbarui.', 'pac-ipnu-ippnu' ),
			'status'  => $status,
			'nomor'   => $nomor,
		)
	);
}
add_action( 'wp_ajax_pacipnuippnu_update_surat_status', 'pacipnuippnu_ajax_update_surat_status' );

