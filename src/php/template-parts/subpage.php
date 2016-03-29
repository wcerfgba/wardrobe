<header class="subpage-bar">
    <div class="buttons-left">
       <button class="sidepage-close-button">
        <svg viewBox="0 0 8 8" class="icon">
            <use xlink:href="#x" class="icon-use icon-close-sidepage"></use>
        </svg>
        <span class="button-text text-close-sidepage">
                <?php esc_html_e( 'Close', 'wardrobe' ); ?>
        </span>
       </button>
    </div>
    <?php if ( get_query_var( 'navigation', false ) ) : wardrobe_nav_start(); ?>
    <div class="nav-links buttons-right">
        <a class="nav-links__prev-link button-link" href="<?php echo wardrobe_nav_permalink_prev( $post->ID ); ?>">
            <svg viewBox="0 0 8 8" class="icon">
                <use xlink:href="#chevron-left" class="icon-use icon-nav-prev"></use>
            </svg>
            <span class="link__text text-nav-prev">
                <?php esc_html_e( 'Previous', 'wardrobe' ); ?>
            </span>
        </a>
        <a class="nav-links__next-link button-link" href="<?php echo wardrobe_nav_permalink_next( $post->ID ); ?>">
            <svg viewBox="0 0 8 8" class="icon">
                <use xlink:href="#chevron-right" class="icon-use icon-nav-next"></use>
            </svg>
            <span class="link__text text-nav-next">
                <?php esc_html_e( 'Next', 'wardrobe' ); ?>
            </span>
        </a>
    </div>
    <?php session_write_close(); endif; ?>
</header>
<?php get_template_part( 'template-parts/content' ); ?>