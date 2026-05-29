<?php
/**
 * Template Name: Profil Organisasi
 *
 * @package PACIPNUIPPNu
 */

get_header();
?>

<section class="page-hero">
	<div class="page-hero__overlay"></div>
	<div class="container">
		<?php get_template_part( 'template-parts/breadcrumb' ); ?>
		<span class="eyebrow"><?php esc_html_e( 'Profil Organisasi', 'pac-ipnu-ippnu' ); ?></span>
		<h1><?php echo esc_html( pacipnuippnu_option( 'org_name', 'PAC IPNU IPPNU' ) ); ?></h1>
		<p><?php esc_html_e( 'Visi, misi, struktur, dokumen dasar, dan lokasi sekretariat organisasi pelajar NU tingkat PAC.', 'pac-ipnu-ippnu' ); ?></p>
	</div>
</section>


<section class="section section--soft">
	<div class="container">
		<div class="feature-grid">
			<article class="feature-card reveal">
				<span class="feature-card__icon icon icon-target"></span>
				<h2><?php esc_html_e( 'Visi', 'pac-ipnu-ippnu' ); ?></h2>
				<p><?php echo esc_html( pacipnuippnu_option( 'vision_text', 'Terwujudnya pelajar NU yang berilmu, berakhlak, mandiri, dan berdaya guna bagi agama, bangsa, dan masyarakat.' ) ); ?></p>
			</article>
			<article class="feature-card reveal">
				<span class="feature-card__icon icon icon-list"></span>
				<h2><?php esc_html_e( 'Misi', 'pac-ipnu-ippnu' ); ?></h2>
				<p><?php echo esc_html( pacipnuippnu_option( 'mission_text', 'Menguatkan kaderisasi, literasi, dakwah pelajar, advokasi pendidikan, dan jejaring komisariat secara berkelanjutan.' ) ); ?></p>
			</article>
			<article class="feature-card reveal">
				<span class="feature-card__icon icon icon-handshake"></span>
				<h2><?php esc_html_e( 'Tujuan', 'pac-ipnu-ippnu' ); ?></h2>
				<p><?php esc_html_e( 'Membentuk kader pelajar NU yang siap memimpin, melayani, menjaga tradisi, dan memberi manfaat nyata bagi lingkungan pendidikan dan masyarakat.', 'pac-ipnu-ippnu' ); ?></p>
			</article>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-heading reveal">
			<span class="eyebrow"><?php esc_html_e( 'Data Pengurus', 'pac-ipnu-ippnu' ); ?></span>
			<h2><?php esc_html_e( 'Struktur organisasi dan pengurus aktif', 'pac-ipnu-ippnu' ); ?></h2>
		</div>
		<div class="people-grid">
			<?php
			$users = get_users( array( 'role__in' => array( 'pengurus', 'administrator' ), 'number' => 8 ) );
			if ( $users ) :
				foreach ( $users as $user ) :
					?>
					<article class="person-card reveal">
						<img src="<?php echo esc_url( pacipnuippnu_user_avatar_url( $user->ID ) ); ?>" alt="<?php echo esc_attr( $user->display_name ); ?>" loading="lazy">
						<h3><?php echo esc_html( $user->display_name ); ?></h3>
						<p><?php echo esc_html( in_array( 'pengurus', (array) $user->roles, true ) ? __( 'Pengurus PAC', 'pac-ipnu-ippnu' ) : __( 'Administrator', 'pac-ipnu-ippnu' ) ); ?></p>
					</article>
					<?php
				endforeach;
			else :
				foreach ( array( 'Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara' ) as $role ) :
					?>
					<article class="person-card reveal">
						<img src="<?php echo esc_url( PACIPNUIPPNu_URI . 'assets/images/default-avatar.svg' ); ?>" alt="<?php echo esc_attr( $role ); ?>" loading="lazy">
						<h3><?php echo esc_html( $role ); ?></h3>
						<p><?php esc_html_e( 'Data dapat ditambahkan melalui user role Pengurus.', 'pac-ipnu-ippnu' ); ?></p>
					</article>
					<?php
				endforeach;
			endif;
			?>
		</div>
	</div>
</section>

<section class="section section--soft">
	<div class="container split-layout">
		<div class="section-copy reveal">
			<span class="eyebrow"><?php esc_html_e( 'AD/ART dan Arsip', 'pac-ipnu-ippnu' ); ?></span>
			<h2><?php esc_html_e( 'Dokumen dasar organisasi', 'pac-ipnu-ippnu' ); ?></h2>
			<p><?php esc_html_e( 'Dokumen organisasi dapat diunggah melalui CPT Arsip, dikategorikan, dicari, dipreview, dan diunduh anggota.', 'pac-ipnu-ippnu' ); ?></p>
			<a class="btn btn--primary" href="<?php echo esc_url( get_post_type_archive_link( 'arsip' ) ?: home_url( '/arsip/' ) ); ?>"><?php esc_html_e( 'Buka Arsip', 'pac-ipnu-ippnu' ); ?></a>
		</div>
		<div class="document-mini-list reveal">
			<?php
			$docs = new WP_Query( array( 'post_type' => 'arsip', 'posts_per_page' => 3, 'post_status' => 'publish' ) );
			if ( $docs->have_posts() ) :
				while ( $docs->have_posts() ) :
					$docs->the_post();
					?>
					<a href="<?php the_permalink(); ?>">
						<span class="icon icon-file"></span>
						<strong><?php the_title(); ?></strong>
						<small><?php echo esc_html( get_the_date() ); ?></small>
					</a>
					<?php
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</div>
	</div>
</section>

<section class="section">
	<div class="container split-layout">
		<div class="section-copy reveal">
			<span class="eyebrow"><?php esc_html_e( 'Sekretariat', 'pac-ipnu-ippnu' ); ?></span>
			<h2><?php esc_html_e( 'Lokasi dan kontak organisasi', 'pac-ipnu-ippnu' ); ?></h2>
			<ul class="info-list">
				<li><span class="icon icon-location"></span><?php echo esc_html( pacipnuippnu_option( 'org_address', 'Sekretariat PAC IPNU IPPNU, Kecamatan setempat' ) ); ?></li>
				<li><span class="icon icon-phone"></span><?php echo esc_html( pacipnuippnu_option( 'org_phone', '+62 812-0000-0000' ) ); ?></li>
				<li><span class="icon icon-mail"></span><?php echo esc_html( pacipnuippnu_option( 'org_email', 'info@pacipnuippnu.or.id' ) ); ?></li>
			</ul>
		</div>
		<div class="map-card reveal">
			<?php
			$map = pacipnuippnu_option( 'maps_embed', '' );
			echo $map ? wp_kses( $map, pacipnuippnu_allowed_map_html() ) : '<div class="map-placeholder">' . esc_html__( 'Google Maps sekretariat', 'pac-ipnu-ippnu' ) . '</div>';
			?>
		</div>
	</div>
</section>

<?php
get_footer();

