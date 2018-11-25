<?php
/**
 * Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package     @@pkg.name
 * @link        @@pkg.theme_uri
 * @author      @@pkg.author
 * @copyright   @@pkg.copyright
 * @license     @@pkg.license
 */


	add_theme_support( 'post-thumbnails' );
	add_image_size( 'tabor-featured-image-xsm', 120, 120, true );
	add_image_size( 'tabor-featured-image-sml', 434, 9999, true );
	add_image_size( 'tabor-featured-image-med', 868, 9999, true );
	add_image_size( 'tabor-featured-image-lrg', 1736, 9999, true );
	add_image_size( 'tabor-featured-image-custom', 200, 9999, $crop = true );

	