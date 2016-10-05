<?php
/* -------------------------------------------------------------------------------- *
 *
 *  Categories - Four columns
 * _____________________
 *
 *  You can find the widget in: /acosmin/widgets/section-categories-4col-widget.php
 * _____________________
 * 
 *  $section_title ~ Section title
 *  $section_postsnr ~ How many posts a query has
 *  $section_category1 ~ Selected category #1
 *  $section_category2 ~ Selected category #2
 *  $section_category3 ~ Selected category #3
 *  $section_category4 ~ Selected category #4
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

<?php 
	// Multiply this template
	for ( $i = 1; $i < 5; $i++ ) :
	  
		// Category ID
		$cat_name = ${"section_category$i"};
?>

<div class="col threecol<?php if( $i == 4 ) { echo ' last';} ?>">
	<header class="section-col-header">
		<?php 
			// Category title
			ac_widget_cols_title( $cat_name ); 
		?>
		<?php if( $smo || $srs ) : ?>
		<ul class="section-col-nav">
			<?php if( $smo ) { ?><li><a href="<?php echo esc_url( get_category_link( $cat_name ) ); ?>" title="<?php _e( 'More articles in this category', 'justwrite' ); ?>"><?php ac_icon( 'ellipsis-h' ); ?></a></li><?php } ?>
            <?php if( $srs ) { ?><li><a href="<?php echo esc_url( get_category_feed_link( $cat_name, '' ) ); ?>" title="<?php _e( 'RSS Feed', 'justwrite' ); ?>"><?php ac_icon( 'rss' ); ?></a></li><?php } ?>
		</ul><?php endif; ?>
	</header><!-- END .section-col-header -->
	
	<?php if( ${"section_category$i"} != '' ) : ?>
	<div class="section-cat-wrap clearfix">
		<ul class="sc-posts alignright">
		<?php
			/* Query arguments
			------------------ */
			// Posts in category
			$query_args = array( 
				'posts_per_page'		=> absint( $section_postsnr ),
				'post_status'         	=> 'publish',
				'cat'					=> $cat_name,
				'ignore_sticky_posts'	=> 1
			);
			
			// The Query
			$query_posts = new WP_Query( apply_filters( 'ac_widget_cats_4col_query_filter', $query_args ) );
			$count = 0;
			if( $query_posts->have_posts()) : while ( $query_posts->have_posts() ) : $query_posts->the_post(); $count++;
				if($count == 1) :
		?>
			<li class="sc-first-post sc-title-hover sc-item">
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
					</figcaption>
				</figure>
				<div class="sc-entry">
					<?php if( $sdt || $scm || $sau ) { ?>
					<aside class="s-info clearfix">
						<?php if( $scm ) { ?><a href="<?php comments_link(); ?>" rel="nofollow" class="com"><i class="fa fa-comment"></i> <?php comments_number( '0', '1', '%' ); ?></a><?php } ?>
						<?php if( $sdt ) { ?><time class="date" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'M d, Y' ); ?></time><?php } ?>
						<?php if( $sau ) { ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="category"><?php echo esc_html( get_the_author() ); ?></a><?php } ?>
					</aside>
					<?php } ?>
					<?php the_title( '<h4 class="section-title st-medium st-bold"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>
				</div>
			</li>
			<?php else : ?>
			<li>
				<div class="sc-entry">
					<?php the_title( '<h4 class="section-title st-small"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>
				</div>
			</li>
			<?php endif; endwhile; else : ?>
			<ul class="sc-posts alignright no-posts"><li><h4 class="section-title st-small"><?php _e( 'This category has no posts!', 'justwrite' ); ?></h4></li>	
			<?php endif; wp_reset_postdata(); // End Query ?>
		</ul>
	</div><!-- END .section-cat-wrap -->
	<?php endif; // if cat# not selected ?>
</div><!-- END .threecol -->

<?php endfor; ?>