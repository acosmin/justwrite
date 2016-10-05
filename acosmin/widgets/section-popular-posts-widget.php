<?php
/* ------------------------------------------------------------------------- *
 *
 *  Popular posts Section/Widget
 *  ________________
 *
 *	This widget is used to display popular posts in a podium style ranking
 *	________________
 *
/* ------------------------------------------------------------------------- */


if( ! class_exists( 'AC_Section_Popular_Posts' ) ) {
	class AC_Section_Popular_Posts extends AC_Section {
		
		protected $defaults;
		
		/*  Constructor
		/* ------------------------------------ */
		function __construct() {
			
			/* Variables */
			$this->widget_title = __( 'AC SEC: Popular Posts' , 'justwrite' );
			$this->widget_id = 'popular-posts-big';
			
			/* Settings */
			$widget_ops = array( 'classname' => 'sp-popular', 'description' => 'This widget is used to display popular posts in a podium style ranking.' );

			/* Control settings */
			$control_ops = array( 'width' => NULL, 'height' => NULL, 'id_base' => 'ac-widget-' . $this->widget_id );
			
			/* Create the widget */
			parent::__construct( 'ac-widget-' . $this->widget_id, $this->widget_title, $widget_ops, $control_ops );
			
			/* Set some widget defaults */
			$this->defaults = array (
				'title' 		=> '',
				'show_pos'		=> true,
				'show_date'		=> true,
				'show_cat'		=> false,
				'show_com'		=> true,
				'css_no_mt'		=> true,
				'css_no_mb'		=> true,
				'css_b_top'		=> false,
				'css_b_bot'		=> false,
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
			$section_title = ! empty( $instance['title'] ) ? $instance['title'] : ''; set_query_var( 'section_title', strip_tags( $section_title ) );
			$spo	= ! empty( $instance['show_pos'] ) ? 1 : 0; set_query_var( 'spo', absint( $spo ) );
			$sco	= ! empty( $instance['show_com'] ) ? 1 : 0; set_query_var( 'sco', absint( $sco ) );
			$sca	= ! empty( $instance['show_cat'] ) ? 1 : 0; set_query_var( 'sca', absint( $sca ) );
			$sda	= ! empty( $instance['show_date'] ) ? 1 : 0; set_query_var( 'sda', absint( $sda ) );
			$cnmt	= ! empty( $instance['css_no_mt'] ) ? 1 : 0;
			$cnmb	= ! empty( $instance['css_no_mb'] ) ? 1 : 0;
			$cbot	= ! empty( $instance['css_b_top'] ) ? 1 : 0;
			$cbob	= ! empty( $instance['css_b_bot'] ) ? 1 : 0;
			$cpat	= ! empty( $instance['css_p_top'] ) ? 1 : 0;
			
			// Widget styling based on options
			$css_class = array();
			if ( $cnmt ) { $css_class[] = 'n-mt'; }
			if ( $cnmb ) { $css_class[] = 'n-mb'; }
			if ( $cbot ) { $css_class[] = 'b-top'; }
			if ( $cbob ) { $css_class[] = 'b-bot'; }
			if ( $cpat ) { $css_class[] = 'p-top'; }
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
				get_template_part( 'section-templates/section', 'popular-posts' ); // Get section template

			echo $args['after_widget']; // After widget template
			
		}
		
		
		/*  Update Widget
		/* ------------------------------------ */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			// Text fields
			$instance['title'] 		= strip_tags( $new_instance['title'] );
			
			// Checkboxes
			$instance['show_pos'] 	= ! empty($new_instance['show_pos']) ? 1 : 0;
			$instance['show_date'] 	= ! empty($new_instance['show_date']) ? 1 : 0;
			$instance['show_cat'] 	= ! empty($new_instance['show_cat']) ? 1 : 0;
			$instance['show_com'] 	= ! empty($new_instance['show_com']) ? 1 : 0;
			$instance['css_no_mt']	= ! empty($new_instance['css_no_mt']) ? 1 : 0;
			$instance['css_no_mb']	= ! empty($new_instance['css_no_mb']) ? 1 : 0;
			$instance['css_b_top']	= ! empty($new_instance['css_b_top']) ? 1 : 0;
			$instance['css_b_bot']	= ! empty($new_instance['css_b_bot']) ? 1 : 0;
			$instance['css_p_top']	= ! empty($new_instance['css_p_top']) ? 1 : 0;
			
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
			$show_pos = isset( $instance['show_pos'] ) ? (bool) $instance['show_pos'] : false;
			$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
			$show_cat = isset( $instance['show_cat'] ) ? (bool) $instance['show_cat'] : false;
			$show_com = isset( $instance['show_com'] ) ? (bool) $instance['show_com'] : false;
			$css_nmt = isset( $instance['css_no_mt'] ) ? (bool) $instance['css_no_mt'] : false;
			$css_nmb = isset( $instance['css_no_mb'] ) ? (bool) $instance['css_no_mb'] : false;
			$css_bot = isset( $instance['css_b_top'] ) ? (bool) $instance['css_b_top'] : false;
			$css_bob = isset( $instance['css_b_bot'] ) ? (bool) $instance['css_b_bot'] : false;
			$css_pat = isset( $instance['css_p_top'] ) ? (bool) $instance['css_p_top'] : false;

			?>
                <p>
                    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Section title:', 'justwrite' ); ?></label>
                    <input class="widefat ac-builder-widget-title" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>"/>
                </p>
                <p>
                	<b><?php _e( 'Display options:', 'justwrite' ); ?></b><br />
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_pos'); ?>" name="<?php echo $this->get_field_name('show_pos'); ?>"<?php checked( $show_pos ); ?> />
                    <label for="<?php echo $this->get_field_id('show_pos'); ?>"><?php _e( 'Show # position', 'justwrite' ); ?></label><br />
                    
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
                    <label for="<?php echo $this->get_field_id('css_p_top'); ?>"><?php _e( 'Add padding top', 'justwrite' ); ?></label>
				</p>
            <?php
		}
		
	} // AC_Section_Popular_Posts .END
	
	// Register this widget
	register_widget( 'AC_Section_Popular_Posts' );
}
?>