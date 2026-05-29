<?php
/**
 * Single agenda.
 *
 * @package PACIPNUIPPNu
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>
	<?php
	$date     = get_post_meta( get_the_ID(), '_pac_agenda_date', true );
	$time     = get_post_meta( get_the_ID(), '_pac_agenda_time', true );
	$location = get_post_meta( get_the_ID(), '_pac_agenda_location', true );
	$status   = get_post_meta( get_the_ID(), '_pac_agenda_status', true ) ?: 'upcoming';
	?>
	<section class="single-hero" style="--single-bg: url('<?php echo esc_url( pacipnuippnu_featured_image_url( get_the_ID(), 'pac-hero' ) ); ?>');">
		<div class="single-hero__overlay"></div>
		<div class="container single-hero__content">
			<?php get_template_part( 'template-parts/breadcrumb' ); ?>
			<span class="status-badge status-badge--<?php echo esc_attr( $status ); ?>"><?php echo esc_html( pacipnuippnu_agenda_status_label( $status ) ); ?></span>
			<h1><?php the_title(); ?></h1>
			<div class="single-meta-grid">
				<span><strong><?php esc_html_e( 'Tanggal', 'pac-ipnu-ippnu' ); ?></strong><?php echo esc_html( $date ? gmdate( 'd M Y', strtotime( $date ) ) : get_the_date() ); ?></span>
				<span><strong><?php esc_html_e( 'Waktu', 'pac-ipnu-ippnu' ); ?></strong><?php echo esc_html( $time ); ?></span>
				<span><strong><?php esc_html_e( 'Lokasi', 'pac-ipnu-ippnu' ); ?></strong><?php echo esc_html( $location ); ?></span>
			</div>
		</div>
	</section>
	<section class="section">
		<div class="container layout-with-sidebar">
			<div class="readable-content">
				<?php if ( $date ) : ?>
					<div class="countdown-card" data-countdown="<?php echo esc_attr( $date . ' ' . ( $time ? $time : '00:00' ) ); ?>">
						<strong><?php esc_html_e( 'Menuju kegiatan', 'pac-ipnu-ippnu' ); ?></strong>
						<div class="countdown-values"></div>
					</div>
				<?php endif; ?>
				<?php the_content(); ?>
				<?php pacipnuippnu_social_share(); ?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</section>
<?php endwhile; ?>

<?php
get_footer();

