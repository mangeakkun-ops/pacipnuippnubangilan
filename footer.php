<?php
/**
 * Site footer.
 *
 * @package PACIPNUIPPNu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</main>

<footer class="site-footer">
	<div class="container footer-grid">
		<div class="footer-brand">
			<a class="site-brand site-brand--footer" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<img src="<?php echo esc_url( PACIPNUIPPNu_URI . 'assets/images/logo.svg' ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="52" height="52">
				<span>
					<strong><?php echo esc_html( pacipnuippnu_option( 'org_name', 'PAC IPNU IPPNU' ) ); ?></strong>
					<small><?php echo esc_html( pacipnuippnu_option( 'org_tagline', 'Belajar, Berjuang, Bertaqwa' ) ); ?></small>
				</span>
			</a>
			<p><?php echo esc_html( pacipnuippnu_option( 'footer_about', 'Media resmi organisasi pelajar Nahdlatul Ulama tingkat PAC untuk informasi, layanan administrasi, dan penguatan kaderisasi.' ) ); ?></p>
			<div class="social-list social-list--footer">
				<?php pacipnuippnu_social_links(); ?>
			</div>
		</div>

		<div>
			<h2><?php esc_html_e( 'Tautan Cepat', 'pac-ipnu-ippnu' ); ?></h2>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'footer-menu',
					'fallback_cb'    => 'pacipnuippnu_footer_fallback_menu',
				)
			);
			?>
		</div>

		<div>
			<h2><?php esc_html_e( 'Kontak Sekretariat', 'pac-ipnu-ippnu' ); ?></h2>
			<ul class="footer-contact">
				<li><span class="icon icon-location"></span><?php echo esc_html( pacipnuippnu_option( 'org_address', 'Sekretariat PAC IPNU IPPNU, Kecamatan setempat' ) ); ?></li>
				<li><span class="icon icon-phone"></span><?php echo esc_html( pacipnuippnu_option( 'org_phone', '+62 812-0000-0000' ) ); ?></li>
				<li><span class="icon icon-mail"></span><?php echo esc_html( pacipnuippnu_option( 'org_email', 'info@pacipnuippnu.or.id' ) ); ?></li>
			</ul>
		</div>

		<div>
			<h2><?php esc_html_e( 'Peta Lokasi', 'pac-ipnu-ippnu' ); ?></h2>
			<div class="footer-map">
				<?php
				$pacipnuippnu_map = pacipnuippnu_option( 'maps_embed', '' );
				if ( $pacipnuippnu_map ) {
					echo wp_kses( $pacipnuippnu_map, pacipnuippnu_allowed_map_html() );
				} else {
					echo '<div class="map-placeholder">' . esc_html__( 'Lokasi sekretariat PAC IPNU IPPNU', 'pac-ipnu-ippnu' ) . '</div>';
				}
				?>
			</div>
		</div>
	</div>

	<div class="footer-bottom">
		<div class="container footer-bottom__inner">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( pacipnuippnu_option( 'org_name', 'PAC IPNU IPPNU' ) ); ?>. <?php esc_html_e( 'Semua hak dilindungi.', 'pac-ipnu-ippnu' ); ?></p>
			<p><?php esc_html_e( 'Tema custom native WordPress.', 'pac-ipnu-ippnu' ); ?></p>
		</div>
	</div>
</footer>

<?php if ( pacipnuippnu_option( 'whatsapp_number', '6281200000000' ) ) : ?>
	<a class="floating-whatsapp" href="<?php echo esc_url( 'https://wa.me/' . preg_replace( '/\D+/', '', pacipnuippnu_option( 'whatsapp_number', '6281200000000' ) ) ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Hubungi WhatsApp', 'pac-ipnu-ippnu' ); ?>">
		<span class="icon icon-whatsapp"></span>
	</a>
<?php endif; ?>

<button class="scroll-top" type="button" data-scroll-top aria-label="<?php esc_attr_e( 'Kembali ke atas', 'pac-ipnu-ippnu' ); ?>">
	<span class="icon icon-arrow-up"></span>
</button>

<div class="toast-stack" data-toast-stack aria-live="polite" aria-atomic="true"></div>

<?php wp_footer(); ?>
</body>
</html>

