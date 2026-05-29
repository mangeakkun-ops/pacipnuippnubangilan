<?php
/**
 * Custom authentication screens.
 *
 * @package PACIPNUIPPNu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function pacipnuippnu_handle_auth_forms() {
	if ( empty( $_POST['pac_auth_action'] ) ) {
		return;
	}

	$action = sanitize_key( wp_unslash( $_POST['pac_auth_action'] ) );

	if ( 'login' === $action ) {
		if ( ! isset( $_POST['pac_login_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pac_login_nonce'] ) ), 'pac_login' ) ) {
			wp_safe_redirect( add_query_arg( 'auth', 'nonce', wp_get_referer() ?: pacipnuippnu_login_url() ) );
			exit;
		}

		$login    = isset( $_POST['log'] ) ? sanitize_text_field( wp_unslash( $_POST['log'] ) ) : '';
		$password = isset( $_POST['pwd'] ) ? (string) wp_unslash( $_POST['pwd'] ) : '';
		$user_obj = is_email( $login ) ? get_user_by( 'email', $login ) : false;
		$creds    = array(
			'user_login'    => $user_obj ? $user_obj->user_login : $login,
			'user_password' => $password,
			'remember'      => ! empty( $_POST['rememberme'] ),
		);

		$user = wp_signon( $creds, is_ssl() );

		if ( is_wp_error( $user ) ) {
			wp_safe_redirect( add_query_arg( 'auth', 'failed', pacipnuippnu_login_url() ) );
			exit;
		}

		wp_safe_redirect( pacipnuippnu_dashboard_url() );
		exit;
	}

	if ( 'register' === $action ) {
		wp_safe_redirect( add_query_arg( 'auth', 'registration_disabled', pacipnuippnu_login_url() ) );
		exit;
	}

	if ( 'lost_password' === $action ) {
		if ( ! isset( $_POST['pac_lost_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pac_lost_nonce'] ) ), 'pac_lost' ) ) {
			wp_safe_redirect( add_query_arg( 'auth', 'nonce', pacipnuippnu_login_url() ) );
			exit;
		}

		$result = retrieve_password();
		wp_safe_redirect( add_query_arg( 'auth', is_wp_error( $result ) ? 'lost_failed' : 'lost_sent', pacipnuippnu_login_url() ) );
		exit;
	}
}
add_action( 'template_redirect', 'pacipnuippnu_handle_auth_forms' );

function pacipnuippnu_auth_notice() {
	$state = isset( $_GET['auth'] ) ? sanitize_key( wp_unslash( $_GET['auth'] ) ) : '';
	if ( ! $state ) {
		return;
	}

	$messages = array(
		'failed'          => array( 'error', __( 'Login gagal. Periksa email/username dan kata sandi.', 'pac-ipnu-ippnu' ) ),
		'nonce'           => array( 'error', __( 'Sesi form kedaluwarsa. Silakan coba lagi.', 'pac-ipnu-ippnu' ) ),
		'registration_disabled' => array( 'error', __( 'Registrasi anggota sedang dinonaktifkan sementara.', 'pac-ipnu-ippnu' ) ),
		'lost_failed'     => array( 'error', __( 'Email reset password belum dapat dikirim.', 'pac-ipnu-ippnu' ) ),
		'lost_sent'       => array( 'success', __( 'Instruksi reset password sudah dikirim.', 'pac-ipnu-ippnu' ) ),
	);

	if ( ! isset( $messages[ $state ] ) ) {
		return;
	}

	printf( '<div class="form-alert form-alert--%1$s">%2$s</div>', esc_attr( $messages[ $state ][0] ), esc_html( $messages[ $state ][1] ) );
}

function pacipnuippnu_render_login_form() {
	?>
	<form class="auth-form" method="post">
		<?php wp_nonce_field( 'pac_login', 'pac_login_nonce' ); ?>
		<input type="hidden" name="pac_auth_action" value="login">
		<label>
			<span><?php esc_html_e( 'Email atau Username', 'pac-ipnu-ippnu' ); ?></span>
			<input type="text" name="log" autocomplete="username" required>
		</label>
		<label>
			<span><?php esc_html_e( 'Password', 'pac-ipnu-ippnu' ); ?></span>
			<input type="password" name="pwd" autocomplete="current-password" required>
		</label>
		<label class="checkbox-line">
			<input type="checkbox" name="rememberme" value="forever">
			<span><?php esc_html_e( 'Ingat saya', 'pac-ipnu-ippnu' ); ?></span>
		</label>
		<button class="btn btn--primary btn--full" type="submit"><?php esc_html_e( 'Masuk Dashboard', 'pac-ipnu-ippnu' ); ?></button>
	</form>
	<?php
}


function pacipnuippnu_render_lost_password_form() {
	?>
	<form class="auth-form" method="post">
		<?php wp_nonce_field( 'pac_lost', 'pac_lost_nonce' ); ?>
		<input type="hidden" name="pac_auth_action" value="lost_password">
		<label>
			<span><?php esc_html_e( 'Email atau Username', 'pac-ipnu-ippnu' ); ?></span>
			<input type="text" name="user_login" autocomplete="username" required>
		</label>
		<button class="btn btn--outline btn--full" type="submit"><?php esc_html_e( 'Kirim Link Reset', 'pac-ipnu-ippnu' ); ?></button>
	</form>
	<?php
}

function pacipnuippnu_login_logo_styles() {
	?>
	<style>
		body.login { background: #f4fbf6; }
		.login h1 a { background-image: url('<?php echo esc_url( PACIPNUIPPNu_URI . 'assets/images/logo.svg' ); ?>'); background-size: contain; width: 88px; height: 88px; }
		.login form { border: 0; border-radius: 16px; box-shadow: 0 20px 50px rgba(4, 83, 49, .12); }
		.wp-core-ui .button-primary { background: #0f7a45; border-color: #0f7a45; }
	</style>
	<?php
}
add_action( 'login_enqueue_scripts', 'pacipnuippnu_login_logo_styles' );

