<?php

/**
 * Styles
 */
function logan_enqueue_style(){
	wp_enqueue_style( 'default-styles', get_template_directory_uri() . '/css/bootstrap.min.css', array(), false, 'all' );
	wp_enqueue_style( 'normalize', get_template_directory_uri() . '/css/normalize.css', false, 'all' );		
	wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css', array(), false, 'all' );
}
/**
 * Scripts
 */
function logan_enqueue_script() {
	wp_enqueue_script( 'slim', get_template_directory_uri() . '/js/slim.min.js', array(), true );
	wp_enqueue_script( 'popper', get_template_directory_uri() . '/js/popper.min.js', array('jquery'), true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), true );
	wp_enqueue_script( 'holder', get_template_directory_uri() . '/js/holder.min.js', array('jquery'), true );
}

if ( ! is_admin() ) {
	add_action( 'wp_enqueue_scripts', 'logan_enqueue_style' );
	add_action( 'wp_enqueue_scripts', 'logan_enqueue_script' );
}

function admin_writing_notice(){
    if ( is_admin() ) {
    $user = wp_get_current_user();
		if ( in_array( 'administrator', (array) $user->roles ) ) {
			echo '<div class="notice notice-info is-dismissible">
			<p>Click on <a href="edit.php">Posts</a> to start writing.</p>
			</div>';
		}
	}
}
add_action('admin_notices', 'admin_writing_notice');
	

register_nav_menus( array(
	'primary' => __( 'Primary Menu', 'Loganwebdev' ),
) );

if ( ! current_user_can( 'manage_options' ) ) {
	show_admin_bar( false );
}
include_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

?>