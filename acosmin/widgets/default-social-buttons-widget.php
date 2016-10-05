<?php
/* ------------------------------------------------------------------------- *
 *  Social Buttons Widget
/* ------------------------------------------------------------------------- */

// Setup Widget
class AC_Social_Buttons_Widget extends WP_Widget {
	
	// Widget Information
	function __construct() {
		// Settings
		$widget_ops = array('classname' => 'ac-social-buttons-widget', 'description' => __('Displays buttons for your social profiles.', 'justwrite') );
		
		// Create the widget
		parent::__construct('ac_social_buttons_widget', __('AC: Social Buttons', 'justwrite'), $widget_ops);
		
		// Default values
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
		);
		
		// Profiles
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
	
	// Widget Display
	function widget( $args, $instance ) {
		
		// Turn $args array into variables.
		extract( $args );
		
		// $instance Defaults
		$instance_defaults = $this->defaults;
		
		// Parse $instance
		$instance = wp_parse_args( (array) $instance, $instance_defaults );
		
		$title = apply_filters('widget_title', $instance['title'] );
		
		$profiles = (array) $this->profiles;
		
		echo $before_widget;
		if ( $title ) { 
			echo $before_title . $title . $after_title; 
		}
		?>
        
        <ul class="sidebar-social clearfix">
        	<?php
			$count = 0; 
			foreach ( $profiles as $profile => $data ) :
				$anc = $data['anchor'];

				if( ! empty( $instance[$profile] ) && ! empty( $instance[$anc] ) ) :
					$count++;
					if( $count % 2 == 0 ) { $social_align = 'alignright'; } else { $social_align = 'alignleft'; };
					
					echo '<li class="' . $social_align . '"><a href="' . esc_url( $instance[$profile] ) . '" class="social-btn ' . esc_attr( $profile ) . '">' . esc_html( $instance[$anc] ) . ' ' . ac_icon( $profile, false ) . '</a></li>';
			else : continue; endif; endforeach; ?>
        </ul>
        
        <?php
		echo $after_widget;
	}
	
	/* Update settings.*/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML
	    $instance['title'] = strip_tags( $new_instance['title'] );
		
		foreach ( (array) $this->profiles as $profile => $data ) {
			$anc 					= strip_tags( $data['anchor'] );
			$instance[$profile] 	= esc_url_raw( $new_instance[$profile] );
			$instance[$anc] 		= strip_tags( $new_instance[$anc] );
		}
		
		return $instance;
	}
	
	// Display Form Fields
	function form( $instance ) {
		
		// Parse $instance
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		extract( $instance, EXTR_SKIP );
		
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
            <?php
	}

}
register_widget( 'AC_Social_Buttons_Widget' );