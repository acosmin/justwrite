<?php
/* ------------------------------------------------------------------------- *
 *
 *  Slider Section/Widget
 *  ________________
 *
 *	This is used to display your featured posts in a jQuery slider
 *	________________
 *
/* ------------------------------------------------------------------------- */


if( ! class_exists( 'AC_Section_Slider' ) ) {
	class AC_Section_Slider extends AC_Section {
		
		protected $defaults;
		
		/*  Constructor
		/* ------------------------------------ */
		function __construct() {
			
			/* Variables */
			$this->widget_title = __( 'AC SEC: Slider #1' , 'justwrite' );
			$this->widget_id = 'featured-posts-slider';
			
			/* Settings */
			$widget_ops = array( 'classname' => 'ss-slider', 'description' => 'This widget is used to display your featured posts in a jQuery slider.' );

			/* Control settings */
			$control_ops = array( 'width' => NULL, 'height' => NULL, 'id_base' => 'ac-widget-' . $this->widget_id );
			
			/* Create the widget */
			parent::__construct( 'ac-widget-' . $this->widget_id, $this->widget_title, $widget_ops, $control_ops );
			
			/* Set some widget defaults */
			$this->defaults = array (
				'title' 		=> '',
				'typeselect' 	=> 'featured',
				'category'		=> '',
				'posts_nr'		=> 3,
				'offset'		=> 0,
				'autoplay'		=> false,
				'delay'			=> '5000',
				'show_date'		=> true,
				'show_cat'		=> true,
				'show_com'		=> true,
				'css_no_mt'		=> true,
				'css_no_mb'		=> true,
				'css_b_top'		=> false,
				'css_b_bot'		=> false,
				'css_p_bot'		=> false,
				'css_p_top'		=> false,
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
			$section_title 		= ! empty( $instance['title'] ) ? $instance['title'] : ''; set_query_var( 'section_title', strip_tags( $section_title ) );
			$section_type		= ! empty( $instance['typeselect'] ) ? $instance['typeselect'] : ''; set_query_var( 'section_type', esc_html( $section_type ) );
			$section_category	= ! empty( $instance['category'] ) ? $instance['category'] : ''; set_query_var( 'section_category', absint( $section_category ) );
			$section_postsnr	= ! empty( $instance['posts_nr'] ) ? $instance['posts_nr'] : 3; set_query_var( 'section_postsnr', absint( $section_postsnr ) );
			$section_offset		= ! empty( $instance['offset'] ) ? $instance['offset'] : 0; set_query_var( 'section_offset', absint( $section_offset ) );
			$section_delay		= ! empty( $instance['delay'] ) ? $instance['delay'] : 5000; set_query_var( 'section_delay', absint( $section_delay ) );
			$ap		= ! empty( $instance['autoplay'] ) ? 'true' : 'false'; set_query_var( 'ap', esc_html( $ap ) );
			$sco	= ! empty( $instance['show_com'] ) ? 1 : 0; set_query_var( 'sco', absint( $sco ) );
			$sca	= ! empty( $instance['show_cat'] ) ? 1 : 0; set_query_var( 'sca', absint( $sca ) );
			$sda	= ! empty( $instance['show_date'] ) ? 1 : 0; set_query_var( 'sda', absint( $sda ) );
			$cnmt	= ! empty( $instance['css_no_mt'] ) ? 1 : 0;
			$cnmb	= ! empty( $instance['css_no_mb'] ) ? 1 : 0;
			$cbot	= ! empty( $instance['css_b_top'] ) ? 1 : 0;
			$cbob	= ! empty( $instance['css_b_bot'] ) ? 1 : 0;
			$cpat	= ! empty( $instance['css_p_top'] ) ? 1 : 0;
			$cpab	= ! empty( $instance['css_p_bot'] ) ? 1 : 0;

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
			
			// Gets widge's unique ID number and makes it available for get_template_part
			$wnum = $this->number;
			set_query_var('wnum', absint( $wnum ) );
			
			// Check if we have 3 or more posts selected
			if( $instance['posts_nr'] >= 3 ) :
			
			// Output
			echo $args['before_widget']; // Before widget template

				// Section template
				get_template_part( 'section-templates/section', 'slider' ); // Get section template

			echo $args['after_widget']; // After widget template
			
			endif; // End posts_nr >= 3;
			
		}
		
		
		/*  Update Widget
		/* ------------------------------------ */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			// Text fields
			$instance['title'] 		= strip_tags( $new_instance['title'] );
			$instance['category'] 	= absint( $new_instance['category'] );
			$instance['posts_nr'] 	= absint( $new_instance['posts_nr'] );
			$instance['offset'] 	= absint( $new_instance['offset'] );
			$instance['delay'] 		= absint( $new_instance['delay'] );
			
			// Select type
			if ( in_array( $new_instance['typeselect'], array( 'featured', 'category' ) ) ) {
				$instance['typeselect'] = $new_instance['typeselect'];
			} else {
				$instance['typeselect'] = 'featured';
			}
			
			// Checkboxes
			$instance['autoplay'] 	= ! empty($new_instance['autoplay']) ? 1 : 0;
			$instance['show_date'] 	= ! empty($new_instance['show_date']) ? 1 : 0;
			$instance['show_cat'] 	= ! empty($new_instance['show_cat']) ? 1 : 0;
			$instance['show_com'] 	= ! empty($new_instance['show_com']) ? 1 : 0;
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
			$autoplay = isset( $instance['autoplay'] ) ? (bool) $instance['autoplay'] : false;
			$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
			$show_cat = isset( $instance['show_cat'] ) ? (bool) $instance['show_cat'] : false;
			$show_com = isset( $instance['show_com'] ) ? (bool) $instance['show_com'] : false;
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
                <?php
					$protitle = esc_html__( 'Pro Features', 'justwrite' );
					$getpro = esc_html__( 'Upgrade Now', 'justwrite' );
					$asdf = esc_html__( 'to enable them + many more', 'justwrite' );
					$lines 		= array(
						esc_html__( 'Some options are disabled:', 'justwrite' ),
						esc_html__( '- Display posts from a category;', 'justwrite' ),
						esc_html__( '- Autoplay delay timer;', 'justwrite' ),
						esc_html__( '- Offset number;', 'justwrite' ),
					);
					parent::ac_promo_info( $lines, $protitle, $getpro, $asdf );
				?>
                <p>
                    <label for="<?php echo $this->get_field_id('typeselect'); ?>"><?php _e( 'Display:', 'justwrite' ); ?></label>
                    <select name="<?php echo $this->get_field_name('typeselect'); ?>" id="<?php echo $this->get_field_id('typeselect'); ?>" class="widefat ac-select-type">
                        <option value="featured"<?php selected( $instance['typeselect'], 'featured' ); ?>><?php _e( 'Featured posts', 'justwrite' ); ?></option>
                        <option	disabled value="category"<?php selected( $instance['typeselect'], 'category' ); ?>><?php _e( 'Category posts', 'justwrite' ); ?></option>
                    </select>
                </p>
                <p class="ac-display-category-field" style="display: none;">
                    <label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Select a category:', 'justwrite' ); ?></label>
                    <?php

					wp_dropdown_categories( array(
		
						'orderby'    => 'title',
						'hide_empty' => false,
						'name'       => $this->get_field_name( 'category' ),
						'id'         => $this->get_field_id( 'category' ),
						'class'      => 'widefat',
						'selected'   => $instance['category'],
		
					) );
		
					?>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id( 'posts_nr' ); ?>"><?php esc_html_e( 'Number of posts (more than 3):', 'justwrite' ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'posts_nr' ); ?>" name="<?php echo $this->get_field_name( 'posts_nr' ); ?>" type="text" value="<?php echo esc_attr( $instance['posts_nr'] ); ?>"/>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id( 'offset' ); ?>"><?php esc_html_e( 'Offset (number of posts to "displace" or pass over):', 'justwrite' ); ?></label>
                    <input class="widefat" disabled id="<?php echo $this->get_field_id( 'offset' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>" type="text" value="<?php echo esc_attr( $instance['offset'] ); ?>"/>
                </p>
                <p>
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>"<?php checked( $autoplay ); ?> />
                    <label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php _e( 'Enable autoplay', 'justwrite' ); ?></label>
				</p>
                <p>
                    <label for="<?php echo $this->get_field_id( 'delay' ); ?>"><?php esc_html_e( 'Autoplay delay (milliseconds):', 'justwrite' ); ?></label>
                    <input disabled class="widefat" id="<?php echo $this->get_field_id( 'delay' ); ?>" name="<?php echo $this->get_field_name( 'delay' ); ?>" type="text" value="5000"/>
                </p>
                <p>
                	<b><?php _e( 'Display options:', 'justwrite' ); ?></b><br />
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>"<?php checked( $show_date ); ?> />
                    <label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e( 'Show date', 'justwrite' ); ?></label><br />
                    
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_cat'); ?>" name="<?php echo $this->get_field_name('show_cat'); ?>"<?php checked( $show_cat ); ?> />
                    <label for="<?php echo $this->get_field_id('show_cat'); ?>"><?php _e( 'Show category', 'justwrite' ); ?></label><br />
                    
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_com'); ?>" name="<?php echo $this->get_field_name('show_com'); ?>"<?php checked( $show_com ); ?> />
                    <label for="<?php echo $this->get_field_id('show_com'); ?>"><?php _e( 'Show # comments', 'justwrite' ); ?></label>
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
		
	} // AC_Section_Slider .END
	
	// Register this widget
	register_widget( 'AC_Section_Slider' );
}
?>