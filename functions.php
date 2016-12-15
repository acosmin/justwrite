<?php
/* ------------------------------------------------------------------------- *
 *  Functions
 *  ________________
 *
 *	If you want to add/edit functions please use a child theme
 *	http://codex.wordpress.org/Child_Themes
 *	________________
 *
/* ------------------------------------------------------------------------- */



/* ------------------------------------------------------------------------- *
 *  Required Files
/* ------------------------------------------------------------------------- */
require_once ( get_template_directory() . '/acosmin/functions/functions-default.php' );
require_once ( get_template_directory() . '/acosmin/functions/functions-icons.php' );
require_once ( get_template_directory() . '/acosmin/functions/functions-post-options.php' );
require_once ( get_template_directory() . '/acosmin/functions/functions-theme-customizer.php' );
require_once ( get_template_directory() . '/acosmin/functions/class-tgm-plugin-activation.php' );
require_once ( get_template_directory() . '/acosmin/widgets/ac-sections-widgets-init.php' );



/*  Theme setup
/* ------------------------------------ */
if ( ! function_exists( 'ac_setup' ) ) {
	function ac_setup() {

		// Make JustWrite available for translation.
		load_theme_textdomain( 'justwrite', get_template_directory() . '/languages' );

		// Post Thumbnails
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 600, 400, true );
		add_image_size( 'ac-post-thumbnail', 600, 400, true );
		add_image_size( 'ac-slide-thumbnail', 515, 300, true );
		add_image_size( 'ac-sidebar-featured', 638, 368, true );
		add_image_size( 'ac-masonry-2x-thumbnail', 900, 520, true );
		add_image_size( 'ac-masonry-small-featured', 600 );
		add_image_size( 'ac-sidebar-small-thumbnail', 210, 140, true );
		add_image_size( 'ac-post-billboard-full', 1800, 900, true );

		// Enable post format support
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery' ) );

		// Menues
		// This theme has only one menu, located in the header.
		register_nav_menus( array(
			'main'				=> __( 'Main Menu', 'justwrite' ),
			'second'			=> __( 'Second Menu', 'justwrite' ),
			'mini-first'		=> __( 'Right Sidebar - First Menu', 'justwrite' ),
			'mini-second'		=> __( 'Right Sidebar - Second Menu', 'justwrite' ),
		) );

		// This feature adds theme support for themes to display titles.
		add_theme_support( 'title-tag' );

		// This feature enables post and comment RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// This feature allows the use of HTML5 markup for the comment forms, search forms and comment lists.
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form' ) );

		// Adding theme support for TinyMCE editor style.
		$selected_ff = ac_get_selected_ff();
		add_editor_style( array( 'assets/css/editor-style.css', 'assets/css/es-' . $selected_ff . '.css', ac_font_url( $selected_ff ) ) );

		// Custom header and background support
		if ( isset( $ac_custom_header ) && isset( $ac_custom_bg ) ) {
			add_theme_support( 'custom-header' ); add_theme_support( 'custom-background' );
		}

		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );

		// Add support for widgets selective refresh
		add_theme_support( 'customize-selective-refresh-widgets' );

	}
}
add_action( 'after_setup_theme', 'ac_setup' );



/*  Sets the content width in pixels, based on the theme's
 *	design and stylesheet
/* ------------------------------------ */
if ( ! function_exists( 'ac_content_width' ) ) {

	function ac_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'ac_content_width___filter', 940 );
	}

}
add_action( 'after_setup_theme', 'ac_content_width', 0 );



/*  Load CSS files
/* ------------------------------------ */
if ( ! function_exists( 'ac_css_files' ) ) {

	function ac_css_files() {

		// Register
		wp_register_style( 'ac_webfonts_' . ac_get_selected_ff(), ac_font_url( ac_get_selected_ff() ), array(), null);

		// Enqueue
		wp_enqueue_style( 'ac_style', get_stylesheet_uri(), array(), '2.0.3.5', 'all' );
		wp_enqueue_style( 'ac_icons', get_template_directory_uri() . '/assets/icons/css/font-awesome.min.css', array(), '4.7.0', 'all' );
		wp_enqueue_style( 'ac_webfonts_' . ac_get_selected_ff() );

	}

}
add_action( 'wp_enqueue_scripts', 'ac_css_files', 99 );



/*  Load JavaScript files
/* ------------------------------------ */
if ( ! function_exists( 'ac_js_files' ) ) {

	function ac_js_files() {

		// Enqueue
		wp_enqueue_script( 'ac_js_fitvids', get_template_directory_uri() . '/assets/js/jquery.fitvids.js', array('jquery'), '1.1', true );
		wp_enqueue_script( 'ac_js_menudropdown', get_template_directory_uri() . '/assets/js/menu-dropdown.js', array('jquery'), '1.4.8', true );

		if( is_home() && get_theme_mod( 'ac_enable_slider', false ) ) {
			wp_enqueue_script( 'ac_js_slider', get_template_directory_uri() . '/assets/js/slider.js', array('jquery'), '0.3.0', true );
		}

		wp_enqueue_script( 'ac_js_myscripts', get_template_directory_uri() . '/assets/js/myscripts.js', array('jquery'), '1.0.6', true );
		wp_enqueue_script( 'ac_js_html5', get_template_directory_uri() . '/assets/js/html5.js', array('jquery'), '3.7.0', false );

		// Comments Script
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
	}

}
add_action( 'wp_enqueue_scripts', 'ac_js_files' );



/*  Load admin CSS files
/* ------------------------------------ */
if ( ! function_exists( 'ac_admin_css_files' ) ) {

	function ac_admin_css_files() {
		wp_enqueue_style( 'ac_admin_styles', get_template_directory_uri() . '/assets/css/admin/ac-admin-styles.css', array(), '1.0', 'all' );
	}

}
add_action( 'admin_enqueue_scripts', 'ac_admin_css_files' );


