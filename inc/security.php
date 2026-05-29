<?php
/**
 * Basic security and SEO helpers.
 *
 * @package PACIPNUIPPNu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

remove_action( 'wp_head', 'wp_generator' );

function pacipnuippnu_security_headers() {
	if ( headers_sent() ) {
		return;
	}

	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
}
add_action( 'send_headers', 'pacipnuippnu_security_headers' );

function pacipnuippnu_add_opengraph_tags() {
	if ( is_admin() ) {
		return;
	}

	$title       = wp_get_document_title();
	$description = is_singular() ? wp_strip_all_tags( get_the_excerpt() ) : get_bloginfo( 'description' );
	$image       = is_singular() ? pacipnuippnu_featured_image_url( get_the_ID(), 'large' ) : PACIPNUIPPNu_URI . 'assets/images/hero-bg.svg';
	$url         = is_singular() ? get_permalink() : home_url( add_query_arg( null, null ) );
	?>
	<meta name="description" content="<?php echo esc_attr( wp_trim_words( $description, 28 ) ); ?>">
	<meta property="og:type" content="<?php echo is_singular() ? 'article' : 'website'; ?>">
	<meta property="og:title" content="<?php echo esc_attr( $title ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( wp_trim_words( $description, 28 ) ); ?>">
	<meta property="og:image" content="<?php echo esc_url( $image ); ?>">
	<meta property="og:url" content="<?php echo esc_url( $url ); ?>">
	<meta name="twitter:card" content="summary_large_image">
	<?php
}
add_action( 'wp_head', 'pacipnuippnu_add_opengraph_tags', 4 );

function pacipnuippnu_schema_json_ld() {
	if ( is_admin() ) {
		return;
	}

	$schema = array(
		'@context' => 'https://schema.org',
		'@type'    => 'Organization',
		'name'     => pacipnuippnu_option( 'org_name', 'PAC IPNU IPPNU' ),
		'url'      => home_url( '/' ),
		'email'    => pacipnuippnu_option( 'org_email', 'info@pacipnuippnu.or.id' ),
		'telephone' => pacipnuippnu_option( 'org_phone', '+62 812-0000-0000' ),
		'address'  => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => pacipnuippnu_option( 'org_address', 'Sekretariat PAC IPNU IPPNU' ),
			'addressCountry'  => 'ID',
		),
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>';
}
add_action( 'wp_head', 'pacipnuippnu_schema_json_ld', 8 );

function pacipnuippnu_comment_antispam_field() {
	echo '<p class="comment-form-url pac-honeypot"><label for="pac-comment-check">Website</label><input id="pac-comment-check" name="pac_comment_check" type="text" value=""></p>';
}
add_action( 'comment_form_after_fields', 'pacipnuippnu_comment_antispam_field' );

function pacipnuippnu_verify_comment_antispam( $commentdata ) {
	if ( ! empty( $_POST['pac_comment_check'] ) ) {
		wp_die( esc_html__( 'Komentar terindikasi spam.', 'pac-ipnu-ippnu' ) );
	}

	return $commentdata;
}
add_filter( 'preprocess_comment', 'pacipnuippnu_verify_comment_antispam' );

