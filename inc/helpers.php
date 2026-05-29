<?php
/**
 * Shared helper functions.
 *
 * @package PACIPNUIPPNu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function pacipnuippnu_option( $key, $default = '' ) {
	return get_theme_mod( 'pacipnuippnu_' . $key, $default );
}

function pacipnuippnu_allowed_map_html() {
	return array(
		'iframe' => array(
			'src'             => true,
			'width'           => true,
			'height'          => true,
			'style'           => true,
			'allowfullscreen' => true,
			'loading'         => true,
			'referrerpolicy'  => true,
			'aria-label'      => true,
		),
	);
}

function pacipnuippnu_fallback_menu() {
	$items = array(
		home_url( '/' )             => __( 'Beranda', 'pac-ipnu-ippnu' ),
		home_url( '/profil/' )      => __( 'Profil', 'pac-ipnu-ippnu' ),
		home_url( '/berita/' )      => __( 'Berita', 'pac-ipnu-ippnu' ),
		home_url( '/agenda/' )      => __( 'Agenda', 'pac-ipnu-ippnu' ),
		home_url( '/galeri/' )      => __( 'Galeri', 'pac-ipnu-ippnu' ),
		home_url( '/arsip/' )       => __( 'Arsip', 'pac-ipnu-ippnu' ),
	);

	echo '<ul id="primary-menu" class="primary-menu">';
	foreach ( $items as $url => $label ) {
		printf( '<li><a href="%1$s">%2$s</a></li>', esc_url( $url ), esc_html( $label ) );
	}
	echo '</ul>';
}

function pacipnuippnu_footer_fallback_menu() {
	$items = array(
		array( home_url( '/' ), __( 'Beranda', 'pac-ipnu-ippnu' ) ),
		array( home_url( '/profil-organisasi/' ), __( 'Profil Organisasi', 'pac-ipnu-ippnu' ) ),
		array( get_post_type_archive_link( 'agenda' ) ?: home_url( '/agenda/' ), __( 'Agenda', 'pac-ipnu-ippnu' ) ),
		array( get_post_type_archive_link( 'galeri' ) ?: home_url( '/galeri/' ), __( 'Galeri', 'pac-ipnu-ippnu' ) ),
		array( get_post_type_archive_link( 'arsip' ) ?: home_url( '/arsip/' ), __( 'Arsip Dokumen', 'pac-ipnu-ippnu' ) ),
		array( pacipnuippnu_login_url(), __( 'Login Anggota', 'pac-ipnu-ippnu' ) ),
	);

	echo '<ul class="footer-menu">';
	foreach ( $items as $item ) {
		printf( '<li><a href="%1$s">%2$s</a></li>', esc_url( $item[0] ), esc_html( $item[1] ) );
	}
	echo '</ul>';
}


function pacipnuippnu_hide_request_surat_menu_items( $items ) {
	return array_values(
		array_filter(
			$items,
			function ( $item ) {
				$url = isset( $item->url ) ? untrailingslashit( $item->url ) : '';

				return false === stripos( $url, '/request-surat' );
			}
		)
	);
}
add_filter( 'wp_nav_menu_objects', 'pacipnuippnu_hide_request_surat_menu_items' );

function pacipnuippnu_get_page_url_by_template( $template, $fallback = '' ) {
	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_wp_page_template',
			'meta_value'     => $template,
		)
	);

	if ( $pages ) {
		return get_permalink( $pages[0] );
	}

	return $fallback ? $fallback : home_url( '/' );
}

function pacipnuippnu_login_url() {
	return pacipnuippnu_get_page_url_by_template( 'page-templates/login.php', wp_login_url() );
}

function pacipnuippnu_dashboard_url() {
	if ( ! is_user_logged_in() ) {
		return pacipnuippnu_login_url();
	}

	if ( pacipnuippnu_can_manage_organization() ) {
		return pacipnuippnu_get_page_url_by_template( 'page-templates/dashboard-pengurus.php', admin_url() );
	}

	return pacipnuippnu_get_page_url_by_template( 'page-templates/dashboard-anggota.php', home_url( '/' ) );
}

function pacipnuippnu_request_surat_url() {
	return pacipnuippnu_get_page_url_by_template( 'page-templates/request-surat.php', home_url( '/request-surat/' ) );
}

function pacipnuippnu_post_type_label( $post_type ) {
	$object = get_post_type_object( $post_type );
	return $object ? $object->labels->singular_name : __( 'Konten', 'pac-ipnu-ippnu' );
}

function pacipnuippnu_featured_image_url( $post_id = null, $size = 'large' ) {
	$post_id = $post_id ? $post_id : get_the_ID();

	if ( has_post_thumbnail( $post_id ) ) {
		return get_the_post_thumbnail_url( $post_id, $size );
	}

	$type = get_post_type( $post_id );
	$file = 'default-thumbnail.svg';

	if ( 'agenda' === $type ) {
		$file = 'default-agenda.svg';
	} elseif ( 'galeri' === $type ) {
		$file = 'default-gallery.svg';
	} elseif ( 'arsip' === $type ) {
		$file = 'default-document.svg';
	} elseif ( 'pengurus' === $type ) {
		$file = 'default-avatar.svg';
	}

	return PACIPNUIPPNu_URI . 'assets/images/' . $file;
}


function pacipnuippnu_pengurus_photo_url( $post_id = null, $size = 'pac-card' ) {
	$post_id   = $post_id ? $post_id : get_the_ID();
	$photo_url = get_post_meta( $post_id, '_pac_pengurus_photo_url', true );

	if ( $photo_url ) {
		return $photo_url;
	}

	return pacipnuippnu_featured_image_url( $post_id, $size );
}

function pacipnuippnu_breadcrumb() {
	if ( is_front_page() ) {
		return;
	}

	echo '<nav class="breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'pac-ipnu-ippnu' ) . '">';
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Beranda', 'pac-ipnu-ippnu' ) . '</a>';

	if ( is_singular() ) {
		$post_type = get_post_type();
		if ( 'post' !== $post_type ) {
			$archive = get_post_type_archive_link( $post_type );
			$label   = pacipnuippnu_post_type_label( $post_type );
			if ( $archive ) {
				echo '<span>/</span><a href="' . esc_url( $archive ) . '">' . esc_html( $label ) . '</a>';
			}
		} elseif ( get_the_category() ) {
			$category = get_the_category()[0];
			echo '<span>/</span><a href="' . esc_url( get_category_link( $category ) ) . '">' . esc_html( $category->name ) . '</a>';
		}
		echo '<span>/</span><span>' . esc_html( get_the_title() ) . '</span>';
	} elseif ( is_archive() ) {
		echo '<span>/</span><span>' . wp_kses_post( get_the_archive_title() ) . '</span>';
	} elseif ( is_search() ) {
		echo '<span>/</span><span>' . esc_html__( 'Pencarian', 'pac-ipnu-ippnu' ) . '</span>';
	} elseif ( is_404() ) {
		echo '<span>/</span><span>404</span>';
	} elseif ( is_page() ) {
		echo '<span>/</span><span>' . esc_html( get_the_title() ) . '</span>';
	}

	echo '</nav>';
}

function pacipnuippnu_reading_time() {
	$content = wp_strip_all_tags( strip_shortcodes( get_post_field( 'post_content', get_the_ID() ) ) );
	$words   = str_word_count( $content );
	$minutes = max( 1, (int) ceil( $words / 200 ) );

	return sprintf(
		/* translators: %d: reading minutes. */
		_n( '%d menit baca', '%d menit baca', $minutes, 'pac-ipnu-ippnu' ),
		$minutes
	);
}

