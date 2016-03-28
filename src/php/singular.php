<?php get_header(); ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <div class="page">
        <?php
        while ( have_posts() ) : the_post();
            get_template_part( 'content' );
        endwhile;
        ?>
        </div>
    </main>
</div>
<?php get_footer(); ?>
