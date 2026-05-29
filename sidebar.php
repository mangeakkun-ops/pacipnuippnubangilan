<?php
/**
 * Sidebar template.
 *
 * @package PACIPNUIPPNu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<aside class="site-sidebar">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	<?php else : ?>
		<section class="widget widget_search">
			<h2 class="widget-title"><?php esc_html_e( 'Cari Berita', 'pac-ipnu-ippnu' ); ?></h2>
			<?php get_search_form(); ?>
		</section>

		<section class="widget">
			<h2 class="widget-title"><?php esc_html_e( 'Berita Terbaru', 'pac-ipnu-ippnu' ); ?></h2>
			<?php
			$pacipnuippnu_latest = new WP_Query(
				array(
					'post_type'      => 'post',
					'posts_per_page' => 5,
					'post_status'    => 'publish',
				)
			);
			if ( $pacipnuippnu_latest->have_posts() ) :
				?>
				<ul class="sidebar-posts">
					<?php
					while ( $pacipnuippnu_latest->have_posts() ) :
						$pacipnuippnu_latest->the_post();
						?>
						<li>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							<span><?php echo esc_html( get_the_date() ); ?></span>
						</li>
					<?php endwhile; ?>
				</ul>
				<?php
				wp_reset_postdata();
			endif;
			?>
		</section>

		<section class="widget">
			<h2 class="widget-title"><?php esc_html_e( 'Kategori', 'pac-ipnu-ippnu' ); ?></h2>
			<ul>
				<?php wp_list_categories( array( 'title_li' => '' ) ); ?>
			</ul>
		</section>
	<?php endif; ?>
</aside>

