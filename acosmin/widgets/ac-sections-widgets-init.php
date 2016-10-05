<?php
/* ------------------------------------------------------------------------- *
 *  Initiate sections
 *  ________________
 *
 *	This class will initiate all the available homepage sections/widgets
 *	________________
 *
/* ------------------------------------------------------------------------- */


class AC_Sections {
	
	private static $instance;
	
	/*  Initiator
	/* ------------------------------------ */

	public static function init() {
		return self::$instance;
	}
	
	/*  Constructor
	/* ------------------------------------ */
	public function __construct() {
		
		// Widgets/Sections 
		require_once ( get_template_directory() . '/acosmin/widgets/section-basic-widget.php' ); // Basic - starter widget
		require_once ( get_template_directory() . '/acosmin/widgets/section-slider-widget.php' ); // Slider
		require_once ( get_template_directory() . '/acosmin/widgets/section-categories-2col-widget.php' ); // Categories (two columns)
		require_once ( get_template_directory() . '/acosmin/widgets/section-categories-3col-widget.php' ); // Categories (three columns)
		require_once ( get_template_directory() . '/acosmin/widgets/section-categories-4col-widget.php' ); // Categories (four columns)
		require_once ( get_template_directory() . '/acosmin/widgets/section-masonry-1-widget.php' ); // Masonry 1
		require_once ( get_template_directory() . '/acosmin/widgets/section-masonry-2-widget.php' ); // Masonry 2
		require_once ( get_template_directory() . '/acosmin/widgets/section-popular-posts-widget.php' ); // Popular Posts
		require_once ( get_template_directory() . '/acosmin/widgets/section-ad-widget.php' ); // Advertising
		require_once ( get_template_directory() . '/acosmin/widgets/section-archives-widget.php' ); // Archives
		require_once ( get_template_directory() . '/acosmin/widgets/section-social-profiles-widget.php' ); // Social Profiles

		// Enqueue styles & scripts
		add_action( 'admin_enqueue_scripts' , array( $this, 'ac_admin_widgets_js_files' ) );
		add_action( 'wp_enqueue_scripts' , array( $this, 'ac_widgets_js_files' ), 5 );
		
		//add_action( 'admin_enqueue_scripts', array( $this, 'ac_builder_css_styles' ) , 50 );

	}
	
	
	/*  JS Files
	/* ------------------------------------ */
	// Customizer and Admin area
	public function ac_admin_widgets_js_files() {
		wp_enqueue_script( 
			'ac-admin-widgets-js', 
			get_template_directory_uri() . '/assets/js/admin/widgets-js.js',
			array( 'jquery' ), 
			'1.0', 
			FALSE 
		);
	}
	
	// Front end
	public function ac_widgets_js_files() {
		if ( is_active_widget( false, false, 'ac-widget-masonry-small', true ) || is_active_widget( false, false, 'ac-widget-masonry-large', true ) ) {
			// ImagesLoaded
			wp_enqueue_script( 
				'ac-images-loaded-js', 
				get_template_directory_uri() . '/assets/js/imagesloaded.min.js', 
				array( 'jquery' ), 
				'3.1.8', 
				TRUE 
			);
			
			// Masonry
			wp_enqueue_script( 'jquery-masonry' );
		}
		
		if ( is_active_widget( false, false, 'ac-widget-featured-posts-slider', true ) ) {
			// Owl carousel
			wp_enqueue_script(
				'ac-owl-carousel-js', 
				get_template_directory_uri() . '/assets/js/owl.carousel.min.js', 
				array('jquery'), 
				'2.0.0', 
				false 
			);
		}
	}
	
}


/* Init everything via 'widgets_init' hook
/* --------------------------------------- */
function ac_sections_init() {
	global $ac_sections_widgets;
	$ac_sections_widgets = new AC_Sections();
	$ac_sections_widgets->init();
}
add_action( 'widgets_init' , 'ac_sections_init' , 20 );
?>