<?php
/**
 * Search results template.
 *
 * @package PACIPNUIPPNu
 */

get_header();
?>

<section class="page-hero page-hero--compact">
	<div class="container">
		<?php get_template_part( 'template-parts/breadcrumb' ); ?>
		<h1><?php printf( esc_html__( 'Hasil pencarian: %s', 'pac-ipnu-ippnu' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
		<p><?php esc_html_e( 'Temukan berita, agenda, galeri, dan arsip organisasi dari satu pencarian.', 'pac-ipnu-ippnu' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="container layout-with-sidebar">
		<div class="content-list">
			<?php if ( have_posts() ) : ?>
				<div class="post-grid post-grid--two">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'card' );
					endwhile;
					?>
				</div>
				<?php get_template_part( 'template-parts/pagination' ); ?>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</section>

<?php
get_footer();

