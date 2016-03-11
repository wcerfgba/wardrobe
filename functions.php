<?php

function wardrobe_enqueue_scripts() {
	wp_enqueue_style( 'core', get_stylesheet_uri(), false ); 
	
	wp_enqueue_script( 'script', get_template_directory_uri() . '/script.js', false );
}

add_action( 'wp_enqueue_scripts', 'wardrobe_enqueue_scripts' );

?>
