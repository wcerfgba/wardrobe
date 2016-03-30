<?php get_header(); ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <div class="flex-page">
        <?php
        foreach ( wardrobe_outfit_ids() as $pos => $id ) :
            query_posts( array(
                    'p'                 =>  $id,
                    'subpage'           =>  'true',
                    'navigation'        =>  wardrobe_outfit_navs()[$pos],
                    'outfit_position'   =>  $pos,
                    'outfit'            =>  get_query_var( 'outfit' ),
                    'outfit_navs'       =>  get_query_var( 'outfit_navs' ) ) );
        
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
