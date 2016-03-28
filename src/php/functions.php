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
    $vars[] = 'sidepage';
    $vars[] = 'nav_position';
    $vars[] = 'outfit';
    return $vars;
}

add_action( 'wp_enqueue_scripts', 'wardrobe_enqueue_scripts' );
add_action( 'widgets_init', 'wardrobe_widgets_init' );
add_action( 'after_setup_theme', 'wardrobe_after_setup_theme' );

add_action( 'init', 'wardrobe_outfit_init' );

add_filter( 'query_vars', 'wardrobe_query_vars' );


/* Outfit builder */

function wardrobe_outfit_post_ids() {
    $ids = array();

    foreach ( explode( ':', get_query_var( 'outfit', '' ) ) as $id ) {
        if ( get_post( $id ) ) {
            $ids[] = $id;
        }
    }

    return $ids;
}


/* Nav session management */

function wardrobe_session_nav_start() {
    ini_set( 'session.use_cookies', '0' );
    ini_set( 'session.use_only_cookies', '0' );
    ini_set( 'session.use_trans_sid', '0' );
    ini_set( 'session.cache_limiter', '' );
    session_name( 'nav_session' );
    session_start();
}

function wardrobe_session_nav_set( $category_posts ) {
    $_SESSION['category_posts'] = array();

    foreach ( $category_posts as $cat => $posts ) {
        $_SESSION['category_posts']["$cat"] = array();

        foreach ( $posts as $post ) {
            $_SESSION['category_posts']["$cat"][] = $post->ID;
        }
    }
}

function wardrobe_session_nav_link_prev_attrs() {
    $queryvar = get_query_var( 'nav_position', '');

    if ( $queryvar ) {
        $position = explode( ':', $queryvar );
        $cat = $position[0];
        $post = intval( $position[1] );

        if ( array_key_exists( $cat, $_SESSION['category_posts'] ) &&
             array_key_exists( $post, $_SESSION['category_posts'][$cat] ) ) {
            if ( 0 < $post ) {
                echo 'href="' .
                        wardrobe_session_nav_permalink( $cat, $post - 1, 
                            $_SESSION['category_posts'][$cat][$post - 1] ) .
                    '" post-id="' .
                        $_SESSION['category_posts'][$cat][$post - 1] .
                    '"';
                return true;
            } else {
                $idx = count( $_SESSION['category_posts'][$cat] ) - 1;
                echo 'href="' .
                        wardrobe_session_nav_permalink( $cat, $idx, 
                            $_SESSION['category_posts'][$cat][$idx] ) .
                    '" post-id="' .
                        $_SESSION['category_posts'][$cat][$idx] .
                    '"';
                return true;
            }
        }
    }

    return false;
}

function wardrobe_session_nav_link_next_attrs() {
    $queryvar = get_query_var( 'nav_position', '');

    if ( $queryvar ) {
        $position = explode( ':', $queryvar );
        $cat = $position[0];
        $post = intval( $position[1] );

        if ( array_key_exists( $cat, $_SESSION['category_posts'] ) &&
             array_key_exists( $post, $_SESSION['category_posts'][$cat] ) ) {
            if ( $post < count( $_SESSION['category_posts'][$cat] ) - 1) {
                echo 'href="' .
                        wardrobe_session_nav_permalink( $cat, $post + 1, 
                            $_SESSION['category_posts'][$cat][$post + 1] ) .
                    '" post-id="' .
                        $_SESSION['category_posts'][$cat][$post + 1] .
                    '"';
                return true;
            } else {
                echo 'href="' .
                        wardrobe_session_nav_permalink( $cat, 0, 
                            $_SESSION['category_posts'][$cat][0] ) .
                    '" post-id="' .
                        $_SESSION['category_posts'][$cat][0] .
                    '"';
                return true;
            }
        }
    }

    return false;
}

function wardrobe_session_nav_permalink( $cat_id, $post_idx, $post = 0 ) {
    return esc_url( add_query_arg( array (
                                    'nav_position'  =>  "$cat_id:$post_idx",
                                    'nav_session'   =>  session_id()
                                ),
                                get_permalink( $post ) ) );
}
?>
