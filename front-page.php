<?php
/**
 * Front page template.
 *
 * @package PACIPNUIPPNu
 */

get_header();

$pacipnuippnu_posts = get_posts(
	array(
		'post_type'      => array( 'post', 'agenda' ),
		'posts_per_page' => 3,
		'post_status'    => 'publish',
	)
);

$pacipnuippnu_default_slides = array(
	array(
		'title'       => __( 'PAC IPNU IPPNU', 'pac-ipnu-ippnu' ),
		'description' => __( 'Media resmi organisasi pelajar NU untuk informasi, kaderisasi, administrasi, dan gerakan pelajar yang berakhlak.', 'pac-ipnu-ippnu' ),
		'url'         => home_url( '/profil-organisasi/' ),
		'button'      => __( 'Kenali Organisasi', 'pac-ipnu-ippnu' ),
		'image'       => PACIPNUIPPNu_URI . 'assets/images/hero-bg.svg',
	),
	array(
		'title'       => __( 'Kaderisasi Pelajar NU', 'pac-ipnu-ippnu' ),
		'description' => __( 'Menguatkan literasi, kepemimpinan, keaswajaan, dan pengabdian kader di setiap komisariat.', 'pac-ipnu-ippnu' ),
		'url'         => get_post_type_archive_link( 'agenda' ) ?: home_url( '/agenda/' ),
		'button'      => __( 'Lihat Agenda', 'pac-ipnu-ippnu' ),
		'image'       => PACIPNUIPPNu_URI . 'assets/images/hero-bg.svg',
	),
);
?>

<section class="home-hero" data-hero-slider>
	<div class="home-hero__ambient" aria-hidden="true"></div>
	<div class="container home-hero__grid">
		<div class="home-hero__copy reveal">
			<span class="eyebrow"><?php esc_html_e( 'Website Resmi PAC IPNU IPPNU', 'pac-ipnu-ippnu' ); ?></span>
			<h1><?php esc_html_e( 'Gerakan pelajar NU yang rapi, adaptif, dan berdampak.', 'pac-ipnu-ippnu' ); ?></h1>
			<p><?php esc_html_e( 'Satu rumah digital untuk kabar organisasi, agenda kaderisasi, galeri kegiatan, dan arsip dokumen yang mudah diakses dari perangkat apa pun.', 'pac-ipnu-ippnu' ); ?></p>
			<div class="home-hero__actions">
				<a class="btn btn--primary" href="<?php echo esc_url( get_post_type_archive_link( 'agenda' ) ?: home_url( '/agenda/' ) ); ?>"><?php esc_html_e( 'Lihat Agenda', 'pac-ipnu-ippnu' ); ?></a>
				<a class="btn btn--glass" href="<?php echo esc_url( get_post_type_archive_link( 'galeri' ) ?: home_url( '/galeri/' ) ); ?>"><?php esc_html_e( 'Buka Galeri', 'pac-ipnu-ippnu' ); ?></a>
			</div>
			<div class="home-hero__metrics" aria-label="<?php esc_attr_e( 'Ringkasan organisasi', 'pac-ipnu-ippnu' ); ?>">
				<?php foreach ( array_slice( pacipnuippnu_org_stats(), 0, 3, true ) as $label => $value ) : ?>
					<span><strong data-counter="<?php echo esc_attr( $value ); ?>">0</strong><?php echo esc_html( ucwords( str_replace( '_', ' ', $label ) ) ); ?></span>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="home-hero__showcase reveal">
			<div class="hero-phone-card">
				<div class="hero-slider__track">
					<?php if ( $pacipnuippnu_posts ) : ?>
						<?php foreach ( $pacipnuippnu_posts as $index => $slide_post ) : ?>
							<article class="hero-slide <?php echo 0 === $index ? 'is-active' : ''; ?>" style="--hero-bg: url('<?php echo esc_url( pacipnuippnu_featured_image_url( $slide_post->ID, 'pac-hero' ) ); ?>');">
								<div class="hero-slide__overlay"></div>
								<div class="hero-slide__content">
									<span class="eyebrow"><?php echo esc_html( pacipnuippnu_post_type_label( get_post_type( $slide_post ) ) ); ?></span>
									<h2><?php echo esc_html( get_the_title( $slide_post ) ); ?></h2>
									<p><?php echo esc_html( wp_trim_words( get_the_excerpt( $slide_post ), 18 ) ); ?></p>
									<a class="text-link text-link--light" href="<?php echo esc_url( get_permalink( $slide_post ) ); ?>"><?php esc_html_e( 'Baca Detail', 'pac-ipnu-ippnu' ); ?></a>
								</div>
							</article>
						<?php endforeach; ?>
					<?php else : ?>
						<?php foreach ( $pacipnuippnu_default_slides as $index => $slide ) : ?>
							<article class="hero-slide <?php echo 0 === $index ? 'is-active' : ''; ?>" style="--hero-bg: url('<?php echo esc_url( $slide['image'] ); ?>');">
								<div class="hero-slide__overlay"></div>
								<div class="hero-slide__content">
									<span class="eyebrow"><?php esc_html_e( 'Media Organisasi', 'pac-ipnu-ippnu' ); ?></span>
									<h2><?php echo esc_html( $slide['title'] ); ?></h2>
									<p><?php echo esc_html( $slide['description'] ); ?></p>
									<a class="text-link text-link--light" href="<?php echo esc_url( $slide['url'] ); ?>"><?php echo esc_html( $slide['button'] ); ?></a>
								</div>
							</article>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<div class="hero-slider__controls">
					<button type="button" data-hero-prev aria-label="<?php esc_attr_e( 'Slide sebelumnya', 'pac-ipnu-ippnu' ); ?>"><span class="icon icon-arrow-left"></span></button>
					<div class="hero-slider__dots" data-hero-dots></div>
					<button type="button" data-hero-next aria-label="<?php esc_attr_e( 'Slide berikutnya', 'pac-ipnu-ippnu' ); ?>"><span class="icon icon-arrow-right"></span></button>
				</div>
			</div>
			<div class="floating-card floating-card--agenda">
				<strong><?php esc_html_e( 'Agenda & Arsip', 'pac-ipnu-ippnu' ); ?></strong>
				<span><?php esc_html_e( 'Tertata, cepat dicari, siap dibagikan.', 'pac-ipnu-ippnu' ); ?></span>
			</div>
		</div>
	</div>
