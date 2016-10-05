<?php
/* ------------------------------------------------------------------------- *
 *
 *  Social Profiles Section/Widget
 *  ________________
 *
 *	This is used to display links to your social profiles
 *	________________
 *
/* ------------------------------------------------------------------------- */


if( ! class_exists( 'AC_Section_Social_Profiles' ) ) {
	class AC_Section_Social_Profiles extends AC_Section {
		
		protected $defaults;
		
		/*  Constructor
		/* ------------------------------------ */
		function __construct() {
			
			/* Variables */
			$this->widget_title = __( 'AC SEC: Social Profiles' , 'justwrite' );
			$this->widget_id = 'social-profiles';
			
			/* Settings */
			$widget_ops = array( 'classname' => 'sp-social', 'description' => 'This is used to display links to your social profiles.' );

			/* Control settings */
			$control_ops = array( 'width' => NULL, 'height' => NULL, 'id_base' => 'ac-widget-' . $this->widget_id );
			
			/* Create the widget */
			parent::__construct( 'ac-widget-' . $this->widget_id, $this->widget_title, $widget_ops, $control_ops );
			
			/* Set some widget defaults */
			$this->defaults = array (
				'title' 			=> '',
				'twitter'			=> '',
				'twitter_anc'		=> '',
				'facebook'			=> '',
				'facebook_anc'		=> '',
				'google-plus'		=> '',
				'google-plus_anc'	=> '',
				'rss'				=> '',
				'rss_anc'			=> '',
				'youtube'			=> '',
				'youtube_anc'		=> '',
				'instagram'			=> '',
				'instagram_anc'		=> '',
				'flickr'			=> '',
				'flickr_anc'		=> '',
				'tumblr'			=> '',
				'tumblr_anc'		=> '',
				'vk'				=> '',
				'vk_anc'			=> '',
				'pinterest'			=> '',
				'pinterest_anc'		=> '',
				'linkedin'			=> '',
				'linkedin_anc'		=> '',
				'dribbble'			=> '',
				'dribbble_anc'		=> '',
				'github'			=> '',
				'github_anc'		=> '',
				'css_no_mt'			=> true,
				'css_no_mb'			=> true,
				'css_b_top'			=> false,
				'css_b_bot'			=> false,
				'css_p_top'			=> false,
				'css_p_bot'			=> false,
			);
			
			/* Profiles */
			$this->profiles = array (
				'twitter' => array(
					'label'   	=> __( 'Twitter URI', 'justwrite' ),
					'anchor'	=> 'twitter_anc',
				),
				'facebook' => array(
					'label'   	=> __( 'Facebook URI', 'justwrite' ),
					'anchor'	=> 'facebook_anc',
				),
				'google-plus' => array(
					'label'   	=> __( 'Google Plus URI', 'justwrite' ),
					'anchor'	=> 'google-plus_anc',
				),
				'rss' => array(
					'label'   	=> __( 'RSS URI', 'justwrite' ),
					'anchor'	=> 'rss_anc',
				),
				'youtube' => array(
					'label'   	=> __( 'Youtube URI', 'justwrite' ),
					'anchor'	=> 'youtube_anc',
				),
				'instagram' => array(
					'label'   	=> __( 'Instagram URI', 'justwrite' ),
					'anchor'	=> 'instagram_anc',
				),
				'flickr' => array(
					'label'   	=> __( 'Flickr URI', 'justwrite' ),
					'anchor'	=> 'flickr_anc',
				),
				'tumblr' => array(
					'label'   	=> __( 'Tumblr URI', 'justwrite' ),
					'anchor'	=> 'tumblr_anc',
				),
				'vk' => array(
					'label'   	=> __( 'VK URI', 'justwrite' ),
					'anchor'	=> 'vk_anc',
				),
				'pinterest' => array(
					'label'   	=> __( 'Pinterest URI', 'justwrite' ),
					'anchor'	=> 'pinterest_anc',
				),
				'linkedin' => array(
					'label'   	=> __( 'LinkedIn URI', 'justwrite' ),
					'anchor'	=> 'linkedin_anc',
				),
				'dribbble' => array(
					'label'   	=> __( 'Dribbble URI', 'justwrite' ),
					'anchor'	=> 'dribbble_anc',
				),
				'github' => array(
					'label'   	=> __( 'GitHub URI', 'justwrite' ),
					'anchor'	=> 'github_anc',
				),
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
			$instance = wp_parse_args( (array) $instance, $instance_defaults );
			
			// Options output
			$section_title = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$cnmt	= ! empty( $instance['css_no_mt'] ) ? '1' : '0';
			$cnmb	= ! empty( $instance['css_no_mb'] ) ? '1' : '0';
			$cbot	= ! empty( $instance['css_b_top'] ) ? '1' : '0';
			$cbob	= ! empty( $instance['css_b_bot'] ) ? '1' : '0';
			$cpat	= ! empty( $instance['css_p_top'] ) ? '1' : '0';
			$cpab	= ! empty( $instance['css_p_bot'] ) ? '1' : '0';

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
			
			$profiles = (array) $this->profiles;

			// Output
			echo $args['before_widget']; // Before widget template

				// Check if a title is set
				if ( ! empty( $section_title ) ) { ?>
                <header class="twelvecol sh-large-smaller">
                    <h2 class="section-title-2nd st-small st-bold"><?php echo esc_html( $section_title ); ?></h2>	
                </header><!-- END .section-heading -->
                <?php } ?>
                
                <ul class="sp-social-list clearfix">
                	<?php
					foreach ( $profiles as $profile => $data ) :
						$anc = $data['anchor'];
						if( ! empty( $instance[$profile] ) && ! empty( $instance[$anc] ) ) :
					?>
                    <li><a href="<?php echo esc_url( $instance[$profile] ) ?>" class="social-btn <?php echo esc_attr( $profile ) ?>"><?php echo esc_html( $instance[$anc] ) . ' ' . ac_icon( $profile ); ?> </a></li>
                    <?php else : continue; endif; endforeach; ?>
                </ul>
                <?php

			echo $args['after_widget']; // After widget template
			
		}
		
		
		/*  Update Widget
		/* ------------------------------------ */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			// Text fields
			$instance['title'] = strip_tags( $new_instance['title'] );
			
			foreach ( (array) $this->profiles as $profile => $data ) {
				$anc 					= strip_tags( $data['anchor'] );
				$instance[$profile] 	= esc_url_raw( $new_instance[$profile] );
				$instance[$anc] 		= strip_tags( $new_instance[$anc] );
			}
			
			// Checkboxes
			$instance['css_no_mt']	= !empty($new_instance['css_no_mt']) ? 1 : 0;
			$instance['css_no_mb']	= !empty($new_instance['css_no_mb']) ? 1 : 0;
			$instance['css_b_top']	= !empty($new_instance['css_b_top']) ? 1 : 0;
			$instance['css_b_bot']	= !empty($new_instance['css_b_bot']) ? 1 : 0;
			$instance['css_p_top']	= !empty($new_instance['css_p_top']) ? 1 : 0;
			$instance['css_p_bot']	= !empty($new_instance['css_p_bot']) ? 1 : 0;
			
			// Return
			return $instance;
		}
		
		
		/*  Form
		/* ------------------------------------ */
		function form( $instance ){
			// Parse $instance
			$instance = wp_parse_args( (array) $instance, $this->defaults );
			extract( $instance, EXTR_SKIP );
			
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
                <div>
                <hr />
                <?php
					foreach ( (array) $this->profiles as $profile => $data ) {
						$anc = $data['anchor'];
						printf( '<p><label for="%s"><b>%s:</b></label>', esc_attr( $this->get_field_id( $profile ) ), esc_attr( $data['label'] ) );
						printf( '<input type="text" id="%s" name="%s" value="%s" class="widefat" />', esc_attr( $this->get_field_id( $profile ) ), esc_attr( $this->get_field_name( $profile ) ), esc_url( $instance[$profile] ) );
						printf( '<br />' );
						printf( '<label for="%s">%s:</label>', esc_attr( $this->get_field_id( $anc ) ), __( 'Anchor text', 'justwrite') );
						printf( '<input type="text" id="%s" name="%s" value="%s" class="widefat" />', esc_attr( $this->get_field_id( $anc ) ), esc_attr( $this->get_field_name( $anc ) ), esc_attr( $instance[$anc] ) );
						printf( '<hr style="height: 2px; background-color: #e1e1e1;" /></p>' );
			
					}
				?>
                </div>
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
		
	} // AC_Section_Social_Profiles .END
	
	// Register this widget
	register_widget( 'AC_Section_Social_Profiles' );
}
?>