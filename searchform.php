<?php
/**
 * Search form.
 *
 * @package PACIPNUIPPNu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php esc_html_e( 'Cari:', 'pac-ipnu-ippnu' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Cari...', 'pac-ipnu-ippnu' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	</label>
	<button class="btn btn--primary btn--sm" type="submit"><?php esc_html_e( 'Cari', 'pac-ipnu-ippnu' ); ?></button>
</form>

