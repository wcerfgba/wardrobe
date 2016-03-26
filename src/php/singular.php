<?php if ( ! get_query_var( 'sidepage', false ) ) : ?>
    <?php get_header(); ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <div class="page">
<?php else : ?>
    <div class="sidepage-bar">
        <div class="sidepage-close-button">
            <button class="sidepage-close-button__button">
                <svg viewBox="0 0 8 8" class="icon">
                    <use xlink:href="#x" class="icon-use icon-sidepage-close"></use>
                </svg>
                <span class="button__text text-sidepage-close">
                    <?php esc_html_e( 'Close', 'wardrobe' ); ?>
                </span>
            </button>
        </div>
        <div class="sidepage-nav-buttons">
            <button class="sidepage-nav-buttons__prev-button">
                <svg viewBox="0 0 8 8" class="icon">
                    <use xlink:href="#chevron-left" class="icon-use icon-sidepage-nav-prev"></use>
                </svg>
                <span class="button__text text-sidepage-nav-prev">
                    <?php esc_html_e( 'Previous', 'wardrobe' ); ?>
                </span>
            </button>
            <button class="sidepage-nav-buttons__next-button">
                <svg viewBox="0 0 8 8" class="icon">
                    <use xlink:href="#chevron-right" class="icon-use icon-sidepage-nav-next"></use>
                </svg>
                <span class="button__text text-sidepage-nav-next">
                    <?php esc_html_e( 'Next', 'wardrobe' ); ?>
                </span>
            </button>
        </div>
    </div>
<?php endif; ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'singular' ); ?>>
                    <header class="singular-header">
                        <div id="post-<?php the_ID(); ?>__thumbnail" class="singular-header__thumbnail">
                            <?php the_post_thumbnail( 'full' ); ?>
                        </div>
                        <div id="post-<?php the_ID(); ?>-title" class="singular-header-title">
                            <?php the_title( '<h1 class="singular-header-title__heading">', '</h1>' ); ?>
                        </div>
                    <?php if ( 'post' === get_post_type() ) : ?>
                        <div class="singular-header-meta">
                            <span class="entry-date"><?php echo get_the_date(); ?></span>
                        </div>
                    <?php endif; ?>
                    </header>
                    <div class="singular-content">
                        <?php
                            the_content();
                            wp_link_pages( array(
                                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wardrobe' ),
                                'after'  => '</div>'
                            ) );
                        ?>
                    </div>

                    <?php if ( comments_open() || get_comments_number() ) {
                              comments_template();
                          }
                    ?>
                </article>
            <?php endwhile; ?>
<?php if ( ! get_query_var( 'sidepage', false ) ) : ?>
            </div>
        <?php get_header(); ?>
        </main>
    </div>
    <?php get_footer(); ?>
<?php endif; ?>
