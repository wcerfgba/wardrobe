<?php get_header(); ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php foreach ( get_categories( "orderby=id" ) as $cat) : ?>
            <div id="category-<?php echo $cat->cat_ID; ?>" class="category">
                <div id="category-<?php echo $cat->cat_ID; ?>-name-div" class="category-name-div">
                    <h2 class="category-name"><?php echo $cat->cat_name; ?></h2>
                </div>
                <div id="category-<?php echo $cat->cat_ID; ?>-content-div" class="category-content-div">
                <?php $cat_query = new WP_Query( "cat=$cat->cat_ID" );
                while ( $cat_query->have_posts() ) : $cat_query->the_post(); ?>
                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div id="post-<?php the_ID(); ?>-thumbnail" class="post-thumbnail">
                            <?php the_post_thumbnail(); ?>
                        </div>
                        <div id="post-<?php the_ID(); ?>-title" class="post-title">
                            <?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </main>
</div>
<?php get_footer(); ?>
