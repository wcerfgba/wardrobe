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
       <div id="page" class="site">
            <header id="masthead" class="site-header" role="banner">
                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <div class="prev-next-nav">
                    <button class="prev-nav-button"><?php esc_html_e( 'Previous', 'wardrobe' ); ?></button>
                    <button class="next-nav-button"><?php esc_html_e( 'Next', 'wardrobe' ); ?></button>
                </div>
            <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
                <div class="sidebar-wrapper">
                    <button class="sidebar-toggle" aria-controls="secondary" aria-expanded="false"><?php esc_html_e( 'Sidebar', 'wardrobe' ); ?></button>
                    <aside id="secondary" class="sidebar widget-area" role="complementary">
                        <?php dynamic_sidebar( 'sidebar-1' ); ?>
                    </aside>
                </div>
            <?php endif; ?>
            </header>
            <div id="content" class="site-content">
