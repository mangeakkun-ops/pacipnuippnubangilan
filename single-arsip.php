<?php
/**
 * Single document.
 *
 * @package PACIPNUIPPNu
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>
	<?php
	$file   = get_post_meta( get_the_ID(), '_pac_archive_file_url', true );
	$type   = get_post_meta( get_the_ID(), '_pac_archive_type', true );
	$number = get_post_meta( get_the_ID(), '_pac_archive_number', true );
	?>
	<section class="page-hero page-hero--compact">
		<div class="container">
			<?php get_template_part( 'template-parts/breadcrumb' ); ?>
			<span class="eyebrow"><?php echo esc_html( $type ?: __( 'Dokumen Organisasi', 'pac-ipnu-ippnu' ) ); ?></span>
			<h1><?php the_title(); ?></h1>
			<p><?php echo esc_html( $number ); ?></p>
		</div>
	</section>
	<section class="section">
		<div class="container layout-with-sidebar">
			<div class="readable-content">
				<?php the_content(); ?>
				<?php if ( $file ) : ?>
					<div class="document-preview">
						<iframe src="<?php echo esc_url( $file ); ?>" title="<?php the_title_attribute(); ?>" loading="lazy"></iframe>
					</div>
					<a class="btn btn--primary" href="<?php echo esc_url( $file ); ?>" download><?php esc_html_e( 'Download Dokumen', 'pac-ipnu-ippnu' ); ?></a>
				<?php else : ?>
					<div class="form-alert form-alert--error"><?php esc_html_e( 'File dokumen belum diunggah.', 'pac-ipnu-ippnu' ); ?></div>
				<?php endif; ?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</section>
<?php endwhile; ?>

<?php
get_footer();

