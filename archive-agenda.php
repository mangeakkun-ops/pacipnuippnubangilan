<?php
/**
 * Agenda archive.
 *
 * @package PACIPNUIPPNu
 */

get_header();
?>

<section class="page-hero page-hero--compact">
	<div class="container">
		<?php get_template_part( 'template-parts/breadcrumb' ); ?>
		<h1><?php esc_html_e( 'Agenda Kegiatan', 'pac-ipnu-ippnu' ); ?></h1>
		<p><?php esc_html_e( 'Kalender kegiatan, rapat, kaderisasi, dan agenda publik organisasi.', 'pac-ipnu-ippnu' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="archive-toolbar">
			<?php get_search_form(); ?>
			<div class="taxonomy-pills">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'agenda' ) ); ?>"><?php esc_html_e( 'Semua', 'pac-ipnu-ippnu' ); ?></a>
				<?php
				$terms = get_terms( array( 'taxonomy' => 'kategori_agenda', 'hide_empty' => true ) );
				foreach ( $terms as $term ) {
					printf( '<a href="%1$s">%2$s</a>', esc_url( get_term_link( $term ) ), esc_html( $term->name ) );
				}
				?>
			</div>
		</div>
		<?php if ( have_posts() ) : ?>
			<div class="agenda-list agenda-list--archive">
				<?php
				while ( have_posts() ) :
					the_post();
					$date     = get_post_meta( get_the_ID(), '_pac_agenda_date', true );
					$time     = get_post_meta( get_the_ID(), '_pac_agenda_time', true );
					$location = get_post_meta( get_the_ID(), '_pac_agenda_location', true );
					$status   = get_post_meta( get_the_ID(), '_pac_agenda_status', true ) ?: 'upcoming';
					?>
					<article class="agenda-card reveal">
						<div class="agenda-card__date">
							<strong><?php echo esc_html( $date ? gmdate( 'd', strtotime( $date ) ) : get_the_date( 'd' ) ); ?></strong>
							<span><?php echo esc_html( $date ? gmdate( 'M Y', strtotime( $date ) ) : get_the_date( 'M Y' ) ); ?></span>
						</div>
						<div>
							<span class="status-badge status-badge--<?php echo esc_attr( $status ); ?>"><?php echo esc_html( pacipnuippnu_agenda_status_label( $status ) ); ?></span>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p><span class="icon icon-clock"></span><?php echo esc_html( $time ); ?> <span class="icon icon-location"></span><?php echo esc_html( $location ); ?></p>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
						</div>
						<a class="btn btn--outline" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Detail', 'pac-ipnu-ippnu' ); ?></a>
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