/*  Font Families
/* ------------------------------------ */
if ( ! function_exists( 'ac_font_url' ) ) {

	function ac_font_url( $font_type = 'style5' ) {

		// You have 9 optios
		// Please select a option from the WP Theme Customise, Content tab.
		$font_url = '';
		$google_fonts_url = "//fonts.googleapis.com/css";

		if( $font_type == 'style1' ) {
			$font_url = add_query_arg( 'family', urlencode( 'Montserrat:400,700|Questrial|Arimo:400,700|Source Sans Pro:400,700,400italic,700italic' ), $google_fonts_url );
		} elseif( $font_type == 'style2' ) {
			$font_url = add_query_arg( 'family', urlencode( 'PT Serif:400,700,400italic,700italic|Montserrat:400,700' ), $google_fonts_url );
		} elseif( $font_type == 'style3' ) {
			$font_url = add_query_arg( 'family', urlencode( 'Roboto:400,700italic,700,400italic|Montserrat:400,700' ), $google_fonts_url );
		} elseif( $font_type == 'style4' ) {
			$font_url = add_query_arg( 'family', urlencode( 'PT Sans:400,700,400italic,700italic' ), $google_fonts_url );
		} elseif( $font_type == 'style5' ) {
			$font_url = add_query_arg( 'family', urlencode( 'Poppins:400,500,700|Lato:400,700,900,400italic,700italic' ), $google_fonts_url );
		} elseif( $font_type == 'style6' ) {
			$font_url = add_query_arg( 'family', urlencode( 'Roboto Slab:400,700|Open Sans:400,700,800,400italic,700italic' ), $google_fonts_url );
		} elseif( $font_type == 'style7' ) {
			$font_url = add_query_arg( 'family', urlencode( 'Roboto Slab:400,700|Source Serif Pro:400,700' ), $google_fonts_url );
		} elseif( $font_type == 'style8' ) {
			$font_url = add_query_arg( 'family', urlencode( 'Playfair Display:400,700,900|Source Serif Pro:400,700' ), $google_fonts_url );
		} elseif( $font_type == 'style9' ) {
			$font_url = add_query_arg( 'family', urlencode( 'Playfair Display:400,700,900|Open Sans:400,700,800,400italic,700italic' ), $google_fonts_url );
		}

		$font_url = apply_filters( 'ac_font_url___filter', $font_url );

		return $font_url;

	}

}



/*  Font Styles
/* ------------------------------------ */
if ( ! function_exists( 'ac_font_styles' ) ) {

	function ac_font_styles() {

		$selected 				= apply_filters( 'ac_font_styles___filter', $selected = get_theme_mod( 'ac_font_select', 'style5' ) );
		$childtheme 			= get_theme_mod( 'ac_disable_child_fonst_style', false );
		$font_style_url_child 	= get_stylesheet_directory_uri() . '/assets/css/font-' . $selected . '.css';
		$font_style_url 		= get_template_directory_uri() . '/assets/css/font-' . $selected . '.css';

		if( $selected == '' || $selected == 'style1' ) {
			return;
		} else {
			wp_enqueue_style( 'ac_webfonts_selected-' . $selected, $font_style_url, array(), null );
			if( is_child_theme() && $childtheme ) {
				wp_enqueue_style( 'ac_webfonts_selected-' . $selected . '_child', $font_style_url_child, array(), null );
			}
		}

	}

}
add_action( 'wp_enqueue_scripts', 'ac_font_styles', 100 );



/*  Get selected font
/* ------------------------------------ */
if ( ! function_exists( 'ac_get_selected_ff' ) ) {

	function ac_get_selected_ff() {

		// Check if a font is selected
		$selected = apply_filters( 'ac_font_styles___filter', $selected = get_theme_mod( 'ac_font_select', 'style5' ) );

		if ( $selected == '' ) {
			$current_font = 'style1';
		} else {
			$current_font = $selected;
		}

		return $current_font;

	}

}



/*  Setup posts excerpt
/* ------------------------------------ */
if ( ! function_exists( 'ac_custom_excerpt_length' ) ) {

	function ac_custom_excerpt_length( $length ) {
		return 45;
	}

}
add_filter( 'excerpt_length', 'ac_custom_excerpt_length', 999 );

if ( ! function_exists( 'ac_no_excerpt_dots' ) ) {

	function ac_no_excerpt_dots( $more ) {
		return '';
	}

}
add_filter('excerpt_more', 'ac_no_excerpt_dots');



