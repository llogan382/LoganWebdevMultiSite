<?php
/**
 * Theme Customizer functionality
 *
 * @package     @@pkg.name
 * @link        @@pkg.theme_uri
 * @author      @@pkg.author
 * @copyright   @@pkg.copyright
 * @license     @@pkg.license
 */

/**
 * Customizer.
 *
 * @param WP_Customize_Manager $wp_customize the Customizer object.
 */
function tabor_customize_register( $wp_customize ) {

	/**
	 * Remove the Header Image panel, as we only need the "Display Site Title and Tagline" setting in Site Identity.
	 */
	$wp_customize->remove_section( 'header_image' );

	/**
	 * Customize.
	 */
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial(
		'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'tabor_customize_partial_blogname',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'tabor_customize_partial_blogdescription',
		)
	);

	/**
	 * Add custom controls.
	 */
	require get_parent_theme_file_path( THEMEBEANS_CUSTOM_CONTROLS_DIR . 'class-themebeans-title-control.php' );
	require get_parent_theme_file_path( THEMEBEANS_CUSTOM_CONTROLS_DIR . 'class-themebeans-range-control.php' );
	require get_parent_theme_file_path( THEMEBEANS_CUSTOM_CONTROLS_DIR . 'class-themebeans-toggle-control.php' );

	/**
	 * Top-Level Customizer sections and panels.
	 */
	$wp_customize->add_section(
		'tabor_theme_options', array(
			'title'    => esc_html__( 'Theme Options', '@@textdomain' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_section(
		'tabor_fonts', array(
			'title'    => esc_html__( 'Typography', '@@textdomain' ),
			'priority' => 40,
		)
	);

	  // Custom Work for Child Theme

	  $wp_customize->add_section(
		'custom_settings', array(
			'title'    => esc_html__( 'Custom Settings', '@@textdomain' ),
			'priority' => 35,
		)
    );
		$wp_customize->add_setting(
			'blog_archiveheader', array(
				'default'  => '',
				'transport' => 'refresh',
				'sanitize_callback' => 'tabor_sanitize_nohtml',
				)
		);
		$wp_customize->add_control(
			'blog_archiveheader', array(
				'type' => 'range',
				'label' => 	esc_html__( 'Blog Header', '@@textdomain' ),
				'section'     => 'custom_settings',
				'description' => __( 'Set the font size for the blog title in on the blog archive page.' ),
				'input_attrs' => array(
					'min' => 10,
					'max' => 70,
					'step' => 2,
					)
				)
			);

		$wp_customize->add_setting(
			'blogpost_fontsize', array(
				'default'  => '',
				'transport' => 'refresh',
				'sanitize_callback' => 'esc_html',
				)
			);

		$wp_customize->add_control(
			'blogpost_fontsize', array(
				'type'        => 'range',
				'label'       => esc_html__( 'Blog Content', '@@textdomain' ),
				'section'     => 'custom_settings',
				'description' => '',
				'input_attrs' => array(
						'min' => 6,
						'max' => 30,
						'step' => 1,
					)
			)
		);


	/**
	 * Typography.
	 */
	$wp_customize->add_setting(
		'heading_font', array(
			'default'           => tabor_defaults( 'heading_font' ),
			'sanitize_callback' => 'tabor_sanitize_nohtml',
		)
	);

	$wp_customize->add_control(
		'heading_font', array(
			'type'        => 'select',
			'label'       => esc_html__( 'Heading Font', '@@textdomain' ),
			'description' => '',
			'section'     => 'tabor_fonts',
			'choices'     => tabor_get_fonts(),
		)
	);

	$wp_customize->add_setting(
		'body_font', array(
			'default'           => tabor_defaults( 'body_font' ),
			'sanitize_callback' => 'tabor_sanitize_nohtml',
		)
	);

	$wp_customize->add_control(
		'body_font', array(
			'type'        => 'select',
			'label'       => esc_html__( 'Body Font', '@@textdomain' ),
			'description' => '',
			'section'     => 'tabor_fonts',
			'choices'     => tabor_get_fonts(),
		)
	);

	/**
	 * Typekit.
	 */
	$wp_customize->add_setting(
		'typekit_id', array(
			'default'           => tabor_defaults( 'typekit_id' ),
			'sanitize_callback' => 'esc_html',
		)
	);

	$wp_customize->add_control(
		'typekit_id', array(
			'type'        => 'text',
			'label'       => esc_html__( 'Typekit Kit ID', '@@textdomain' ),
			'description' => esc_html__( 'Located within your kit embed code. Font changes can be added to the CSS module or child theme.', '@@textdomain' ),
			'section'     => 'tabor_fonts',
		)
	);

	$wp_customize->add_setting(
		'typekit_font_1', array(
			'default'           => tabor_defaults( 'typekit_font_1' ),
			'sanitize_callback' => 'esc_html',
		)
	);

	$wp_customize->add_control(
		'typekit_font_1', array(
			'type'    => 'text',
			'label'   => esc_html__( 'Font Family #1', '@@textdomain' ),
			'section' => 'tabor_fonts',
		)
	);

	$wp_customize->add_setting(
		'typekit_font_2', array(
			'default'           => tabor_defaults( 'typekit_font_2' ),
			'sanitize_callback' => 'esc_html',
		)
	);

	$wp_customize->add_control(
		'typekit_font_2', array(
			'type'    => 'text',
			'label'   => esc_html__( 'Font Family #2', '@@textdomain' ),
			'section' => 'tabor_fonts',
		)
	);

	/**
	 * Add the site logo max-width options to the Site Identity section.
	 */
	$wp_customize->add_setting(
		'custom_logo_max_width', array(
			'default'           => tabor_defaults( 'custom_logo_max_width' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		new ThemeBeans_Range_Control(
			$wp_customize, 'custom_logo_max_width', array(
				'default'     => tabor_defaults( 'custom_logo_max_width' ),
				'type'        => 'themebeans-range',
				'label'       => esc_html__( 'Max Width', '@@textdomain' ),
				'description' => 'px',
				'section'     => 'title_tagline',
				'priority'    => 8,
				'input_attrs' => array(
					'min'  => 40,
					'max'  => 300,
					'step' => 2,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'custom_logo_mobile_max_width', array(
			'default'           => tabor_defaults( 'custom_logo_max_width' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		new ThemeBeans_Range_Control(
			$wp_customize, 'custom_logo_mobile_max_width', array(
				'default'     => tabor_defaults( 'custom_logo_max_width' ),
				'type'        => 'themebeans-range',
				'label'       => esc_html__( 'Mobile Max Width', '@@textdomain' ),
				'description' => 'px',
				'section'     => 'title_tagline',
				'priority'    => 9,
				'input_attrs' => array(
					'min'  => 40,
					'max'  => 200,
					'step' => 2,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'custom_logo_border_radius', array(
			'default'           => tabor_defaults( 'custom_logo_border_radius' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		new ThemeBeans_Toggle_Control(
			$wp_customize, 'custom_logo_border_radius', array(
				'type'     => 'themebeans-toggle',
				'label'    => esc_html__( 'Border Radius', '@@textdomain' ),
				'section'  => 'title_tagline',
				'priority' => 9,
			)
		)
	);

	$wp_customize->add_setting(
		'custom_logo_hover_animation', array(
			'default'           => tabor_defaults( 'custom_logo_hover_animation' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		new ThemeBeans_Toggle_Control(
			$wp_customize, 'custom_logo_hover_animation', array(
				'type'     => 'themebeans-toggle',
				'label'    => esc_html__( 'Hover Animation', '@@textdomain' ),
				'section'  => 'title_tagline',
				'priority' => 9,
			)
		)
	);

	$wp_customize->add_setting(
		'invert_night_mode_logo', array(
			'default'           => tabor_defaults( 'invert_night_mode_logo' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		new ThemeBeans_Toggle_Control(
			$wp_customize, 'invert_night_mode_logo', array(
				'type'     => 'themebeans-toggle',
				'label'    => esc_html__( 'Invert for Night Mode', '@@textdomain' ),
				'section'  => 'title_tagline',
				'priority' => 9,
			)
		)
	);

	/**
	 * Search.
	 */
	$wp_customize->add_setting( 'header_title', array( 'sanitize_callback' => 'esc_html' ) );

	$wp_customize->add_control(
		new ThemeBeans_Title_Control(
			$wp_customize, 'header_title', array(
				'type'    => 'themebeans-title',
				'label'   => esc_html__( 'Header', '@@textdomain' ),
				'section' => 'tabor_theme_options',
			)
		)
	);

	$wp_customize->add_setting(
		'header_search', array(
			'default'           => tabor_defaults( 'header_search' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		new ThemeBeans_Toggle_Control(
			$wp_customize, 'header_search', array(
				'type'        => 'themebeans-toggle',
				'label'       => esc_html__( 'Header Search', '@@textdomain' ),
				'description' => esc_html__( 'A site-wide searching element next to the header navigation.', '@@textdomain' ),
				'section'     => 'tabor_theme_options',
			)
		)
	);

	/**
	 * Accessibility Settings.
	 */
	$wp_customize->add_setting(
		'accessibility_settings', array(
			'default'           => tabor_defaults( 'accessibility_settings' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		new ThemeBeans_Toggle_Control(
			$wp_customize, 'accessibility_settings', array(
				'type'        => 'themebeans-toggle',
				'label'       => esc_html__( 'Accessibility Settings', '@@textdomain' ),
				'description' => esc_html__( 'Night Mode and text size modifiers for your readers.', '@@textdomain' ),
				'section'     => 'tabor_theme_options',
			)
		)
	);

	$wp_customize->add_setting(
		'accessibility_settings_icon', array(
			'default'           => tabor_defaults( 'accessibility_settings_icon' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'accessibility_settings_icon', array(
			'type'    => 'select',
			'section' => 'tabor_theme_options',
			'choices' => array(
				'settings'   => esc_html__( 'Cog Icon', '@@textdomain' ),
				'settings-2' => esc_html__( 'Mix Panel Icon', '@@textdomain' ),
				'settings-3' => esc_html__( 'Mix Panel Filled', '@@textdomain' ),
			),
		)
	);

	/**
	 * Blog.
	 */
	$wp_customize->add_setting( 'post_title', array( 'sanitize_callback' => 'esc_html' ) );

	$wp_customize->add_control(
		new ThemeBeans_Title_Control(
			$wp_customize, 'post_title', array(
				'type'    => 'themebeans-title',
				'label'   => esc_html__( 'Post', '@@textdomain' ),
				'section' => 'tabor_theme_options',
			)
		)
	);

	$wp_customize->add_setting(
		'selective_sharing', array(
			'default'           => tabor_defaults( 'selective_sharing' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		new ThemeBeans_Toggle_Control(
			$wp_customize, 'selective_sharing', array(
				'type'        => 'themebeans-toggle',
				'label'       => esc_html__( 'Selective Sharing', '@@textdomain' ),
				'description' => esc_html__( 'Empower readers to easily share text to Facebook and Twitter.', '@@textdomain' ),
				'section'     => 'tabor_theme_options',
			)
		)
	);

	$wp_customize->add_setting(
		'author_meta', array(
			'default'           => tabor_defaults( 'author_meta' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		new ThemeBeans_Toggle_Control(
			$wp_customize, 'author_meta', array(
				'type'        => 'themebeans-toggle',
				'label'       => esc_html__( 'Author', '@@textdomain' ),
				'description' => esc_html__( 'Add the post author metadata below the post title.', '@@textdomain' ),
				'section'     => 'tabor_theme_options',
			)
		)
	);

	$wp_customize->add_setting(
		'categories', array(
			'default'           => tabor_defaults( 'categories' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		new ThemeBeans_Toggle_Control(
			$wp_customize, 'categories', array(
				'type'        => 'themebeans-toggle',
				'label'       => esc_html__( 'Categories', '@@textdomain' ),
				'description' => esc_html__( 'Enable or disable categories that display in the post footer.', '@@textdomain' ),
				'section'     => 'tabor_theme_options',
			)
		)
	);

	$wp_customize->add_setting(
		'tags', array(
			'default'           => tabor_defaults( 'tags' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		new ThemeBeans_Toggle_Control(
			$wp_customize, 'tags', array(
				'type'        => 'themebeans-toggle',
				'label'       => esc_html__( 'Tags', '@@textdomain' ),
				'description' => esc_html__( 'Enable or disable tags that display in the post footer.', '@@textdomain' ),
				'section'     => 'tabor_theme_options',
			)
		)
	);

	$wp_customize->add_setting(
		'comments_visibility', array(
			'default'           => tabor_defaults( 'comments_visibility' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		new ThemeBeans_Toggle_Control(
			$wp_customize, 'comments_visibility', array(
				'type'        => 'themebeans-toggle',
				'label'       => esc_html__( 'Comments Trigger', '@@textdomain' ),
				'description' => esc_html__( 'Enable the comments button and show/hide comments functionality.', '@@textdomain' ),
				'section'     => 'tabor_theme_options',
			)
		)
	);

	// If Gutenberg does exist, fallback to use this control.
	if ( function_exists( 'register_block_type' ) ) {

		$wp_customize->add_setting(
			'guten_more_tag', array(
				'default'           => tabor_defaults( 'guten_more_tag' ),
				'transport'         => 'postMessage',
				'sanitize_callback' => 'tabor_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			new ThemeBeans_Toggle_Control(
				$wp_customize, 'guten_more_tag', array(
					'type'        => 'themebeans-toggle',
					'label'       => esc_html__( 'More Link', '@@textdomain' ),
					'description' => esc_html__( 'Enable the more tag button, if a More block is added to post.', '@@textdomain' ),
					'section'     => 'tabor_theme_options',
				)
			)
		);
	}

	$wp_customize->add_setting(
		'post_date', array(
			'default'           => tabor_defaults( 'post_date' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'post_date', array(
			'type'        => 'select',
			'label'       => esc_html__( 'Date', '@@textdomain' ),
			'description' => esc_html__( 'Choose to display either the updated or published date on all posts.', '@@textdomain' ),
			'section'     => 'tabor_theme_options',
			'choices'     => array(
				'none'      => esc_html__( 'None', '@@textdomain' ),
				'updated'   => esc_html__( 'Updated', '@@textdomain' ),
				'published' => esc_html__( 'Published', '@@textdomain' ),
			),
		)
	);

	// If Gutenberg does not exist, fallback to use this control.
	if ( ! function_exists( 'register_block_type' ) ) {
		$wp_customize->add_setting(
			'more_tag', array(
				'default'           => tabor_defaults( 'more_tag' ),
				'transport'         => 'postMessage',
				'sanitize_callback' => 'esc_html',
			)
		);

		$wp_customize->add_control(
			'more_tag', array(
				'type'        => 'text',
				'label'       => esc_html__( 'More Link', '@@textdomain' ),
				'description' => esc_html__( 'Change the existing empty more tag into a button with custom text.', '@@textdomain' ),
				'section'     => 'tabor_theme_options',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'more_tag', array(
				'settings'        => 'more_tag',
				'selector'        => '.more-link.button',
				'render_callback' => 'tabor_customize_partial_more_tag',
			)
		);
	}

	/**
	 * Social.
	 */
	$wp_customize->add_setting( 'social_title', array( 'sanitize_callback' => 'esc_html' ) );

	$wp_customize->add_control(
		new ThemeBeans_Title_Control(
			$wp_customize, 'social_title', array(
				'type'    => 'themebeans-title',
				'label'   => esc_html__( 'Social', '@@textdomain' ),
				'section' => 'tabor_theme_options',
			)
		)
	);

	$wp_customize->add_setting(
		'post_bar', array(
			'default'           => tabor_defaults( 'post_bar' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		new ThemeBeans_Toggle_Control(
			$wp_customize, 'post_bar', array(
				'type'        => 'themebeans-toggle',
				'label'       => esc_html__( 'Engagement Bar', '@@textdomain' ),
				'description' => esc_html__( 'Enable or disable the engagement bar that appears on singular posts.', '@@textdomain' ),
				'section'     => 'tabor_theme_options',
			)
		)
	);

	$wp_customize->add_setting(
		'post_bar_style', array(
			'default'           => tabor_defaults( 'post_bar_style' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'post_bar_style', array(
			'type'    => 'select',
			'section' => 'tabor_theme_options',
			'choices' => array(
				'drop-in-style-1' => esc_html__( 'Shadow Style', '@@textdomain' ),
				'drop-in-style-2' => esc_html__( 'Stroke Style', '@@textdomain' ),
			),
		)
	);

	$wp_customize->add_setting(
		'facebook_share', array(
			'default'           => tabor_defaults( 'facebook_share' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		new ThemeBeans_Toggle_Control(
			$wp_customize, 'facebook_share', array(
				'type'        => 'themebeans-toggle',
				'label'       => esc_html__( 'Facebook', '@@textdomain' ),
				'description' => esc_html__( 'Display a Facebook sharing button on the singular post mini-bar.', '@@textdomain' ),
				'section'     => 'tabor_theme_options',
			)
		)
	);

	$wp_customize->add_setting(
		'twitter_share', array(
			'default'           => tabor_defaults( 'twitter_share' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		new ThemeBeans_Toggle_Control(
			$wp_customize, 'twitter_share', array(
				'type'        => 'themebeans-toggle',
				'label'       => esc_html__( 'Twitter', '@@textdomain' ),
				'description' => esc_html__( 'Display a Twitter button and append your username.', '@@textdomain' ),
				'section'     => 'tabor_theme_options',
			)
		)
	);

	$wp_customize->add_setting(
		'twitter_via', array(
			'default'           => tabor_defaults( 'twitter_via' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_html',
		)
	);

	$wp_customize->add_control(
		'twitter_via', array(
			'type'    => 'text',
			'label'   => esc_html__( '@username:', '@@textdomain' ),
			'section' => 'tabor_theme_options',
		)
	);

	$wp_customize->add_setting(
		'linkedin_share', array(
			'default'           => tabor_defaults( 'linkedin_share' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		new ThemeBeans_Toggle_Control(
			$wp_customize, 'linkedin_share', array(
				'type'        => 'themebeans-toggle',
				'label'       => esc_html__( 'LinkedIn', '@@textdomain' ),
				'description' => esc_html__( 'Display a LinkedIn sharing button on the singular post mini-bar.', '@@textdomain' ),
				'section'     => 'tabor_theme_options',
			)
		)
	);

	/**
	 * Colophon.
	 */
	$wp_customize->add_setting( 'colophon_title', array( 'sanitize_callback' => 'esc_html' ) );

	$wp_customize->add_control(
		new ThemeBeans_Title_Control(
			$wp_customize, 'colophon_title', array(
				'type'    => 'themebeans-title',
				'label'   => esc_html__( 'Colophon', '@@textdomain' ),
				'section' => 'tabor_theme_options',
			)
		)
	);

	$wp_customize->add_setting(
		'theme_info', array(
			'default'           => tabor_defaults( 'theme_info' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		new ThemeBeans_Toggle_Control(
			$wp_customize, 'theme_info', array(
				'type'        => 'themebeans-toggle',
				'label'       => esc_html__( 'Theme Info', '@@textdomain' ),
				'description' => esc_html__( 'Let others know about the beautiful WordPress theme you are using.', '@@textdomain' ),
				'section'     => 'tabor_theme_options',
			)
		)
	);

	$wp_customize->add_setting(
		'copyright_year', array(
			'default'           => tabor_defaults( 'copyright_year' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		new ThemeBeans_Toggle_Control(
			$wp_customize, 'copyright_year', array(
				'type'        => 'themebeans-toggle',
				'label'       => esc_html__( 'Copyright Year', '@@textdomain' ),
				'description' => esc_html__( 'Display a copyright badge and the current year in the site footer.', '@@textdomain' ),
				'section'     => 'tabor_theme_options',
			)
		)
	);

	$wp_customize->add_setting(
		'copyright_text', array(
			'default'           => tabor_defaults( 'copyright_text' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_html',
		)
	);

	$wp_customize->add_control(
		'copyright_text', array(
			'type'        => 'text',
			'label'       => esc_html__( 'Custom Copyright', '@@textdomain' ),
			'description' => esc_html__( 'Add custom text to display beside the copyright date in the site footer.', '@@textdomain' ),
			'section'     => 'tabor_theme_options',
		)
	);

	/**
	 * Colors.
	 */
	$wp_customize->add_setting(
		'heading_color', array(
			'default'           => tabor_defaults( 'heading_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'heading_color', array(
				'label'   => esc_html__( 'Heading Color', '@@textdomain' ),
				'section' => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'alt_heading_color', array(
			'default'           => tabor_defaults( 'alt_heading_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'alt_heading_color', array(
				'label'   => esc_html__( 'Alt Heading Color', '@@textdomain' ),
				'section' => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'text_color', array(
			'default'           => tabor_defaults( 'text_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'text_color', array(
				'label'   => esc_html__( 'Text Color', '@@textdomain' ),
				'section' => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'header_icon_color', array(
			'default'           => tabor_defaults( 'header_icon_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'header_icon_color', array(
				'label'   => esc_html__( 'Header Icon Color', '@@textdomain' ),
				'section' => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'nav_color', array(
			'default'           => tabor_defaults( 'nav_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'nav_color', array(
				'label'   => esc_html__( 'Navigation Color', '@@textdomain' ),
				'section' => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'mobile_nav_color', array(
			'default'           => tabor_defaults( 'mobile_nav_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'mobile_nav_color', array(
				'label'   => esc_html__( 'Mobile Navigation Color', '@@textdomain' ),
				'section' => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'footer_bg_color', array(
			'default'           => tabor_defaults( 'footer_bg_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'footer_bg_color', array(
				'label'   => esc_html__( 'Footer Background Color', '@@textdomain' ),
				'section' => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'footer_text_color', array(
			'default'           => tabor_defaults( 'footer_text_color' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'footer_text_color', array(
				'label'   => esc_html__( 'Footer Text Color', '@@textdomain' ),
				'section' => 'colors',
			)
		)
	);

	// Register the accent color only if Gutenberg is enabled.
	if ( function_exists( 'register_block_type' ) ) {
		$wp_customize->add_setting(
			'accent_color', array(
				'default'           => tabor_defaults( 'accent_color' ),
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 'accent_color', array(
					'label'       => esc_html__( 'Gutenberg Accent', '@@textdomain' ),
					'description' => esc_html__( 'Add an accent color to use within the Gutenberg editor block color palettes.', '@@textdomain' ),
					'section'     => 'colors',
				)
			)
		);
	}

	/**
	 * Home.
	 */
	$wp_customize->add_setting( 'home_title', array( 'sanitize_callback' => 'esc_html' ) );

	$wp_customize->add_control(
		new ThemeBeans_Title_Control(
			$wp_customize, 'home_title', array(
				'type'    => 'themebeans-title',
				'label'   => esc_html__( 'Home', '@@textdomain' ),
				'section' => 'tabor_theme_options',
			)
		)
	);

	$wp_customize->add_setting(
		'disable_home_styles', array(
			'default'           => tabor_defaults( 'disable_home_styles' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'tabor_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		new ThemeBeans_Toggle_Control(
			$wp_customize, 'disable_home_styles', array(
				'type'        => 'themebeans-toggle',
				'label'       => esc_html__( 'Disable Home Styles', '@@textdomain' ),
				'description' => esc_html__( 'Custom styling to create the default landing page. Home will display as a standard page.', '@@textdomain' ),
				'section'     => 'tabor_theme_options',
			)
		)
	);

	/**
	 * Adding support for Customize inline editing.
	 *
	 * @link https://github.com/xwp/wp-customize-inline-editing
	 */
	$opt_in_partials = array_filter(
		array(
			$wp_customize->selective_refresh->get_partial( 'blogname' ),
		)
	);
	foreach ( $opt_in_partials as $partial ) {
		$partial->type = 'inline_editable';
	}
}
add_action( 'customize_register', 'tabor_customize_register', 11 );

/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 */
function tabor_customize_preview_js() {
	wp_enqueue_script( 'tabor-customize-preview', get_theme_file_uri( '/assets/js/admin/customize-preview' . __PREFIX_ASSET_SUFFIX . '.js' ), array( 'customize-preview' ), '@@pkg.version', true );
}
add_action( 'customize_preview_init', 'tabor_customize_preview_js' );

/**
 * Load dynamic logic for the customizer controls area.
 */
function tabor_customize_controls_js() {
	wp_enqueue_script( 'tabor-customize-controls', get_theme_file_uri( '/assets/js/admin/customize-controls' . __PREFIX_ASSET_SUFFIX . '.js' ), array( 'customize-controls' ), '@@pkg.version', true );
}
add_action( 'customize_controls_enqueue_scripts', 'tabor_customize_controls_js' );

/**
 * Customizer Events.
 */
function tabor_customize_events_js() {
	wp_enqueue_script( 'tabor-customize-events', get_theme_file_uri( '/assets/js/admin/customize-events' . __PREFIX_ASSET_SUFFIX . '.js' ), array( 'customize-controls' ), '@@pkg.version', true );
}
add_action( 'customize_controls_enqueue_scripts', 'tabor_customize_events_js' );

/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 */
function tabor_customize_live_js() {
	wp_enqueue_script( 'tabor-customize-live', get_theme_file_uri( '/assets/js/admin/customize-live' . __PREFIX_ASSET_SUFFIX . '.js' ), array( 'customize-preview' ), '@@pkg.version', true );
}
add_action( 'customize_preview_init', 'tabor_customize_live_js' );

/**
 * CSS to make the Customizer controls look a bit better.
 */
function tabor_customize_controls_css() {
	wp_enqueue_style( 'tabor-customize-preview', get_theme_file_uri( '/assets/css/customize-controls' . __PREFIX_ASSET_SUFFIX . '.css' ), '@@pkg.version', true );
}
add_action( 'customize_controls_print_styles', 'tabor_customize_controls_css' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @see tabor_customize_register()
 *
 * @return void
 */
function tabor_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @see tabor_customize_register()
 *
 * @return void
 */
function tabor_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Render the custom more tag for the selective refresh partial.
 *
 * @see tabor_customize_register()
 */
function tabor_customize_partial_more_tag() {
	return get_theme_mod( 'more_tag' );
}
