<?php
/* -------------------------------------------------------------------------------- *
 *
 *  Slider Template v2
 * _____________________
 *
 *  You can find the widget in: /acosmin/widgets/section-slider-widget.php
 * _____________________
 * 
 *  $section_title ~ Section title
 *  $section_type ~ Section type (category, featured posts or latest posts)
 *  $section_postsnr ~ How many posts a query has
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

<div class="col twelvecol clearfix" style="display: none;">

	<div class="ss-nav-btn alignleft"><a href="#" class="ss-prev-<?php echo absint( $wnum ); ?>"><span><?php ac_icon( 'angle-left' ); ?></span></a></div>
	<div class="ss-nav-btn alignright"><a href="#" class="ss-next-<?php echo absint( $wnum ); ?>"><span><?php ac_icon( 'angle-right' ); ?></span></a></div>
	
	<div class="slider-container slider-number-<?php echo esc_html( $wnum ); ?> owl-carousel">
		
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
			};
			
			// The Query
			$query_posts = new WP_Query( apply_filters( 'ac_widget_slider_query_filter', $query_args ) );
			if( $query_posts->have_posts()) : while ( $query_posts->have_posts() ) : $query_posts->the_post();
		?>
		<div class="item">
			<figure class="sc-thumbnail">
				<?php 
				if ( has_post_thumbnail() ) : 
					the_post_thumbnail( 'ac-masonry-2x-thumbnail' );
				else :
					echo '<img src="' . get_template_directory_uri() . '/images/no-thumbnail-transparent-big.png" alt="' . __( 'No Thumbnail', 'justwrite' ) . '" />';
				endif;
				?>
				<figcaption class="st-overlay">
					<?php do_action( 'ac_action_thumbnail_after' ); // Thumbnail action ?>
					<a href="<?php echo esc_url( get_permalink() ); ?>" rel="nofollow" class="st-overlay-link"></a>
					<div class="st-title-wrap">
						<?php if( $sco || $sda || $sca ) : ?>
						<aside class="s-info si-center clearfix">
							<?php if( $sco ) : ?><a href="<?php comments_link(); ?>" rel="nofollow" class="com"><?php ac_icon('comment'); ?></a><?php endif; ?>
							<?php if( $sda ) : ?><time class="date" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'M d, Y' ); ?></time><?php endif; ?>
							<?php if( $sca ) : ac_output_first_category( 'category' ); endif; ?>
						</aside>
						<?php endif; ?>
						<?php the_title( '<h3 class="section-title st-wrapped st-large st-bold"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
					</div>
				</figcaption>
			</figure>
		</div>
		<?php endwhile; else : // No posts ?>
		<div class="item">
			<figure class="sc-thumbnail">
				<img src="<?php echo get_template_directory_uri(); ?>/images/no-thumbnail-transparent-big.png" alt="<?php _e( 'No Posts Found!', 'justwrite') ?>" />
				<figcaption class="st-overlay">
                	<?php do_action( 'ac_action_thumbnail_after' ); // Thumbnail action ?>
					<div class="st-title-wrap">
						<h3 class="section-title st-wrapped st-large st-bold"><?php _e( 'Select some featured posts first!', 'justwrite') ?></h3>
					</div>
				</figcaption>
			</figure>
		</div>
		<?php endif; wp_reset_postdata(); // End Query ?>
		
	</div><!-- END .owl-carousel -->   
</div><!-- END .twelvecol -->

<script type='text/javascript'>
/* <![CDATA[ */
	(function( $ ) { $( document ).ready(function() {
		$('.slider-number-<?php echo absint( $wnum ); ?>').parent().show();
		var owl<?php echo absint( $wnum ); ?> = $('.slider-number-<?php echo absint( $wnum ); ?>');
		owl<?php echo absint( $wnum ); ?>.owlCarousel({ center: true, items: 2, loop: true, dots: false, autoplay: <?php echo esc_html( $ap ); ?>, responsiveRefreshRate: 100, responsiveClass:true, responsive: { 0: { items: 1 }, 500: { items: 1 }, 1221: { items: 2, autoWidth: true }, 1540: { items: 2, autoWidth: true },  1920: { items: 2 }, }, });
		$('.ss-next-<?php echo absint( $wnum ); ?>').click(function(event) { event.preventDefault(); owl<?php echo absint( $wnum ); ?>.trigger('next.owl.carousel', [200]); });
		$('.ss-prev-<?php echo absint( $wnum ); ?>').click(function(event) { event.preventDefault(); owl<?php echo absint( $wnum ); ?>.trigger('prev.owl.carousel', [200]); });
	});})(jQuery);
/* ]]> */
</script>