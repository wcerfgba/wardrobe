<?php get_header(); ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
    <?php
        $full_query = $wp_query->query;
        $full_query['posts_per_page'] = -1;
        query_posts( $full_query );
        $cat_posts = array();
        while ( have_posts() ) : the_post();
            foreach ( get_the_category() as $cat ) :
                $cat_posts["$cat->cat_ID"][] = get_post();
            endforeach;
        endwhile;

        foreach ( $cat_posts as $cat_id => $posts ) : ?>
            <div id="category-<?php echo $cat_id; ?>" class="category">
                <div id="category-<?php echo $cat_id; ?>-name-div" class="category-name-div">
                    <h2 class="category-name"><?php echo get_cat_name( $cat_id ); ?></h2>
                </div>
                <div id="category-<?php echo $cat_id; ?>-content-div" class="category-content-div">
                <?php foreach ( $posts as $current_post ) :
                    /* Reinitialise post data for in-the-loop functions. */
                    global $post;
                    $post = $current_post;
                    setup_postdata( $post );
                ?>
                    <article id="grid-post-<?php the_ID(); ?>" <?php post_class( 'grid-post' ); ?>>
                        <div id="grid-post-<?php the_ID(); ?>-thumbnail" class="grid-post-thumbnail">
                            <?php the_post_thumbnail(); ?>
                        </div>
                        <div id="grid-post-<?php the_ID(); ?>-title-div" class="grid-post-title-div">
                            <h2 class="grid-post-title">
                            <?php the_title(); ?>
                            </h2>
                        </div>
                    </article>
                <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </main>
</div>
<?php get_footer(); ?>
