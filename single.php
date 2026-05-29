<?php
/**
 * Single post template.
 *
 * @package PACIPNUIPPNu
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>
	<article <?php post_class( 'single-article' ); ?>>
		<section class="single-hero" style="--single-bg: url('<?php echo esc_url( pacipnuippnu_featured_image_url( get_the_ID(), 'full' ) ); ?>');">
			<div class="single-hero__overlay"></div>
			<div class="container single-hero__content">
				<?php get_template_part( 'template-parts/breadcrumb' ); ?>
				<div class="post-meta">
					<span><?php echo esc_html( get_the_date() ); ?></span>
					<span><?php echo esc_html( pacipnuippnu_reading_time() ); ?></span>
					<span><?php the_category( ', ' ); ?></span>
				</div>
				<h1><?php the_title(); ?></h1>
			</div>
		</section>

		<section class="section">
			<div class="container layout-with-sidebar">
				<div class="readable-content">
					<?php the_content(); ?>
					<?php pacipnuippnu_social_share(); ?>
					<?php
					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Halaman:', 'pac-ipnu-ippnu' ),
							'after'  => '</div>',
						)
					);
					?>

					<?php if ( comments_open() || get_comments_number() ) : ?>
						<?php comments_template(); ?>
					<?php endif; ?>
				</div>

				<?php get_sidebar(); ?>
			</div>
		</section>

		<?php pacipnuippnu_related_posts_section( get_the_ID() ); ?>
	</article>
<?php endwhile; ?>

<?php
get_footer();

