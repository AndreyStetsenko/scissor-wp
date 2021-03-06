<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Scissor
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function scissor_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'scissor_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function scissor_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'scissor_pingback_header' );

/**
 * Get Instagram Posts
 */
require get_template_directory() . '/inc/func/instagram.php';

/**
 * Woo Custom
 */
require get_template_directory() . '/inc/func/woo.php';

/**
 * Template Custom
 */
require get_template_directory() . '/inc/func/tmp.php';

/**
 * ACF
 */
require get_template_directory() . '/inc/func/acf.php';

/**
 * Auth
 */
require get_template_directory() . '/inc/func/auth.php';

/**
 * Custom Login
 */
require get_template_directory() . '/inc/func/login.php';

/**
 * Filter
 */
require get_template_directory() . '/inc/func/filter.php';

/**
 * Lang
 */

require get_template_directory() . '/inc/func/lang.php';
