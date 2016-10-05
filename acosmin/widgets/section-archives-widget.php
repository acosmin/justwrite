<?php
/* ------------------------------------------------------------------------- *
 *
 *  Archives Section/Widget
 *  ________________
 *
 *	This is used to display monthly archives by year
 *	________________
 *
/* ------------------------------------------------------------------------- */


if( ! class_exists( 'AC_Section_Archives' ) ) {
	class AC_Section_Archives extends AC_Section {
		
		protected $defaults;
		
		/*  Constructor
		/* ------------------------------------ */
		function __construct() {
			
			/* Variables */
			$this->widget_title = __( 'AC SEC: Archives' , 'justwrite' );
			$this->widget_id = 'extended-archives';
			
			/* Settings */
			$widget_ops = array( 'classname' => 'sa-archives', 'description' => 'This is used to display monthly archives by year.' );

			/* Control settings */
			$control_ops = array( 'width' => NULL, 'height' => NULL, 'id_base' => 'ac-widget-' . $this->widget_id );
			
			/* Create the widget */
			parent::__construct( 'ac-widget-' . $this->widget_id, $this->widget_title, $widget_ops, $control_ops );
			
			/* Set some widget defaults */
			$this->defaults = array (
				'title' 		=> '',
				'css_no_mt'		=> true,
				'css_no_mb'		=> true,
				'css_b_top'		=> false,
				'css_b_bot'		=> false,
				'css_p_top'		=> false,
				'css_p_bot'		=> false,
			);
			
		}
		
		
		/*  Front-end display
		/* ------------------------------------ */
		function widget( $args, $instance ) {
			// Turn $args array into variables.
			extract( $args );
			
			// $instance Defaults
			$instance_defaults = $this->defaults;
			
			// Parse $instance
			$instance = wp_parse_args( $instance, $instance_defaults );
			
			// Options output
			$section_title = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$cnmt	= ! empty( $instance['css_no_mt'] ) ? 1 : 0;
			$cnmb	= ! empty( $instance['css_no_mb'] ) ? 1 : 0;
			$cbot	= ! empty( $instance['css_b_top'] ) ? 1 : 0;
			$cbob	= ! empty( $instance['css_b_bot'] ) ? 1 : 0;
			$cpat	= ! empty( $instance['css_p_top'] ) ? 1 : 0;
			$cpab	= ! empty( $instance['css_p_bot'] ) ? 1 : 0;
			
			// Parse $instance
			$widget = wp_parse_args( $instance, $instance_defaults );
			
			// Widget styling based on options
			$css_class = array();
			if ( $cnmt ) { $css_class[] = 'n-mt'; }
			if ( $cnmb ) { $css_class[] = 'n-mb'; }
			if ( $cbot ) { $css_class[] = 'b-top'; }
			if ( $cbob ) { $css_class[] = 'b-bot'; }
			if ( $cpat ) { $css_class[] = 'p-top'; }
			if ( $cpab ) { $css_class[] = 'p-bot'; }
			$css_classes = join(' ', $css_class);

			if ( ! empty( $css_classes ) ) {
				if( strpos($args['before_widget'], 'class') === false ) {
					$args['before_widget'] = str_replace('>', 'class="'. esc_attr( $css_classes ) . '"', $args['before_widget']);
				} else {
					$args['before_widget'] = str_replace('class="', 'class="'. esc_attr( $css_classes ) . ' ', $args['before_widget']);
				}
			}

			// Output
			echo $args['before_widget']; // Before widget template

				// Section template
				?>
                <div class="sa-wrap">
                	<?php 
					// Check if a title is set
					if ( ! empty( $section_title ) ) { ?>
					<aside class="sa-column sa-title">
                    	<h2 class="section-title-2nd st-small st-bold"><?php echo esc_html( $section_title ); ?></h2>
					</aside>
					<?php } ?>

                    <?php
						global $wpdb;
						$prevYear = "";
						$currentYear = "";
						if ( $months = $wpdb->get_results( "SELECT DISTINCT DATE_FORMAT(post_date, '%b') AS month , MONTH(post_date) as numMonth, YEAR( post_date ) AS year, COUNT( id ) as post_count FROM $wpdb->posts WHERE post_status = 'publish' and post_date <= now( ) and post_type = 'post' GROUP BY month , year ORDER BY post_date DESC" ) ) :
							foreach ( $months as $month ) :
								$currentYear = $month->year;
								if ( ( $currentYear != $prevYear ) && ( $prevYear != "" ) ) { echo "</ul></aside>"; }
								if ( $currentYear != $prevYear ) : 
					?>
                    <aside class="sa-column">
                    	<h3 class="sa-year st-small st-bold"><a href="<?php echo esc_url( get_year_link( $month->year ) ); ?>"><?php echo esc_html( $month->year ); ?></a></h3>
                        <ul class="sa-months">
                    <?php endif; ?>
                    		<li><a href="<?php echo esc_url( get_month_link( $month->year, $month->numMonth ) ); ?>"><?php echo esc_html( $month->month ); ?></a></li>
					<?php 
						$prevYear = $month->year; 
						endforeach; 
					?>
                    </ul></aside>
                </div><!-- END .sa-wrap -->	
                <?php  endif;

			echo $args['after_widget']; // After widget template
			
		}
		
		
		/*  Update Widget
		/* ------------------------------------ */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			// Text fields
			$instance['title'] 		= strip_tags( $new_instance['title'] ) ;
			
			// Checkboxes
			$instance['css_no_mt']	= ! empty($new_instance['css_no_mt']) ? 1 : 0;
			$instance['css_no_mb']	= ! empty($new_instance['css_no_mb']) ? 1 : 0;
			$instance['css_b_top']	= ! empty($new_instance['css_b_top']) ? 1 : 0;
			$instance['css_b_bot']	= ! empty($new_instance['css_b_bot']) ? 1 : 0;
			$instance['css_p_top']	= ! empty($new_instance['css_p_top']) ? 1 : 0;
			$instance['css_p_bot']	= ! empty($new_instance['css_p_bot']) ? 1 : 0;
			
			// Return
			return $instance;
		}
		
		
		/*  Form
		/* ------------------------------------ */
		function form( $instance ){
			// Parse $instance
			$instance_defaults = $this->defaults;
			$instance = wp_parse_args( $instance, $instance_defaults );
			extract( $instance, EXTR_SKIP );
			
			// $instance Defaults
			$css_nmt = isset( $instance['css_no_mt'] ) ? (bool) $instance['css_no_mt'] : false;
			$css_nmb = isset( $instance['css_no_mb'] ) ? (bool) $instance['css_no_mb'] : false;
			$css_bot = isset( $instance['css_b_top'] ) ? (bool) $instance['css_b_top'] : false;
			$css_bob = isset( $instance['css_b_bot'] ) ? (bool) $instance['css_b_bot'] : false;
			$css_pat = isset( $instance['css_p_top'] ) ? (bool) $instance['css_p_top'] : false;
			$css_pab = isset( $instance['css_p_bot'] ) ? (bool) $instance['css_p_bot'] : false;
			
			?>
                <p>
                    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Section title:', 'justwrite' ); ?></label>
                    <input class="widefat ac-builder-widget-title" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>"/>
                </p>
                <p>
                	<b><?php _e( 'Styling options:', 'justwrite' ); ?></b><br />
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('css_no_mt'); ?>" name="<?php echo $this->get_field_name('css_no_mt'); ?>"<?php checked( $css_nmt ); ?> />
                    <label for="<?php echo $this->get_field_id('css_no_mt'); ?>"><?php _e( 'Remove top margin', 'justwrite' ); ?></label><br />

                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('css_no_mb'); ?>" name="<?php echo $this->get_field_name('css_no_mb'); ?>"<?php checked( $css_nmb ); ?> />
                    <label for="<?php echo $this->get_field_id('css_no_mb'); ?>"><?php _e( 'Remove bottom margin', 'justwrite' ); ?></label><br />
                    
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('css_b_top'); ?>" name="<?php echo $this->get_field_name('css_b_top'); ?>"<?php checked( $css_bot ); ?> />
                    <label for="<?php echo $this->get_field_id('css_b_top'); ?>"><?php _e( 'Add border top', 'justwrite' ); ?></label><br />
                    
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('css_b_bot'); ?>" name="<?php echo $this->get_field_name('css_b_bot'); ?>"<?php checked( $css_bob ); ?> />
                    <label for="<?php echo $this->get_field_id('css_b_bot'); ?>"><?php _e( 'Add border bottom', 'justwrite' ); ?></label><br />
                    
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('css_p_top'); ?>" name="<?php echo $this->get_field_name('css_p_top'); ?>"<?php checked( $css_pat ); ?> />
                    <label for="<?php echo $this->get_field_id('css_p_top'); ?>"><?php _e( 'Add padding top', 'justwrite' ); ?></label><br />
                    
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('css_p_bot'); ?>" name="<?php echo $this->get_field_name('css_p_bot'); ?>"<?php checked( $css_pab ); ?> />
                    <label for="<?php echo $this->get_field_id('css_p_bot'); ?>"><?php _e( 'Add padding bottom', 'justwrite' ); ?></label>
				</p>
            <?php
		}
		
	} // AC_Section_Archives .END
	
	// Register this widget
	register_widget( 'AC_Section_Archives' );
}
?>