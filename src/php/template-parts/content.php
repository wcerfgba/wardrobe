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
