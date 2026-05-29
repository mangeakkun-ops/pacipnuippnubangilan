<?php
/**
 * Template Name: Dashboard Pengurus
 *
 * @package PACIPNUIPPNu
 */

pacipnuippnu_require_manager();
get_header();

$counts   = pacipnuippnu_get_dashboard_counts();
$members  = pacipnuippnu_get_members( 8 );
?>

<section class="dashboard-shell dashboard-shell--manager">
	<div class="container dashboard-grid">
		<aside class="dashboard-sidebar">
			<div class="member-card">
				<img src="<?php echo esc_url( pacipnuippnu_user_avatar_url( get_current_user_id() ) ); ?>" alt="<?php echo esc_attr( wp_get_current_user()->display_name ); ?>" loading="lazy">
				<h1><?php echo esc_html( wp_get_current_user()->display_name ); ?></h1>
				<p><?php echo esc_html( pacipnuippnu_current_user_role_label() ); ?></p>
				<a class="btn btn--outline btn--full" href="<?php echo esc_url( admin_url() ); ?>"><?php esc_html_e( 'WP Admin', 'pac-ipnu-ippnu' ); ?></a>
			</div>
			<nav class="dashboard-nav">
				<a href="#statistik"><?php esc_html_e( 'Statistik', 'pac-ipnu-ippnu' ); ?></a>
				<a href="#anggota"><?php esc_html_e( 'Anggota', 'pac-ipnu-ippnu' ); ?></a>
				<a href="#konten"><?php esc_html_e( 'Manajemen Konten', 'pac-ipnu-ippnu' ); ?></a>
			</nav>
		</aside>

		<div class="dashboard-content">
			<div class="dashboard-heading">
				<div>
					<span class="eyebrow"><?php esc_html_e( 'Dashboard Pengurus', 'pac-ipnu-ippnu' ); ?></span>
					<h2><?php esc_html_e( 'Manajemen data organisasi', 'pac-ipnu-ippnu' ); ?></h2>
				</div>
				<div class="button-group">
					<a class="btn btn--outline" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=pacipnuippnu_export_members' ), 'pac_export_members' ) ); ?>"><?php esc_html_e( 'Export Anggota', 'pac-ipnu-ippnu' ); ?></a>
				</div>
			</div>

			<section id="statistik" class="dashboard-panel">
				<h3><?php esc_html_e( 'Statistik Website', 'pac-ipnu-ippnu' ); ?></h3>
				<div class="dashboard-stats">
					<?php foreach ( $counts as $label => $value ) : ?>
						<div class="stat-card">
							<strong><?php echo esc_html( $value ); ?></strong>
							<span><?php echo esc_html( ucwords( $label ) ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
				<canvas class="dashboard-chart" data-chart='<?php echo esc_attr( wp_json_encode( $counts ) ); ?>' width="900" height="320"></canvas>
			</section>

			<section id="anggota" class="dashboard-panel">
				<h3><?php esc_html_e( 'Manajemen Anggota', 'pac-ipnu-ippnu' ); ?></h3>
				<div class="table-wrap">
					<table>
						<thead><tr><th><?php esc_html_e( 'Nama', 'pac-ipnu-ippnu' ); ?></th><th><?php esc_html_e( 'Email', 'pac-ipnu-ippnu' ); ?></th><th><?php esc_html_e( 'Komisariat', 'pac-ipnu-ippnu' ); ?></th><th><?php esc_html_e( 'Role', 'pac-ipnu-ippnu' ); ?></th></tr></thead>
						<tbody>
						<?php foreach ( $members as $member ) : ?>
							<tr>
								<td><?php echo esc_html( $member->display_name ); ?></td>
								<td><?php echo esc_html( $member->user_email ); ?></td>
								<td><?php echo esc_html( get_user_meta( $member->ID, 'pac_komisariat', true ) ?: '-' ); ?></td>
								<td><?php echo esc_html( implode( ', ', $member->roles ) ); ?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</section>

			<section id="konten" class="dashboard-panel">
				<h3><?php esc_html_e( 'Manajemen Konten Organisasi', 'pac-ipnu-ippnu' ); ?></h3>
				<div class="quick-manage-grid">
					<a href="<?php echo esc_url( admin_url( 'edit.php' ) ); ?>"><span class="icon icon-newspaper"></span><strong><?php esc_html_e( 'Berita', 'pac-ipnu-ippnu' ); ?></strong></a>
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=agenda' ) ); ?>"><span class="icon icon-calendar"></span><strong><?php esc_html_e( 'Agenda', 'pac-ipnu-ippnu' ); ?></strong></a>
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=galeri' ) ); ?>"><span class="icon icon-image"></span><strong><?php esc_html_e( 'Galeri', 'pac-ipnu-ippnu' ); ?></strong></a>
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=arsip' ) ); ?>"><span class="icon icon-file"></span><strong><?php esc_html_e( 'Arsip', 'pac-ipnu-ippnu' ); ?></strong></a>
					<a href="<?php echo esc_url( admin_url( 'users.php' ) ); ?>"><span class="icon icon-people"></span><strong><?php esc_html_e( 'User', 'pac-ipnu-ippnu' ); ?></strong></a>
				</div>
			</section>
		</div>
	</div>
</section>

<?php
get_footer();

