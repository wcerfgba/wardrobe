<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <title><?php wp_title(); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php wp_head(); ?>
    </head>
    <body>
        <img src="<?php echo esc_url( get_template_directory_uri() . '/icons.svg' ); ?>" class="iconic-sprite" style="display: none;" />
       <div id="page" class="site">
        <?php if ( is_admin_bar_showing() ) : ?>
            <header id="masthead" class="site-header shift-masthead" role="banner">
        <?php else : ?>
            <header id="masthead" class="site-header" role="banner">
        <?php endif; ?>
                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <div class="float-right">
                    <div class="prev-next-nav inline-block">
                        <button class="prev-nav-button">
                            <svg viewBox="0 0 8 8" class="icon">
                                <use xlink:href="#chevron-left" class="icon-use icon-prev-nav"></use>
                            </svg>
                            <span class="button-text text-prev-nav">
                                <?php esc_html_e( 'Previous', 'wardrobe' ); ?>
                            </span>
                        </button>
                        <button class="next-nav-button">
                            <svg viewBox="0 0 8 8" class="icon">
                                <use xlink:href="#chevron-right" class="icon-use icon-next-nav"></use>
                            </svg>
                            <span class="button-text text-next-nav">
                                <?php esc_html_e( 'Next', 'wardrobe' ); ?>
                            </span>
                        </button>
                    </div>
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