</section>

<section class="quick-access">
	<div class="container quick-access__grid">
		<?php
		$quick_links = array(
			array( 'icon-calendar', __( 'Agenda', 'pac-ipnu-ippnu' ), __( 'Pantau kegiatan terdekat.', 'pac-ipnu-ippnu' ), get_post_type_archive_link( 'agenda' ) ?: home_url( '/agenda/' ) ),
			array( 'icon-file', __( 'Arsip', 'pac-ipnu-ippnu' ), __( 'Unduh dokumen organisasi.', 'pac-ipnu-ippnu' ), get_post_type_archive_link( 'arsip' ) ?: home_url( '/arsip/' ) ),
			array( 'icon-people', __( 'Anggota', 'pac-ipnu-ippnu' ), __( 'Masuk ke dashboard kader.', 'pac-ipnu-ippnu' ), pacipnuippnu_login_url() ),
		);
		foreach ( $quick_links as $link ) :
			?>
			<a class="quick-access__item reveal" href="<?php echo esc_url( $link[3] ); ?>">
				<span class="icon <?php echo esc_attr( $link[0] ); ?>"></span>
				<strong><?php echo esc_html( $link[1] ); ?></strong>
				<small><?php echo esc_html( $link[2] ); ?></small>
			</a>
		<?php endforeach; ?>
	</div>
</section>

