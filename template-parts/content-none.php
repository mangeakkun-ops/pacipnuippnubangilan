<?php
/**
 * Empty state partial.
 *
 * @package PACIPNUIPPNu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="empty-state">
	<img src="<?php echo esc_url( PACIPNUIPPNu_URI . 'assets/images/empty-state.svg' ); ?>" alt="" width="160" height="160" loading="lazy">
	<h2><?php esc_html_e( 'Belum ada konten', 'pac-ipnu-ippnu' ); ?></h2>
	<p><?php esc_html_e( 'Konten akan tampil otomatis saat pengurus menambahkan data melalui dashboard WordPress.', 'pac-ipnu-ippnu' ); ?></p>
	<?php get_search_form(); ?>
</div>