/*  Widgets and Sidebars Setup
/* ------------------------------------ */
if ( ! function_exists( 'ac_sidebars_widgets' ) ) {

	function ac_sidebars_widgets() {

		// Include Widgets
		require_once get_template_directory() . '/acosmin/widgets/ac-default-widgets-init.php';
		require_once get_template_directory() . '/acosmin/widgets/ac-custom-widgets-init.php';

		// Main sidebar that appears on the right.
		register_sidebar( array(
			'name'          => __( 'Main Sidebar', 'justwrite' ),
			'id'            => 'main-sidebar',
			'description'   => __( 'Main sidebar that appears on the right.', 'justwrite' ),
			'before_widget' => '<aside id="%1$s" class="side-box clearfix widget %2$s"><div class="sb-content clearfix">',
			'after_widget'  => '</div></aside><!-- END .sidebox .widget -->',
			'before_title'  => '<h3 class="sidebar-heading">',
			'after_title'   => '</h3>',
		) );

		// Same as above, designed for the articles area.
		register_sidebar( array(
			'name'          => __( 'Posts Sidebar', 'justwrite' ),
			'id'            => 'posts-sidebar',
			'description'   => __( 'Same as "Main Sidebar", designed for the posts.', 'justwrite' ),
			'before_widget' => '<aside id="%1$s" class="side-box clearfix widget %2$s"><div class="sb-content clearfix">',
			'after_widget'  => '</div></aside><!-- END .sidebox .widget -->',
			'before_title'  => '<h3 class="sidebar-heading">',
			'after_title'   => '</h3>',
		) );

		// Main Page - Before posts
		register_sidebar( array(
			'name'          => __( 'Sections - Before posts', 'justwrite' ),
			'id'            => 'main-page-before',
			'description'   => __( 'Use this area with the special designed widgets.("AC SEC:" prefix and bright blue background color).', 'justwrite' ),
			'before_widget' => '<section id="%1$s" class="container %2$s builder clearfix">',
			'after_widget'  => '</section><div class="cleardiv"></div><!-- END .container .builder -->',
			'before_title'  => '<h3 class="sidebar-heading">',
			'after_title'   => '</h3>',
		) );

		// Main Page - After posts
		register_sidebar( array(
			'name'          => __( 'Sections - After posts', 'justwrite' ),
			'id'            => 'main-page-after',
			'description'   => __( 'Use this area with the special designed widgets.("AC SEC:" prefix and bright blue background color).', 'justwrite' ),
			'before_widget' => '<section id="%1$s" class="container %2$s builder clearfix">',
			'after_widget'  => '</section><div class="cleardiv"></div><!-- END .container .builder -->',
			'before_title'  => '<h3 class="sidebar-heading">',
			'after_title'   => '</h3>',
		) );

		// All pages - After header
		register_sidebar( array(
			'name'          => __( 'Sections - After header', 'justwrite' ),
			'id'            => 'all-pages-header-after',
			'description'   => __( 'Widgets will appear on all pages (except main page), after the header location. Use this area with the special designed widgets ("AC SEC:" prefix and bright blue background color).', 'justwrite' ),
			'before_widget' => '<section id="%1$s" class="container %2$s builder' . ac_sidebars_all_pages_disabled_mini() . ' clearfix">',
			'after_widget'  => '</section><div class="cleardiv"></div><!-- END .container .builder -->',
			'before_title'  => '<h3 class="sidebar-heading">',
			'after_title'   => '</h3>',
		) );

		// All pages - Before footer
		register_sidebar( array(
			'name'          => __( 'Sections - Before footer', 'justwrite' ),
			'id'            => 'all-pages-footer-before',
			'description'   => __( 'Widgets will appear on all pages (except main page), before the widgetized footer area. Use this area with the special designed widgets ("AC SEC:" prefix and bright blue background color).', 'justwrite' ),
			'before_widget' => '<section id="%1$s" class="container %2$s builder' . ac_sidebars_all_pages_disabled_mini() . ' clearfix">',
			'after_widget'  => '</section><div class="cleardiv"></div><!-- END .container .builder -->',
			'before_title'  => '<h3 class="sidebar-heading">',
			'after_title'   => '</h3>',
		) );

		// Footer - Area #1
		register_sidebar( array(
			'name'          => __( 'Footer - Area #1', 'justwrite' ),
			'id'            => 'footer-area-1',
			'description'   => __( 'Displays widgets in area #1 (footer).', 'justwrite' ),
			'before_widget' => '<aside id="%1$s" class="side-box clearfix widget %2$s"><div class="sb-content clearfix">',
			'after_widget'  => '</div></aside><!-- END .sidebox .widget -->',
			'before_title'  => '<h3 class="sidebar-heading">',
			'after_title'   => '</h3>',
		) );

		// Footer - Area #2
		register_sidebar( array(
			'name'          => __( 'Footer - Area #2', 'justwrite' ),
			'id'            => 'footer-area-2',
			'description'   => __( 'Displays widgets in area #2 (footer).', 'justwrite' ),
			'before_widget' => '<aside id="%1$s" class="side-box clearfix widget %2$s"><div class="sb-content clearfix">',
			'after_widget'  => '</div></aside><!-- END .sidebox .widget -->',
			'before_title'  => '<h3 class="sidebar-heading">',
			'after_title'   => '</h3>',
		) );

		// Footer - Area #3
		register_sidebar( array(
			'name'          => __( 'Footer - Area #3', 'justwrite' ),
			'id'            => 'footer-area-3',
			'description'   => __( 'Displays widgets in area #3 (footer).', 'justwrite' ),
			'before_widget' => '<aside id="%1$s" class="side-box clearfix widget %2$s"><div class="sb-content clearfix">',
			'after_widget'  => '</div></aside><!-- END .sidebox .widget -->',
			'before_title'  => '<h3 class="sidebar-heading">',
			'after_title'   => '</h3>',
		) );

		// Footer - Area #4
		register_sidebar( array(
			'name'          => __( 'Footer - Area #4', 'justwrite' ),
			'id'            => 'footer-area-4',
			'description'   => __( 'Displays widgets in area #4 (footer).', 'justwrite' ),
			'before_widget' => '<aside id="%1$s" class="side-box clearfix widget %2$s"><div class="sb-content clearfix">',
			'after_widget'  => '</div></aside><!-- END .sidebox .widget -->',
			'before_title'  => '<h3 class="sidebar-heading">',
			'after_title'   => '</h3>',
		) );

	}

}
add_action( 'widgets_init', 'ac_sidebars_widgets' );

// Add a widgetized area on all pages, before the footer
if ( ! function_exists( 'ac_sidebars_before_footer_area' ) ) {

	function ac_sidebars_before_footer_area() {
		if( ! is_front_page() ) {
			if ( is_active_sidebar( 'all-pages-footer-before' ) ) { dynamic_sidebar( 'all-pages-footer-before' ); }
		}
	}

}
add_action( 'ac_action_footer_widgets_before', 'ac_sidebars_before_footer_area' );

// Add a widgetized area on all pages, after the header
if ( ! function_exists( 'ac_sidebars_after_header_area' ) ) {

	function ac_sidebars_after_header_area() {
		if( ! is_front_page() ) {
			if ( is_active_sidebar( 'all-pages-header-after' ) ) { dynamic_sidebar( 'all-pages-header-after' ); }
		}
	}

}
add_action( 'ac_action_header_main_tag_after', 'ac_sidebars_after_header_area', 10 );

// In case the mini sidebar is disabled
if ( ! function_exists( 'ac_sidebars_all_pages_disabled_mini' ) ) {

	function ac_sidebars_all_pages_disabled_mini() {
		$is_enabled = get_theme_mod( 'ac_disable_minisidebar' );
		if( $is_enabled ) {
			return ' mini-disabled';
		} else {
			return;
		}
	}

}



/*  Set mini-sidebar to disabled
/* ------------------------------------ */
if ( ! function_exists( 'ac_mini_disabled' ) ) {

	function ac_mini_disabled( $echo = true ) {

		// Adds a class to the mini-sidebar if you select to disable it
		$is_enabled = get_theme_mod( 'ac_disable_minisidebar' );
		$class		= array();

		if ( $is_enabled ) {
			$class[] = ' mini-disabled';
			if ( is_home() && (
				is_active_widget( false, false, 'ac-widget-masonry-small', true ) ||
				is_active_widget( false, false, 'ac-widget-masonry-large', true ) ||
				is_active_widget( false, false, 'ac-widget-four-columns-categories', true ) ||
				is_active_widget( false, false, 'ac-widget-three-columns-categories', true ) ||
				is_active_widget( false, false, 'ac-widget-two-columns-categories', true ) ||
				is_active_widget( false, false, 'ac-widget-popular-posts', true )
				) ) {
				$class[] = 'builder-on';
			} else { }

			if( has_filter( 'ac_mini_disabled_filter' ) ) {
				$class = apply_filters( 'ac_mini_disabled_filter', $class );
			}
		}

		$classes = join(' ', $class);

		if( $echo ) {
			echo esc_html( $classes );
		} else {
			return esc_html( $classes );
		}

	}

}