<section class="section section--leaders">
	<div class="container">
		<div class="section-heading section-heading--between reveal">
			<div>
				<span class="eyebrow"><?php esc_html_e( 'Struktur Organisasi', 'pac-ipnu-ippnu' ); ?></span>
				<h2><?php esc_html_e( 'Pengurus PAC IPNU IPPNU', 'pac-ipnu-ippnu' ); ?></h2>
			</div>
			<p><?php esc_html_e( 'Data struktur pengurus dikelola sendiri dari menu Struktur Pengurus di wp-admin, terpisah dari akun Pengguna WordPress.', 'pac-ipnu-ippnu' ); ?></p>
		</div>
		<div class="people-grid people-grid--modern">
			<?php
			$pengurus_query = new WP_Query(
				array(
					'post_type'      => 'pengurus',
					'posts_per_page' => 8,
					'post_status'    => 'publish',
					'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
				)
			);
			if ( $pengurus_query->have_posts() ) :
				while ( $pengurus_query->have_posts() ) :
					$pengurus_query->the_post();
					$nama    = get_post_meta( get_the_ID(), '_pac_pengurus_nama', true ) ?: get_the_title();
					$jabatan = get_post_meta( get_the_ID(), '_pac_pengurus_jabatan', true ) ?: __( 'Pengurus PAC IPNU IPPNU', 'pac-ipnu-ippnu' );
					$quote   = get_post_meta( get_the_ID(), '_pac_pengurus_quote', true );
					?>
					<article class="person-card person-card--modern reveal">
						<div class="person-card__photo">
							<img src="<?php echo esc_url( pacipnuippnu_pengurus_photo_url( get_the_ID(), 'pac-card' ) ); ?>" alt="<?php echo esc_attr( $nama ); ?>" loading="lazy">
						</div>
						<span><?php echo esc_html( $jabatan ); ?></span>
						<h3><?php echo esc_html( $nama ); ?></h3>
						<?php if ( $quote ) : ?>
							<p><?php echo esc_html( $quote ); ?></p>
						<?php endif; ?>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			<?php else : ?>
				<?php foreach ( array( 'Ketua', 'Sekretaris', 'Bendahara', 'Koordinator Kaderisasi' ) as $role ) : ?>
					<article class="person-card person-card--modern reveal">
						<div class="person-card__photo">
							<img src="<?php echo esc_url( PACIPNUIPPNu_URI . 'assets/images/default-avatar.svg' ); ?>" alt="<?php echo esc_attr( $role ); ?>" loading="lazy">
						</div>
						<span><?php echo esc_html( $role ); ?></span>
						<h3><?php esc_html_e( 'Nama Pengurus', 'pac-ipnu-ippnu' ); ?></h3>
						<p><?php esc_html_e( 'Tambahkan data asli melalui menu Pengurus di wp-admin.', 'pac-ipnu-ippnu' ); ?></p>
					</article>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<section class="section section--soft about-section">
	<div class="container">
		<div class="section-heading reveal">
			<span class="eyebrow"><?php esc_html_e( 'Tentang Organisasi', 'pac-ipnu-ippnu' ); ?></span>
			<h2><?php esc_html_e( 'Pelajar NU yang bergerak, tertib, dan bermanfaat', 'pac-ipnu-ippnu' ); ?></h2>
			<p><?php echo esc_html( pacipnuippnu_option( 'about_short', 'PAC IPNU IPPNU adalah wadah kaderisasi pelajar NU yang bergerak dalam penguatan keilmuan, kepemimpinan, keaswajaan, dan pengabdian masyarakat.' ) ); ?></p>
		</div>
		<div class="feature-grid">
			<article class="feature-card reveal">
				<span class="feature-card__icon icon icon-target"></span>
				<h3><?php esc_html_e( 'Visi', 'pac-ipnu-ippnu' ); ?></h3>
				<p><?php echo esc_html( pacipnuippnu_option( 'vision_text', 'Terwujudnya pelajar NU yang berilmu, berakhlak, mandiri, dan berdaya guna bagi agama, bangsa, dan masyarakat.' ) ); ?></p>
			</article>
			<article class="feature-card reveal">
				<span class="feature-card__icon icon icon-people"></span>
				<h3><?php esc_html_e( 'Misi', 'pac-ipnu-ippnu' ); ?></h3>
				<p><?php echo esc_html( pacipnuippnu_option( 'mission_text', 'Menguatkan kaderisasi, literasi, dakwah pelajar, advokasi pendidikan, dan jejaring komisariat secara berkelanjutan.' ) ); ?></p>
			</article>
		</div>
	</div>
</section>

