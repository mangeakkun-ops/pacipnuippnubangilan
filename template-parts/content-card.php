<?php
/**
 * Post card partial.
 *
 * @package PACIPNUIPPNu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<article <?php post_class( 'post-card reveal' ); ?>>
	<a class="post-card__media" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
		<img src="<?php echo esc_url( pacipnuippnu_featured_image_url( get_the_ID(), 'medium_large' ) ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
		<span class="post-card__type"><?php echo esc_html( pacipnuippnu_post_type_label( get_post_type() ) ); ?></span>
	</a>
	<div class="post-card__body">
		<div class="post-meta">
			<span><?php echo esc_html( get_the_date() ); ?></span>
			<?php if ( 'post' === get_post_type() ) : ?>
				<span><?php the_category( ', ' ); ?></span>
			<?php endif; ?>
		</div>
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
		<a class="text-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Baca selengkapnya', 'pac-ipnu-ippnu' ); ?></a>
	</div>
</article>

