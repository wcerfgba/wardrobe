<?php $subpage = get_query_var( 'subpage', false ); ?>
<?php if ( $subpage ) : ?>
    <?php get_template_part( 'template-parts/subpage' ); ?>
<?php else : ?>
    <?php get_header(); ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <div class="page singular">
            <?php
            while ( have_posts() ) : the_post();
                get_template_part( 'template-parts/content' );
            endwhile;
            ?>
            </div>
        </main>
    </div>
    <?php get_footer(); ?>
<?php endif; ?>
