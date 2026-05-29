<?php
/**
 * Theme bootstrap file.
 *
 * @package PACIPNUIPPNu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PACIPNUIPPNu_VERSION', '1.0.0' );
define( 'PACIPNUIPPNu_DIR', trailingslashit( get_template_directory() ) );
define( 'PACIPNUIPPNu_URI', trailingslashit( get_template_directory_uri() ) );

$pacipnuippnu_includes = array(
	'inc/helpers.php',
	'inc/setup.php',
	'inc/enqueue.php',
	'inc/customizer.php',
	'inc/cpt.php',
	'inc/meta-boxes.php',
	'inc/roles.php',
	'inc/security.php',
	'inc/ajax.php',
	'inc/login.php',
	'inc/dashboard.php',
	'inc/demo-data.php',
);

foreach ( $pacipnuippnu_includes as $pacipnuippnu_file ) {
	$pacipnuippnu_path = PACIPNUIPPNu_DIR . $pacipnuippnu_file;
	if ( file_exists( $pacipnuippnu_path ) ) {
		require_once $pacipnuippnu_path;
	}
}

