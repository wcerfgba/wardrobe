<?php get_header(); ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <div class="flex-page">
        <?php
        foreach ( explode( ':', get_query_var( 'outfit', '' ) ) as $id ) :
            query_posts( array(
                            'p'         =>  $id,
                            'subpage'   =>  'true' ) );
        
            while ( have_posts() ) : the_post(); ?>
            <div class="flex-subpage">
            <?php get_template_part( 'template-parts/subpage' ); ?>
            </div>
        <?php
            endwhile;
        endforeach;
        ?>
        </div>
    </main>
</div>
<?php get_footer(); ?>