/*  Main menu social profiles
/* ------------------------------------ */
if ( ! function_exists( 'ac_main_menu_social' ) ) {

	function ac_main_menu_social() {
		$show		= get_theme_mod( 'ac_disable_menu_social', true );
		$show_fixed = get_theme_mod( 'ac_disable_menu_social_fixed', true );
		$output		= '';

		// Social variables
		$header_fb 	= get_theme_mod( 'ac_social_profile_fb', '' );
		$header_tw 	= get_theme_mod( 'ac_social_profile_tw', '' );
		$header_gp 	= get_theme_mod( 'ac_social_profile_gp', '' );
		$header_rss = get_theme_mod( 'ac_social_profile_rss', '' );

		// Check if rss url is set
		if( $header_rss != '' ) { $h_rss_link = $header_rss; } else { $h_rss_link = get_bloginfo( 'rss2_url' ); };

		// Show the icons only if the menu is in fixed state
		if( $show_fixed ) { $show_fixed_state = ''; } else { $show_fixed_state = ' show'; };

		// If enabled show icons
		if( $show ) {
			$output .= '<ul class="header-social-icons' . $show_fixed_state . ' clearfix">';
				if( $header_tw != '' ) {
					$output .=	'<li><a href="https://twitter.com/' . esc_html( $header_tw ) . '" class="social-btn left twitter">' . ac_icon( 'twitter', false ) . '</a></li>';
				}
				if( $header_fb != '' ) {
					$output .=	'<li><a href="' . esc_url( $header_fb ) . '" class="social-btn left facebook">' . ac_icon( 'facebook', false ) . '</a></li>';
				}
				if( $header_gp != '' ) {
					$output .=	'<li><a href="' . esc_url( $header_gp ) . '" class="social-btn left google-plus">' . ac_icon( 'google-plus', false ) . '</a></li>';
				}
				$output .= '<li><a href="' . esc_url ( $h_rss_link ) . '" class="social-btn right rss">' . ac_icon( 'rss', false) . '</a></li>';
			$output .= '</ul><!-- END .header-social-icons -->';

			echo $output = apply_filters( 'ac_main_menu_social_filter', $output );
		} else {
			return;
		}
	}

}
add_action( 'ac_action_search_btn_after', 'ac_main_menu_social' );



/*  Comment template
/* ------------------------------------ */
if ( ! function_exists( 'ac_comment_template' ) ) {

	function ac_comment_template( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		$classes = array(
			'clearfix'
		);
		switch ( $comment->comment_type ) :
			case '' :
		?>
		<li <?php comment_class( $classes ); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">


				<figure class="comment-avatar">
					<?php echo get_avatar( $comment, 70 ); ?>
				</figure>


				 <div class="comment-main">

					<header class="vcard clearfix">
						<?php printf(__('<cite class="fn">%s says:</cite>', 'justwrite'), get_comment_author_link()) ?>

						<aside class="comm-edit">
							<a class="comment-date" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf('%1$s', get_comment_date('M d, Y'),  get_comment_time()) ?></a>
							<?php edit_comment_link(__('Edit', 'justwrite'),'  ','') ?>
						</aside>
					</header>

					<div class="comment-text">
					<?php comment_text(); ?>
						<?php if ($comment->comment_approved == '0') : ?>
							 <em><?php _e('Your comment is awaiting moderation.', 'justwrite') ?></em>
							 <br />
						<?php endif; ?>
					</div>

					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'before' => '<footer class="reply">', 'after' => '</footer>','max_depth' => $args['max_depth']))) ?>

				</div>

			</div><!-- #comment-<?php comment_ID(); ?>  -->

		<?php
			break;
			case 'pingback'  :
		?>
			<li <?php comment_class(); ?> id="li-pingback-<?php comment_ID(); ?>">
				<?php _e('Pingback:', 'justwrite') ?> <?php echo get_comment_author_link(); ?> <small class="ping-edit"><?php ac_icon('edit'); edit_comment_link(__('Edit', 'justwrite'),'  ','') ?></small>
			</li>
		<?php
			case 'trackback' :
		?>
			<li <?php comment_class(); ?> id="li-trackback-<?php comment_ID(); ?>">
				<?php _e('Trackback:', 'justwrite') ?> <?php echo get_comment_author_link(); ?> <small class="ping-edit"><?php ac_icon('edit'); edit_comment_link(__('Edit', 'justwrite'),'  ','') ?></small>
			</li>
		<?php
		endswitch;
	}

}



/*  Logo output
/* ------------------------------------ */
if ( ! function_exists( 'ac_get_logo' ) ) {

	function ac_get_logo() {

		// Adds different classes in case you select an image logo.
		$logo_text 		= get_bloginfo( 'name' );
		$logo_image 	= get_theme_mod( 'ac_logo_image' );

		if ( $logo_image ) {
			echo '<img src="' . esc_url( $logo_image ) . '" alt="' . get_bloginfo( 'name' ) . '" />';
		} else {
			if ( $logo_text != '' ) {
				echo esc_html( $logo_text );
			}
		}
	}

	function ac_logo_class() {
		$class = array();
		$centered = get_theme_mod( 'ac_logo_centered', false );

		if ( get_theme_mod( 'ac_logo_image' ) ) {
			$class[] = 'logo-image';
		} else {
			$class[] = 'logo-text';
		}

		if ( $centered ) {
			$class[] = 'logo-centered';
		}

		if( has_filter( 'ac_logo_class_filter' ) ) {
			$class = apply_filters( 'ac_logo_class_filter', $class );
		}

		$classes = join( ' ', $class );

		echo ' ' . esc_attr( $classes );

	}

}



