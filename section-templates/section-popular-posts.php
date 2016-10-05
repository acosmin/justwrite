<?php
/* -------------------------------------------------------------------------------- *
 *
 *  Popular Posts v2
 * _____________________
 *
 *  You can find the widget in: /acosmin/widgets/section-popular-posts-widget.php
 * _____________________
 * 
 *  $section_title ~ Section title
 *
/* -------------------------------------------------------------------------------- */
?>

<div class="twelvecol clearfix">

	<header class="section-heading sp-popular-heading<?php if ( empty( $section_title ) ) { echo ' no-title'; } ?>">
    <?php 
    // Check if a title is set
    if ( ! empty( $section_title ) ) { ?>
        <h2><?php echo esc_html( $section_title ); ?></h2>
    <?php } ?>
    </header><!-- END .section-heading -->
    
    <div class="sp-popular-items clearfix">
    <?php
        /* Query arguments
        ------------------ */
        $count = 0;
        $query_args = array(
            'orderby' 				=> 'comment_count', 
            'posts_per_page'		=> 3,
            'post_status'         	=> 'publish',
            'ignore_sticky_posts'	=> 1
        ); 
        
        // The Query
        $query_posts = new WP_Query( apply_filters( 'ac_widget_popular_posts_query_filter', $query_args ) );
        if( $query_posts->have_posts()) : while ( $query_posts->have_posts() ) : $query_posts->the_post(); $count++;
        
            // First place 
            if( $count == 1 ) :
        ?>
        <div class="first-place-item sc-item">
            <?php if( $spo ) { ?><span class="sc-popular-position st-bold"><?php _e( '1', 'justwrite' ); ?></span><?php } ?>
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
                        <?php if( $sco || $sda || $sca ) : ?>
                        <aside class="s-info si-center clearfix">
                            <?php if( $sco ) : ?><a href="<?php comments_link(); ?>" rel="nofollow" class="com"><?php ac_icon('comment') . ' ' . comments_number( '0', '1', '%' ); ?></a><?php endif; ?>
                            <?php if( $sda ) : ?><time class="date" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'M d, Y' ); ?></time><?php endif; ?>
                            <?php if( $sca ) : ac_output_first_category( 'category' ); endif; ?>
                        </aside>
                        <?php endif; ?>
                        <?php the_title( '<h3 class="section-title st-wrapped st-large st-bold"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
                    </div>
                </figcaption>
            </figure>
        </div>
        
        <?php
            endif;
            
            // Second place 
            if( $count == 2 ) :
        ?>
        
        <div class="secondary-item alignleft sc-title-hover sc-th-center sc-item second-pos">
            <?php if( $spo ) { ?><span class="sc-popular-position st-bold"><?php _e( '2', 'justwrite' ); ?></span><?php } ?>
            <figure  class="sc-thumbnail">
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
                </figcaption>
            </figure>
            <div class="sc-entry">
                <?php if( $sco || $sda || $sca ) : ?>
                <aside class="s-info si-center clearfix">
                    <?php if( $sco ) : ?><a href="<?php comments_link(); ?>" rel="nofollow" class="com"><?php ac_icon('comment') . ' ' . comments_number( '0', '1', '%' ); ?></a><?php endif; ?>
                    <?php if( $sda ) : ?><time class="date" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'M d, Y' ); ?></time><?php endif; ?>
                    <?php if( $sca ) : ac_output_first_category( 'category' ); endif; ?>
                </aside>
                <?php endif; ?>
                <?php the_title( '<h4 class="section-title st-small st-bold"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>
            </div>
        </div>
        
        <?php
            endif;
            
            // Thired place 
            if( $count == 3 ) :
        ?>
        
        <div class="secondary-item alignright sc-title-hover sc-th-center sc-item third-pos">
            <?php if( $spo ) { ?><span class="sc-popular-position st-bold"><?php _e( '3', 'justwrite' ); ?></span><?php } ?>
            <figure class="sc-thumbnail">
                <?php 
                    if ( has_post_thumbnail() ) : 
                        the_post_thumbnail( 'ac-sidebar-featured' );
                    else :
                        echo '<img src="' . get_template_directory_uri() . '/images/no-thumbnail.png" alt="' . __( 'No Thumbnail', 'justwrite' ) . '" />';
                    endif;
                ?>
                <figcaption class="st-overlay third-pos">
                    <?php do_action( 'ac_action_thumbnail_after' ); // Thumbnail action ?>
                    <a href="<?php echo esc_url( get_permalink() ); ?>" rel="nofollow" class="st-overlay-link"></a>
                </figcaption>
            </figure>
            <div class="sc-entry">
                <?php if( $sco || $sda || $sca ) : ?>
                <aside class="s-info si-center clearfix">
                    <?php if( $sco ) : ?><a href="<?php comments_link(); ?>" rel="nofollow" class="com"><?php ac_icon('comment') . ' ' . comments_number( '0', '1', '%' ); ?></a><?php endif; ?>
                    <?php if( $sda ) : ?><time class="date" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'M d, Y' ); ?></time><?php endif; ?>
                    <?php if( $sca ) : ac_output_first_category( 'category' ); endif; ?>
                </aside>
                <?php endif; ?>
                <?php the_title( '<h4 class="section-title st-small st-bold"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>
            </div>
        </div>
        
        <?php endif; endwhile; endif; ?>
    </div><!-- END .sp-popular-items -->
    
    <div class="sp-popular-spacer"></div>
</div><!-- END .twelvecol -->