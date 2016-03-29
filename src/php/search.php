<?php get_header(); ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
    <?php
        /* Execute query and sort posts by category. */
        $full_query = $wp_query->query;
        $full_query['posts_per_page'] = -1;
        query_posts( $full_query );
        $cat_posts = array();
        while ( have_posts() ) : the_post();
            foreach ( get_the_category() as $cat ) :
                $cat_posts["$cat->cat_ID"][] = get_post();
            endforeach;
        endwhile;
    ?>
        <div class="category-grid">
        <?php
            foreach ( $cat_posts as $cat_id => $posts ) :
                
            /* Construct new nav session for each category. */
            wardrobe_nav_start();
            session_regenerate_id();
            wardrobe_nav_array( $posts );
        ?>
            <div id="category-<?php echo $cat_id; ?>" class="category">
                <div id="category-<?php echo $cat_id; ?>-name" class="category-name">
                    <h2 class="category-name__heading"><?php echo get_cat_name( $cat_id ); ?></h2>
                </div>
                <div id="category-<?php echo $cat_id; ?>-content" class="category-content">
                <?php foreach ( $posts as $current_post ) :
                    /* Reinitialise post data for in-the-loop functions. */
                    global $post;
                    $post = $current_post;
                    setup_postdata( $post );
                ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'search-result' ); ?>>
                        <a id="post-<?php the_ID(); ?>-link" class="post-link" href="<?php echo wardrobe_nav_permalink(); ?>" post-title="<?php the_title(); ?>">
                            <div id="post-<?php the_ID(); ?>__thumbnail" class="search-result__thumbnail">
                                <?php echo the_post_thumbnail(); ?>
                            </div>
                            <header class="search-result-header">
                                <h2 class="entry-title">
                                <?php the_title(); ?>
                                </h2>
                            <?php if ( 'post' === get_post_type() ) : ?>
                                <div class="search-result-header__meta">
                                    <span class="entry-date">
                                    <?php the_time( get_option( 'date_format' ) ); ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                                <div class="search-result-summary">
                                <?php the_excerpt(); ?>
                                </div>
                            </header>
                        </a>
                    </article>
                <?php endforeach; ?>
                </div>
            </div>
        <?php session_write_close(); endforeach; ?>
    </main>
</div>
<?php get_footer(); ?>
