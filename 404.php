<?php
/**
 * 404 template.
 *
 * @package PACIPNUIPPNu
 */

get_header();
?>

<section class="section not-found">
	<div class="container not-found__inner">
		<span class="eyebrow"><?php esc_html_e( '404', 'pac-ipnu-ippnu' ); ?></span>
		<h1><?php esc_html_e( 'Halaman tidak ditemukan', 'pac-ipnu-ippnu' ); ?></h1>
		<p><?php esc_html_e( 'Tautan mungkin berubah atau konten sudah dipindahkan. Gunakan pencarian untuk menemukan informasi yang dibutuhkan.', 'pac-ipnu-ippnu' ); ?></p>
		<?php get_search_form(); ?>
		<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Kembali ke Beranda', 'pac-ipnu-ippnu' ); ?></a>
	</div>
</section>

<?php
get_footer();

