<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
        <title><?php wp_title(); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php wp_head(); ?>
    </head>
    <body>
        <?php include_once( 'icons.svg' ); ?>
        <div id="page" class="site">
        <?php if ( is_admin_bar_showing() ) : ?>
            <header id="masthead" class="site-header masthead_shift" role="banner">
        <?php else : ?>
            <header id="masthead" class="site-header" role="banner">
        <?php endif; ?>
                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php if ( get_query_var( 'outfit', false ) ) : ?>
                <div id="outfit-bar" class="outfit-bar">
                    <?php foreach ( wardrobe_outfit_post_ids() as $id ) : ?>
                    <article id="post-<?php echo $id; ?>" <?php post_class( 'outfit-post', $id ); ?>>
                        <div id="post-<?php echo $id; ?>__thumbnail" class="outfit-post__thumbnail">
                        <?php echo get_the_post_thumbnail( $id, 'thumbnail' ); ?>
                        </div>
                    </article>
                    <?php endforeach; ?>
                    <div class="outfit-expand-button button-link">
                        <svg viewBox="0 0 8 8" class="icon_big outfit-expand-button__icon">
                            <use xlink:href="#chevron-bottom" class="icon-use icon-outfit-expand"></use>
                        </svg>
                        <span class="link__text text-outfit-expand">
                            <?php esc_html_e( 'Expand outfit', 'wardrobe' ); ?>
                        </span>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
                <div class="sidebar-button buttons-right">
                    <button class="sidebar-button__button" aria-controls="secondary" aria-expanded="false">
                        <svg viewBox="0 1 8 8" class="icon_big">
                            <use xlink:href="#menu" class="icon-use icon-menu"></use>
                        </svg>
                        <span class="button__text text-menu">
                            <?php esc_html_e( 'Menu', 'wardrobe' ); ?>
                        </span>
                    </button>
                </div>
            <?php endif; ?>
            <?php if ( get_query_var( 'navigation', false ) && is_single() ) : wardrobe_nav_start(); ?>
                <div class="nav-links buttons-right">
                    <a class="nav-links__prev-link button-link" href="<?php echo wardrobe_nav_permalink_prev( $post->ID ); ?>">
                        <svg viewBox="0 0 8 8" class="icon_big">
                            <use xlink:href="#chevron-left" class="icon-use icon-nav-prev"></use>
                        </svg>
                        <span class="link__text text-nav-prev">
                            <?php esc_html_e( 'Previous', 'wardrobe' ); ?>
                        </span>
                    </a>
                    <a class="nav-links__next-link button-link" href="<?php echo wardrobe_nav_permalink_next( $post->ID ); ?>">
                        <svg viewBox="0 0 8 8" class="icon_big">
                            <use xlink:href="#chevron-right" class="icon-use icon-nav-next"></use>
                        </svg>
                        <span class="link__text text-nav-next">
                            <?php esc_html_e( 'Next', 'wardrobe' ); ?>
                        </span>
                    </a>
                </div>
            <?php session_write_close(); endif; ?>
            </header>
        <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
            <aside id="secondary" class="sidebar widget-area" role="complementary">
                <?php dynamic_sidebar( 'sidebar-1' ); ?>
            </aside>
        <?php endif; ?>
            <div id="content" class="site-content">
