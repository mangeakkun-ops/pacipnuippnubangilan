<?php
/**
 * Template Name: Login Anggota
 *
 * @package PACIPNUIPPNu
 */

get_header();
?>

<section class="auth-page">
	<div class="container auth-layout">
		<div class="auth-copy reveal">
			<span class="eyebrow"><?php esc_html_e( 'Akses Anggota', 'pac-ipnu-ippnu' ); ?></span>
			<h1><?php esc_html_e( 'Masuk ke dashboard organisasi', 'pac-ipnu-ippnu' ); ?></h1>
			<p><?php esc_html_e( 'Kelola profil, unduh arsip, dan ikuti informasi kegiatan dari satu halaman.', 'pac-ipnu-ippnu' ); ?></p>
		</div>
		<div class="auth-panel reveal">
			<?php if ( is_user_logged_in() ) : ?>
				<div class="empty-state">
					<h2><?php esc_html_e( 'Anda sudah login', 'pac-ipnu-ippnu' ); ?></h2>
					<p><?php esc_html_e( 'Silakan lanjut ke dashboard sesuai role akun Anda.', 'pac-ipnu-ippnu' ); ?></p>
					<a class="btn btn--primary" href="<?php echo esc_url( pacipnuippnu_dashboard_url() ); ?>"><?php esc_html_e( 'Buka Dashboard', 'pac-ipnu-ippnu' ); ?></a>
					<a class="btn btn--outline" href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>"><?php esc_html_e( 'Keluar', 'pac-ipnu-ippnu' ); ?></a>
				</div>
			<?php else : ?>
				<?php pacipnuippnu_auth_notice(); ?>
				<div class="tabs" data-tabs>
					<div class="tab-buttons" role="tablist">
						<button type="button" class="is-active" data-tab="login"><?php esc_html_e( 'Login', 'pac-ipnu-ippnu' ); ?></button>
						<button type="button" data-tab="lost"><?php esc_html_e( 'Lupa Password', 'pac-ipnu-ippnu' ); ?></button>
					</div>
					<div class="tab-panel is-active" data-tab-panel="login"><?php pacipnuippnu_render_login_form(); ?></div>
					<div class="tab-panel" data-tab-panel="lost"><?php pacipnuippnu_render_lost_password_form(); ?></div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
get_footer();

