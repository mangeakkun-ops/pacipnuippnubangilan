<?php
/**
 * Main template.
 *
 * @package PACIPNUIPPNu
 */

get_header();
?>

<section class="page-hero page-hero--compact">
	<div class="container">
		<?php get_template_part( 'template-parts/breadcrumb' ); ?>
		<h1><?php single_post_title(); ?></h1>
		<p><?php esc_html_e( 'Informasi terbaru dari organisasi, kegiatan, dan ruang kaderisasi.', 'pac-ipnu-ippnu' ); ?></p>
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

