<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package _s
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function _s_body_classes( $classes ) {
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
add_filter( 'body_class', '_s_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function _s_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', '_s_pingback_header' );

/**
 * Retrieve the sidebar menu items assigned to the sidebar location.
 *
 * @return array Array of WP_Post items representing the menu.
 */
function brendon_core_get_sidebar_menu_items() {
	$locations = get_nav_menu_locations();

	if ( empty( $locations['sidebar'] ) ) {
		return [];
	}

	$menu = wp_get_nav_menu_object( $locations['sidebar'] );

	if ( ! $menu ) {
		return [];
	}

	return wp_get_nav_menu_items( $menu->term_id ) ?: [];
}