/*  Pagination
/* ------------------------------------ */
if ( ! function_exists( 'ac_paginate' ) ) {

	function ac_paginate() {
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

		$links   = paginate_links( array(
			'base'     => $pagenum_link,
			'format'   => $format,
			'total'    => $GLOBALS['wp_query']->max_num_pages,
			'current'  => $paged,
			'mid_size' => 1,
			'add_args' => array_map( 'urlencode', $query_args ),
			'prev_text' => __( '&larr; Previous', 'justwrite' ),
			'next_text' => __( 'Next &rarr;', 'justwrite' ),
		) );

		if ( $links ) :

		?>
		<nav class="posts-pagination clearfix" role="navigation">
			<div class="paging-wrap">
				<?php echo $links; ?>
			</div><!-- END .paging-wrap -->
		</nav><!-- .posts-pagination -->
		<?php
		endif;

	}

}



/*  Slider options
/* ------------------------------------ */
if ( ! function_exists( 'ac_slider_options' ) ) {

	function ac_slider_options() {

		if ( get_theme_mod( 'ac_enable_slider', false ) && is_front_page() && !is_paged() && ac_featured_posts_count() > 2 ) {

			if ( get_theme_mod( 'ac_autostart_slider', false ) ) {
				$slider_autostart = 'true';
			} else {
				$slider_autostart = 'false';
			}

			$slider_transition_delay = get_theme_mod( 'ac_slider_delay', '5000' );

			?>

			<script type="text/javascript">
			jQuery(function($){
				$('.slider').jcarouselAutoscroll({
					interval: <?php echo esc_html( $slider_transition_delay ); ?>,
					autostart: <?php echo $slider_autostart; ?>
				});
			});
			</script>

			<?php
		}

		return;

	}

}
add_action( 'wp_footer', 'ac_slider_options' );



/*  Get featured posts count
/* ------------------------------------ */
if ( ! function_exists( 'ac_featured_posts_count' ) ) {

	function ac_featured_posts_count() {

		// Get total number
		$featured_posts_nr = get_posts( array(
			'meta_key' => 'ac_featured_article',
			'meta_value' => 1,
		));

		$count_featured_posts = count( $featured_posts_nr );

		return $count_featured_posts;
	}

}



/*  Post pagination
/* ------------------------------------ */
if ( ! function_exists( 'ac_post_nav_arrows' ) ) {

	function ac_post_nav_arrows() {
		global $post;

		$prev_post = get_next_post();
		$next_post = get_previous_post();

		if( $prev_post ) {
			$prev_post_id = $prev_post->ID;
			$prev_post_url = get_permalink($prev_post_id);
		};
		if( $next_post ) {
			$next_post_id = $next_post->ID;
			$next_post_url = get_permalink($next_post_id);
		};

		echo '<div class="post-navigation clearfix">';

		if( $prev_post ) {
			echo '<a href="' . esc_url( $prev_post_url ) . '" class="prev-post" title="' . __( 'Previous Post', 'justwrite' ) . '">' . ac_icon('angle-left', false) . '</a>';
		} else {
			echo '<span class="prev-post">' . ac_icon('angle-left', false) . '</span>';
		}

		if( $next_post ) {
			echo '<a href="' . esc_url( $next_post_url ) . '" class="next-post" title="' . __( 'Next Post', 'justwrite' ) . '">' . ac_icon('angle-right', false) . '</a>';
		} else {
			echo '<span class="next-post">' . ac_icon('angle-right', false) . '</span>';
		}

		echo '</div>';
	}

}



/*  Single post title & details
/* ------------------------------------ */
if ( ! function_exists( 'ac_single_post_td' ) ) {

	function ac_single_post_td() {
		$post_layout_customizer = get_theme_mod( 'ac_single_post_layout_select', 'ac_post_layout_normal' );
		$post_layout_editor = get_post_meta( get_the_ID(), 'ac_post_layout_options', true );

		if( $post_layout_editor == '' ) {
			$post_layout_editor = $post_layout_customizer;
		}

		if( $post_layout_editor == 'ac_post_layout_normal' || ! ac_check_paged() ) {
			the_title( '<h2 class="title">', '</h2>' );
			ac_single_post_details();
			$ple = true;
		}

		if( $post_layout_customizer == 'ac_post_layout_normal' || ! ac_check_paged() ) {
			$ple = true;
			if( ! $ple ) {
				the_title( '<h2 class="title">', '</h2>' );
				ac_single_post_details();
			}
		}

	}

}
add_action( 'ac_single_post_title_info_thumb', 'ac_single_post_td', 10 );



/*  Single post details
/* ------------------------------------ */
if ( ! function_exists( 'ac_single_post_details' ) ) {

	function ac_single_post_details() {
		global $post;

		$author_id = $post->post_author;
		$author_info = get_userdata( $author_id );
		$author_name = $author_info->display_name;
		$author_url = get_author_posts_url( $author_id );
		$author_output = '<a href="' . esc_url( $author_url ) . '">' . esc_html( $author_name ) . '</a>';

		$show_date = apply_filters( 'ac_single_post_details_sd', true );
		$show_author = apply_filters( 'ac_single_post_details_sa', true );
		$show_category = apply_filters( 'ac_single_post_details_sc', true );

		do_action( 'ac_single_post_details_before' );
		?>
        <header class="details clearfix">
        	<?php do_action( 'ac_single_post_details_before_items' ); ?>
        	<?php if( $show_date ) { ?><time class="detail left index-post-date" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'M d, Y' ); ?></time><?php }; ?>
			<?php if( $show_author ) { ?><span class="detail left index-post-author"><em><?php _e( 'by', 'justwrite' ); ?></em> <?php echo $author_output; ?></span><?php }; ?>
			<?php if( $show_category ) { ?><span class="detail left index-post-category"><em><?php _e( 'in', 'justwrite' ); ?></em> <?php ac_output_first_category(); ?></span><?php }; ?>
            <?php do_action( 'ac_single_post_details_after_items' ); ?>
        </header><!-- END .details -->
        <?php
		do_action( 'ac_single_post_details_after' );
	}

}



/*  Single post thumbnails
/* ------------------------------------ */
if ( ! function_exists( 'ac_single_post_thumb' ) ) {

	function ac_single_post_thumb() {
		global $paged;
		$show_thumbnail = get_post_meta( get_the_ID(), 'ac_show_post_thumbnail', true );

		if( $show_thumbnail && ac_check_paged() ) {
			do_action( 'ac_single_post_thumbnail_before' );
			?>
			<figure class="featured-image-wrap">
				<?php
				do_action( 'ac_single_post_thumbnail_before_image' );
				if ( has_post_thumbnail() && $paged == false ) :
					the_post_thumbnail( 'ac-sidebar-featured' );
				else :
					echo '<img src="' . get_template_directory_uri() . '/images/no-thumbnail.png" alt="' . __( 'No Thumbnail', 'justwrite' ) . '" />';
				endif;
				do_action( 'ac_single_post_thumbnail_after_image' );
				?>
			</figure>
			<?php
			do_action( 'ac_single_post_thumbnail_after' );
        }
	}

}
add_action( 'ac_single_post_title_info_thumb', 'ac_single_post_thumb', 20 );



