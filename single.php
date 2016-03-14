<?php get_header(); ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
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
    </main>
</div>
<?php get_footer(); ?>
