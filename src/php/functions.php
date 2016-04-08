<?php

function wardrobe_enqueue_scripts() {
	wp_enqueue_style( 'core', get_stylesheet_uri(), false ); 
	
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'comment-reply' );
	wp_enqueue_script( 'script', get_template_directory_uri() . '/wardrobe.min.js', false );
}

function wardrobe_widgets_init() {
    register_sidebar( array( 'id' => 'sidebar-1' ) );
}

function wardrobe_after_setup_theme() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'automatic-feed-links' );
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
    $vars[] = 'outfit_navs';    // CSV of session IDs for each post in outfit.
    $vars[] = 'outfit_position'; // Position of post in outfit.
    return $vars;
}

add_action( 'wp_enqueue_scripts', 'wardrobe_enqueue_scripts' );
add_action( 'widgets_init', 'wardrobe_widgets_init' );
add_action( 'after_setup_theme', 'wardrobe_after_setup_theme' );

add_action( 'init', 'wardrobe_outfit_init' );

add_filter( 'query_vars', 'wardrobe_query_vars' );


if ( ! isset( $content_width ) ) {
	$content_width = 576; // 36rem @ 16px for singular
}


function wardrobe_output_callback( $buffer ) {
    // Add outfit parameters to absolute URLs.
    $buf = preg_replace_callback( 
        '#(href=["\'])(' . preg_quote( site_url(), '#' ) . '[^"\']+)(["\'])#',
        function ( $matches ) {
            // Don't mangle feed links.
            if ( strpos( $matches[2], 'feed=' ) !== false ||
                 strpos( $matches[2], '/feed/' ) !== false ) {
                return $matches[0];
            }

            $url = $matches[2];

            // Test for each query arg.
            if ( strpos( $url, 'outfit=' ) === false ) {
                $url = add_query_arg( array(
                            'outfit'    =>  get_query_var( 'outfit', false ) ),
                        $url );
            }
            
            if ( strpos( $url, 'outfit_navs=' ) === false ) {
                $url = add_query_arg( array(
                            'outfit_navs'   =>  get_query_var( 'outfit_navs', false ) ),
                        $url );
            }

            return $matches[1] . esc_url( $url ) . $matches[3];
        },
        $buffer );

    // Add outfit parameters as hidden inputs on forms with absolute actions.
    $buf = preg_replace_callback(
        '#action="' . preg_quote( site_url(), '#' ) . '[^"]+">#',
        function ( $matches ) {
            return $matches[0] .
                    '<input type="hidden" name="outfit" value="' .
                        get_query_var( 'outfit' ) . '" />' .
                    '<input type="hidden" name="outfit_navs" value="' .
                        get_query_var( 'outfit_navs' ) . '" />';
        },
        $buf );

    return $buf;
}

function wardrobe_ob_start() {
    ob_start( 'wardrobe_output_callback' );
}

function wardrobe_ob_end() {
    ob_end_flush();
}

add_action( 'wp_head', 'wardrobe_ob_start' );
add_action( 'wp_footer', 'wardrobe_ob_end' );


/* Outfits */

function wardrobe_outfit_ids() {
    $ids = array();

    foreach ( explode( ':', get_query_var( 'outfit', '' ) ) as $id ) {
        if ( $id !== '' && get_post( $id ) ) {
            $ids[] = $id;
        }
    }

    return $ids;
}

function wardrobe_outfit_navs() {
    return explode( ':', get_query_var( 'outfit_navs', '') );
}

function wardrobe_outfit_add_permalink( $id ) {
    $outfit = trim( get_query_var( 'outfit', '') . ':' . $id, ':' );
    $outfit_navs = trim( get_query_var( 'outfit_navs', '') . ':' . session_id(), ':' );

    return esc_url( add_query_arg( array (
                                    'outfit'        =>  $outfit,
                                    'outfit_navs'   =>  $outfit_navs ) ) );
}

function wardrobe_outfit_prev_permalink( $pos ) {
    $outfit = wardrobe_outfit_ids();

    $outfit[$pos] = wardrobe_nav_prev( $outfit[$pos] );

    return esc_url( add_query_arg( array(
                        'outfit'        =>  implode( ':', $outfit ),
                        'outfit_navs'   =>  get_query_var( 'outfit_navs' ) ) ) );
}

function wardrobe_outfit_next_permalink( $pos ) {
    $outfit = wardrobe_outfit_ids();

    $outfit[$pos] = wardrobe_nav_next( $outfit[$pos] );

    return esc_url( add_query_arg( array(
                        'outfit'        =>  implode( ':', $outfit ),
                        'outfit_navs'   =>  get_query_var( 'outfit_navs' ) ) ) );
}

function wardrobe_outfit_remove_permalink( $pos ) {
    $outfit = wardrobe_outfit_ids();
    $outfit_navs = wardrobe_outfit_navs();

    unset( $outfit[$pos] );
    unset( $outfit_navs[$pos] );

    $outfit = array_values( $outfit );
    $outfit_navs = array_values( $outfit_navs );

    return esc_url( add_query_arg( array(
                        'outfit'        =>  implode( ':', $outfit ),
                        'outfit_navs'   =>  implode( ':', $outfit_navs ) ) ) );
}

function wardrobe_outfit_view_permalink() {
    return get_permalink( get_page_by_title( 'outfit' ) );
}

/* Navigation */

function wardrobe_nav_start( $session_id = null ) {
//    ini_set( 'session.use_cookies', '0' );
//    ini_set( 'session.use_only_cookies', '0' );
//    ini_set( 'session.use_trans_sid', '0' );
//    ini_set( 'session.cache_limiter', '' );
    session_name( 'navigation' );

    if ( $session_id ) {
        session_id( $session_id );
    } else {
        session_id( uniqid() );
    }

    @session_start( array( 
            'use_cookies'       => '0',
            'use_only_cookies'  => '0',
            'use_trans_sid'     => '0',
            'cache_limiter'     => ''
        ) );
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
                                    'navigation'   =>  session_id() ),
                                get_permalink( $post ) ) );
}

function wardrobe_nav_prev( $id ) {
    $pos = wardrobe_nav_array_pos( $id );

    if ( 0 < $pos ) {
        return wardrobe_nav_array()[$pos - 1];
    } else {
        return wardrobe_nav_array()[count ( wardrobe_nav_array() ) - 1];
    }
}

function wardrobe_nav_next( $id ) {
    $pos = wardrobe_nav_array_pos( $id );

    if ( $pos < count( wardrobe_nav_array() ) - 1 ) {
        return wardrobe_nav_array()[$pos + 1];
    } else {
        return wardrobe_nav_array()[0];
    }
}

?>
