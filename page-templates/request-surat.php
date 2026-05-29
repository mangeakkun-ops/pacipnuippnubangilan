<?php
/**
 * Template Name: Request Surat Online
 *
 * @package PACIPNUIPPNu
 */

get_header();
?>

<section class="page-hero page-hero--compact">
	<div class="container">
		<?php get_template_part( 'template-parts/breadcrumb' ); ?>
		<span class="eyebrow"><?php esc_html_e( 'Layanan Administrasi', 'pac-ipnu-ippnu' ); ?></span>
		<h1><?php esc_html_e( 'Request Surat Dinonaktifkan Sementara', 'pac-ipnu-ippnu' ); ?></h1>
		<p><?php esc_html_e( 'Form request surat online sedang disembunyikan sementara. Silakan hubungi sekretariat untuk kebutuhan administrasi.', 'pac-ipnu-ippnu' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="empty-state reveal">
			<h2><?php esc_html_e( 'Layanan belum tersedia', 'pac-ipnu-ippnu' ); ?></h2>
			<p><?php esc_html_e( 'Fitur pengajuan surat akan ditampilkan kembali setelah siap digunakan.', 'pac-ipnu-ippnu' ); ?></p>
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Kembali ke Beranda', 'pac-ipnu-ippnu' ); ?></a>
		</div>
	</div>
</section>

<?php
get_footer();
