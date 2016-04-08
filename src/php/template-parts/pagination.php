<?php if ( $wp_query->max_num_pages > 1 ) : ?>
<div class="pagination">
    <?php //if ( ! is_home() ) :
    echo paginate_links( array(
            'show_all'  =>  true,
            'prev_text' =>  '&laquo;',
            'next_text' =>  '&raquo;'
        ) );
    //endif; ?>
</div>
<?php endif; ?>
