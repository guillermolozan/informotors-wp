<?php

if (! defined('WP_DEBUG')) {
	die( 'Direct access forbidden.' );
}

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'parent-style', get_theme_file_uri() . '/style.css' );
});


require_once get_stylesheet_directory() . '/inc/fase-1-informe.php';

require_once get_stylesheet_directory() . '/inc/testimonios.php';