/*  Single post content classes
/* ------------------------------------ */
if ( ! function_exists( 'ac_single_content_classes' ) ) {

	function ac_single_content_classes( $echo = true ) {
		$class = array();
		$show_thumbnail = get_post_meta( get_the_ID(), 'ac_show_post_thumbnail', true );
		$post_layout_customizer = get_theme_mod( 'ac_single_post_layout_select', 'ac_post_layout_normal' );
		$post_layout_editor = get_post_meta( get_the_ID(), 'ac_post_layout_options', true );

		if( $show_thumbnail ) {
			$class[] = 'featured-image';
		}

		if( $post_layout_editor == '' ) {
			$post_layout_editor = $post_layout_customizer;
		}

		if( ac_check_paged() ) {
			if( $post_layout_editor != 'ac_post_layout_normal' ) {
				$class[] = 'sg-cover';
				if( $post_layout_editor == 'ac_post_layout_cover_parallax' ) {
					$class[] = 'sg-parallax';
				}
				$ple = true;
			}

			if( $post_layout_customizer != 'ac_post_layout_normal' ) {
				$ple = true;
				if( ! $ple ) {
					$class[] = 'sg-cover';
					if( $post_layout_customizer == 'ac_post_layout_cover_parallax' ) {
						$class[] = 'sg-parallax';
					}
				}
			}
		}

		if( has_filter( 'ac_single_content_classes_filter' ) ) {
			$class = apply_filters( 'ac_single_content_classes_filter', $class );
		}

		$classes = join( ' ', $class );
		$output_classes = ' ' . $classes;

		if( $echo && $output_classes != ' ' ) {
			echo esc_attr( $output_classes );
		} else {
			return esc_attr( $output_classes );
		}
	}

}



/*  Single post billboard parallax class
/* --------------------------------------- */
if ( ! function_exists( 'ac_single_post_billboard_parallax_class' ) ) {

	function ac_single_post_billboard_parallax_class() {
		$post_layout_customizer = get_theme_mod( 'ac_single_post_layout_select', 'ac_post_layout_normal' );
		$post_layout_editor = get_post_meta( get_the_ID(), 'ac_post_layout_options', true );

		if( $post_layout_editor == '' ) {
			$post_layout_editor = $post_layout_customizer;
		}

		if( $post_layout_editor == 'ac_post_layout_cover_parallax' ) {
			echo ' with-parallax';
			$ple = true;
		}

		if( $post_layout_customizer == 'ac_post_layout_cover_parallax' ) {
			$ple = true;
			if( ! $ple ) {
				echo ' with-parallax';
			}
		}

	}

}



/*  Single post billboard image
/* ------------------------------------ */
if ( ! function_exists( 'ac_single_post_billboard_img' ) ) {

	function ac_single_post_billboard_img( $only_url = false, $echo = false ) {
		$billboard_image 		= wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'ac-post-billboard-full' );
		$billboard_image_url 	= $billboard_image['0'];
		if( ! $only_url && ! $echo ) {
			if( has_post_thumbnail() ) {
				echo ' style="background-image: url(' . esc_url( $billboard_image_url ) . ');"';
			} else {
				return;
			}
		}

		if( $only_url ) {
			if( $echo ) {
				echo esc_url( $billboard_image_url );
			} else {
				return esc_url( $billboard_image_url );
			}
		}

	}

}



/*  Single post information
/* ------------------------------------ */
if ( ! function_exists( 'ac_single_post_info' ) ) {

	function ac_single_post_info() {
		$post_layout_customizer = get_theme_mod( 'ac_single_post_layout_select', 'ac_post_layout_normal' );
		$post_layout_editor = get_post_meta( get_the_ID(), 'ac_post_layout_options', true );
		$format = get_post_format() ? '' : 'standard';

		if( $post_layout_editor == '' ) {
			$post_layout_editor = $post_layout_customizer;
		}

		if( is_single() && ac_check_paged() && $format == 'standard' ) {

			if( $post_layout_editor != 'ac_post_layout_normal'  ) {
				get_template_part( 'post-templates/layouts/layout', 'cover' );
				$ple = true;
			}

			if( $post_layout_customizer != 'ac_post_layout_normal' ) {
				$ple = true;
				if( ! $ple ) {
					get_template_part( 'post-templates/layouts/layout', 'cover' );
				}
			}

		}

	}

}
add_action( 'ac_action_wrap_main_inside_top', 'ac_single_post_info' );



/*  Single post cover overlay background/opacity
/* ---------------------------------------------- */
if ( ! function_exists( 'ac_single_post_overlay_options' ) ) {

	function ac_single_post_overlay_options() {
		$background_color = get_post_meta( get_the_ID(), 'ac_color_field_select', true );
		$bg_default_value = apply_filters( 'ac_sp_overlay_bg_default_filter', $bg_default_value = '#000000' );
		$opacity_default_value = get_theme_mod( 'ac_single_post_opacity_select', '0.5' );
		$opacity_editor_value = get_post_meta( get_the_ID(), 'ac_cover_overlay_opacity', true );

		if( $background_color == '' ) {
			$background_color = $bg_default_value;
		}

		if( $opacity_editor_value == '' ) {
			if( $opacity_default_value == 'transparent' ) {
				$opacity_editor_value = "0";
			} else {
				$opacity_editor_value = $opacity_default_value;
			}
		} elseif( $opacity_editor_value == 'transparent' ) {
			$opacity_editor_value = "0";
		}

		if( $opacity_editor_value != '0.5' ) {
			echo ' style="background-color: rgba(' . ac_hex2rgba( $background_color, $opacity_editor_value, true ) . ')"';
			$ple = true;
		}

		if( $opacity_default_value != '0.5' ) {
			$ple = true;
			if( ! $ple ) {
				echo ' style="background-color: rgba(' . ac_hex2rgba( $background_color, $opacity_editor_value, true ) . ')"';
			}
		}

	}

}



