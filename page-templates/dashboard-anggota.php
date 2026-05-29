<?php
/**
 * Template Name: Dashboard Anggota
 *
 * @package PACIPNUIPPNu
 */

pacipnuippnu_require_login();
get_header();

$user     = wp_get_current_user();
$agenda   = new WP_Query( array( 'post_type' => 'agenda', 'posts_per_page' => 4, 'post_status' => 'publish', 'meta_key' => '_pac_agenda_date', 'orderby' => 'meta_value', 'order' => 'ASC' ) );
$docs     = new WP_Query( array( 'post_type' => 'arsip', 'posts_per_page' => 4, 'post_status' => 'publish' ) );
?>

<section class="dashboard-shell">
	<div class="container dashboard-grid">
		<aside class="dashboard-sidebar">
			<div class="member-card">
				<img src="<?php echo esc_url( pacipnuippnu_user_avatar_url( $user->ID ) ); ?>" alt="<?php echo esc_attr( $user->display_name ); ?>" loading="lazy">
				<h1><?php echo esc_html( $user->display_name ); ?></h1>
				<p><?php echo esc_html( pacipnuippnu_current_user_role_label() ); ?></p>
				<a class="btn btn--outline btn--full" href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>"><?php esc_html_e( 'Keluar', 'pac-ipnu-ippnu' ); ?></a>
			</div>
			<nav class="dashboard-nav">
				<a href="#profil"><?php esc_html_e( 'Profil', 'pac-ipnu-ippnu' ); ?></a>
				<a href="#kegiatan"><?php esc_html_e( 'Kegiatan', 'pac-ipnu-ippnu' ); ?></a>
				<a href="#arsip"><?php esc_html_e( 'Download', 'pac-ipnu-ippnu' ); ?></a>
			</nav>
		</aside>

		<div class="dashboard-content">
			<div class="dashboard-heading">
				<div>
					<span class="eyebrow"><?php esc_html_e( 'Dashboard Anggota', 'pac-ipnu-ippnu' ); ?></span>
					<h2><?php esc_html_e( 'Selamat datang di ruang anggota', 'pac-ipnu-ippnu' ); ?></h2>
				</div>
			</div>

			<section id="profil" class="dashboard-panel">
				<h3><?php esc_html_e( 'Profil Anggota', 'pac-ipnu-ippnu' ); ?></h3>
				<div class="member-identity">
					<div class="digital-card">
						<span><?php echo esc_html( pacipnuippnu_option( 'org_name', 'PAC IPNU IPPNU' ) ); ?></span>
						<strong><?php echo esc_html( $user->display_name ); ?></strong>
						<small><?php echo esc_html( get_user_meta( $user->ID, 'pac_komisariat', true ) ?: __( 'Komisariat belum diisi', 'pac-ipnu-ippnu' ) ); ?></small>
						<em><?php echo esc_html( 'ID-' . str_pad( (string) $user->ID, 5, '0', STR_PAD_LEFT ) ); ?></em>
					</div>
					<form class="profile-form ajax-form" data-action="pacipnuippnu_update_profile" enctype="multipart/form-data">
						<div class="form-grid">
							<label><span><?php esc_html_e( 'Nama Depan', 'pac-ipnu-ippnu' ); ?></span><input type="text" name="first_name" value="<?php echo esc_attr( $user->first_name ); ?>"></label>
							<label><span><?php esc_html_e( 'Nama Belakang', 'pac-ipnu-ippnu' ); ?></span><input type="text" name="last_name" value="<?php echo esc_attr( $user->last_name ); ?>"></label>
							<label><span><?php esc_html_e( 'NIK/NIS', 'pac-ipnu-ippnu' ); ?></span><input type="text" name="pac_nik" value="<?php echo esc_attr( get_user_meta( $user->ID, 'pac_nik', true ) ); ?>"></label>
							<label><span><?php esc_html_e( 'Komisariat', 'pac-ipnu-ippnu' ); ?></span><input type="text" name="pac_komisariat" value="<?php echo esc_attr( get_user_meta( $user->ID, 'pac_komisariat', true ) ); ?>"></label>
							<label><span><?php esc_html_e( 'Nomor HP', 'pac-ipnu-ippnu' ); ?></span><input type="text" name="pac_hp" value="<?php echo esc_attr( get_user_meta( $user->ID, 'pac_hp', true ) ); ?>"></label>
							<label><span><?php esc_html_e( 'Status Keanggotaan', 'pac-ipnu-ippnu' ); ?></span><input type="text" name="pac_status_keanggotaan" value="<?php echo esc_attr( get_user_meta( $user->ID, 'pac_status_keanggotaan', true ) ?: __( 'Aktif', 'pac-ipnu-ippnu' ) ); ?>"></label>
							<label class="form-grid__full"><span><?php esc_html_e( 'Foto Profil', 'pac-ipnu-ippnu' ); ?></span><input type="file" name="avatar" accept=".jpg,.jpeg,.png,.webp"></label>
						</div>
						<button class="btn btn--primary" type="submit"><?php esc_html_e( 'Simpan Profil', 'pac-ipnu-ippnu' ); ?></button>
					</form>
				</div>
			</section>

			<section id="kegiatan" class="dashboard-panel">
				<h3><?php esc_html_e( 'Riwayat dan Agenda Kegiatan', 'pac-ipnu-ippnu' ); ?></h3>
				<div class="mini-card-grid">
					<?php while ( $agenda->have_posts() ) : $agenda->the_post(); ?>
						<a class="mini-card" href="<?php the_permalink(); ?>"><strong><?php the_title(); ?></strong><span><?php echo esc_html( get_post_meta( get_the_ID(), '_pac_agenda_date', true ) ); ?></span></a>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			</section>

			<section id="arsip" class="dashboard-panel">
				<h3><?php esc_html_e( 'Download File Organisasi', 'pac-ipnu-ippnu' ); ?></h3>
				<div class="mini-card-grid">
					<?php while ( $docs->have_posts() ) : $docs->the_post(); ?>
						<?php $file = get_post_meta( get_the_ID(), '_pac_archive_file_url', true ); ?>
						<a class="mini-card" href="<?php echo esc_url( $file ?: get_permalink() ); ?>"><strong><?php the_title(); ?></strong><span><?php esc_html_e( 'Unduh dokumen', 'pac-ipnu-ippnu' ); ?></span></a>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			</section>
		</div>
	</div>
</section>

<?php
get_footer();

