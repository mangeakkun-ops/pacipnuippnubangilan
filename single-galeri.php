<?php
/**
 * Single gallery.
 *
 * @package PACIPNUIPPNu
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>
	<section class="page-hero page-hero--compact">
		<div class="container">
			<?php get_template_part( 'template-parts/breadcrumb' ); ?>
			<h1><?php the_title(); ?></h1>
			<p><?php echo esc_html( get_the_excerpt() ); ?></p>
		</div>
	</section>
	<section class="section">
		<div class="container">
			<div class="readable-content">
				<?php the_content(); ?>
			</div>
			<?php $drive_url = get_post_meta( get_the_ID(), '_pac_gallery_drive_url', true ); ?>
			<div class="gallery-grid gallery-grid--masonry">
				<?php
				$ids = get_post_meta( get_the_ID(), '_pac_gallery_ids', true );
				if ( $ids ) :
					foreach ( array_filter( array_map( 'absint', explode( ',', $ids ) ) ) as $attachment_id ) :
						$url = wp_get_attachment_image_url( $attachment_id, 'large' );
						?>
						<a class="gallery-tile reveal" href="<?php echo esc_url( $url ); ?>" data-lightbox>
							<?php echo wp_get_attachment_image( $attachment_id, 'medium_large', false, array( 'loading' => 'lazy' ) ); ?>
							<span><?php echo esc_html( get_the_title( $attachment_id ) ); ?></span>
						</a>
					<?php endforeach; ?>
				<?php else : ?>
					<a class="gallery-tile reveal" href="<?php echo esc_url( pacipnuippnu_featured_image_url( get_the_ID(), 'large' ) ); ?>" data-lightbox>
						<img src="<?php echo esc_url( pacipnuippnu_featured_image_url( get_the_ID(), 'large' ) ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
						<span><?php the_title(); ?></span>
					</a>
				<?php endif; ?>
			</div>
			<?php if ( $drive_url ) : ?>
				<div class="gallery-download-box reveal">
					<div>
						<strong><?php esc_html_e( 'Mau download semua foto?', 'pac-ipnu-ippnu' ); ?></strong>
						<p><?php esc_html_e( 'Buka folder Google Drive untuk mengunduh seluruh dokumentasi kegiatan ini.', 'pac-ipnu-ippnu' ); ?></p>
					</div>
					<a class="btn btn--primary" href="<?php echo esc_url( $drive_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Masuk ke Google Drive', 'pac-ipnu-ippnu' ); ?></a>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endwhile; ?>

<?php
get_footer();

