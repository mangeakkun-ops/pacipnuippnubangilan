<?php
/**
 * Theme customizer.
 *
 * @package PACIPNUIPPNu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function pacipnuippnu_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'pacipnuippnu_org',
		array(
			'title'       => __( 'Identitas Organisasi', 'pac-ipnu-ippnu' ),
			'description' => __( 'Atur data dasar organisasi, kontak, sosial media, dan peta.', 'pac-ipnu-ippnu' ),
			'priority'    => 30,
		)
	);

	$fields = array(
		'org_name'          => array( 'Nama Organisasi', 'PAC IPNU IPPNU' ),
		'org_tagline'       => array( 'Tagline', 'Belajar, Berjuang, Bertaqwa' ),
		'org_email'         => array( 'Email', 'info@pacipnuippnu.or.id' ),
		'org_phone'         => array( 'Telepon', '+62 812-0000-0000' ),
		'org_address'       => array( 'Alamat Sekretariat', 'Sekretariat PAC IPNU IPPNU, Kecamatan setempat' ),
		'whatsapp_number'   => array( 'Nomor WhatsApp', '6281200000000' ),
		'facebook_url'      => array( 'Facebook URL', '' ),
		'instagram_url'     => array( 'Instagram URL', '' ),
		'youtube_url'       => array( 'YouTube URL', '' ),
		'tiktok_url'        => array( 'TikTok URL', '' ),
		'commissioner_count' => array( 'Jumlah Komisariat', '12' ),
		'footer_about'      => array( 'Deskripsi Footer', 'Media resmi organisasi pelajar Nahdlatul Ulama tingkat PAC untuk informasi, layanan administrasi, dan penguatan kaderisasi.' ),
	);

	foreach ( $fields as $key => $data ) {
		$wp_customize->add_setting(
			'pacipnuippnu_' . $key,
			array(
				'default'           => $data[1],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'pacipnuippnu_' . $key,
			array(
				'label'   => $data[0],
				'section' => 'pacipnuippnu_org',
				'type'    => 'text',
			)
		);
	}

	$wp_customize->add_setting(
		'pacipnuippnu_maps_embed',
		array(
			'default'           => '',
			'sanitize_callback' => 'pacipnuippnu_sanitize_map_embed',
		)
	);
	$wp_customize->add_control(
		'pacipnuippnu_maps_embed',
		array(
			'label'       => __( 'Google Maps Embed Iframe', 'pac-ipnu-ippnu' ),
			'section'     => 'pacipnuippnu_org',
			'type'        => 'textarea',
			'description' => __( 'Tempel kode iframe Google Maps sekretariat.', 'pac-ipnu-ippnu' ),
		)
	);

	$wp_customize->add_section(
		'pacipnuippnu_home',
		array(
			'title'    => __( 'Konten Beranda', 'pac-ipnu-ippnu' ),
			'priority' => 31,
		)
	);

	$home_fields = array(
		'chairman_name'     => array( 'Nama Ketua', 'Rekan Ketua PAC' ),
		'chairman_message'  => array( 'Sambutan Ketua', 'Selamat datang di media resmi PAC IPNU IPPNU. Website ini menjadi ruang informasi, pelayanan administrasi, dokumentasi, dan kolaborasi kader pelajar NU.' ),
		'about_short'       => array( 'Tentang Singkat', 'PAC IPNU IPPNU adalah wadah kaderisasi pelajar NU yang bergerak dalam penguatan keilmuan, kepemimpinan, keaswajaan, dan pengabdian masyarakat.' ),
		'vision_text'       => array( 'Visi', 'Terwujudnya pelajar NU yang berilmu, berakhlak, mandiri, dan berdaya guna bagi agama, bangsa, dan masyarakat.' ),
		'mission_text'      => array( 'Misi', 'Menguatkan kaderisasi, literasi, dakwah pelajar, advokasi pendidikan, dan jejaring komisariat secara berkelanjutan.' ),
	);

	foreach ( $home_fields as $key => $data ) {
		$wp_customize->add_setting(
			'pacipnuippnu_' . $key,
			array(
				'default'           => $data[1],
				'sanitize_callback' => 'sanitize_textarea_field',
			)
		);
		$wp_customize->add_control(
			'pacipnuippnu_' . $key,
			array(
				'label'   => $data[0],
				'section' => 'pacipnuippnu_home',
				'type'    => 'textarea',
			)
		);
	}
}
add_action( 'customize_register', 'pacipnuippnu_customize_register' );

function pacipnuippnu_sanitize_map_embed( $value ) {
	return wp_kses( $value, pacipnuippnu_allowed_map_html() );
}
