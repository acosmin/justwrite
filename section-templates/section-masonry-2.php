<?php
/* -------------------------------------------------------------------------------- *
 *
 *  Masonry Template v2
 * _____________________
 *
 *  You can find the widget in: /acosmin/widgets/section-masonry-2-widget.php
 * _____________________
 * 
 *  $section_title ~ Section title
 *  $section_type ~ Section type (category, featured posts or latest posts)
 *  $section_category ~ Selected category
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

<div id="sm-<?php echo absint( $wnum ); ?>-large" class="js-masonry twelvecol" style="display: none;" data-masonry-options='{ "columnWidth": ".grid-sizer-large", "percentPosition": true, "itemSelector": ".col-large" }'>

    <div class="grid-sizer-large"></div>
    
    <?php
        /* Query arguments
        ------------------ */
        if( $section_type == 'featured' ) {
            // Featured posts
            $query_args = array( 
                'posts_per_page'		=> 5,
				'post_status'         	=> 'publish',
                'meta_key'				=> 'ac_featured_article',
                'meta_value'			=> 1, 
                'ignore_sticky_posts'	=> 1
            );
        } elseif(  $section_type == 'category' ) {
            // Posts in category
            $query_args = array( 
                'posts_per_page'		=> 5,
				'post_status'         	=> 'publish',
                'cat'					=> absint( $section_category ),
                'ignore_sticky_posts'	=> 1
            ); 
        } else {
            // Recent posts
            $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
            $query_args = array( 
                'posts_per_page'		=> 5,
				'post_status'         	=> 'publish',
                'paged' 				=> $paged,
                'ignore_sticky_posts'	=> 1
            );	
        }
        
        // The Query
        $count = 0;
        $query_posts = new WP_Query( apply_filters( 'ac_widget_masonry2_query_filter', $query_args ) );
        if( $query_posts->have_posts()) : while ( $query_posts->have_posts() ) : $query_posts->the_post(); $count++;
            if( $count == 1 || $count == 8 ) :
    ?>
    
    <div class="col-large col-2x">
        <figure class="sc-thumbnail<?php if ( ! has_post_thumbnail() ) echo ' no-thumbnail'; ?>">
            <?php 
                if ( has_post_thumbnail() ) : 
                    the_post_thumbnail( 'ac-masonry-2x-thumbnail' );
                else :
                    echo '<img src="' . get_template_directory_uri() . '/images/no-thumbnail.png" alt="' . __( 'No Thumbnail', 'justwrite' ) . '" />';
                endif;
            ?>
            <figcaption class="st-overlay">
                <?php do_action( 'ac_action_thumbnail_after' ); // Thumbnail action ?>
                <a href="<?php echo esc_url( get_permalink() ); ?>" rel="nofollow" class="st-overlay-link"></a>
                <div class="st-title-wrap">
                    <?php if( $sda || $sco || $sau || $sca ) { ?>
                    <aside class="s-info clearfix">
                        <?php if( $sco ) { ?><a href="<?php comments_link(); ?>" rel="nofollow" class="com"><i class="fa fa-comment"></i> <?php comments_number( '0', '1', '%' ); ?></a><?php } ?>
                        <?php if( $sda ) { ?><time class="date" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'M d, Y' ); ?></time><?php } ?>
                        <?php if( $sau && ( $section_type != 'posts' && $section_type != 'featured' ) ) { ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="category"><?php echo esc_html( get_the_author() ); ?></a><?php } ?>
                        <?php if( $sca && $section_type != 'category' ) : ac_output_first_category( 'category' ); endif; ?>
                    </aside>
                    <?php } ?>
                     <?php the_title( '<h3 class="section-title st-wrapped st-large st-bold"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
                </div>
            </figcaption>
        </figure>     
    </div><!-- END .col-large .col-2x -->
    
    <?php else : ?>
    
    <div class="col-large">
        <figure class="sc-thumbnail<?php if ( ! has_post_thumbnail() ) echo ' no-thumbnail'; ?>">
            <?php 
                if ( has_post_thumbnail() ) : 
                    the_post_thumbnail( 'ac-sidebar-featured' );
                else :
                    echo '<img src="' . get_template_directory_uri() . '/images/no-thumbnail.png" alt="' . __( 'No Thumbnail', 'justwrite' ) . '" />';
                endif;
            ?>
            <figcaption class="st-overlay">
                <?php do_action( 'ac_action_thumbnail_after' ); // Thumbnail action ?>
                <a href="<?php echo esc_url( get_permalink() ); ?>" rel="nofollow" class="st-overlay-link"></a>
                <div class="st-title-wrap">
                    <?php if( $sda || $sco || $sau || $sca ) { ?>
                    <aside class="s-info clearfix">
                        <?php if( $sco ) { ?><a href="<?php comments_link(); ?>" rel="nofollow" class="com"><i class="fa fa-comment"></i> <?php comments_number( '0', '1', '%' ); ?></a><?php } ?>
                        <?php if( $sda ) { ?><time class="date" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'M d, Y' ); ?></time><?php } ?>
                        <?php if( $sau && ( $section_type != 'posts' && $section_type != 'featured' ) ) { ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="category"><?php echo esc_html( get_the_author() ); ?></a><?php } ?>
                        <?php if( $sca && $section_type != 'category' ) : ac_output_first_category( 'category' ); endif; ?>
                    </aside>
                    <?php } ?>
                    <?php the_title( '<h4 class="section-title st-wrapped st-small st-bold"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>
                </div>	
            </figcaption>
        </figure>     
    </div><!-- END .col-large -->
    
    <?php endif; endwhile;  else : // No posts ?>
        <h4 class="section-title st-small-2nd st-bold"><?php _e( 'No posts available', 'justwrite' ); ?></h4>
    <?php endif; wp_reset_postdata(); // End Query ?>

</div><!-- END .sm-wrap -->

<script type='text/javascript'>/* <![CDATA[ */ (function( $ ) { $( document ).ready(function() { $('#sm-<?php echo absint( $wnum ); ?>-large').show(); var $masonry_large_<?php echo absint( $wnum ); ?> = $('#sm-<?php echo absint( $wnum ); ?>-large').masonry(); $masonry_large_<?php echo absint( $wnum ); ?>.imagesLoaded( function() { $masonry_large_<?php echo absint( $wnum ); ?>.masonry(); });});})(jQuery); /* ]]> */</script>