/*  <html> tag classes
/* ------------------------------------ */
if ( ! function_exists( 'ac_html_tag_classes' ) ) {

	function ac_html_tag_classes() {
		$check_preloader = get_theme_mod( 'ac_preloader_enable', false );
		$check_plugin = get_option( 'ac_justwrite_freebies_activated' );
		$classes = array();

		if( $check_plugin == 'active' ) {
			if( ! empty( $check_preloader ) ) {
				$classes[] = 'js';
			}
		}

		if( has_filter( 'ac_html_tag_classes_filter' )) {
			$classes = apply_filters('ac_html_tag_classes_filter', $classes);
		}

		$css_classes = join(' ', $classes);

		if( ! empty( $classes ) ) {
			echo ' class="' . esc_attr( $css_classes ) . '"';
		} else {
			return;
		}
	}

}



/*  Categories title output (columns widgets)
/* ---------------------------------------------- */
if ( ! function_exists( 'ac_widget_cols_title' ) ) {

	function ac_widget_cols_title( $cat_name = '' ) {

		if( $cat_name != '' ) {
			$category_name = get_cat_name( absint( $cat_name ) );
			if( has_filter( 'ac_widget_cats_cols_title_filter') ) {
				$title_output = '<h3 class="section-col-title">' .  apply_filters( 'ac_widget_cats_cols_title_filter', esc_html( $category_name ) ) . '</h3>';
				echo $title_output;
			} else {
				$title_output = '<h3 class="section-col-title">' . esc_html( $category_name ) . '</h3>';
				echo $title_output;
			}
		} else {
			echo '<h3 class="section-col-title">' . __( 'No category selected', 'justwrite' ) . '</h3>';
		}
	}

}



