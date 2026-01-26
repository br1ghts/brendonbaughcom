<?php

/**
 * The template for displaying all pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package brendon-core
 */

get_header();

while (have_posts()) :
	the_post();
	get_template_part('template-parts/content');
endwhile;

get_footer();
