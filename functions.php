<?php

function wardrobe_enqueue_scripts() {
	wp_enqueue_style( 'core', get_stylesheet_uri(), false ); 
	
	wp_enqueue_script( 'jquery', get_template_directory_uri() . '/jquery.js', false );
	wp_enqueue_script( 'script', get_template_directory_uri() . '/script.js', false );
}

function wardrobe_widgets_init() {
    register_sidebar();
}

add_action( 'wp_enqueue_scripts', 'wardrobe_enqueue_scripts' );
add_action( 'widgets_init', 'wardrobe_widgets_init' );

?>
