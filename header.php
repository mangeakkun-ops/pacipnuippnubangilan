<?php
/**
 * Site header.
 *
 * @package PACIPNUIPPNu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="site-loader" data-loader aria-hidden="true">
	<div class="loader-mark">
		<span></span>
		<span></span>
		<span></span>
	</div>
</div>

<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Lewati ke konten', 'pac-ipnu-ippnu' ); ?></a>

<header class="site-header" data-header>
	<div class="topbar">
		<div class="container topbar__inner">
			<div class="topbar__info">
				<span><?php echo esc_html( pacipnuippnu_option( 'org_email', 'info@pacipnuippnu.or.id' ) ); ?></span>
				<span><?php echo esc_html( pacipnuippnu_option( 'org_phone', '+62 812-0000-0000' ) ); ?></span>
			</div>
			<div class="topbar__links">
				<?php pacipnuippnu_social_links(); ?>
			</div>
		</div>
	</div>

	<nav class="navbar" aria-label="<?php esc_attr_e( 'Navigasi utama', 'pac-ipnu-ippnu' ); ?>">
		<div class="container navbar__inner">
			<a class="site-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<img src="<?php echo esc_url( PACIPNUIPPNu_URI . 'assets/images/logo.svg' ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="48" height="48">
				<?php endif; ?>
				<span>
					<strong><?php echo esc_html( pacipnuippnu_option( 'org_name', 'PAC IPNU IPPNU' ) ); ?></strong>
					<small><?php echo esc_html( pacipnuippnu_option( 'org_tagline', 'Belajar, Berjuang, Bertaqwa' ) ); ?></small>
				</span>
			</a>

			<div class="nav-actions nav-actions--mobile">
				<button class="icon-button" type="button" data-search-open aria-label="<?php esc_attr_e( 'Buka pencarian', 'pac-ipnu-ippnu' ); ?>">
					<span class="icon icon-search"></span>
				</button>
				<button class="icon-button" type="button" data-theme-toggle aria-label="<?php esc_attr_e( 'Ubah mode gelap', 'pac-ipnu-ippnu' ); ?>">
					<span class="icon icon-moon"></span>
				</button>
				<button class="menu-toggle" type="button" data-menu-toggle aria-controls="primary-menu" aria-expanded="false">
					<span></span>
					<span></span>
					<span></span>
				</button>
			</div>

			<div class="nav-panel" data-nav-panel>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'container'      => false,
						'menu_class'     => 'primary-menu',
						'fallback_cb'    => 'pacipnuippnu_fallback_menu',
					)
				);
				?>
				<div class="nav-actions">
					<button class="icon-button" type="button" data-search-open aria-label="<?php esc_attr_e( 'Buka pencarian', 'pac-ipnu-ippnu' ); ?>">
						<span class="icon icon-search"></span>
					</button>
					<button class="icon-button" type="button" data-theme-toggle aria-label="<?php esc_attr_e( 'Ubah mode gelap', 'pac-ipnu-ippnu' ); ?>">
						<span class="icon icon-moon"></span>
					</button>
					<?php if ( is_user_logged_in() ) : ?>
						<a class="btn btn--sm btn--primary" href="<?php echo esc_url( pacipnuippnu_dashboard_url() ); ?>"><?php esc_html_e( 'Dashboard', 'pac-ipnu-ippnu' ); ?></a>
					<?php else : ?>
						<a class="btn btn--sm btn--outline" href="<?php echo esc_url( pacipnuippnu_login_url() ); ?>"><?php esc_html_e( 'Login', 'pac-ipnu-ippnu' ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</nav>
</header>

<div class="search-modal" data-search-modal hidden>
	<div class="search-modal__backdrop" data-search-close></div>
	<div class="search-modal__dialog" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Pencarian global', 'pac-ipnu-ippnu' ); ?>">
		<button class="icon-button search-modal__close" type="button" data-search-close aria-label="<?php esc_attr_e( 'Tutup pencarian', 'pac-ipnu-ippnu' ); ?>">
			<span class="icon icon-close"></span>
		</button>
		<form class="global-search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label for="global-search-field"><?php esc_html_e( 'Cari informasi organisasi', 'pac-ipnu-ippnu' ); ?></label>
			<div class="global-search__field">
				<input id="global-search-field" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Ketik berita, agenda, arsip...', 'pac-ipnu-ippnu' ); ?>">
				<button class="btn btn--primary" type="submit"><?php esc_html_e( 'Cari', 'pac-ipnu-ippnu' ); ?></button>
			</div>
		</form>
	</div>
</div>

<main id="primary" class="site-main">

