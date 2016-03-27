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

        /* Construct new nav session. */
        wardrobe_session_nav_start();
        session_regenerate_id();
        wardrobe_session_nav_set( $cat_posts );
        session_write_close();
    ?>
        <div class="category-grid">
        <?php foreach ( $cat_posts as $cat_id => $posts ) : ?>
            <div id="category-<?php echo $cat_id; ?>" class="category">
                <div id="category-<?php echo $cat_id; ?>-name" class="category-name">
                    <h2 class="category-name__heading"><?php echo get_cat_name( $cat_id ); ?></h2>
                </div>
                <div id="category-<?php echo $cat_id; ?>-content" class="category-content">
                <?php foreach ( $posts as $idx => $current_post ) :
                    /* Reinitialise post data for in-the-loop functions. */
                    global $post;
                    $post = $current_post;
                    setup_postdata( $post );
                ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'thumbnail-post' ); ?>>
                        <a id="post-<?php the_ID(); ?>-link" class="post-link" href="<?php echo wardrobe_session_nav_permalink( $cat_id, $idx ); ?>" post-title="<?php the_title(); ?>">
                            <div id="post-<?php the_ID(); ?>__thumbnail" class="thumbnail-post__thumbnail">
                            <?php the_post_thumbnail(); ?>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </main>
</div>
<?php get_footer(); ?>