function pacipnuippnu_social_links() {
	$links = array(
		'facebook'  => pacipnuippnu_option( 'facebook_url', '#' ),
		'instagram' => pacipnuippnu_option( 'instagram_url', '#' ),
		'youtube'   => pacipnuippnu_option( 'youtube_url', '#' ),
		'tiktok'    => pacipnuippnu_option( 'tiktok_url', '#' ),
	);

	foreach ( $links as $network => $url ) {
		if ( empty( $url ) || '#' === $url ) {
			continue;
		}
		printf(
			'<a class="social-link social-link--%1$s" href="%2$s" target="_blank" rel="noopener"><span class="screen-reader-text">%3$s</span></a>',
			esc_attr( $network ),
			esc_url( $url ),
			esc_html( ucfirst( $network ) )
		);
	}
}

function pacipnuippnu_social_share() {
	$url   = rawurlencode( get_permalink() );
	$title = rawurlencode( get_the_title() );
	?>
	<div class="share-box">
		<strong><?php esc_html_e( 'Bagikan:', 'pac-ipnu-ippnu' ); ?></strong>
		<a href="<?php echo esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . $url ); ?>" target="_blank" rel="noopener">Facebook</a>
		<a href="<?php echo esc_url( 'https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title ); ?>" target="_blank" rel="noopener">X</a>
		<a href="<?php echo esc_url( 'https://api.whatsapp.com/send?text=' . $title . '%20' . $url ); ?>" target="_blank" rel="noopener">WhatsApp</a>
	</div>
	<?php
}

