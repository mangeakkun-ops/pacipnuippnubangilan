# PAC IPNU IPPNU WordPress Theme

Tema custom native WordPress untuk website organisasi pelajar NU tingkat PAC. Tema ini tidak memakai Elementor atau page builder, dan seluruh fitur utama dibangun melalui PHP theme development, template hierarchy, Custom Post Type, user role, AJAX, CSS, dan JavaScript custom.

## Instalasi

1. Salin folder `pac-ipnu-ippnu` ke direktori `wp-content/themes/`.
2. Aktifkan tema dari menu `Appearance > Themes`.
3. Saat tema diaktifkan, sistem membuat role `Anggota` dan `Pengurus`, flush permalink, serta seed halaman dan contoh konten awal.
4. Buka `Settings > Permalinks`, lalu klik `Save Changes` bila archive CPT belum tampil.
5. Atur identitas organisasi melalui `Appearance > Customize > Identitas Organisasi`.

## Halaman Otomatis

- `Beranda` memakai `front-page.php`.
- `Profil Organisasi` memakai `page-templates/profil-organisasi.php`.
- `Request Surat Online` memakai `page-templates/request-surat.php`.
- `Login Anggota` memakai `page-templates/login.php`.
- `Dashboard Anggota` memakai `page-templates/dashboard-anggota.php`.
- `Dashboard Pengurus` memakai `page-templates/dashboard-pengurus.php`.
- `Struktur Pengurus` dikelola sebagai data konten di wp-admin, bukan dari menu `Pengguna`.

## Custom Post Type

- `agenda`: kegiatan organisasi, tanggal, waktu, lokasi, status, poster dari featured image.
- `galeri`: dokumentasi kegiatan, kategori galeri, multi image dari media library.
- `arsip`: dokumen organisasi, kategori arsip, file download/preview, nomor dokumen.
- `surat_request`: request surat online, status approval, nomor surat otomatis, file pendukung, file surat jadi.
- `pengurus`: data struktur pengurus untuk homepage, berisi foto/muka, nama, jabatan, dan deskripsi singkat. Data ini terpisah dari akun `Pengguna` WordPress.

## Role

- `Admin`: administrator WordPress penuh.
- `Pengurus`: mengelola berita, agenda, galeri, arsip, request surat, export data, dan approval.
- `Anggota`: login front-end, update profil, request surat, melihat riwayat, dan download arsip.

## Relasi Data WordPress

- Data berita memakai tabel `wp_posts` post type `post`, kategori/tag native WordPress.
- Data agenda/galeri/arsip/request surat memakai `wp_posts` dengan post type masing-masing.
- Field tambahan disimpan di `wp_postmeta`:
  - `_pac_agenda_date`, `_pac_agenda_time`, `_pac_agenda_location`, `_pac_agenda_status`
  - `_pac_gallery_ids`, `_pac_gallery_drive_url`
  - `_pac_archive_file_url`, `_pac_archive_type`, `_pac_archive_number`
  - `_pac_surat_nama`, `_pac_surat_nik`, `_pac_surat_komisariat`, `_pac_surat_hp`, `_pac_surat_email`, `_pac_surat_jenis`, `_pac_surat_keperluan`, `_pac_surat_status`, `_pac_surat_nomor`, `_pac_surat_file_url`, `_pac_surat_support_file`, `_pac_surat_note`
  - `_pac_pengurus_nama`, `_pac_pengurus_photo_url`, `_pac_pengurus_jabatan`, `_pac_pengurus_quote`
- Data anggota/pengurus memakai `wp_users` dan `wp_usermeta`:
  - `pac_nik`, `pac_komisariat`, `pac_hp`, `pac_status_keanggotaan`, `pac_avatar_url`
- Taksonomi memakai `wp_terms`, `wp_term_taxonomy`, dan `wp_term_relationships`.

## Keamanan Dasar

- Nonce WordPress pada form login/register, metabox, AJAX, export.
- `sanitize_*` untuk input dan `esc_*` untuk output.
- Honeypot anti-spam untuk contact form, request surat, dan komentar.
- Pembatasan approval/export hanya untuk Admin atau role Pengurus.
- Header keamanan dasar: `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`.

## Aset

- CSS utama: `assets/css/main.css`
- CSS dashboard: `assets/css/dashboard.css`
- JavaScript utama: `assets/js/main.js`
- JavaScript dashboard: `assets/js/dashboard.js`
- Ilustrasi SVG: `assets/images/`

