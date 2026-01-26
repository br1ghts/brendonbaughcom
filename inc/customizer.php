<?php
/**
 * _s Theme Customizer
 *
 * @package _s
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function _s_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => '_s_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => '_s_customize_partial_blogdescription',
			)
		);
	}
}
add_action( 'customize_register', '_s_customize_register' );

/**
 * Register controls to manage the sidebar socials list.
 *
 * @param WP_Customize_Manager $wp_customize
 */
function brendon_core_customize_social_links( $wp_customize ) {
	$wp_customize->add_section(
		'brendon_core_social_links',
		[
			'title'       => esc_html__( 'Sidebar Social Links', 'brendon-core' ),
			'description' => esc_html__( 'Update which links appear in the sidebar card.', 'brendon-core' ),
			'priority'    => 140,
		]
	);

	$defaults = brendon_core_default_social_links();
	$choices  = brendon_core_get_social_icon_choices();

	foreach ( $defaults as $index => $link ) {
		$wp_customize->add_setting(
			"brendon_core_social_{$index}_label",
			[
				'default'           => $link['label'],
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			"brendon_core_social_{$index}_label",
			[
				'label'       => sprintf( esc_html__( 'Link %d label', 'brendon-core' ), $index + 1 ),
				'section'     => 'brendon_core_social_links',
				'type'        => 'text',
			]
		);

		$wp_customize->add_setting(
			"brendon_core_social_{$index}_url",
			[
				'default'           => $link['url'],
				'sanitize_callback' => 'esc_url_raw',
			]
		);

		$wp_customize->add_control(
			"brendon_core_social_{$index}_url",
			[
				'label'       => sprintf( esc_html__( 'Link %d URL', 'brendon-core' ), $index + 1 ),
				'section'     => 'brendon_core_social_links',
				'type'        => 'url',
			]
		);

		$wp_customize->add_setting(
			"brendon_core_social_{$index}_icon",
			[
				'default'           => $link['icon'],
				'sanitize_callback' => 'brendon_core_sanitize_social_icon',
			]
		);

		$wp_customize->add_control(
			"brendon_core_social_{$index}_icon",
			[
				'label'       => sprintf( esc_html__( 'Link %d icon', 'brendon-core' ), $index + 1 ),
				'description' => esc_html__( 'Select the icon that appears before the label.', 'brendon-core' ),
				'section'     => 'brendon_core_social_links',
				'type'        => 'select',
				'choices'     => $choices,
			]
		);
	}
}
add_action( 'customize_register', 'brendon_core_customize_social_links' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function _s_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function _s_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function _s_customize_preview_js() {
	wp_enqueue_script( '_s-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', '_s_customize_preview_js' );
