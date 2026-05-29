<?php
/**
 * Pagination partial.
 *
 * @package PACIPNUIPPNu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

the_posts_pagination(
	array(
		'mid_size'  => 1,
		'prev_text' => esc_html__( 'Sebelumnya', 'pac-ipnu-ippnu' ),
		'next_text' => esc_html__( 'Berikutnya', 'pac-ipnu-ippnu' ),
	)
);

