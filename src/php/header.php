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
            <header id="masthead" class="site-header shift-masthead" role="banner">
        <?php else : ?>
            <header id="masthead" class="site-header" role="banner">
        <?php endif; ?>
                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <div class="float-right">
                <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
                    <div class="sidebar-button-wrapper inline-block">
                        <button id="sidebar-toggle" aria-controls="secondary" aria-expanded="false">
                            <svg viewBox="0 0 8 8" class="icon">
                                <use xlink:href="#menu" class="icon-use icon-menu"></use>
                            </svg>
                            <span class="button-text text-menu">
                                <?php esc_html_e( 'Menu', 'wardrobe' ); ?>
                            </span>
                        </button>
                    </div>
                <?php endif; ?>
                </div>
            </header>
        <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
            <aside id="secondary" class="sidebar widget-area" role="complementary">
                <?php dynamic_sidebar( 'sidebar-1' ); ?>
            </aside>
        <?php endif; ?>
            <div id="content" class="site-content">