function pacipnuippnu_related_posts_section( $post_id ) {
	$post_type = get_post_type( $post_id );
	$args      = array(
		'post_type'           => $post_type,
		'post__not_in'        => array( $post_id ),
		'posts_per_page'      => 3,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
	);

	if ( 'post' === $post_type ) {
		$categories = wp_get_post_categories( $post_id );
		if ( $categories ) {
			$args['category__in'] = $categories;
		}
	}

	$query = new WP_Query( $args );

	if ( ! $query->have_posts() ) {
		return;
	}
	?>
	<section class="section section--soft">
		<div class="container">
			<div class="section-heading">
				<span class="eyebrow"><?php esc_html_e( 'Bacaan Terkait', 'pac-ipnu-ippnu' ); ?></span>
				<h2><?php esc_html_e( 'Konten yang masih berhubungan', 'pac-ipnu-ippnu' ); ?></h2>
			</div>
			<div class="post-grid post-grid--three">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					get_template_part( 'template-parts/content', 'card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
	<?php
}

function pacipnuippnu_get_request_statuses() {
	return array(
		'menunggu'  => __( 'Menunggu', 'pac-ipnu-ippnu' ),
		'diproses'  => __( 'Diproses', 'pac-ipnu-ippnu' ),
		'disetujui' => __( 'Disetujui', 'pac-ipnu-ippnu' ),
		'ditolak'   => __( 'Ditolak', 'pac-ipnu-ippnu' ),
	);
}

function pacipnuippnu_status_badge( $status ) {
	$statuses = pacipnuippnu_get_request_statuses();
	$label    = isset( $statuses[ $status ] ) ? $statuses[ $status ] : __( 'Menunggu', 'pac-ipnu-ippnu' );
	return '<span class="status-badge status-badge--' . esc_attr( $status ) . '">' . esc_html( $label ) . '</span>';
}

function pacipnuippnu_agenda_status_label( $status ) {
	$labels = array(
		'upcoming'   => __( 'Akan Datang', 'pac-ipnu-ippnu' ),
		'ongoing'    => __( 'Berlangsung', 'pac-ipnu-ippnu' ),
		'completed'  => __( 'Selesai', 'pac-ipnu-ippnu' ),
		'cancelled'  => __( 'Dibatalkan', 'pac-ipnu-ippnu' ),
	);

	return isset( $labels[ $status ] ) ? $labels[ $status ] : $labels['upcoming'];
}

function pacipnuippnu_roman_month( $month = null ) {
	$month  = $month ? (int) $month : (int) gmdate( 'n' );
	$romans = array( 1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII' );
	return isset( $romans[ $month ] ) ? $romans[ $month ] : 'I';
}

function pacipnuippnu_generate_nomor_surat() {
	$count = wp_count_posts( 'surat_request' );
	$total = isset( $count->publish ) ? (int) $count->publish + 1 : 1;

	return sprintf(
		'%03d/PAC-IPNU-IPPNU/%s/%s',
		$total,
		pacipnuippnu_roman_month(),
		gmdate( 'Y' )
	);
}

function pacipnuippnu_can_manage_organization() {
	if ( current_user_can( 'manage_options' ) ) {
		return true;
	}

	$user = wp_get_current_user();
	return in_array( 'pengurus', (array) $user->roles, true );
}

function pacipnuippnu_current_user_role_label() {
	$user = wp_get_current_user();
	if ( in_array( 'pengurus', (array) $user->roles, true ) ) {
		return __( 'Pengurus', 'pac-ipnu-ippnu' );
	}
	if ( in_array( 'anggota', (array) $user->roles, true ) ) {
		return __( 'Anggota', 'pac-ipnu-ippnu' );
	}
	if ( current_user_can( 'manage_options' ) ) {
		return __( 'Admin', 'pac-ipnu-ippnu' );
	}

	return __( 'Pengguna', 'pac-ipnu-ippnu' );
}

function pacipnuippnu_user_avatar_url( $user_id ) {
	$custom = get_user_meta( $user_id, 'pac_avatar_url', true );
	return $custom ? esc_url( $custom ) : get_avatar_url( $user_id, array( 'size' => 160 ) );
}

function pacipnuippnu_org_stats() {
	$member_query = new WP_User_Query(
		array(
			'role__in' => array( 'anggota', 'pengurus' ),
			'fields'   => 'ID',
		)
	);

	return array(
		'anggota'     => (int) $member_query->get_total(),
		'kegiatan'    => (int) wp_count_posts( 'agenda' )->publish,
		'komisariat'  => (int) pacipnuippnu_option( 'commissioner_count', 12 ),
		'arsip'       => (int) wp_count_posts( 'arsip' )->publish,
	);
}

function pacipnuippnu_get_page_id_by_template( $template ) {
	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_wp_page_template',
			'meta_value'     => $template,
		)
	);

	return $pages ? (int) $pages[0] : 0;
}
