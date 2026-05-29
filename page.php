<?php
/**
 * Page template.
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
			<?php if ( has_excerpt() ) : ?>
				<p><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<section class="section">
		<div class="container readable-content">
			<?php
			the_content();
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Halaman:', 'pac-ipnu-ippnu' ),
					'after'  => '</div>',
				)
			);
			?>
		</div>
	</section>
<?php endwhile; ?>

<?php
get_footer();

