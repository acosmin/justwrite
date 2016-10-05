<?php
/* ------------------------------------------------------------------------- *
 *  The template used to display articles on your main page.
/* ------------------------------------------------------------------------- */

// Options
// $disable_share = of_get_option( 'ac_dont_share_options' );

// Custom Post Classes
$classes = array(
    'post-template-1',
    'clearfix',
);

$newlayout = get_theme_mod( 'ac_main_posts_layout', 'lthumb' ); 
if( $newlayout == 'nthumb' ) {
	$classes[] = 'nthumb';
}

$classes = join(' ', $classes);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<?php if( $newlayout != 'nthumb' ) : ?>
	<figure class="post-thumbnail<?php if ( ! has_post_thumbnail() ) echo ' no-thumbnail'; ?>">
    	<?php
			if ( is_sticky() ) :
				echo '<span class="sticky-badge">' . __('Sticky Post', 'justwrite') . '</span>';
			endif;
			
			if ( has_post_thumbnail() ) :
					the_post_thumbnail( 'ac-post-thumbnail' );
			else :
					echo '<img src="' . get_template_directory_uri() . '/images/no-thumbnail.png" alt="' . __( 'No Thumbnail', 'justwrite' ) . '" />';
			endif;
			
			do_action( 'ac_action_content_thumbnail_after' ); // After thumbnail action
			
			// Post Formats Icons
			if ( has_post_format( 'video' ) && !is_sticky() ) echo'<span class="post-format-icon">' . ac_icon( 'play', false ) . '</span>';
			if ( has_post_format( 'audio' ) && !is_sticky() ) echo'<span class="post-format-icon">' . ac_icon( 'volume-up', false ) . '</span>';
			if ( has_post_format( 'gallery' ) && !is_sticky() ) echo'<span class="post-format-icon">' . ac_icon( 'picture-o', false ) . '</span>';
			if ( has_post_format( 'quote' ) && !is_sticky() ) echo'<span class="post-format-icon">' . ac_icon( 'quote-left', false ) . '</span>';
			if ( has_post_format( 'link' ) && !is_sticky() ) echo'<span class="post-format-icon">' . ac_icon( 'link', false ) . '</span>';
			if ( has_post_format( 'aside' ) && !is_sticky() ) echo'<span class="post-format-icon">' . ac_icon( 'coffee', false ) . '</span>';
			if ( has_post_format( 'image' ) && !is_sticky() ) echo'<span class="post-format-icon">' . ac_icon( 'instagram', false ) . '</span>';
		?>
	</figure>
    <?php endif; ?>
	<div class="post-content">
    	<?php the_title( '<h2 class="title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
		<?php the_excerpt(); ?>
        <footer class="details">
        	<span class="post-small-button left p-read-more" id="share-<?php the_ID(); ?>-rm">
            	<a href="<?php echo esc_url( get_permalink() ); ?>" rel="nofollow" title="<?php _e( 'Read More...', 'justwrite' ) ?>"><i class="fa fa-ellipsis-h fa-lg"></i></a>
			</span>
            <?php do_action( 'ac_action_content_read_more_after' ); // After "Read More" button action ?>
            <time class="detail left index-post-date" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'M d, Y' ); ?></time>
			<span class="detail left index-post-author"><em><?php _e( 'by', 'justwrite' ); ?></em> <?php the_author_posts_link(); ?></span>
			<?php if( ! is_category() ) { ?><span class="detail left index-post-category"><em><?php _e( 'in', 'justwrite' ); ?></em> <?php ac_output_first_category(); ?></span><?php } ?>
		</footer><!-- END .details -->
	</div><!-- END .post-content -->
</article><!-- END #post-<?php the_ID(); ?> .post-template-1 -->
