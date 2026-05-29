<?php
/**
 * Gallery archive.
 *
 * @package PACIPNUIPPNu
 */

get_header();
?>

<section class="page-hero page-hero--compact">
	<div class="container">
		<?php get_template_part( 'template-parts/breadcrumb' ); ?>
		<h1><?php esc_html_e( 'Galeri Kegiatan', 'pac-ipnu-ippnu' ); ?></h1>
		<p><?php esc_html_e( 'Dokumentasi visual kegiatan kaderisasi, rapat, pengabdian, dan kolaborasi organisasi.', 'pac-ipnu-ippnu' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="archive-toolbar">
			<?php get_search_form(); ?>
			<div class="taxonomy-pills" data-gallery-filter>
				<button type="button" data-filter="all"><?php esc_html_e( 'Semua', 'pac-ipnu-ippnu' ); ?></button>
				<?php
				$terms = get_terms( array( 'taxonomy' => 'kategori_galeri', 'hide_empty' => true ) );
				foreach ( $terms as $term ) {
					printf( '<button type="button" data-filter="%1$s">%2$s</button>', esc_attr( $term->slug ), esc_html( $term->name ) );
				}
				?>
			</div>
		</div>

		<?php if ( have_posts() ) : ?>
			<div class="gallery-grid gallery-grid--masonry">
				<?php
				while ( have_posts() ) :
					the_post();
					$post_terms = wp_get_post_terms( get_the_ID(), 'kategori_galeri', array( 'fields' => 'slugs' ) );
					$image      = pacipnuippnu_featured_image_url( get_the_ID(), 'pac-card' );
					$drive_url  = get_post_meta( get_the_ID(), '_pac_gallery_drive_url', true );
					?>
					<article class="gallery-tile reveal" data-category="<?php echo esc_attr( implode( ' ', $post_terms ) ); ?>">
						<a class="gallery-tile__image" href="<?php echo esc_url( $image ); ?>" data-lightbox aria-label="<?php the_title_attribute(); ?>">
							<img src="<?php echo esc_url( $image ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
						</a>
						<a class="gallery-tile__title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						<?php if ( $drive_url ) : ?>
							<a class="gallery-tile__drive" href="<?php echo esc_url( $drive_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Google Drive', 'pac-ipnu-ippnu' ); ?></a>
						<?php endif; ?>
					</article>
				<?php endwhile; ?>
			</div>
			<?php get_template_part( 'template-parts/pagination' ); ?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();

