<?php if ( ! get_query_var( 'sidepage', false ) ) : ?>
    <?php get_header(); ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <div class="single-post-div">
<?php else : ?>
    <div class="sidepage-bar">
        <div class="close-sidepage-div inline-block">
            <button class="close-sidepage-button">
                <svg viewBox="0 0 8 8" class="icon">
                    <use xlink:href="#x" class="icon-use icon-close-sidepage"></use>
                </svg>
                <span class="button-text text-close-sidepage">
                    <?php esc_html_e( 'Close', 'wardrobe' ); ?>
                </span>
            </button>
        </div>
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
    </div>
<?php endif; ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post' ); ?>>
                    <header class="entry-header">
                        <div id="single-post-<?php the_ID(); ?>-thumbnail" class="single-post-thumbnail">
                            <?php the_post_thumbnail(); ?>
                        </div>
                        <div id="single-post-<?php the_ID(); ?>-title" class="single-post-title">
                            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                        </div>
                    <?php if ( 'post' === get_post_type() ) : ?>
                        <div class="entry-meta">
                            <span class="entry-date"><?php echo get_the_date(); ?></span>
                        </div>
                    <?php endif; ?>
                    </header>
                    <div class="entry-content">
                        <?php
                            the_content();
                            wp_link_pages( array(
                                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wardrobe' ),
                                'after'  => '</div>'
                            ) );
                        ?>
                    </div>
                </article>
            <?php endwhile; ?>
<?php if ( ! get_query_var( 'sidepage', false ) ) : ?>
            </div>
        <?php get_header(); ?>
        </main>
    </div>
    <?php get_footer(); ?>
<?php endif; ?>
