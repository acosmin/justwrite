<?php
/* -------------------------------------------------------------------------------- *
 *
 *  Masonry Template v1
 * _____________________
 *
 *  You can find the widget in: /acosmin/widgets/section-masonry-1-widget.php
 * _____________________
 * 
 *  $section_title ~ Section title
 *  $section_type ~ Section type (category, featured posts or latest posts)
 *  $section_postsnr ~ How many posts a query has
 *
/* -------------------------------------------------------------------------------- */
?>

<?php 
// Check if a title is set
if ( ! empty( $section_title ) ) { ?>
<header class="section-heading sh-large twelvecol">
	<h2><?php echo esc_html( $section_title ); ?></h2>	
</header><!-- END .section-heading -->
<?php } ?>

<div id="sm-<?php echo absint( $wnum ); ?>-small" class="js-masonry sm-wrap clearfix" data-masonry-options='{ "columnWidth": ".grid-sizer", "gutter": ".gutter-sizer", "percentPosition": true, "itemSelector": ".col" }'>

    <div class="grid-sizer"></div>
    <div class="gutter-sizer"></div>
    
    <?php
        /* Query arguments
        ------------------ */
        if( $section_type == 'featured' ) {
            // Featured posts
            $query_args = array( 
                'posts_per_page'		=> absint( $section_postsnr ),
				'post_status'         	=> 'publish',
                'meta_key'				=> 'ac_featured_article',
                'meta_value'			=> 1, 
                'ignore_sticky_posts'	=> 1
            );
		 } elseif( $section_type == 'category' ) {
            // Posts in category
            $query_args = array( 
                'posts_per_page'		=> absint( $section_postsnr ),
				'post_status'         	=> 'publish',
                'cat'					=> absint( $section_category ),
                'ignore_sticky_posts'	=> 1
            ); 
        } else {
            // Recent posts
            $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
            $query_args = array( 
                'posts_per_page'		=> absint( $section_postsnr ),
				'post_status'         	=> 'publish',
                'paged' 				=> $paged,
                'ignore_sticky_posts'	=> 1
            );	
        }
        
        // The Query
        $query_posts = new WP_Query( apply_filters( 'ac_widget_masonry1_query_filter', $query_args ) );
        if( $query_posts->have_posts()) : while ( $query_posts->have_posts() ) : $query_posts->the_post();
    ?>
    <div class="col threecol sc-title-hover sc-item">
        <figure class="sc-thumbnail<?php if ( ! has_post_thumbnail() ) echo ' no-thumbnail'; ?>">
            <?php 
                if ( has_post_thumbnail() ) : 
                    the_post_thumbnail( 'ac-masonry-small-featured' );
                else :
                    echo '<img src="' . get_template_directory_uri() . '/images/no-thumbnail.png" alt="' . __( 'No Thumbnail', 'justwrite' ) . '" />';
                endif;
            ?>
            <figcaption class="st-overlay">
                <?php do_action( 'ac_action_thumbnail_after' ); // Thumbnail action ?>
                <a href="<?php echo esc_url( get_permalink() ); ?>" rel="nofollow" class="st-overlay-link"></a>
            </figcaption>
        </figure>
        <div class="sc-entry">
            <?php if( $sda || $sco || $sau || $sca ) { ?>
            <aside class="s-info clearfix">
                <?php if( $sco ) { ?><a href="<?php comments_link(); ?>" rel="nofollow" class="com"><i class="fa fa-comment"></i> <?php comments_number( '0', '1', '%' ); ?></a><?php } ?>
                <?php if( $sda ) { ?><time class="date" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'M d, Y' ); ?></time><?php } ?>
                <?php if( $sau && ( $section_type != 'posts' && $section_type != 'featured' ) ) { ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="category"><?php echo esc_html( get_the_author() ); ?></a><?php } ?>
                <?php if( $sca && $section_type != 'category' ) : ac_output_first_category( 'category' ); endif; ?>
            </aside>
            <?php } ?>
            <?php the_title( '<h4 class="section-title st-small-2nd st-bold"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>
        </div>     
    </div><!-- END .threecol -->
    <?php endwhile;  else : // No posts ?>
        <h4 class="section-title st-small-2nd st-bold"><?php _e( 'No posts available', 'justwrite' ); ?></h4>
    <?php endif; wp_reset_postdata(); // End Query ?>

</div><!-- END .sm-wrap -->

<script type='text/javascript'>/* <![CDATA[ */ (function( $ ) { $( document ).ready(function() { var $masonry_small_<?php echo absint( $wnum ); ?> = $('#sm-<?php echo absint( $wnum ); ?>-small').masonry(); $masonry_small_<?php echo absint( $wnum ); ?>.imagesLoaded( function() { $masonry_small_<?php echo absint( $wnum ); ?>.masonry(); });});})(jQuery); /* ]]> */</script>