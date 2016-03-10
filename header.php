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
                <nav id="site-navigation" class="main-navigation" role="navigation">
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'wardrobe' ); ?></button>
                    <?php wp_nav_menu( array(
                            'theme_location' => 'primary',
                            'menu_class'     => 'primary-menu'
                          ) );
                    ?>
                </nav>
            </header>
            <div id="content" class="site-content">
