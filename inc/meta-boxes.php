<?php
/**
 * Meta boxes for organization data.
 *
 * @package PACIPNUIPPNu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function pacipnuippnu_register_meta_boxes() {
	add_meta_box( 'pac_agenda_detail', __( 'Detail Agenda', 'pac-ipnu-ippnu' ), 'pacipnuippnu_agenda_metabox', 'agenda', 'normal', 'high' );
	add_meta_box( 'pac_gallery_images', __( 'Foto Galeri', 'pac-ipnu-ippnu' ), 'pacipnuippnu_gallery_metabox', 'galeri', 'normal', 'high' );
	add_meta_box( 'pac_archive_file', __( 'Dokumen Arsip', 'pac-ipnu-ippnu' ), 'pacipnuippnu_archive_metabox', 'arsip', 'normal', 'high' );
	add_meta_box( 'pac_surat_detail', __( 'Detail Request Surat', 'pac-ipnu-ippnu' ), 'pacipnuippnu_surat_metabox', 'surat_request', 'normal', 'high' );
	add_meta_box( 'pac_pengurus_detail', __( 'Detail Pengurus', 'pac-ipnu-ippnu' ), 'pacipnuippnu_pengurus_metabox', 'pengurus', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'pacipnuippnu_register_meta_boxes' );

function pacipnuippnu_metabox_nonce() {
	wp_nonce_field( 'pacipnuippnu_save_meta', 'pacipnuippnu_meta_nonce' );
}

function pacipnuippnu_agenda_metabox( $post ) {
	pacipnuippnu_metabox_nonce();
	$date     = get_post_meta( $post->ID, '_pac_agenda_date', true );
	$time     = get_post_meta( $post->ID, '_pac_agenda_time', true );
	$location = get_post_meta( $post->ID, '_pac_agenda_location', true );
	$status   = get_post_meta( $post->ID, '_pac_agenda_status', true ) ?: 'upcoming';
	?>
	<div class="pac-admin-grid">
		<label>
			<span><?php esc_html_e( 'Tanggal Kegiatan', 'pac-ipnu-ippnu' ); ?></span>
			<input type="date" name="pac_agenda_date" value="<?php echo esc_attr( $date ); ?>">
		</label>
		<label>
			<span><?php esc_html_e( 'Waktu', 'pac-ipnu-ippnu' ); ?></span>
			<input type="time" name="pac_agenda_time" value="<?php echo esc_attr( $time ); ?>">
		</label>
		<label>
			<span><?php esc_html_e( 'Lokasi', 'pac-ipnu-ippnu' ); ?></span>
			<input type="text" name="pac_agenda_location" value="<?php echo esc_attr( $location ); ?>" placeholder="<?php esc_attr_e( 'Gedung, masjid, sekolah, atau alamat', 'pac-ipnu-ippnu' ); ?>">
		</label>
		<label>
			<span><?php esc_html_e( 'Status', 'pac-ipnu-ippnu' ); ?></span>
			<select name="pac_agenda_status">
				<?php foreach ( array( 'upcoming', 'ongoing', 'completed', 'cancelled' ) as $value ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $status, $value ); ?>><?php echo esc_html( pacipnuippnu_agenda_status_label( $value ) ); ?></option>
				<?php endforeach; ?>
			</select>
		</label>
	</div>
	<?php
}

function pacipnuippnu_gallery_metabox( $post ) {
	pacipnuippnu_metabox_nonce();
	$ids       = get_post_meta( $post->ID, '_pac_gallery_ids', true );
	$drive_url = get_post_meta( $post->ID, '_pac_gallery_drive_url', true );
	?>
	<p><?php esc_html_e( 'Pilih banyak foto dari Media Library. Foto pertama dapat digunakan sebagai visual utama galeri.', 'pac-ipnu-ippnu' ); ?></p>
	<input type="hidden" name="pac_gallery_ids" id="pac_gallery_ids" value="<?php echo esc_attr( $ids ); ?>">
	<div class="pac-admin-grid">
		<label class="pac-admin-full">
			<span><?php esc_html_e( 'Link Google Drive Semua Foto', 'pac-ipnu-ippnu' ); ?></span>
			<input type="url" name="pac_gallery_drive_url" value="<?php echo esc_url( $drive_url ); ?>" placeholder="<?php esc_attr_e( 'https://drive.google.com/...', 'pac-ipnu-ippnu' ); ?>">
		</label>
	</div>
	<button type="button" class="button pac-media-gallery"><?php esc_html_e( 'Pilih Foto Galeri', 'pac-ipnu-ippnu' ); ?></button>
	<button type="button" class="button pac-media-clear"><?php esc_html_e( 'Kosongkan', 'pac-ipnu-ippnu' ); ?></button>
	<div class="pac-gallery-preview" id="pac_gallery_preview">
		<?php
		if ( $ids ) {
			foreach ( array_filter( array_map( 'absint', explode( ',', $ids ) ) ) as $attachment_id ) {
				echo wp_get_attachment_image( $attachment_id, 'thumbnail' );
			}
		}
		?>
	</div>
	<?php
}

function pacipnuippnu_archive_metabox( $post ) {
	pacipnuippnu_metabox_nonce();
	$file_url = get_post_meta( $post->ID, '_pac_archive_file_url', true );
	$type     = get_post_meta( $post->ID, '_pac_archive_type', true );
	$number   = get_post_meta( $post->ID, '_pac_archive_number', true );
	?>
	<div class="pac-admin-grid">
		<label>
			<span><?php esc_html_e( 'Nomor Dokumen', 'pac-ipnu-ippnu' ); ?></span>
			<input type="text" name="pac_archive_number" value="<?php echo esc_attr( $number ); ?>">
		</label>
		<label>
			<span><?php esc_html_e( 'Jenis Dokumen', 'pac-ipnu-ippnu' ); ?></span>
			<select name="pac_archive_type">
				<?php foreach ( array( 'PDF', 'DOC', 'XLS', 'PPT', 'ZIP', 'Lainnya' ) as $item ) : ?>
					<option value="<?php echo esc_attr( $item ); ?>" <?php selected( $type, $item ); ?>><?php echo esc_html( $item ); ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<label class="pac-admin-full">
			<span><?php esc_html_e( 'URL File Dokumen', 'pac-ipnu-ippnu' ); ?></span>
			<input type="url" name="pac_archive_file_url" id="pac_archive_file_url" value="<?php echo esc_url( $file_url ); ?>">
		</label>
	</div>
	<button type="button" class="button pac-media-file" data-target="pac_archive_file_url"><?php esc_html_e( 'Pilih / Upload Dokumen', 'pac-ipnu-ippnu' ); ?></button>
	<?php if ( $file_url ) : ?>
		<a class="button button-primary" href="<?php echo esc_url( $file_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Preview Dokumen', 'pac-ipnu-ippnu' ); ?></a>
	<?php endif; ?>
	<?php
}


function pacipnuippnu_pengurus_metabox( $post ) {
	pacipnuippnu_metabox_nonce();
	$nama      = get_post_meta( $post->ID, '_pac_pengurus_nama', true ) ?: get_the_title( $post );
	$jabatan   = get_post_meta( $post->ID, '_pac_pengurus_jabatan', true );
	$photo_url = get_post_meta( $post->ID, '_pac_pengurus_photo_url', true );
	$quote     = get_post_meta( $post->ID, '_pac_pengurus_quote', true );
	?>
	<div class="pac-admin-grid">
		<label>
			<span><?php esc_html_e( 'Nama Pengurus', 'pac-ipnu-ippnu' ); ?></span>
			<input type="text" name="pac_pengurus_nama" value="<?php echo esc_attr( $nama ); ?>" placeholder="<?php esc_attr_e( 'Nama lengkap yang tampil di homepage', 'pac-ipnu-ippnu' ); ?>">
		</label>
		<label>
			<span><?php esc_html_e( 'Jabatan', 'pac-ipnu-ippnu' ); ?></span>
			<input type="text" name="pac_pengurus_jabatan" value="<?php echo esc_attr( $jabatan ); ?>" placeholder="<?php esc_attr_e( 'Ketua, Sekretaris, Bendahara, ...', 'pac-ipnu-ippnu' ); ?>">
		</label>
		<label class="pac-admin-full">
			<span><?php esc_html_e( 'Foto / Muka Pengurus', 'pac-ipnu-ippnu' ); ?></span>
			<input type="url" name="pac_pengurus_photo_url" id="pac_pengurus_photo_url" value="<?php echo esc_url( $photo_url ); ?>" placeholder="<?php esc_attr_e( 'Pilih dari Media Library atau tempel URL foto', 'pac-ipnu-ippnu' ); ?>">
		</label>
		<label class="pac-admin-full">
			<span><?php esc_html_e( 'Deskripsi Singkat / Motto', 'pac-ipnu-ippnu' ); ?></span>
			<textarea name="pac_pengurus_quote" rows="3" placeholder="<?php esc_attr_e( 'Opsional, tampil sebagai teks kecil di kartu homepage.', 'pac-ipnu-ippnu' ); ?>"><?php echo esc_textarea( $quote ); ?></textarea>
		</label>
	</div>
	<p>
		<button type="button" class="button pac-media-file" data-target="pac_pengurus_photo_url" data-title="<?php esc_attr_e( 'Pilih Foto Pengurus', 'pac-ipnu-ippnu' ); ?>" data-library="image"><?php esc_html_e( 'Pilih / Upload Foto Pengurus', 'pac-ipnu-ippnu' ); ?></button>
		<?php if ( $photo_url ) : ?>
			<a class="button" href="<?php echo esc_url( $photo_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Preview Foto', 'pac-ipnu-ippnu' ); ?></a>
		<?php endif; ?>
	</p>
	<p><?php esc_html_e( 'Data ini khusus struktur organisasi dan berbeda dari menu Pengguna WordPress. Buat, edit, hapus, dan urutkan data pengurus dari menu Struktur Pengurus.', 'pac-ipnu-ippnu' ); ?></p>
	<?php
}

function pacipnuippnu_surat_metabox( $post ) {
	pacipnuippnu_metabox_nonce();
	$fields = array(
		'nama'       => __( 'Nama Lengkap', 'pac-ipnu-ippnu' ),
		'nik'        => __( 'NIK/NIS', 'pac-ipnu-ippnu' ),
		'komisariat' => __( 'Komisariat', 'pac-ipnu-ippnu' ),
		'hp'         => __( 'Nomor HP', 'pac-ipnu-ippnu' ),
		'email'      => __( 'Email', 'pac-ipnu-ippnu' ),
		'jenis'      => __( 'Jenis Surat', 'pac-ipnu-ippnu' ),
		'keperluan'  => __( 'Keperluan', 'pac-ipnu-ippnu' ),
	);
	$status   = get_post_meta( $post->ID, '_pac_surat_status', true ) ?: 'menunggu';
	$nomor    = get_post_meta( $post->ID, '_pac_surat_nomor', true );
	$file     = get_post_meta( $post->ID, '_pac_surat_file_url', true );
	$note     = get_post_meta( $post->ID, '_pac_surat_note', true );
	$upload   = get_post_meta( $post->ID, '_pac_surat_support_file', true );
	?>
	<div class="pac-admin-grid">
		<?php foreach ( $fields as $key => $label ) : ?>
			<label class="<?php echo 'keperluan' === $key ? 'pac-admin-full' : ''; ?>">
				<span><?php echo esc_html( $label ); ?></span>
				<?php if ( 'keperluan' === $key ) : ?>
					<textarea name="pac_surat_<?php echo esc_attr( $key ); ?>" rows="4"><?php echo esc_textarea( get_post_meta( $post->ID, '_pac_surat_' . $key, true ) ); ?></textarea>
				<?php else : ?>
					<input type="text" name="pac_surat_<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( get_post_meta( $post->ID, '_pac_surat_' . $key, true ) ); ?>">
				<?php endif; ?>
			</label>
		<?php endforeach; ?>
		<label>
			<span><?php esc_html_e( 'Status Permohonan', 'pac-ipnu-ippnu' ); ?></span>
			<select name="pac_surat_status">
				<?php foreach ( pacipnuippnu_get_request_statuses() as $value => $label ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $status, $value ); ?>><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<label>
			<span><?php esc_html_e( 'Nomor Surat', 'pac-ipnu-ippnu' ); ?></span>
			<input type="text" name="pac_surat_nomor" value="<?php echo esc_attr( $nomor ); ?>" placeholder="<?php esc_attr_e( 'Otomatis saat disetujui', 'pac-ipnu-ippnu' ); ?>">
		</label>
		<label class="pac-admin-full">
			<span><?php esc_html_e( 'URL Surat Jadi', 'pac-ipnu-ippnu' ); ?></span>
			<input type="url" name="pac_surat_file_url" id="pac_surat_file_url" value="<?php echo esc_url( $file ); ?>">
		</label>
		<label class="pac-admin-full">
			<span><?php esc_html_e( 'Catatan Pengurus', 'pac-ipnu-ippnu' ); ?></span>
			<textarea name="pac_surat_note" rows="3"><?php echo esc_textarea( $note ); ?></textarea>
		</label>
	</div>
	<button type="button" class="button pac-media-file" data-target="pac_surat_file_url"><?php esc_html_e( 'Upload Surat Jadi', 'pac-ipnu-ippnu' ); ?></button>
	<?php if ( $upload ) : ?>
		<a class="button" href="<?php echo esc_url( $upload ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'File Pendukung Pemohon', 'pac-ipnu-ippnu' ); ?></a>
	<?php endif; ?>
	<?php
}

function pacipnuippnu_save_meta_boxes( $post_id ) {
	if ( ! isset( $_POST['pacipnuippnu_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pacipnuippnu_meta_nonce'] ) ), 'pacipnuippnu_save_meta' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$post_type = get_post_type( $post_id );

	if ( 'agenda' === $post_type ) {
		$status = isset( $_POST['pac_agenda_status'] ) ? sanitize_key( wp_unslash( $_POST['pac_agenda_status'] ) ) : 'upcoming';
		if ( ! in_array( $status, array( 'upcoming', 'ongoing', 'completed', 'cancelled' ), true ) ) {
			$status = 'upcoming';
		}

		update_post_meta( $post_id, '_pac_agenda_date', isset( $_POST['pac_agenda_date'] ) ? sanitize_text_field( wp_unslash( $_POST['pac_agenda_date'] ) ) : '' );
		update_post_meta( $post_id, '_pac_agenda_time', isset( $_POST['pac_agenda_time'] ) ? sanitize_text_field( wp_unslash( $_POST['pac_agenda_time'] ) ) : '' );
		update_post_meta( $post_id, '_pac_agenda_location', isset( $_POST['pac_agenda_location'] ) ? sanitize_text_field( wp_unslash( $_POST['pac_agenda_location'] ) ) : '' );
		update_post_meta( $post_id, '_pac_agenda_status', $status );
	}

	if ( 'galeri' === $post_type ) {
		$ids = isset( $_POST['pac_gallery_ids'] ) ? implode( ',', array_filter( array_map( 'absint', explode( ',', wp_unslash( $_POST['pac_gallery_ids'] ) ) ) ) ) : '';
		update_post_meta( $post_id, '_pac_gallery_ids', $ids );
		update_post_meta( $post_id, '_pac_gallery_drive_url', isset( $_POST['pac_gallery_drive_url'] ) ? esc_url_raw( wp_unslash( $_POST['pac_gallery_drive_url'] ) ) : '' );
	}

	if ( 'arsip' === $post_type ) {
		update_post_meta( $post_id, '_pac_archive_file_url', isset( $_POST['pac_archive_file_url'] ) ? esc_url_raw( wp_unslash( $_POST['pac_archive_file_url'] ) ) : '' );
		update_post_meta( $post_id, '_pac_archive_type', isset( $_POST['pac_archive_type'] ) ? sanitize_text_field( wp_unslash( $_POST['pac_archive_type'] ) ) : '' );
		update_post_meta( $post_id, '_pac_archive_number', isset( $_POST['pac_archive_number'] ) ? sanitize_text_field( wp_unslash( $_POST['pac_archive_number'] ) ) : '' );
	}

	if ( 'pengurus' === $post_type ) {
		$nama = isset( $_POST['pac_pengurus_nama'] ) ? sanitize_text_field( wp_unslash( $_POST['pac_pengurus_nama'] ) ) : '';
		update_post_meta( $post_id, '_pac_pengurus_nama', $nama );
		update_post_meta( $post_id, '_pac_pengurus_photo_url', isset( $_POST['pac_pengurus_photo_url'] ) ? esc_url_raw( wp_unslash( $_POST['pac_pengurus_photo_url'] ) ) : '' );
		update_post_meta( $post_id, '_pac_pengurus_jabatan', isset( $_POST['pac_pengurus_jabatan'] ) ? sanitize_text_field( wp_unslash( $_POST['pac_pengurus_jabatan'] ) ) : '' );
		update_post_meta( $post_id, '_pac_pengurus_quote', isset( $_POST['pac_pengurus_quote'] ) ? sanitize_textarea_field( wp_unslash( $_POST['pac_pengurus_quote'] ) ) : '' );

		if ( $nama && get_the_title( $post_id ) !== $nama ) {
			remove_action( 'save_post', 'pacipnuippnu_save_meta_boxes' );
			wp_update_post(
				array(
					'ID'         => $post_id,
					'post_title' => $nama,
				)
			);
			add_action( 'save_post', 'pacipnuippnu_save_meta_boxes' );
		}
	}

	if ( 'surat_request' === $post_type ) {
		foreach ( array( 'nama', 'nik', 'komisariat', 'hp', 'email', 'jenis', 'keperluan' ) as $key ) {
			$value = isset( $_POST[ 'pac_surat_' . $key ] ) ? sanitize_textarea_field( wp_unslash( $_POST[ 'pac_surat_' . $key ] ) ) : '';
			update_post_meta( $post_id, '_pac_surat_' . $key, $value );
		}
		$status = isset( $_POST['pac_surat_status'] ) ? sanitize_key( wp_unslash( $_POST['pac_surat_status'] ) ) : 'menunggu';
		if ( ! array_key_exists( $status, pacipnuippnu_get_request_statuses() ) ) {
			$status = 'menunggu';
		}

		$nomor  = isset( $_POST['pac_surat_nomor'] ) ? sanitize_text_field( wp_unslash( $_POST['pac_surat_nomor'] ) ) : '';
		if ( 'disetujui' === $status && ! $nomor ) {
			$nomor = pacipnuippnu_generate_nomor_surat();
		}
		update_post_meta( $post_id, '_pac_surat_status', $status );
		update_post_meta( $post_id, '_pac_surat_nomor', $nomor );
		update_post_meta( $post_id, '_pac_surat_file_url', isset( $_POST['pac_surat_file_url'] ) ? esc_url_raw( wp_unslash( $_POST['pac_surat_file_url'] ) ) : '' );
		update_post_meta( $post_id, '_pac_surat_note', isset( $_POST['pac_surat_note'] ) ? sanitize_textarea_field( wp_unslash( $_POST['pac_surat_note'] ) ) : '' );
	}
}
add_action( 'save_post', 'pacipnuippnu_save_meta_boxes' );

function pacipnuippnu_admin_media_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	wp_enqueue_media();
	wp_register_style( 'pacipnuippnu-admin', false, array(), PACIPNUIPPNu_VERSION );
	wp_enqueue_style( 'pacipnuippnu-admin' );
	wp_add_inline_style(
		'pacipnuippnu-admin',
		'.pac-admin-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}.pac-admin-grid label{display:flex;flex-direction:column;gap:6px}.pac-admin-grid input,.pac-admin-grid select,.pac-admin-grid textarea{width:100%;max-width:100%}.pac-admin-full{grid-column:1/-1}.pac-gallery-preview{display:flex;flex-wrap:wrap;gap:10px;margin-top:14px}.pac-gallery-preview img{width:86px;height:86px;object-fit:cover;border-radius:8px;border:1px solid #dcdcde}@media(max-width:782px){.pac-admin-grid{grid-template-columns:1fr}}'
	);
}
add_action( 'admin_enqueue_scripts', 'pacipnuippnu_admin_media_assets' );

function pacipnuippnu_admin_media_script() {
	$screen = get_current_screen();
	if ( ! $screen || ! in_array( $screen->post_type, array( 'galeri', 'arsip', 'surat_request', 'pengurus' ), true ) ) {
		return;
	}
	?>
	<script>
	jQuery(function($){
		$('.pac-media-gallery').on('click', function(e){
			e.preventDefault();
			var frame = wp.media({ title: '<?php echo esc_js( __( 'Pilih Foto Galeri', 'pac-ipnu-ippnu' ) ); ?>', multiple: true, library: { type: 'image' } });
			frame.on('select', function(){
				var ids = [];
				var preview = $('#pac_gallery_preview').empty();
				frame.state().get('selection').each(function(attachment){
					var item = attachment.toJSON();
					ids.push(item.id);
					preview.append('<img src="' + (item.sizes && item.sizes.thumbnail ? item.sizes.thumbnail.url : item.url) + '" alt="">');
				});
				$('#pac_gallery_ids').val(ids.join(','));
			});
			frame.open();
		});
		$('.pac-media-clear').on('click', function(){
			$('#pac_gallery_ids').val('');
			$('#pac_gallery_preview').empty();
		});
		$('.pac-media-file').on('click', function(e){
			e.preventDefault();
			var target = $('#' + $(this).data('target'));
			var frame = wp.media({
					title: $(this).data('title') || '<?php echo esc_js( __( 'Pilih Dokumen', 'pac-ipnu-ippnu' ) ); ?>',
					multiple: false,
					library: $(this).data('library') ? { type: $(this).data('library') } : undefined
				});
			frame.on('select', function(){
				var item = frame.state().get('selection').first().toJSON();
				target.val(item.url);
			});
			frame.open();
		});
	});
	</script>
	<?php
}
add_action( 'admin_footer-post.php', 'pacipnuippnu_admin_media_script' );
add_action( 'admin_footer-post-new.php', 'pacipnuippnu_admin_media_script' );


function pacipnuippnu_pengurus_columns( $columns ) {
	$updated = array();
	foreach ( $columns as $key => $label ) {
		$updated[ $key ] = $label;
		if ( 'title' === $key ) {
			$updated['pac_pengurus_nama']    = __( 'Nama Tampil', 'pac-ipnu-ippnu' );
			$updated['pac_pengurus_jabatan'] = __( 'Jabatan', 'pac-ipnu-ippnu' );
			$updated['pac_pengurus_photo']   = __( 'Foto', 'pac-ipnu-ippnu' );
		}
	}

	return $updated;
}
add_filter( 'manage_pengurus_posts_columns', 'pacipnuippnu_pengurus_columns' );

function pacipnuippnu_pengurus_column_content( $column, $post_id ) {
	if ( 'pac_pengurus_nama' === $column ) {
		echo esc_html( get_post_meta( $post_id, '_pac_pengurus_nama', true ) ?: get_the_title( $post_id ) );
	}

	if ( 'pac_pengurus_jabatan' === $column ) {
		echo esc_html( get_post_meta( $post_id, '_pac_pengurus_jabatan', true ) ?: __( 'Belum diisi', 'pac-ipnu-ippnu' ) );
	}

	if ( 'pac_pengurus_photo' === $column ) {
		$photo_url = pacipnuippnu_pengurus_photo_url( $post_id );
		if ( $photo_url ) {
			echo '<img src="' . esc_url( $photo_url ) . '" alt="" style="width:56px;height:56px;object-fit:cover;border-radius:50%;">';
		} else {
			echo '&mdash;';
		}
	}
}
add_action( 'manage_pengurus_posts_custom_column', 'pacipnuippnu_pengurus_column_content', 10, 2 );

function pacipnuippnu_pengurus_title_placeholder( $title, $post ) {
	if ( 'pengurus' === $post->post_type ) {
		return __( 'Nama lengkap pengurus', 'pac-ipnu-ippnu' );
	}

	return $title;
}
add_filter( 'enter_title_here', 'pacipnuippnu_pengurus_title_placeholder', 10, 2 );
