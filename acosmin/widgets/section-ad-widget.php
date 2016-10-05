<?php
/* ------------------------------------------------------------------------- *
 *
 *  Advertising Section/Widget
 *  ________________
 *
 *	This is used to display an ad
 *	________________
 *
/* ------------------------------------------------------------------------- */


if( ! class_exists( 'AC_Section_Advertising' ) ) {
	class AC_Section_Advertising extends AC_Section {
		
		protected $defaults;
		
		/*  Constructor
		/* ------------------------------------ */
		function __construct() {
			
			/* Variables */
			$this->widget_title = __( 'AC SEC: Advertising' , 'justwrite' );
			$this->widget_id = 'mainad';
			
			/* Settings */
			$widget_ops = array( 'classname' => 'sa-mainad', 'description' => 'This is used to display an ad, any size, centered' );

			/* Control settings */
			$control_ops = array( 'width' => NULL, 'height' => NULL, 'id_base' => 'ac-widget-' . $this->widget_id );
			
			/* Create the widget */
			parent::__construct( 'ac-widget-' . $this->widget_id, $this->widget_title, $widget_ops, $control_ops );
			
			/* Set some widget defaults */
			$this->defaults = array (
				'ad_code'		=> '',
				'css_no_mt'		=> true,
				'css_no_mb'		=> true,
				'css_no_bg'		=> true,
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
			$ad_code = ! empty( $instance['ad_code'] ) ? $instance['ad_code'] : '';
			$cnmt	= ! empty( $instance['css_no_mt'] ) ? 1 : 0;
			$cnmb	= ! empty( $instance['css_no_mb'] ) ? 1 : 0;
			$cnbg	= ! empty( $instance['css_no_bg'] ) ? 1 : 0;
			$cbot	= ! empty( $instance['css_b_top'] ) ? 1 : 0;
			$cbob	= ! empty( $instance['css_b_bot'] ) ? 1 : 0;
			$cpat	= ! empty( $instance['css_p_top'] ) ? 1 : 0;
			$cpab	= ! empty( $instance['css_p_bot'] ) ? 1 : 0;

			// Widget styling based on options
			$css_class = array();
			if ( $cnmt ) { $css_class[] = 'n-mt'; }
			if ( $cnmb ) { $css_class[] = 'n-mb'; }
			if ( $cnbg ) { $css_class[] = 'n-bg'; }
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
			
			echo $args['before_widget']; // Before widget template
			?>
				<div class="mainad-container">
                	<?php 
						// Output AD code using wp_kses to allow some tags
						echo ac_sanitize_ads( $ad_code ); 
					?> 
                </div>
			<?php
			echo $args['after_widget']; // After widget template

		}
		
		
		/*  Update Widget
		/* ------------------------------------ */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			// Ad code
			$instance['ad_code'] 	= ac_sanitize_ads( $new_instance['ad_code'] );
			
			// Checkboxes
			$instance['css_no_mt']	= ! empty($new_instance['css_no_mt']) ? 1 : 0;
			$instance['css_no_mb']	= ! empty($new_instance['css_no_mb']) ? 1 : 0;
			$instance['css_no_bg']	= ! empty($new_instance['css_no_bg']) ? 1 : 0;
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
			$css_nbg = isset( $instance['css_no_bg'] ) ? (bool) $instance['css_no_bg'] : false;
			$css_bot = isset( $instance['css_b_top'] ) ? (bool) $instance['css_b_top'] : false;
			$css_bob = isset( $instance['css_b_bot'] ) ? (bool) $instance['css_b_bot'] : false;
			$css_pat = isset( $instance['css_p_top'] ) ? (bool) $instance['css_p_top'] : false;
			$css_pab = isset( $instance['css_p_bot'] ) ? (bool) $instance['css_p_bot'] : false;

			?>
            	<p>
                	<label for="<?php echo $this->get_field_id( 'ad_code' ); ?>"><?php _e( 'Ad code:', 'justwrite' ); ?></label>
					<textarea class="widefat" rows="8" cols="20" id="<?php echo $this->get_field_id('ad_code'); ?>" name="<?php echo $this->get_field_name('ad_code'); ?>"><?php echo ac_sanitize_ads( $ad_code ); ?></textarea></p>
                <p>
                	<b><?php _e( 'Styling options:', 'justwrite' ); ?></b><br />
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('css_no_mt'); ?>" name="<?php echo $this->get_field_name('css_no_mt'); ?>"<?php checked( $css_nmt ); ?> />
                    <label for="<?php echo $this->get_field_id('css_no_mt'); ?>"><?php _e( 'Remove top margin', 'justwrite' ); ?></label><br />

                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('css_no_mb'); ?>" name="<?php echo $this->get_field_name('css_no_mb'); ?>"<?php checked( $css_nmb ); ?> />
                    <label for="<?php echo $this->get_field_id('css_no_mb'); ?>"><?php _e( 'Remove bottom margin', 'justwrite' ); ?></label><br />
                    
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('css_no_bg'); ?>" name="<?php echo $this->get_field_name('css_no_bg'); ?>"<?php checked( $css_nbg ); ?> />
                    <label for="<?php echo $this->get_field_id('css_no_bg'); ?>"><?php _e( 'Remove background-color', 'justwrite' ); ?></label><br />
                    
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
		
	} // AC_Section_Advertising .END
	
	// Register this widget
	register_widget( 'AC_Section_Advertising' );
}
?>