<section class="stats-band">
	<div class="container stats-grid">
		<?php foreach ( pacipnuippnu_org_stats() as $label => $value ) : ?>
			<div class="stat-card reveal">
				<strong data-counter="<?php echo esc_attr( $value ); ?>">0</strong>
				<span><?php echo esc_html( ucwords( str_replace( '_', ' ', $label ) ) ); ?></span>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-heading section-heading--between reveal">
			<div>
				<span class="eyebrow"><?php esc_html_e( 'Berita Terbaru', 'pac-ipnu-ippnu' ); ?></span>
				<h2><?php esc_html_e( 'Kabar dan publikasi organisasi', 'pac-ipnu-ippnu' ); ?></h2>
			</div>
			<a class="text-link" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/berita/' ) ); ?>"><?php esc_html_e( 'Semua Berita', 'pac-ipnu-ippnu' ); ?></a>
		</div>
		<?php
		$news = new WP_Query(
			array(
				'post_type'      => 'post',
				'posts_per_page' => 3,
				'post_status'    => 'publish',
			)
		);
		?>
		<?php if ( $news->have_posts() ) : ?>
			<div class="post-grid post-grid--three">
				<?php
				while ( $news->have_posts() ) :
					$news->the_post();
					get_template_part( 'template-parts/content', 'card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>
		<?php endif; ?>
	</div>
</section>

<section class="section section--soft">
	<div class="container">
		<div class="section-heading section-heading--between reveal">
			<div>
				<span class="eyebrow"><?php esc_html_e( 'Agenda Kegiatan', 'pac-ipnu-ippnu' ); ?></span>
				<h2><?php esc_html_e( 'Kegiatan terdekat kader dan komisariat', 'pac-ipnu-ippnu' ); ?></h2>
			</div>
			<a class="text-link" href="<?php echo esc_url( get_post_type_archive_link( 'agenda' ) ?: home_url( '/agenda/' ) ); ?>"><?php esc_html_e( 'Kalender Agenda', 'pac-ipnu-ippnu' ); ?></a>
		</div>
		<?php
		$agenda = new WP_Query(
			array(
				'post_type'      => 'agenda',
				'posts_per_page' => 3,
				'post_status'    => 'publish',
				'meta_key'       => '_pac_agenda_date',
				'orderby'        => 'meta_value',
				'order'          => 'ASC',
			)
		);
		?>
		<div class="agenda-list">
			<?php if ( $agenda->have_posts() ) : ?>
				<?php
				while ( $agenda->have_posts() ) :
					$agenda->the_post();
					$date   = get_post_meta( get_the_ID(), '_pac_agenda_date', true );
					$status = get_post_meta( get_the_ID(), '_pac_agenda_status', true ) ?: 'upcoming';
					?>
					<article class="agenda-card reveal">
						<div class="agenda-card__date">
							<strong><?php echo esc_html( $date ? gmdate( 'd', strtotime( $date ) ) : get_the_date( 'd' ) ); ?></strong>
							<span><?php echo esc_html( $date ? gmdate( 'M Y', strtotime( $date ) ) : get_the_date( 'M Y' ) ); ?></span>
						</div>
						<div>
							<span class="status-badge status-badge--<?php echo esc_attr( $status ); ?>"><?php echo esc_html( pacipnuippnu_agenda_status_label( $status ) ); ?></span>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p><span class="icon icon-location"></span><?php echo esc_html( get_post_meta( get_the_ID(), '_pac_agenda_location', true ) ); ?></p>
						</div>
						<a class="icon-link" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>"><span class="icon icon-arrow-right"></span></a>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-heading reveal">
			<span class="eyebrow"><?php esc_html_e( 'Galeri Kegiatan', 'pac-ipnu-ippnu' ); ?></span>
			<h2><?php esc_html_e( 'Dokumentasi gerak kader', 'pac-ipnu-ippnu' ); ?></h2>
		</div>
		<?php
		$gallery = new WP_Query(
			array(
				'post_type'      => 'galeri',
				'posts_per_page' => 6,
				'post_status'    => 'publish',
			)
		);
		?>
		<div class="gallery-grid">
			<?php if ( $gallery->have_posts() ) : ?>
				<?php
				while ( $gallery->have_posts() ) :
					$gallery->the_post();
					$image     = pacipnuippnu_featured_image_url( get_the_ID(), 'pac-card' );
					$drive_url = get_post_meta( get_the_ID(), '_pac_gallery_drive_url', true );
					?>
					<article class="gallery-tile reveal">
						<a class="gallery-tile__image" href="<?php echo esc_url( $image ); ?>" data-lightbox aria-label="<?php the_title_attribute(); ?>">
							<img src="<?php echo esc_url( $image ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
						</a>
						<a class="gallery-tile__title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						<?php if ( $drive_url ) : ?>
							<a class="gallery-tile__drive" href="<?php echo esc_url( $drive_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Google Drive', 'pac-ipnu-ippnu' ); ?></a>
						<?php endif; ?>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			<?php else : ?>
				<article class="gallery-tile reveal">
					<a class="gallery-tile__image" href="<?php echo esc_url( PACIPNUIPPNu_URI . 'assets/images/default-gallery.svg' ); ?>" data-lightbox>
						<img src="<?php echo esc_url( PACIPNUIPPNu_URI . 'assets/images/default-gallery.svg' ); ?>" alt="<?php esc_attr_e( 'Galeri contoh', 'pac-ipnu-ippnu' ); ?>" loading="lazy">
					</a>
					<span class="gallery-tile__title"><?php esc_html_e( 'Dokumentasi Kegiatan', 'pac-ipnu-ippnu' ); ?></span>
				</article>
			<?php endif; ?>
		</div>
	</div>
</section>



<section class="section">
	<div class="container">
		<div class="section-heading reveal">
			<span class="eyebrow"><?php esc_html_e( 'Program Kerja', 'pac-ipnu-ippnu' ); ?></span>
			<h2><?php esc_html_e( 'Fokus gerakan organisasi', 'pac-ipnu-ippnu' ); ?></h2>
		</div>
		<div class="feature-grid feature-grid--four">
			<?php
			$programs = array(
				array( 'icon-book', 'Kaderisasi', 'Makesta, Lakmud, diskusi keaswajaan, dan sekolah kepemimpinan.' ),
				array( 'icon-megaphone', 'Media Informasi', 'Publikasi kegiatan, literasi digital, dan dokumentasi organisasi.' ),
				array( 'icon-file', 'Administrasi', 'Arsip, database anggota, dan layanan digital organisasi.' ),
				array( 'icon-handshake', 'Pengabdian', 'Bakti sosial, advokasi pelajar, dan kolaborasi lintas lembaga.' ),
			);
			foreach ( $programs as $program ) :
				?>
				<article class="feature-card reveal">
					<span class="feature-card__icon icon <?php echo esc_attr( $program[0] ); ?>"></span>
					<h3><?php echo esc_html( $program[1] ); ?></h3>
					<p><?php echo esc_html( $program[2] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>


<section class="section">
	<div class="container faq-layout">
		<div class="section-copy reveal">
			<span class="eyebrow"><?php esc_html_e( 'FAQ', 'pac-ipnu-ippnu' ); ?></span>
			<h2><?php esc_html_e( 'Pertanyaan yang sering diajukan', 'pac-ipnu-ippnu' ); ?></h2>
		</div>
		<div class="faq-list reveal">
			<?php
			$faqs = array(
				array( 'Bagaimana cara menjadi anggota?', 'Hubungi pengurus komisariat atau sekretariat untuk pendataan dan verifikasi anggota.' ),
				array( 'Siapa yang dapat mengelola arsip dan agenda?', 'Admin dan pengguna dengan role pengurus dapat mengelola konten organisasi melalui dashboard dan admin WordPress.' ),
			);
			foreach ( $faqs as $faq ) :
				?>
				<details class="faq-item">
					<summary><?php echo esc_html( $faq[0] ); ?></summary>
					<p><?php echo esc_html( $faq[1] ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="partner-band">
	<div class="container partner-track" data-partner-track>
		<?php foreach ( array( 'NU', 'Banom NU', 'Madrasah', 'Pesantren', 'Komisariat', 'Media Pelajar' ) as $partner ) : ?>
			<div class="partner-logo"><?php echo esc_html( $partner ); ?></div>
		<?php endforeach; ?>
	</div>
</section>

<section class="section contact-section">
	<div class="container split-layout">
		<div class="section-copy reveal">
			<span class="eyebrow"><?php esc_html_e( 'Kontak', 'pac-ipnu-ippnu' ); ?></span>
			<h2><?php esc_html_e( 'Terhubung dengan sekretariat', 'pac-ipnu-ippnu' ); ?></h2>
			<p><?php esc_html_e( 'Kirim pesan untuk kerja sama, informasi kegiatan, atau kebutuhan administrasi organisasi.', 'pac-ipnu-ippnu' ); ?></p>
		</div>
		<form class="contact-form ajax-form reveal" data-action="pacipnuippnu_contact">
			<input type="hidden" name="website" value="">
			<label><span><?php esc_html_e( 'Nama', 'pac-ipnu-ippnu' ); ?></span><input type="text" name="name" required></label>
			<label><span><?php esc_html_e( 'Email', 'pac-ipnu-ippnu' ); ?></span><input type="email" name="email" required></label>
			<label><span><?php esc_html_e( 'Pesan', 'pac-ipnu-ippnu' ); ?></span><textarea name="message" rows="4" required></textarea></label>
			<button class="btn btn--primary" type="submit"><?php esc_html_e( 'Kirim Pesan', 'pac-ipnu-ippnu' ); ?></button>
		</form>
	</div>
</section>

<?php
get_footer();

