<?php get_header(); ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <div class="flex-page">
        <?php
        query_posts( array(
            'post__in'  =>  explode( ':', get_query_var( 'outfit', '' ) ) ) );
        
        while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content' ); ?>
        <?php endwhile; ?>
        </div>
    </main>
</div>
<?php get_footer(); ?>
