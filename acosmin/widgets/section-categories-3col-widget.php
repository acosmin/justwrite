<?php
/* ------------------------------------------------------------------------- *
 *
 *  Categories (3 Columns) Section/Widget
 *  ________________
 *
 *	Adds a row displaying posts from categories (three columns)
 *	________________
 *
/* ------------------------------------------------------------------------- */


if( ! class_exists( 'AC_Section_Cat_3_Columns' ) ) {
	class AC_Section_Cat_3_Columns extends AC_Section {
		
		protected $defaults;
		
		/*  Constructor
		/* ------------------------------------ */
		function __construct() {
			
			/* Variables */
			$this->widget_title = __( 'AC SEC: Categories 3 Columns' , 'justwrite' );
			$this->widget_id = 'three-columns-categories';
			
			/* Settings */
			$widget_ops = array( 'classname' => 'sc-medium', 'description' => 'Adds a row displaying posts from categories (three columns)' );

			/* Control settings */
			$control_ops = array( 'width' => NULL, 'height' => NULL, 'id_base' => 'ac-widget-' . $this->widget_id );
			
			/* Create the widget */
			parent::__construct( 'ac-widget-' . $this->widget_id, $this->widget_title, $widget_ops, $control_ops );
			
			/* Set some widget defaults */
			$this->defaults = array (
				'title'			=> '',
				'category_1'	=> '',
				'category_2'	=> '',
				'category_3'	=> '',
				'offset'		=> 0,
				'show_more'		=> true,
				'show_rss'		=> true,
				'show_date'		=> true,
				'show_coms'		=> true,
				'posts_nr'		=> 3,
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
			$section_title 		= ! empty( $instance['title'] ) ? $instance['title'] : ''; set_query_var( 'section_title', strip_tags( $section_title ) );
			$section_postsnr	= ! empty( $instance['posts_nr'] ) ? $instance['posts_nr'] : 3; set_query_var( 'section_postsnr', absint( $section_postsnr ) );
			$section_category1	= ! empty( $instance['category_1'] ) ? $instance['category_1'] : ''; set_query_var( 'section_category1', absint( $section_category1 ) );
			$section_category2	= ! empty( $instance['category_2'] ) ? $instance['category_2'] : ''; set_query_var( 'section_category2', absint( $section_category2 ) );
			$section_category3	= ! empty( $instance['category_3'] ) ? $instance['category_3'] : ''; set_query_var( 'section_category3', absint( $section_category3 ) );
			$section_offset		= ! empty( $instance['offset'] ) ? $instance['offset'] : 0; set_query_var( 'section_offset', absint( $section_offset ) );
			$scm	= ! empty( $instance['show_coms'] ) ? 1 : 0; set_query_var( 'scm', absint( $scm ) );
			$smo	= ! empty( $instance['show_more'] ) ? 1 : 0; set_query_var( 'smo', absint( $smo ) );
			$sdt	= ! empty( $instance['show_date'] ) ? 1 : 0; set_query_var( 'sdt', absint( $sdt ) );
			$srs	= ! empty( $instance['show_rss'] ) ? 1 : 0; set_query_var( 'srs', absint( $srs ) );
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
			if ( $cpat ) { $css_class[] = 'p-top2'; }
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
				get_template_part( 'section-templates/section', 'categories-3col' ); // Get section template

			echo $args['after_widget']; // After widget template
			
		}
		
		
		/*  Update Widget
		/* ------------------------------------ */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			// Text/Select
			$instance['title'] 		= strip_tags( $new_instance['title'] );
			$instance['category_1'] = absint( $new_instance['category_1'] );
			$instance['category_2'] = absint( $new_instance['category_2'] );
			$instance['category_3'] = absint( $new_instance['category_3'] );
			$instance['posts_nr'] 	= absint( $new_instance['posts_nr'] );
			$instance['offset'] 	= absint( $new_instance['offset'] );
			
			// Checkboxes
			$instance['show_more'] 	= ! empty($new_instance['show_more']) ? 1 : 0;
			$instance['show_rss'] 	= ! empty($new_instance['show_rss']) ? 1 : 0;
			$instance['show_date'] 	= ! empty($new_instance['show_date']) ? 1 : 0;
			$instance['show_coms'] 	= ! empty($new_instance['show_coms']) ? 1 : 0;
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
			$show_more = isset( $instance['show_more'] ) ? (bool) $instance['show_more'] : false;
			$show_rss = isset( $instance['show_rss'] ) ? (bool) $instance['show_rss'] : false;
			$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
			$show_coms = isset( $instance['show_coms'] ) ? (bool) $instance['show_coms'] : false;
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
                <?php
					$protitle = esc_html__( 'Pro Features', 'justwrite' );
					$getpro = esc_html__( 'Upgrade Now', 'justwrite' );
					$asdf = esc_html__( 'to enable them + many more', 'justwrite' );
					$lines 		= array(
						esc_html__( 'Some options are disabled:', 'justwrite' ),
						esc_html__( '- Offset number;', 'justwrite' ),
					);
					parent::ac_promo_info( $lines, $protitle, $getpro, $asdf );
				?>
                <p>
                    <label for="<?php echo $this->get_field_id( 'category_1' ); ?>"><?php esc_html_e( '1st column category', 'justwrite' ); ?></label>
                    <?php

					wp_dropdown_categories( array(
		
						'orderby'    => 'title',
						'hide_empty' => true,
						'name'       => $this->get_field_name( 'category_1' ),
						'id'         => $this->get_field_id( 'category_1' ),
						'class'      => 'widefat',
						'selected'   => $instance['category_1'],
		
					) );
		
					?>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id( 'category_2' ); ?>"><?php esc_html_e( '2nd column category', 'justwrite' ); ?></label>
                    <?php

					wp_dropdown_categories( array(
		
						'orderby'    => 'title',
						'hide_empty' => true,
						'name'       => $this->get_field_name( 'category_2' ),
						'id'         => $this->get_field_id( 'category_2' ),
						'class'      => 'widefat',
						'selected'   => $instance['category_2'],
		
					) );
		
					?>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id( 'category_3' ); ?>"><?php esc_html_e( '3rd column category', 'justwrite' ); ?></label>
                    <?php

					wp_dropdown_categories( array(
		
						'orderby'    => 'title',
						'hide_empty' => true,
						'name'       => $this->get_field_name( 'category_3' ),
						'id'         => $this->get_field_id( 'category_3' ),
						'class'      => 'widefat',
						'selected'   => $instance['category_3'],
		
					) );
		
					?>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id( 'posts_nr' ); ?>"><?php esc_html_e( 'Number of posts (3 or more):', 'justwrite' ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'posts_nr' ); ?>" name="<?php echo $this->get_field_name( 'posts_nr' ); ?>" type="text" value="<?php echo esc_attr( $instance['posts_nr'] ); ?>"/>
                </p>
				<p>
                    <label for="<?php echo $this->get_field_id( 'offset' ); ?>"><?php esc_html_e( 'Offset (number of posts to "displace" or pass over):', 'justwrite' ); ?></label>
                    <input disabled class="widefat" id="<?php echo $this->get_field_id( 'offset' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>" type="text" value="<?php echo esc_attr( $instance['offset'] ); ?>"/>
                </p>
                <p>
                	<b><?php _e( 'Display options:', 'justwrite' ); ?></b><br />
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_more'); ?>" name="<?php echo $this->get_field_name('show_more'); ?>"<?php checked( $show_more ); ?> />
                    <label for="<?php echo $this->get_field_id('show_more'); ?>"><?php _e( 'Show "More Articles" button', 'justwrite' ); ?></label><br />
                    
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_rss'); ?>" name="<?php echo $this->get_field_name('show_rss'); ?>"<?php checked( $show_rss ); ?> />
                    <label for="<?php echo $this->get_field_id('show_rss'); ?>"><?php _e( 'Show "RSS" button', 'justwrite' ); ?></label><br />
                    
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>"<?php checked( $show_date ); ?> />
                    <label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e( 'Show date', 'justwrite' ); ?></label><br />
                    
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_coms'); ?>" name="<?php echo $this->get_field_name('show_coms'); ?>"<?php checked( $show_coms ); ?> />
                    <label for="<?php echo $this->get_field_id('show_coms'); ?>"><?php _e( 'Show comments number', 'justwrite' ); ?></label>
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
		
	} // AC_Section_Cat_3_Columns .END
	
	// Register this widget
	register_widget( 'AC_Section_Cat_3_Columns' );
}
?>