/*  Return demo widgets
/* ---------------------------------------------- */
if ( ! function_exists( 'ac_return_inactive_widgets' ) ) {

	function ac_return_inactive_widgets( $area = '' ) {
		$disable 	= get_theme_mod( 'ac_disable_demo_widgets', false );
		$notice 	= '<p class="add-some-widgets">' . esc_html__( 'Disable these demo widgets by adding your own widgets or from `Customizer > Layout Options > Miscellaneous > Disable demo widgets`.', 'justwrite' ) . '</p>';
		$notice2 	= '<p class="add-some-widgets container builder">' . esc_html__( 'Disable these demo sections by adding your own in "Sections - Before posts". You can also disable them from `Customizer > Layout Options > Miscellaneous > Disable demo widgets`.', 'justwrite' ) . '</p>';
		$notice3 	= '<p class="add-some-widgets">' . esc_html__( 'Disable these demo widgets by adding your own widgets or from `Customizer > Layout Options > Miscellaneous > Disable demo widgets`. You can also disable the entire widgetized footer from `Customizer > Footer Options > Hide footer widgets area`.', 'justwrite' ) . '</p>';
		$ac_widgets_wrap_args = array(
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '<h3 class="sidebar-heading">',
				'after_title'   => '</h3>' );
		$ac_widgets_wrap_sec_args = array( 'before_widget' => '', 'after_widget'  => '', 'before_title'  => '', 'after_title'   => '' );

		if( ! $disable ) {
			// Front page before
			if( $area == 'front-page-before' && ! is_paged() ) {
				// Display Slider
				$ac_widget_rp_inst = array( 'title' => '' );
				echo '<section class="n-mb container ss-slider builder clearfix">';
					the_widget( 'AC_Section_Slider', $ac_widget_rp_inst, $ac_widgets_wrap_sec_args );
				echo '</section><div class="cleardiv"></div><!-- END .container .builder -->';

				// Display Masonry 2
				$ac_widget_rp_inst = array( 'title' => '', 'typeselect' => 'category', 'category' => '1' );
				echo '<section class="n-mb n-mt container sm-large-masonary builder clearfix">';
					the_widget( 'AC_Section_Masonry_2', $ac_widget_rp_inst, $ac_widgets_wrap_sec_args );
				echo '</section><div class="cleardiv"></div><!-- END .container .builder -->';

				// Notice
				echo $notice2;

				// Display 4 columns section
				$ac_widget_rp_inst = array( 'title' => '', 'category_1' => '1', 'category_2' => '1', 'category_3' => '1', 'category_4' => '1'  );
				echo '<section class="n-mb b-top p-top2 container sc-small builder clearfix">';
					the_widget( 'AC_Section_Cat_4_Columns', $ac_widget_rp_inst, $ac_widgets_wrap_sec_args );
				echo '</section><div class="cleardiv"></div><!-- END .container .builder -->';

				// Some needed js
				wp_enqueue_script( 'ac-owl-carousel-demo-js', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery'), '2.0.0', false );
				wp_enqueue_script( 'ac-images-loaded-demo-js', get_template_directory_uri() . '/assets/js/imagesloaded.min.js', array( 'jquery' ), '3.1.8', TRUE );
				wp_enqueue_script( 'jquery-masonry' );
			}

			// Main sidebar
			if( $area == 'sidebars' ) {
				// Display social widget
				$ac_widget_rp_inst = array( 'title' => '', 'twitter' => '#', 'twitter_anc' => __( 'Follow', 'justwrite' ), 'facebook' => '#', 'facebook_anc' => __( 'Facebook', 'justwrite' ), 'google-plus' => '#', 'google-plus_anc' => __( 'G+', 'justwrite' ), 'rss' => '#', 'rss_anc' => __( 'Subscribe', 'justwrite' ), 'youtube' => '#', 'youtube_anc' => __( 'Youtube', 'justwrite' ), 'instagram' => '#', 'instagram_anc' => __( 'Instagram', 'justwrite' ) );
				echo '<aside class="side-box clearfix widget ac-social-buttons-widget"><div class="sb-content clearfix">';
					the_widget( 'AC_Social_Buttons_Widget', $ac_widget_rp_inst, $ac_widgets_wrap_args );
				echo '</div></aside><!-- END .sidebox .widget -->';

				// Display recent posts widget
				$ac_widget_rp_inst = array( 'title' => __( 'Recent Posts Demo', 'justwrite' ), 'recent_posts_number' => 3, 'hide_recent_thumbs' => false );
				echo '<aside class="side-box clearfix widget ac_recent_posts_widget"><div class="sb-content clearfix">';
					the_widget( 'AC_Recent_Posts_Widget', $ac_widget_rp_inst, $ac_widgets_wrap_args );
				echo '</div></aside><!-- END .sidebox .widget -->';

				// Display popular posts widget
				$ac_widget_rp_inst = array( 'title' => __( 'Popular Posts Demo', 'justwrite' ), 'popular_posts_number' => 3, );
				echo '<aside class="side-box clearfix widget ac_popular_posts_widget"><div class="sb-content clearfix">';
					the_widget( 'AC_Popular_Posts_Widget', $ac_widget_rp_inst, $ac_widgets_wrap_args );
				echo '</div></aside><!-- END .sidebox .widget -->';

				// Notice
				echo $notice;
			}

			// Footer
			if( $area == 'footer-area-1' ) {
				// Display recent posts widget
				$ac_widget_rp_inst = array( 'title' => __( 'Footer Area #1', 'justwrite' ), 'recent_posts_number' => 3, 'hide_recent_thumbs' => true );
				echo '<aside class="side-box clearfix widget ac_recent_posts_widget"><div class="sb-content clearfix">';
					the_widget( 'AC_Recent_Posts_Widget', $ac_widget_rp_inst, $ac_widgets_wrap_args );
				echo '</div></aside><!-- END .sidebox .widget -->';
			}

			if( $area == 'footer-area-2' ) {
				// Display social widget
				$ac_widget_rp_inst = array( 'title' => __( 'Footer Area #2', 'justwrite' ), 'twitter' => '#', 'twitter_anc' => __( 'Follow', 'justwrite' ), 'facebook' => '#', 'facebook_anc' => __( 'Facebook', 'justwrite' ), 'google-plus' => '#', 'google-plus_anc' => __( 'G+', 'justwrite' ), 'rss' => '#', 'rss_anc' => __( 'Subscribe', 'justwrite' ) );
				echo '<aside class="side-box clearfix widget ac-social-buttons-widget"><div class="sb-content clearfix">';
					the_widget( 'AC_Social_Buttons_Widget', $ac_widget_rp_inst, $ac_widgets_wrap_args );
				echo '</div></aside><!-- END .sidebox .widget -->';

				// Display text widget
				$ac_widget_rp_inst = array( 'title' => __( 'Some Text', 'justwrite' ), 'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s' );
				echo '<aside class="side-box clearfix widget ac-social-buttons-widget"><div class="sb-content clearfix">';
					the_widget( 'WP_Widget_Text', $ac_widget_rp_inst, $ac_widgets_wrap_args );
				echo '</div></aside><!-- END .sidebox .widget -->';
			}

			if( $area == 'footer-area-3' ) {
				// Display calendar widget
				$ac_widget_rp_inst = array( 'title' => __( 'Footer Area #3', 'justwrite' ) );
				echo '<aside class="side-box clearfix widget ac-social-buttons-widget"><div class="sb-content clearfix">';
					the_widget( 'WP_Widget_Calendar', $ac_widget_rp_inst, $ac_widgets_wrap_args );
				echo '</div></aside><!-- END .sidebox .widget -->';
			}

			if( $area == 'footer-area-4' ) {
				// Display text widget
				$ac_widget_rp_inst = array( 'title' => __( 'Footer Area #4', 'justwrite' ), 'text' => '<p>Dummy text variations of passages of Lorem Ipsum available, but the majority have suffered. If you are going to use a passage of Lorem Ipsum.</p><p>Alteration in some form, by injected humour, or randomised words which dont look even slightly believable.</p>' );
				echo '<aside class="side-box clearfix widget ac-social-buttons-widget"><div class="sb-content clearfix">';
					the_widget( 'WP_Widget_Text', $ac_widget_rp_inst, $ac_widgets_wrap_args );
				echo '</div></aside><!-- END .sidebox .widget -->';

				// Notice
				echo $notice3;
			}
		} else {
			return;
		}
	}

}



/*  Social sharing action
/* ------------------------------------ */
if ( ! function_exists( 'ac_action_show_social_sharing' ) ) {

	function ac_action_show_social_sharing( $output = '', $echo = true ) {
		$more_btns = apply_filters( 'ac_action_show_social_sharing_filter', $more_btns = '' );
		$kses_args = array( 'a' => array( 'href' => array(), 'class' => 'array' ), 'i' => array( 'class' => array() ), 'span' => array( 'class' => array() ) );
		$output .= '<span class="s-social">';
			$output .= '<a href="https://twitter.com/intent/tweet?url=' . esc_url( get_permalink() ) . '" class="social-btn twitter"><i class="fa fa-twitter"></i></a>';
			$output .= '<a href="https://www.facebook.com/sharer/sharer.php?u=' . esc_url( get_permalink() ) . '" class="social-btn facebook"><i class="fa fa-facebook"></i></a>';
			$output .= '<a href="https://plus.google.com/share?url=' . esc_url( get_permalink() ) . '" class="social-btn google-plus"><i class="fa fa-google-plus"></i> </a>';
			$output .= $more_btns;
		$output .='</span>';

		if( $echo ) {
			echo wp_kses( $output, $kses_args );
		} else {
			return wp_kses( $output );
		}
	}

}
add_action( 'ac_action_thumbnail_after', 'ac_action_show_social_sharing' );



/*  Plugins Compatibility
/* ------------------------------------ */

// WP Product Review -- Unregister FontAwesome
if ( ! function_exists( 'ac_compatibility_unreg_icons' ) ) {

	function ac_compatibility_unreg_icons() {
		 wp_deregister_style( 'cwp-pac-fontawesome-stylesheet' );
	}

}
add_action( 'init', 'ac_compatibility_unreg_icons' );



/*  TGM Setup & Plugins
/* ------------------------------------ */
if ( ! function_exists( 'ac_register_required_plugins' ) ) {
	function ac_register_required_plugins() {

	    $plugins = array(

			array(
	            'name'      => 'Contact Form 7',
	            'slug'      => 'contact-form-7',
	            'required'  => false,
	        ),

	    );

		$config = array(
			'id'           => 'justwrite',             // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',
			'strings'      => array(
				'notice_can_install_recommended' => _n_noop( '<em><a class="ac-pro-theme-link" target="_blank" href="http://www.acosmin.com/theme/justwrite-pro/?utm_campaign=justwrite_tgm_btn">JustWrite Pro with WooCommerce compatibility</a></em> in now available. Also, this theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'justwrite' ),
			)
		);

	    tgmpa( $plugins, $config );

	}
}
add_action( 'tgmpa_register', 'ac_register_required_plugins' );
