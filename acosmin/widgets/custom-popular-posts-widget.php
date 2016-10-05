<?php
/* ------------------------------------------------------------------------- *
 *  Popular Posts Widget
/* ------------------------------------------------------------------------- */

// Setup Widget
class AC_Popular_Posts_Widget extends WP_Widget {

	function __construct() {
		// Settings
		$widget_ops = array( 'classname' => 'ac_popular_posts_widget', 'description' => 'Displays your most popular articles.' );
		
		// Create the widget
		parent::__construct( 'ac_popular_posts_widget', __('AC: Popular Posts', 'justwrite'), $widget_ops );
		
		// Default values
		$this->defaults = array (
				'title'						=> 'Popular Posts',
				'popular_posts_number' 	=> 3,
		);
	}

	function widget( $args, $instance ) {
		// Turn $args array into variables.
		extract( $args );

		// $instance Defaults
		$instance_defaults = $this->defaults;
		
		// Parse $instance
		$instance = wp_parse_args( $instance, $instance_defaults );

		// Widget Settings
		$title 					= ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$popular_posts_number	= ( ! empty( $instance['popular_posts_number'] ) ) ? absint( $instance['popular_posts_number'] ) : 3;
		
		echo $before_widget;

		// Widget Front End Output
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
	
		$args = array( 
				'orderby' => 'comment_count', 
				'posts_per_page' => $popular_posts_number,
				'ignore_sticky_posts' => 1
		);
		$wp_query = new WP_Query();
		$wp_query->query($args);
		$count = 0; 
		?>
		<ul class="ac-popular-posts">
			<?php if( $wp_query->have_posts()) : while ( $wp_query->have_posts() ) : $wp_query->the_post();
					$count++;
					$mcn = get_comments_number();
					$ncn = get_comments_number();
					
					if( $count == 1 ) { $max_comments_number = $mcn; };
					
					if ( $ncn != 0 ) {
						$make_percent = number_format(100 * $ncn / $max_comments_number);
			?>
			<li>
				<span class="position"><?php echo $count; ?></span>
				<div class="details">
					<span class="category"><?php ac_output_first_category(); ?></span>
					<?php the_title( '<a href="' . esc_url( get_permalink() ) . '" class="title" rel="bookmark">', '</a>' ); ?>
					<div class="the-percentage" style="width: <?php echo $make_percent; ?>%"></div>
					<a href="<?php comments_link(); ?>" class="comments-number"><?php ac_comments_number(); ?></a>
				</div>
			</li>
			<?php }; endwhile; else : ?>
               <li><?php _e('No popular posts available!', 'justwrite'); ?></li>
			<?php endif; wp_reset_postdata(); ?>
		</ul>
		<?php
		
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] 					= strip_tags( $new_instance['title'] );
		$instance['popular_posts_number'] 	= absint( $new_instance['popular_posts_number'] );

		return $instance;
	}

	function form( $instance ) {

		// Parse $instance
		$instance = wp_parse_args( $instance, $this->defaults );
		extract( $instance, EXTR_SKIP );
		
		?>

		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'justwrite'); ?>:</label><br />
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
        
        <p><strong><?php _e('How many', 'justwrite'); ?> &not;</strong></p>
        
        <p class="ac_two_columns">
		<label for="<?php echo $this->get_field_id( 'popular_posts_number' ); ?>"><?php _e('Popular Posts', 'justwrite'); ?>:</label>
		<input  type="text" id="<?php echo $this->get_field_id( 'popular_posts_number' ); ?>" name="<?php echo $this->get_field_name( 'popular_posts_number' ); ?>" value="<?php echo $instance['popular_posts_number']; ?>" size="3" />
		</p>

		<?php
	}

}
?>