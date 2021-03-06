<?php
/* ------------------------------------------------------------------------- *
 *  The template used for displaying posts in the Gallery post format
/* ------------------------------------------------------------------------- */

// Custom Post Classes
$classes = array(
    'single-template-1',
    'clearfix',
);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<div class="post-content">
    	<?php the_title( '<h2 class="title">', '</h2>' ); ?>
        <header class="details clearfix">
        	<time class="detail left index-post-date" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'M d, Y' ); ?></time>
			<span class="detail left index-post-author"><em><?php _e( 'by', 'justwrite' ); ?></em> <?php the_author_posts_link(); ?></span>
			<span class="detail left index-post-category"><em><?php _e( 'in', 'justwrite' ); ?></em> <?php ac_output_first_category(); ?></span>
            <a href="<?php echo esc_url( get_post_format_link( 'gallery' ) ); ?>" title="<?php _e( 'Galleries Archive', 'justwrite' ); ?>" class="post-format-icon"><?php ac_icon( 'picture-o' ); ?></a>
        </header><!-- END .details -->
		<div class="single-content">
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
