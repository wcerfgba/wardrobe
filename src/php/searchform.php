<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="search-label">
		<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'wardrobe' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'wardrobe' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'wardrobe' ); ?>" />
	</label>
    <button type="submit" class="search-submit">
        <svg viewBox="0 0 8 8" class="icon">
            <use xlink:href="#magnifying-glass" class="icon-use icon-magnifying-glass"></use>
        </svg>
        <span class="screen-reader-text">
            <?php echo _x( 'Search', 'submit button', 'wardrobe' ); ?>
        </span>
    </button>
</form>
