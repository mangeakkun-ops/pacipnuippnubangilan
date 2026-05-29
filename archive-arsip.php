<?php
/**
 * Archive documents.
 *
 * @package PACIPNUIPPNu
 */

get_header();
?>

<section class="page-hero page-hero--compact">
	<div class="container">
		<?php get_template_part( 'template-parts/breadcrumb' ); ?>
		<h1><?php esc_html_e( 'Arsip Dokumen', 'pac-ipnu-ippnu' ); ?></h1>
		<p><?php esc_html_e( 'Pusat unduhan dokumen organisasi, administrasi, surat keputusan, dan bahan kaderisasi.', 'pac-ipnu-ippnu' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="archive-toolbar">
			<?php get_search_form(); ?>
			<div class="taxonomy-pills">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'arsip' ) ); ?>"><?php esc_html_e( 'Semua', 'pac-ipnu-ippnu' ); ?></a>
				<?php
				$terms = get_terms( array( 'taxonomy' => 'kategori_arsip', 'hide_empty' => true ) );
				foreach ( $terms as $term ) {
					printf( '<a href="%1$s">%2$s</a>', esc_url( get_term_link( $term ) ), esc_html( $term->name ) );
				}
				?>
			</div>
		</div>

		<?php if ( have_posts() ) : ?>
			<div class="document-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					$file = get_post_meta( get_the_ID(), '_pac_archive_file_url', true );
					$type = get_post_meta( get_the_ID(), '_pac_archive_type', true );
					?>
					<article class="document-card reveal">
						<div class="document-card__icon"><span class="icon icon-file"></span></div>
						<div>
							<span class="eyebrow"><?php echo esc_html( $type ?: __( 'Dokumen', 'pac-ipnu-ippnu' ) ); ?></span>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
							<div class="document-card__meta">
								<span><?php echo esc_html( get_the_date() ); ?></span>
								<span><?php echo esc_html( get_the_author() ); ?></span>
							</div>
						</div>
						<div class="document-card__actions">
							<a class="btn btn--outline" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Preview', 'pac-ipnu-ippnu' ); ?></a>
							<?php if ( $file ) : ?>
								<a class="btn btn--primary" href="<?php echo esc_url( $file ); ?>" download><?php esc_html_e( 'Download', 'pac-ipnu-ippnu' ); ?></a>
							<?php endif; ?>
						</div>
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

