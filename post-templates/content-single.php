<?php
/* ------------------------------------------------------------------------- *
 *  Default post template for single view (post)
/* ------------------------------------------------------------------------- */

// Custom Post Classes
$classes = array(
    'single-template-1',
    'clearfix',
);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<div class="post-content">
    	<?php 
			// Display post title, information (author, date, category) and thumbnail;
			// Hooked: ac_single_post_td & ac_single_post_thumb;
			do_action( 'ac_single_post_title_info_thumb' );
		?>
        
		<div class="single-content<?php ac_single_content_classes(); ?>">
			<?php 
				the_content();

				the_tags('<div class="post-tags-wrap clearfix"><strong>' . __( 'Tagged with:', 'justwrite' ) . '</strong> <span>','</span>, <span>','</span></div>');
				
				wp_link_pages( array(
				'before'      => '<footer class="page-links-wrap"><div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'justwrite' ) . '</span>',
				'after'       => '</div></footer>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
			?>
		</div><!-- END .single-content -->
	</div><!-- END .post-content -->
</article><!-- END #post-<?php the_ID(); ?> .post-template-1 -->
