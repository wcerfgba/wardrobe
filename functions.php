<?php

function wardrobe_enqueue_scripts() {
	wp_enqueue_style( 'core', get_stylesheet_uri(), false ); 
	
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'script', get_template_directory_uri() . '/script.js', false );
}

function wardrobe_widgets_init() {
    register_sidebar( array( 'id' => 'sidebar-1' ) );
}

function wardrobe_query_vars( $vars ) {
    $vars[] = "sidepage";
    return $vars;
}

add_action( 'wp_enqueue_scripts', 'wardrobe_enqueue_scripts' );
add_action( 'widgets_init', 'wardrobe_widgets_init' );

add_filter( 'query_vars', 'wardrobe_query_vars' );

add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 300, 300 );

?>
