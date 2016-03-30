<?php

function wardrobe_enqueue_scripts() {
	wp_enqueue_style( 'core', get_stylesheet_uri(), false ); 
	
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'script', get_template_directory_uri() . '/wardrobe.min.js', false );
}

function wardrobe_widgets_init() {
    register_sidebar( array( 'id' => 'sidebar-1' ) );
}

function wardrobe_after_setup_theme() {
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 300, 300 );
}

function wardrobe_outfit_init() {
    add_rewrite_rule( '^outfit/([0-9]+(?::[0-9]+)*)/?',
                      'index.php?pagename=outfit&outfit=$matches[1]', 'top' );

    if ( ! get_page_by_title( 'outfit' ) ) {
        $_p = array();
        $_p['post_title'] = 'outfit';
        $_p['post_content'] = 'This page implements theme functionality. Content here will not be displayed.';
        $_p['post_status'] = 'publish';
        $_p['post_type'] = 'page';
        $_p['comment_status'] = 'closed';
        $_p['ping_status'] = 'closed';
        $_p['post_category'] = array(1);

        wp_insert_post( $_p );
    }
}

function wardrobe_query_vars( $vars ) {
    $vars[] = 'subpage';        // true if requesting subpage via singular.php
    $vars[] = 'navigation';     // Session ID for navigation.
    $vars[] = 'outfit';         // CSV of post IDs in current outfit.
    return $vars;
}

add_action( 'wp_enqueue_scripts', 'wardrobe_enqueue_scripts' );
add_action( 'widgets_init', 'wardrobe_widgets_init' );
add_action( 'after_setup_theme', 'wardrobe_after_setup_theme' );

add_action( 'init', 'wardrobe_outfit_init' );

add_filter( 'query_vars', 'wardrobe_query_vars' );


/* Outfits */

function wardrobe_outfit_ids() {
    $ids = array();

    foreach ( explode( ':', get_query_var( 'outfit', '' ) ) as $id ) {
        if ( get_post( $id ) ) {
            $ids[] = $id;
        }
    }

    return $ids;
}


/* Navigation */

function wardrobe_nav_start() {
    ini_set( 'session.use_cookies', '0' );
    ini_set( 'session.use_only_cookies', '0' );
    ini_set( 'session.use_trans_sid', '0' );
    ini_set( 'session.cache_limiter', '' );
    session_name( 'navigation' );
    session_start();
}

function wardrobe_nav_array( $new_array = null ) {
    if ( $new_array || ! array_key_exists( 'array', $_SESSION ) ) {
        $_SESSION['array'] = array();
    }

    if ( $new_array ) {
        foreach ( $new_array as $post ) {
            $_SESSION['array'][] = $post->ID;
        }
    } else {
        return $_SESSION['array'];
    }
}

function wardrobe_nav_array_pos( $id ) {
    return array_search( $id, wardrobe_nav_array() );
}

function wardrobe_nav_permalink( $post = 0 ) {
    return esc_url( add_query_arg( array (
                                        'navigation'   =>  session_id()
                                    ),
                                    get_permalink( $post ) ) );
}

function wardrobe_nav_permalink_prev( $id ) {
    $pos = wardrobe_nav_array_pos( $id );

    if ( 0 < $pos ) {
        return wardrobe_nav_permalink( wardrobe_nav_array()[$pos - 1] );
    } else {
        return wardrobe_nav_permalink( wardrobe_nav_array()[count ( wardrobe_nav_array() ) - 1] );
    }
}

function wardrobe_nav_permalink_next( $id ) {
    $pos = wardrobe_nav_array_pos( $id );

    if ( $pos < count( wardrobe_nav_array() ) - 1 ) {
        return wardrobe_nav_permalink( wardrobe_nav_array()[$pos + 1] );
    } else {
        return wardrobe_nav_permalink( wardrobe_nav_array()[0] );
    }
}

?>
