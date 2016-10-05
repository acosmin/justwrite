<?php
/* ------------------------------------------------------------------------- *
 *  WordPress Customise Options
/* ------------------------------------------------------------------------- */



/*  This will output css
/* ------------------------------------ */
function ac_generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {
      $return = '';
      $mod = get_theme_mod($mod_name);
      if ( ! empty( $mod ) ) {
         $return = sprintf('%s{%s:%s;}',
            $selector,
            $style,
            $prefix.$mod.$postfix
         );
         if ( $echo ) {
            echo $return;
         }
      }
      return $return;
}



/*  Converts hex to rgb vaules
/* ------------------------------------ */
function ac_hex2rgb($hex) {
	$hex = str_replace("#", "", $hex);
	
	if(strlen($hex) == 3) {
	  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
	  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
	  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
	  $r = hexdec(substr($hex,0,2));
	  $g = hexdec(substr($hex,2,2));
	  $b = hexdec(substr($hex,4,2));
	}
   
   	echo $r . ',' . $g . ','. $b;
}



/*  Converts hex to rgba vaules
/* ------------------------------------ */
function ac_hex2rgba($hex, $alpha = 1, $ret = false) {
	$hex = str_replace("#", "", $hex);
	
	if(strlen($hex) == 3) {
	  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
	  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
	  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
	  $r = hexdec(substr($hex,0,2));
	  $g = hexdec(substr($hex,2,2));
	  $b = hexdec(substr($hex,4,2));
	}
	
	$output = $r . ',' . $g . ','. $b . ',' . $alpha;
	
	if( $ret ) {
		return $output;
	} else {
		echo $output;
	}
}



/*  Check if option is not changed
/* ------------------------------------ */
function ac_checkdefault($mod_name, $default) {
	$mod = get_theme_mod($mod_name);
	if ( $mod != $default || $mod == '')	{
		return true;
	} 
}



/*  Sanitize stuff
/* ------------------------------------ */
// Checkbox
function ac_sanitize_checkbox( $input ) {
	if ( $input == 1 ) {
		return 1;
	} else {
		return 0;
	}
}

// Select Font Family
function ac_sanitize_ff( $fontfamily ) {
	if ( ! in_array( $fontfamily, array( 'style1', 'style2', 'style3', 'style4' ) ) ) {
		$fontfamily = 'style1';
	}
	return $layout;
}

// Ads
function ac_sanitize_ads( $input ) {
	global $allowedposttags;
	
	$custom_allowedtags["embed"] = array(
		"src" => array(),
      	"type" => array(),
      	"allowfullscreen" => array(),
      	"allowscriptaccess" => array(),
      	"height" => array(),
		"width" => array()
	);
	
	$custom_allowedtags["script"] = array(
		"type" => array(),
		"async" => array(),
		"src" => array(),
	);
	
	$allowedposttags["ins"] = array(
		"data-ad-client" => array(),
		"data-ad-slot" => array(),
		"class" => array(),
		"style" => array(),
	);
	
	$custom_allowedtags = array_merge($custom_allowedtags, $allowedposttags);
	$output = wp_kses( $input, $custom_allowedtags);
	
    return $output;
}



/*  Customisation Function
/* ------------------------------------ */
function ac_customize_init($wp_customize) {
	
	// Variables
	$main_color 		= '#e1e1e1';
	$locations      	= get_registered_nav_menus();
	$menus          	= wp_get_nav_menus();
	$menu_locations 	= get_nav_menu_locations();
	$num_locations  	= count( array_keys( $locations ) );
	$filtered_options	= '';
	
	// Select Options
	$choices = array( 0 => __( '&mdash; Select &mdash;', 'justwrite' ) );
	foreach ( $menus as $menu ) {
		$choices[ $menu->term_id ] = wp_html_excerpt( $menu->name, 40, '&hellip;' );
	}
	
	// Remove some of the default sections
	$wp_customize->remove_section( 'static_front_page' );
	$wp_customize->remove_section( 'nav' );
	
	// Get some settings
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	
	// Add new panels
	$wp_customize->add_panel( 'ac_panel_header_options', array(
	  'title' 				=> __( 'Header Options', 'justwrite' ),
	  'priority'			=> 35
	) );
	$wp_customize->add_panel( 'ac_panel_layout_options', array(
	  'title' 				=> __( 'Layout Options', 'justwrite' ),
	  'priority'			=> 36
	) );
	$wp_customize->add_panel( 'ac_panel_global_options', array(
	  'title' 				=> __( 'Global Options', 'justwrite' ),
	  'priority'			=> 37
	) );
	
	
	
	// Add new sections
	$wp_customize->add_section( 'ac_customize_logo', array(
    	'title'				=> __( 'Logo and Description', 'justwrite' ),
		'panel'				=> 'ac_panel_header_options',
    	'priority'			=> 1
	) );
	$wp_customize->add_section( 'ac_customize_header', array(
    	'title'				=> __( 'Header', 'justwrite' ),
		'panel'				=> 'ac_panel_header_options',
    	'priority'			=> 2
	) );
	$wp_customize->add_section( 'ac_customize_top_menu', array(
    	'title'				=> __( 'Main Menu', 'justwrite' ),
		'panel'				=> 'ac_panel_header_options',
    	'priority'			=> 3
	) );
	$wp_customize->add_section( 'ac_customize_content', array(
    	'title'				=> __( 'Basic Options', 'justwrite' ),
		'panel'				=> 'ac_panel_global_options',
    	'priority'			=> 1,
	) );
	$wp_customize->add_section( 'ac_customize_links', array(
    	'title'				=> __( 'Global Links Colors', 'justwrite' ),
		'description'		=> __( '<small>* Applies to some sub-menus, mini-sidebar, sidebar, post content and basic link color.</small>', 'justwrite' ),
		'panel'				=> 'ac_panel_global_options',
    	'priority'			=> 2,
	) );
	$wp_customize->add_section( 'ac_customize_bgs', array(
    	'title'				=> __( 'Global Background Colors', 'justwrite' ),
		'panel'				=> 'ac_panel_global_options',
    	'priority'			=> 3,
	) );
	$wp_customize->add_section( 'ac_customize_borders', array(
    	'title'				=> __( 'Global Border Colors', 'justwrite' ),
		'panel'				=> 'ac_panel_global_options',
    	'priority'			=> 4,
	) );
	$wp_customize->add_section( 'ac_customize_gfc', array(
    	'title'				=> __( 'Global Fonts Colors', 'justwrite' ),
		'panel'				=> 'ac_panel_global_options',
    	'priority'			=> 5,
	) );
	$wp_customize->add_section( 'ac_customize_slider', array(
    	'title'				=> __( 'Slider', 'justwrite' ),
		'panel'				=> 'ac_panel_layout_options',
		'description'		=> __( '<small>* Some of the options are disabled:</small><br><small><b class="ac_pro-option">Pro Option</b>: Select an offset.</small><br /><small><b class="ac_pro-option">Pro Option</b>: Show slider in category archives.</small><br><br><a href="http://www.acosmin.com/theme/justwrite-pro/" class="button button-primary ac_btn-inner-section" target="_blank">JustWrite Pro</a><br><span class="ac_divider"></span><br><small>* You need at least 3 posts marked as featured for the slider to show up.</small><br><small>* When you post an article click on "Mark this post as featured".</small>', 'justwrite' ),
    	'priority'			=> 1,
	) );
	$wp_customize->add_section( 'ac_customize_advertising', array(
    	'title'				=> __( 'Advertising', 'justwrite' ),
		'panel'				=> 'ac_panel_layout_options',
    	'priority'			=> 2,
	) );
	$wp_customize->add_section( 'ac_customize_minisidebar', array(
    	'title'				=> __( 'Mini-Sidebar', 'justwrite' ),
		'panel'				=> 'ac_panel_layout_options',
		'description'		=> __( '<small>* If you add or change a menu title save your changes.</small>', 'justwrite' ),
		'priority'			=> 3,
	) );
	$wp_customize->add_section( 'ac_customize_misc', array(
    	'title'				=> __( 'Miscellaneous', 'justwrite' ),
		'panel'				=> 'ac_panel_layout_options',
		'priority'			=> 4,
	) );
	$wp_customize->add_section( 'ac_customize_posts', array(
    	'title'				=> __( 'Posts', 'justwrite' ),
		'panel'				=> 'ac_panel_layout_options',
		'description'		=> __( '<small>Some of the options are disabled:</small><br><small><b class="ac_pro-option">Pro Option</b>: Select "Right Thumbnail" option.</small><br><small><b class="ac_pro-option">Pro Option</b>: Show posts in a Masonry grid (2 columns)</small><br><small><b class="ac_pro-option">Pro Option</b>: Billboard Parallax layout for single posts</small><br><br><a href="http://www.acosmin.com/theme/justwrite-pro/" class="button button-primary ac_btn-inner-section" target="_blank">JustWrite Pro</a>', 'justwrite' ),
		'priority'			=> 5,
	) );
	$wp_customize->add_section( 'ac_customize_social', array(
		'title' 				=> __( 'Social Options', 'justwrite' ),
		'priority'			=> 42,
	) );
	$wp_customize->add_section( 'ac_customize_footer', array(
    	'title'				=> __( 'Footer Options', 'justwrite' ),
    	'priority'			=> 44,
	) );
	/* Upsell Sections */
	$wp_customize->add_section( 'ac_customize_woocommerce', array(
    	'title'				=> __( 'WooCommerce', 'justwrite' ),
		'description'		=> __( '<small><b class="ac_pro-option">Pro Option</b></small>: <b>WooCommerce</b> compatibility and support is available only with <b>JustWrite Pro</b>.<br /><br /><a href="http://www.acosmin.com/theme/justwrite-pro/" class="button button-primary ac_btn-inner-section" target="_blank">JustWrite Pro</a>', 'justwrite' ),
    	'priority'			=> 46,
	) );
	$wp_customize->add_section( 'ac_customize_colorfulcats', array(
    	'title'				=> __( 'Colorful Categories', 'justwrite' ),
		'description'		=> __( '<small><b class="ac_pro-option">Pro Option</b></small>: <b>Colorful Categories</b> is available only with <b>JustWrite Pro</b>.<br /><br /><a href="http://www.acosmin.com/theme/justwrite-pro/" class="button button-primary ac_btn-inner-section" target="_blank">JustWrite Pro</a>', 'justwrite' ),
    	'priority'			=> 47,
	) );
	
	
	
	
	// Add new settings
	// -- Logo
	$wp_customize->add_setting( 'ac_logo_image', array(
    	'default'			=> '',
		'sanitize_callback' => 'esc_url_raw',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_logo_centered', array(
    	'default'			=> false,
		'sanitize_callback' => 'ac_sanitize_checkbox',
    	'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'ac_color_logo', array(
		'default'			=> '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_description', array(
    	'default'			=> '#666666',
		'sanitize_callback' => 'sanitize_hex_color',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_show_description', array(
    	'default'			=> true,
		'sanitize_callback' => 'ac_sanitize_checkbox',
    	'capability'		=> 'edit_theme_options',
	) );
	// -- Header
	$wp_customize->add_setting( 'ac_background_color_header', array(
		'default'			=> '#111111',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_background_image_header', array(
		'default'			=> '',
		'sanitize_callback' => 'esc_url_raw',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_border_color_header', array(
		'default'			=> $main_color,
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	// -- Main Menu
	$wp_customize->add_setting( 'ac_disable_stickymenu', array(
		'sanitize_callback' => 'ac_sanitize_checkbox',
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'ac_disable_menu_social', array(
		'sanitize_callback' => 'ac_sanitize_checkbox',
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'ac_disable_menu_social_fixed', array(
		'sanitize_callback' => 'ac_sanitize_checkbox',
		'default'			=> true,
		'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'nav_menu_locations[main]', array(
		'default'			=> 0,
		'sanitize_callback' => 'absint',
		'capability'		=> 'edit_theme_options',
		'theme_supports'    => 'menus',
	) );
	$wp_customize->add_setting( 'ac_border_color_top_menu', array(
		'default'			=> $main_color,
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_border_color_top_menu_bot', array(
		'default'			=> $main_color,
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_border_color_top_menu_inn', array(
		'default'			=> $main_color,
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'ac_background_color_top_menu', array(
		'default'			=> '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_top_menu_links', array(
		'default'			=> '#444444',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_top_menu_submenu_links', array(
		'default'			=> '#dd3333',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_top_menu_links_hover', array(
		'default'			=> '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_top_menu_links_active', array(
		'default'			=> '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_background_color_top_menu_bubble', array(
		'default'			=> '#c33c33',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'ac_color_top_menu_bubble', array(
		'default'			=> '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'ac_top_menu_mobile_break', array(
    	'default'			=> '1140',
		'sanitize_callback' => 'sanitize_text_field',
    	'capability'		=> 'edit_theme_options',
	) );
	// -- Content
	$wp_customize->add_setting( 'ac_font_select', array(
		'default'			=> 'style5',
		'sanitize_callback' => 'sanitize_text_field',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_setting( 'ac_border_color_content', array(
		'default'			=> $main_color,
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_border_color_dd3333', array(
		'default'			=> '#dd3333',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_border_color_000000', array(
		'default'			=> '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_border_color_666666', array(
		'default'			=> '#666666',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_444', array(
		'default'			=> '#444444',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_dd3333', array(
		'default'			=> '#dd3333',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		//'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_hover', array(
		'default'			=> '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		//'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_000', array(
		'default'			=> '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_666', array(
		'default'			=> '#666666',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_222', array(
		'default'			=> '#222222',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_333', array(
		'default'			=> '#333333',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_bbb', array(
		'default'			=> '#bbbbbb',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_aaa', array(
		'default'			=> '#aaaaaa',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	// -- Global Background Colors
	$wp_customize->add_setting( 'ac_background_color_fff', array(
		'default'			=> '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_background_color_dd3333', array(
		'default'			=> '#dd3333',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_background_color_e1e1e1', array(
		'default'			=> '#e1e1e1',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_background_color_f7f7f7', array(
		'default'			=> '#f7f7f7',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_background_color_f2f2f2', array(
		'default'			=> '#f2f2f2',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_background_color_000', array(
		'default'			=> '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_background_color_333', array(
		'default'			=> '#333333',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	// -- Mini Sidebar
	$wp_customize->add_setting( 'ac_mini_first_title', array(
    	'default'			=> __( 'ex: Categories', 'justwrite' ),
		'sanitize_callback' => 'sanitize_text_field',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'nav_menu_locations[mini-first]', array(
		'default'			=> 0,
		'sanitize_callback' => 'absint',
		'capability'		=> 'edit_theme_options',
		'theme_supports'    => 'menus',
	) );
	$wp_customize->add_setting( 'ac_mini_second_title', array(
    	'default'			=> __( 'ex: Blogroll', 'justwrite' ),
		'sanitize_callback' => 'sanitize_text_field',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'nav_menu_locations[mini-second]', array(
		'default'			=> 0,
		'sanitize_callback' => 'absint',
		'capability'		=> 'edit_theme_options',
		'theme_supports'    => 'menus',
	) );
	$wp_customize->add_setting( 'ac_disable_minisidebar', array(
		'default'			=> false,
		'sanitize_callback' => 'ac_sanitize_checkbox',
		'capability'		=> 'edit_theme_options',
	) );
	// -- Slider
	$wp_customize->add_setting( 'ac_enable_slider', array(
		'sanitize_callback' => 'ac_sanitize_checkbox',
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'ac_enable_slider_cat', array(
		'sanitize_callback' => 'ac_sanitize_checkbox',
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'ac_autostart_slider', array(
		'sanitize_callback' => 'ac_sanitize_checkbox',
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'ac_slides_nr_select', array(
		'default'			=> 3,
		'sanitize_callback' => 'absint',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_setting( 'ac_slider_delay', array(
    	'default'			=> '5000',
		'sanitize_callback' => 'sanitize_text_field',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_setting( 'ac_slider_offset', array(
    	'default'			=> 0,
		'sanitize_callback' => 'absint',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'refresh',
	) );
	// -- Advertising
	$wp_customize->add_setting( 'ac_enable_728px_ad', array(
		'sanitize_callback' => 'ac_sanitize_checkbox',
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'ac_enable_728px_code', array(
    	'default'			=> '',
		'sanitize_callback' => 'ac_sanitize_ads',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_setting( 'ac_enable_160px_ad', array(
		'sanitize_callback' => 'ac_sanitize_checkbox',
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'ac_enable_160px_code', array(
    	'default'			=> '',
		'sanitize_callback' => 'ac_sanitize_ads',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_setting( 'ac_enable_160px_title', array(
    	'default'			=> '',
		'sanitize_callback' => 'sanitize_text_field',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_enable_160px_link', array(
    	'default'			=> '',
		'sanitize_callback' => 'sanitize_text_field',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	// -- Misc
	$wp_customize->add_setting( 'ac_disable_comments', array(
		'sanitize_callback' => 'ac_sanitize_checkbox',
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'ac_disable_about_box', array(
		'sanitize_callback' => 'ac_sanitize_checkbox',
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'ac_disable_credit', array(
		'sanitize_callback' => 'ac_sanitize_checkbox',
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'ac_disable_child_fonst_style', array(
		'sanitize_callback' => 'ac_sanitize_checkbox',
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'ac_disable_demo_widgets', array(
		'sanitize_callback' => 'ac_sanitize_checkbox',
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
	) );
	if ( ! function_exists( 'has_site_icon' ) ) {
	$wp_customize->add_setting( 'ac_favicon_image', array(
    	'default'			=> '',
		'sanitize_callback' => 'esc_url_raw',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'refresh',
	) ); }
	// -- Posts
	$wp_customize->add_setting( 'ac_main_posts_layout', array(
		'default'			=> 'lthumb',
		'sanitize_callback' => 'sanitize_text_field',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_setting( 'ac_enable_posts_masonry', array(
		'sanitize_callback' => 'ac_sanitize_checkbox',
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'ac_enable_posts_masonry_excerpt', array(
		'sanitize_callback' => 'ac_sanitize_checkbox',
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'ac_split_posts_masonry', array(
    	'default'			=> 2,
		'sanitize_callback' => 'absint',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_setting( 'ac_disable_index_posts', array(
		'sanitize_callback' => 'ac_sanitize_checkbox',
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'ac_single_post_layout_select', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'			=> 'ac_post_layout_normal',
		'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'ac_single_post_opacity_select', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'			=> '0.5',
		'capability'		=> 'edit_theme_options',
	) );
	// -- Social
	$wp_customize->add_setting( 'ac_social_profile_gp', array(
    	'default'			=> '',
		'sanitize_callback' => 'sanitize_text_field',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_setting( 'ac_social_profile_fb', array(
    	'default'			=> '',
		'sanitize_callback' => 'sanitize_text_field',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_setting( 'ac_social_profile_tw', array(
    	'default'			=> '',
		'sanitize_callback' => 'sanitize_text_field',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_setting( 'ac_social_profile_rss', array(
    	'default'			=> '',
		'sanitize_callback' => 'sanitize_text_field',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'refresh',
	) );
	// -- Footer
	$wp_customize->add_setting( 'ac_footer_logo_text', array(
    	'default'			=> 'JustWrite',
		'sanitize_callback' => 'sanitize_text_field',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_footer_copyright_text', array(
    	'default'			=> 'Copyright 2013 JUSTWRITE. All rights reserved.',
		'sanitize_callback' => 'sanitize_text_field',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_disable_widgetized_footer', array(
		'sanitize_callback' => 'ac_sanitize_checkbox',
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
	) );
	// Upsell
	$wp_customize->add_setting( 'ac_upsell_woocommerce', array(
    	'default'			=> false,
		'sanitize_callback' => 'ac_sanitize_checkbox',
    	'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'ac_upsell_colorfulcats', array(
    	'default'			=> false,
		'sanitize_callback' => 'ac_sanitize_checkbox',
    	'capability'		=> 'edit_theme_options',
	) );
	
	
	
	
	// Add new controls
	// -- Logo
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ac_logo_image', array(
    	'label'				=> __( 'Logo - Image', 'justwrite' ),
    	'section'			=> 'ac_customize_logo',
    	'settings'			=> 'ac_logo_image',
	) ) );
	$wp_customize->add_control('ac_logo_centered', array(
		'label'    			=> __( 'Center align the logo', 'justwrite' ),
		'description' 		=> __( 'You will not be able to disaply an Ad banner', 'justwrite' ),
		'settings' 			=> 'ac_logo_centered',
		'section'  			=> 'ac_customize_logo',
		'type'     			=> 'checkbox',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_logo', array(
		'label'				=> __( 'Logo - Font Color', 'justwrite' ),
		'section'			=> 'ac_customize_logo',
		'settings'			=> 'ac_color_logo',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_description', array(
		'label'				=> __( 'Description - Font Color', 'justwrite' ),
		'section'			=> 'ac_customize_logo',
		'settings'			=> 'ac_color_description',
	) ) );
	$wp_customize->add_control('ac_show_description', array(
		'label'    			=> __( 'Show description', 'justwrite' ),
		'description' 		=> __( 'It will only show up if you do not have an Ad banner enabled', 'justwrite' ),
		'settings' 			=> 'ac_show_description',
		'section'  			=> 'ac_customize_logo',
		'type'     			=> 'checkbox',
	));
	// -- Header
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_background_color_header', array(
		'label'				=> __( 'Header - Background Color', 'justwrite' ),
		'section'			=> 'ac_customize_header',
		'settings'			=> 'ac_background_color_header',
	) ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ac_background_image_header', array(
    	'label'				=> __( 'Header - Background Image', 'justwrite' ),
    	'section'			=> 'ac_customize_header',
    	'settings'			=> 'ac_background_image_header',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_border_color_header', array(
		'label'				=> __( 'Header - Bottom Border Color', 'justwrite' ),
		'section'			=> 'ac_customize_header',
		'settings'			=> 'ac_border_color_header',
	) ) );
	// -- Main Menu
	$wp_customize->add_control('ac_disable_stickymenu', array(
		'settings' => 'ac_disable_stickymenu',
		'label'    => __( 'Disable Fixed Style', 'justwrite' ),
		'section'  => 'ac_customize_top_menu',
		'type'     => 'checkbox',
	));
	$wp_customize->add_control('ac_disable_menu_social', array(
		'settings' => 'ac_disable_menu_social',
		'label'    => __( 'Show social profiles', 'justwrite' ),
		'section'  => 'ac_customize_top_menu',
		'type'     => 'checkbox',
	));
	$wp_customize->add_control('ac_disable_menu_social_fixed', array(
		'settings' => 'ac_disable_menu_social_fixed',
		'label'    => __( 'Show social profiles only when the menu is in fixed state', 'justwrite' ),
		'section'  => 'ac_customize_top_menu',
		'type'     => 'checkbox',
	));
	$wp_customize->add_control( 'nav_menu_locations[main]', array(
		'label'				=> __( 'Select a menu', 'justwrite' ),
		'section'			=> 'ac_customize_top_menu',
		'settings'			=> 'nav_menu_locations[main]',
		'type'   			=> 'select',
		'choices'			=> $choices
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_border_color_top_menu', array(
		'label'				=> __( 'Border color', 'justwrite' ),
		'section'			=> 'ac_customize_top_menu',
		'settings'			=> 'ac_border_color_top_menu',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_border_color_top_menu_bot', array(
		'label'				=> __( 'Bottom border color', 'justwrite' ),
		'section'			=> 'ac_customize_top_menu',
		'settings'			=> 'ac_border_color_top_menu_bot',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_border_color_top_menu_inn', array(
		'label'				=> __( 'Inner borders color', 'justwrite' ),
		'section'			=> 'ac_customize_top_menu',
		'settings'			=> 'ac_border_color_top_menu_inn',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_background_color_top_menu', array(
		'label'				=> __( 'Background color', 'justwrite' ),
		'section'			=> 'ac_customize_top_menu',
		'settings'			=> 'ac_background_color_top_menu',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_top_menu_links', array(
		'label'				=> __( 'Main links color', 'justwrite' ),
		'section'			=> 'ac_customize_top_menu',
		'settings'			=> 'ac_color_top_menu_links',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_top_menu_links_hover', array(
		'label'				=> __( 'Main links color / Hover', 'justwrite' ),
		'section'			=> 'ac_customize_top_menu',
		'settings'			=> 'ac_color_top_menu_links_hover',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_top_menu_submenu_links', array(
		'label'				=> __( 'Sub-menu links color', 'justwrite' ),
		'section'			=> 'ac_customize_top_menu',
		'settings'			=> 'ac_color_top_menu_submenu_links',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_top_menu_links_active', array(
		'label'				=> __( 'Main links color / Active', 'justwrite' ),
		'section'			=> 'ac_customize_top_menu',
		'settings'			=> 'ac_color_top_menu_links_active',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_background_color_top_menu_bubble', array(
		'label'				=> __( 'Bubble background color', 'justwrite' ),
		'section'			=> 'ac_customize_top_menu',
		'settings'			=> 'ac_background_color_top_menu_bubble',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_top_menu_bubble', array(
		'label'				=> __( 'Bubble font color', 'justwrite' ),
		'section'			=> 'ac_customize_top_menu',
		'settings'			=> 'ac_color_top_menu_bubble',
	) ) );
	$wp_customize->add_control( 'ac_top_menu_mobile_break', array(
    	'label'				=> __( 'Mobile Menu', 'justwrite' ),
		'description'		=> __( 'Set the width (in pixels) at which point you want the mobile menu to appear. It helps if you have a lot of menu items and you do not want them to overlap. Minimum width is 1140, you can try 1300.', 'justwrite' ),
    	'section'			=> 'ac_customize_top_menu',
    	'settings'			=> 'ac_top_menu_mobile_break',
	) );
	// -- Global Links Colors
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_dd3333', array(
		'label'				=> __( 'Links - Link/Visited states', 'justwrite' ),
		'section'			=> 'ac_customize_links',
		'settings'			=> 'ac_color_dd3333',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_hover', array(
		'label'				=> __( 'Links - Hover state', 'justwrite' ),
		'section'			=> 'ac_customize_links',
		'settings'			=> 'ac_color_hover',
	) ) );
	// -- Global Fonts Colors
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_000', array(
		'section'			=> 'ac_customize_gfc',
		'label'				=> __( 'Widgets titles + more', 'justwrite' ),
		'description'		=> __( 'Applies to columns, sidebars headings and some buttons colors', 'justwrite' ),
		'settings'			=> 'ac_color_000',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_666', array(
		'section'			=> 'ac_customize_gfc',
		'label'				=> __( 'Sections titles', 'justwrite' ),
		'description'		=> __( 'Also applies to links activ state in mini-sidebar', 'justwrite' ),
		'settings'			=> 'ac_color_666'
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_222', array(
		'section'			=> 'ac_customize_gfc',
		'label'				=> __( 'Posts links', 'justwrite' ),
		// 'description'		=> __( 'Also applies to links activ state in mini-sidebar', 'justwrite' ),
		'settings'			=> 'ac_color_222',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_333', array(
		'section'			=> 'ac_customize_gfc',
		'label'				=> __( 'Posts links hover state', 'justwrite' ),
		// 'description'		=> __( 'Also applies to links activ state in mini-sidebar', 'justwrite' ),
		'settings'			=> 'ac_color_333',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_bbb', array(
		'section'			=> 'ac_customize_gfc',
		'label'				=> __( 'Other links', 'justwrite' ),
		'description'		=> __( 'Applies to bright colored links (categories, some icons, copyright)', 'justwrite' ),
		'settings'			=> 'ac_color_bbb',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_aaa', array(
		'section'			=> 'ac_customize_gfc',
		'description'		=> __( 'Applies to bright colored links (archives, author info box, blockquote text, comment date)', 'justwrite' ),
		'settings'			=> 'ac_color_aaa',
	) ) );
	// -- Global Background Colors
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_background_color_fff', array(
		'section'			=> 'ac_customize_bgs',
		'label'				=> __( 'Body background color', 'justwrite' ),
		'description'		=> __( 'Or anything with a white bg', 'justwrite' ),
		'settings'			=> 'ac_background_color_fff',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_background_color_dd3333', array(
		'section'			=> 'ac_customize_bgs',
		'label'				=> __( 'Main background color', 'justwrite' ),
		'description'		=> __( 'Applies to categories, dates info and a few more', 'justwrite' ),
		'settings'			=> 'ac_background_color_dd3333',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_background_color_f7f7f7', array(
		'section'			=> 'ac_customize_bgs',
		'label'				=> __( 'Section title', 'justwrite' ),
		'description'		=> __( 'Active states for some buttons', 'justwrite' ),
		'settings'			=> 'ac_background_color_f7f7f7',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_background_color_000', array(
		'section'			=> 'ac_customize_bgs',
		'label'				=> __( 'Date background color', 'justwrite' ),
		'settings'			=> 'ac_background_color_000',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_background_color_333', array(
		'section'			=> 'ac_customize_bgs',
		'label'				=> __( 'Popular posts section', 'justwrite' ),
		'settings'			=> 'ac_background_color_333',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_background_color_e1e1e1', array(
		'section'			=> 'ac_customize_bgs',
		'label'				=> __( 'Misc areas', 'justwrite' ),
		'settings'			=> 'ac_background_color_e1e1e1',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_background_color_f2f2f2', array(
		'section'			=> 'ac_customize_bgs',
		'settings'			=> 'ac_background_color_f2f2f2',
	) ) );
	// -- Global Borders Colors
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_border_color_content', array(
		'label'				=> __( 'Main border color', 'justwrite' ),
		'section'			=> 'ac_customize_borders',
		'settings'			=> 'ac_border_color_content',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_border_color_dd3333', array(
		'label'				=> __( 'Other border colors', 'justwrite' ),
		'section'			=> 'ac_customize_borders',
		'settings'			=> 'ac_border_color_dd3333',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_border_color_000000', array(
		'section'			=> 'ac_customize_borders',
		'settings'			=> 'ac_border_color_000000',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_border_color_666666', array(
		'section'			=> 'ac_customize_borders',
		'settings'			=> 'ac_border_color_666666',
	) ) );
	// -- Content
	$wp_customize->add_control('ac_font_select', array(
        'label'				=> __('Select a font family', 'justwrite'),
        'section'    		=> 'ac_customize_content',
        'settings'   		=> 'ac_font_select',
        'type'       		=> 'select',
		'choices'			=> array( 
									'style1' => 'Style #1',
									'style2' => 'Style #2',
									'style3' => 'Style #3',
									'style4' => 'Style #4',
									'style5' => 'Style #5',
									'style6' => 'Style #6',
									'style7' => 'Style #7',
									'style8' => 'Style #8',
									'style9' => 'Style #9',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_444', array(
		'label'				=> __( 'Body font color', 'justwrite' ),
		'section'			=> 'ac_customize_content',
		'description'		=> __( 'Also applies to some dark colored links (post info links, main menu links if not selected)', 'justwrite' ),
		'settings'			=> 'ac_color_444',
	) ) );
	// -- Mini Sidebar
	$wp_customize->add_control( 'ac_mini_first_title', array(
    	'label'				=> __( 'First Menu - Title', 'justwrite' ),
    	'section'			=> 'ac_customize_minisidebar',
    	'settings'			=> 'ac_mini_first_title',
	) );
	$wp_customize->add_control( 'nav_menu_locations[mini-first]', array(
		'label'				=> __( 'First Menu - Select', 'justwrite' ),
		'section'			=> 'ac_customize_minisidebar',
		'settings'			=> 'nav_menu_locations[mini-first]',
		'type'   			=> 'select',
		'choices'			=> $choices
	) );
	$wp_customize->add_control( 'ac_mini_second_title', array(
    	'label'				=> __( 'Second Menu - Title', 'justwrite' ),
    	'section'			=> 'ac_customize_minisidebar',
    	'settings'			=> 'ac_mini_second_title',
	) );
	$wp_customize->add_control( 'nav_menu_locations[mini-second]', array(
		'label'				=> __( 'Second Menu - Select', 'justwrite' ),
		'section'			=> 'ac_customize_minisidebar',
		'settings'			=> 'nav_menu_locations[mini-second]',
		'type'   			=> 'select',
		'choices'			=> $choices
	) );
	$wp_customize->add_control('ac_disable_minisidebar', array(
		'settings' => 'ac_disable_minisidebar',
		'label'    => __( 'Disable Mini-Sidebar', 'justwrite' ),
		'section'  => 'ac_customize_minisidebar',
		'type'     => 'checkbox',
	));
	// -- Slider
	$wp_customize->add_control('ac_enable_slider', array(
		'settings' => 'ac_enable_slider',
		'label'    => __( 'Show Featured Posts Slider', 'justwrite' ),
		'section'  => 'ac_customize_slider',
		'type'     => 'checkbox',
	));
	$wp_customize->add_control('ac_enable_slider_cat', array(
		'settings' 		=> 'ac_enable_slider_cat',
		'label'    		=> __( 'Show Featured Posts in category archives', 'justwrite' ),
		'description'	=> __( 'It will show featured posts from that category', 'justwrite' ),
		'section'  		=> 'ac_customize_slider',
		'type'     		=> 'checkbox',
	));
	$wp_customize->add_control('ac_autostart_slider', array(
		'settings' => 'ac_autostart_slider',
		'label'    => __( 'Enable autostart (autoscrolling)', 'justwrite' ),
		'section'  => 'ac_customize_slider',
		'type'     => 'checkbox',
	));
	$wp_customize->add_control('ac_slides_nr_select', array(
        'label'				=> __('Select how many posts you would like to display.', 'justwrite'),
        'section'    		=> 'ac_customize_slider',
        'settings'   		=> 'ac_slides_nr_select',
        'type'       		=> 'select',
		'choices'			=> array( 
									3 	=> __('Three', 'justwrite'),
									4 	=> __('Four', 'justwrite'),
									5 	=> __('Five', 'justwrite'),
									6 	=> __('Six', 'justwrite'),
									7 	=> __('Seven', 'justwrite'),
									8 	=> __('Eight', 'justwrite'),
									9 	=> __('Nine', 'justwrite'),
									10 	=> __('Ten', 'justwrite'),
									
	) ) );
	$wp_customize->add_control( 'ac_slider_delay', array(
    	'label'				=> __( 'Transition Delay', 'justwrite' ),
    	'section'			=> 'ac_customize_slider',
    	'settings'			=> 'ac_slider_delay',
	) );
	$wp_customize->add_control( 'ac_slider_offset', array(
    	'label'				=> __( 'Offset', 'justwrite' ),
		'description'		=> __( 'Number of posts to "displace" or pass over', 'justwrite' ),
    	'section'			=> 'ac_customize_slider',
    	'settings'			=> 'ac_slider_offset',
	) );
	// -- Advertising
	$wp_customize->add_control('ac_enable_728px_ad', array(
		'settings' 		=> 'ac_enable_728px_ad',
		'label'    		=> __( '728x90px Ad', 'justwrite' ),
		'description' 	=> __( 'Show this banner. Add the code in the following box', 'justwrite' ),
		'section'  		=> 'ac_customize_advertising',
		'type'     		=> 'checkbox',
	));
	$wp_customize->add_control('ac_enable_728px_code', array(
		'settings' 		=> 'ac_enable_728px_code',
		'label'    		=> __( '728x90px Ad HTML Code', 'justwrite' ),
		'description' 	=> __( 'Example: Google Adsense or a simple HTML banner', 'justwrite' ),
		'section'  		=> 'ac_customize_advertising',
		'type'     		=> 'textarea',
	));
	$wp_customize->add_control('ac_enable_160px_ad', array(
		'settings' 		=> 'ac_enable_160px_ad',
		'label'    		=> __( '160x600px Ad', 'justwrite' ),
		'description' 	=> __( 'Show this banner. Add the code in the following box', 'justwrite' ),
		'section'  		=> 'ac_customize_advertising',
		'type'     		=> 'checkbox',
	));
	$wp_customize->add_control('ac_enable_160px_code', array(
		'settings' 		=> 'ac_enable_160px_code',
		'label'    		=> __( '160x600px Ad HTML Code', 'justwrite' ),
		'description' 	=> __( 'Example: Google Adsense or a simple HTML banner; this banner will show up in the left sidebar on screen resolutions higher than 1600px', 'justwrite' ),
		'section'  		=> 'ac_customize_advertising',
		'type'     		=> 'textarea',
	));
	$wp_customize->add_control( 'ac_enable_160px_title', array(
    	'label'				=> __( '160x600px Title:', 'justwrite' ),
		'description' 		=> __( 'Example: Advertising. Leave this blank if you do not want a title.', 'justwrite' ),
    	'section'			=> 'ac_customize_advertising',
    	'settings'			=> 'ac_enable_160px_title',
	) );
	$wp_customize->add_control( 'ac_enable_160px_link', array(
    	'label'				=> __( '160x600px Title Link:', 'justwrite' ),
		'description' 		=> __( 'Example: http://yoursite.com/advertising', 'justwrite' ),
    	'section'			=> 'ac_customize_advertising',
    	'settings'			=> 'ac_enable_160px_link',
	) );
	// -- Misc
	if ( ! function_exists( 'has_site_icon' ) ) {
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ac_favicon_image', array(
    	'label'				=> __( 'Favicon image', 'justwrite' ),
		'description'		=> __( 'The Favicon is used as a browser and app icon for your site. Icons must be square, and at least 512px wide and tall.', 'justwrite' ),
    	'section'			=> 'ac_customize_misc',
    	'settings'			=> 'ac_favicon_image',
	) ) ); }
	$wp_customize->add_control('ac_disable_comments', array(
		'settings' 		=> 'ac_disable_comments',
		'label'    		=> __( 'Disable comments.', 'justwrite' ),
		'section'  		=> 'ac_customize_misc',
		'type'     		=> 'checkbox',
	));
	$wp_customize->add_control('ac_disable_about_box', array(
		'settings' 		=> 'ac_disable_about_box',
		'label'    		=> __( 'Disable "About The Author" box', 'justwrite' ),
		'section'  		=> 'ac_customize_misc',
		'type'     		=> 'checkbox',
	));
	$wp_customize->add_control('ac_disable_credit', array(
		'settings' 		=> 'ac_disable_credit',
		'label'    		=> __( 'Disable footer credit links', 'justwrite' ),
		'description'	=> __( 'You can show some love by leaving them enabled :)', 'justwrite' ),
		'section'  		=> 'ac_customize_misc',
		'type'     		=> 'checkbox',
	));
	$wp_customize->add_control('ac_disable_child_fonst_style', array(
		'settings' 		=> 'ac_disable_child_fonst_style',
		'label'    		=> __( 'Overwrite font style', 'justwrite' ),
		'description'	=> __( 'In case you are using a child theme and you have a font style selected, check this if you want to make some changes.', 'justwrite' ),
		'section'  		=> 'ac_customize_misc',
		'type'     		=> 'checkbox',
	));
	$wp_customize->add_control('ac_disable_demo_widgets', array(
		'settings' 		=> 'ac_disable_demo_widgets',
		'label'    		=> __( 'Disable demo widgets', 'justwrite' ),
		'description'	=> __( 'A few widgets appear when you install the theme for the first time (placeholders).', 'justwrite' ),
		'section'  		=> 'ac_customize_misc',
		'type'     		=> 'checkbox',
	));
	// -- Posts
	$wp_customize->add_control('ac_main_posts_layout', array(
        'label'				=> __( 'Posts layout:', 'justwrite' ),
		'description'		=> __( 'This is the layout for index view, not sigle view.', 'justwrite' ),
        'section'    		=> 'ac_customize_posts',
        'settings'   		=> 'ac_main_posts_layout',
        'type'       		=> 'select',
		'width'				=> '100',
		'choices'			=> array( 
									'lthumb' => 'Left thumbnail',
									'rthumb' => 'Right thumbnail',
									'nthumb' => 'No thumbnail',
	) ) );
	$wp_customize->add_control('ac_enable_posts_masonry', array(
		'settings' 		=> 'ac_enable_posts_masonry',
		'label'    		=> __( 'Enable Posts + Masonry grid', 'justwrite' ),
		'description'	=> __( 'This allows you to display posts in a more unique way, adding some of them in a masonry grid.', 'justwrite' ),
		'section'  		=> 'ac_customize_posts',
		'type'     		=> 'checkbox',
	));
	$wp_customize->add_control( 'ac_split_posts_masonry', array(
    	'label'				=> __( 'Show Masonry after X number of posts', 'justwrite' ),
		'description'		=> __( 'This works only if you enable "Posts + Masonry grid". Set it to 0 to display only a Masonry grid.', 'justwrite' ),
    	'section'			=> 'ac_customize_posts',
    	'settings'			=> 'ac_split_posts_masonry',
	) );
	$wp_customize->add_control('ac_enable_posts_masonry_excerpt', array(
		'settings' 		=> 'ac_enable_posts_masonry_excerpt',
		'label'    		=> __( 'Show excerpt for Masonry posts', 'justwrite' ),
		'section'  		=> 'ac_customize_posts',
		'type'     		=> 'checkbox',
	));
	$wp_customize->add_control('ac_disable_index_posts', array(
		'settings' 		=> 'ac_disable_index_posts',
		'label'    		=> __( 'Hide main posts query', 'justwrite' ),
		'description'	=> __( 'In case you want to use only sections.', 'justwrite' ),
		'section'  		=> 'ac_customize_posts',
		'type'     		=> 'checkbox',
	));
	$wp_customize->add_control('ac_single_post_layout_select', array(
        'label'				=> __( 'Single post layout:', 'justwrite' ),
		'description'		=> __( 'Select how all your posts should be structured. This is a global option. You can overwrite this option and change how a post looks when you edit said post ("Post Options" metabox)!', 'justwrite' ),
        'section'    		=> 'ac_customize_posts',
        'settings'   		=> 'ac_single_post_layout_select',
        'type'       		=> 'select',
		'width'				=> '100',
		'choices'			=> array( 
									'ac_post_layout_normal' => 'Normal',
									'ac_post_layout_cover' => 'Billboard',
									'ac_post_layout_cover_parallax' => 'Billboard Parallax (Pro)',
	) ) );
	$wp_customize->add_control('ac_single_post_opacity_select', array(
        'label'				=> __( 'Single billboard opacity:', 'justwrite' ),
		'description'		=> __( 'Sets the background color opacity in case you select "Billboard" above. This is a global option.', 'justwrite' ),
        'section'    		=> 'ac_customize_posts',
        'settings'   		=> 'ac_single_post_opacity_select',
        'type'       		=> 'select',
		'width'				=> '100',
		'choices'			=> array( 
									'transparent' 	=> 'Transparent',
									'0.1'			=> '10%',
									'0.2'			=> '20%',
									'0.3' 			=> '30%',
									'0.4' 			=> '40%',
									'0.5' 			=> '50%',
									'0.6' 			=> '60%',
									'0.7' 			=> '70%',
									'0.8' 			=> '80%',
									'0.9' 			=> '90%',
									'1' 			=> '100%',
	) ) );
	// -- Social
	$wp_customize->add_control( 'ac_social_profile_gp', array(
    	'label'				=> __( 'Google Plus', 'justwrite' ),
		'description'		=> __( 'Example: <b>https://plus.google.com/+acosmin</b>', 'justwrite' ),
    	'section'			=> 'ac_customize_social',
    	'settings'			=> 'ac_social_profile_gp',
	) );
	$wp_customize->add_control( 'ac_social_profile_fb', array(
    	'label'				=> __( 'Facebook', 'justwrite' ),
		'description'		=> __( 'Example: <b>https://www.facebook.com/acosmincom</b>', 'justwrite' ),
    	'section'			=> 'ac_customize_social',
    	'settings'			=> 'ac_social_profile_fb',
	) );
	$wp_customize->add_control( 'ac_social_profile_tw', array(
    	'label'				=> __( 'Twitter', 'justwrite' ),
		'description'		=> __( 'Example: <b>acosmin</b>', 'justwrite' ),
    	'section'			=> 'ac_customize_social',
    	'settings'			=> 'ac_social_profile_tw',
	) );
	$wp_customize->add_control( 'ac_social_profile_rss', array(
    	'label'				=> __( 'Custom RSS feed', 'justwrite' ),
		'description'		=> __( 'If you do not want to use the default WP RSS feed, add another one (ex: <b>http://feeds.feedburner.com/acosmin</b>)', 'justwrite' ),
    	'section'			=> 'ac_customize_social',
    	'settings'			=> 'ac_social_profile_rss',
	) );
	// -- Footer
	$wp_customize->add_control( 'ac_footer_logo_text', array(
    	'label'				=> __( 'Logo text', 'justwrite' ),
    	'section'			=> 'ac_customize_footer',
    	'settings'			=> 'ac_footer_logo_text',
	) );
	$wp_customize->add_control( 'ac_footer_copyright_text', array(
    	'label'				=> __( 'Copyright text', 'justwrite' ),
    	'section'			=> 'ac_customize_footer',
    	'settings'			=> 'ac_footer_copyright_text',
	) );
	$wp_customize->add_control('ac_disable_widgetized_footer', array(
		'settings' 		=> 'ac_disable_widgetized_footer',
		'label'    		=> __( 'Hide footer widgets area', 'justwrite' ),
		'section'  		=> 'ac_customize_footer',
		'type'     		=> 'checkbox',
	));
	// Upsell
	$wp_customize->add_control('ac_upsell_woocommerce', array(
		'label'    			=> __( 'Enable WooCommerce', 'justwrite' ),
		'description' 		=> __( 'Use WooCommerce to create a shop and start selling products.', 'justwrite' ),
		'settings' 			=> 'ac_upsell_woocommerce',
		'section'  			=> 'ac_customize_woocommerce',
		'type'     			=> 'checkbox',
	));
	$wp_customize->add_control('ac_upsell_colorfulcats', array(
		'label'    			=> __( 'Enable Colorful Categories', 'justwrite' ),
		'description' 		=> __( 'This option allows you to attach a color to a category.', 'justwrite' ),
		'settings' 			=> 'ac_upsell_colorfulcats',
		'section'  			=> 'ac_customize_colorfulcats',
		'type'     			=> 'checkbox',
	));
	

	/* Add more options filter */
	if( has_filter( 'ac_customizer_add_options_filter') ) {
		apply_filters( 'ac_customizer_add_options_filter', $filtered_options );
	}
	
	
	/* Enque Customiser Preview JS */
	if ( $wp_customize->is_preview() && ! is_admin() ) {
    	add_action( 'customize_preview_init', 'ac_customize_preview_js' );
		
		if( has_filter('ac_customize_preview_filtered_js_filter') ) {
			add_action( 'customize_preview_init', 'ac_customize_preview_filtered_js' );
		}
	}
	
	
	// Preview JS 
	function ac_customize_preview_js() {
		wp_enqueue_script(
			'ac_js_theme_customizer_preview', 
			get_template_directory_uri() . '/assets/js/admin/theme-customizer.js',
			array( 'jquery', 'customize-preview' ),
			'1.0',
			true
		);
	}
	
	// Customizer JS/CSS 
	function ac_customize_customizer_js_css() {
		wp_enqueue_script(
			'ac_js_customizer', 
			get_template_directory_uri() . '/assets/js/admin/customizer.js',
			array( 'jquery' ),
			'1.0',
			true
		);
	}
	add_action( 'customize_controls_enqueue_scripts', 'ac_customize_customizer_js_css' );

	
	// Enque Filtered JS 
	function ac_customize_preview_filtered_js() {
		$js_output = '';
		return apply_filters( 'ac_customize_preview_filtered_js_filter', $js_output );
	}
	
} // - END Customizations
add_action( 'customize_register', 'ac_customize_init' );




/* AC - Output Saved Settings */
function ac_header_output() {
	
	  $main_color 		= '#e1e1e1';
	  $output_new_css 	= '';
	
      ?>
      <!-- Customizer - Saved Styles--> 
      <style type="text/css">
		<?php 
		if(ac_checkdefault('ac_color_dd3333', '#dd3333')) { ac_generate_css( 'a, a:visited, .kk, .share-pagination .title i', 'color', 'ac_color_dd3333', '' ); }
		if(ac_checkdefault('ac_color_hover', '#000000')) { ac_generate_css( 'a:hover', 'color', 'ac_color_hover', '' ); }
		
		if(ac_checkdefault('ac_color_logo', '#ffffff')) { ac_generate_css( '.logo a, .logo a:visited, .logo a:hover', 'color', 'ac_color_logo', '' ); }
		if(ac_checkdefault('ac_background_color_header', '#111111')) { ac_generate_css( '.header-wrap', 'background-color', 'ac_background_color_header', '' ); }
		if(ac_checkdefault('ac_background_image_header', '')) { ac_generate_css( '.header-wrap', 'background-image', 'ac_background_image_header', 'url(', ')' ); }
		if(ac_checkdefault('ac_border_color_header', $main_color)) { ac_generate_css( '.header-wrap', 'border-color', 'ac_border_color_header', '' ); }
		if(ac_checkdefault('ac_border_color_top_menu', $main_color)) { 
			ac_generate_css( '.menu-wrap', 'border-top-color', 'ac_border_color_top_menu', '' ); 
			ac_generate_css( '.menu-wrap', 'border-left-color', 'ac_border_color_top_menu', '' );
			ac_generate_css( '.menu-wrap', 'border-right-color', 'ac_border_color_top_menu', '' );
		}
		if(ac_checkdefault('ac_border_color_top_menu_bot', $main_color)) { ac_generate_css( '.menu-wrap', 'border-bottom-color', 'ac_border_color_top_menu_bot', '' ); }
		if(ac_checkdefault('ac_border_color_top_menu_inn', $main_color)) { ac_generate_css( '.menu-main, .menu-main > li, .menu-wrap .search-button, .menu-wrap a.browse-more, .mobile-menu-button, .mobile-menu > li, .mobile-menu .sf-sub-indicator, .menu-main .sub-menu, .menu-main .sub-menu a, .search-wrap.search-visible, .menu-wrap .search-submit', 'border-color', 'ac_border_color_top_menu_inn', '' ); }
		if(ac_checkdefault('ac_border_color_content', $main_color)) { 
			ac_generate_css( 'fieldset, .container, .sidebar, .main-page-title, .post-template-1 .details .p-share .contents .close-this-temp1, .posts-pagination, .page-links-wrap, .posts-pagination .paging-wrap, .page-links-wrap .page-links, .posts-pagination a, .page-links-wrap a, .page-links-wrap span, .comments-pagination, .comments-pagination .paging-wrap, .comments-pagination a, .posts-pagination span.current, .tabs-widget-navigation ul li a, .tabs-widget-navigation ul li.selected a:after, .mini-sidebar.browse-window-opened, .browse-by-wrap, .browse-window-opened:after, #wp-calendar, #wp-calendar tbody td, #wp-calendar thead th, .single-template-1 .details, .single-template-1 .single-content, .single-content blockquote, .comment-text blockquote, .single-content.featured-image:before, .sidebar .sidebar-heading:before, .sidebar .sidebar-heading:after, .ac-recent-posts li.full-width, .sidebar #recentcomments li, .tagcloud a, .slider-controls, .slide-btn, .slider-pagination a, .as-wrap, .share-pagination, .about-the-author, .about-share .title, .post-navigation, .post-navigation a, .ata-wrap .avatar-wrap, .clear-border, .post-navigation span, .content-wrap, .comments-title, .comment-avatar, .comment-main,  textarea, input, select, li .comment-reply-title small, .post-template-1 .details .post-small-button, .sidebar-heading, .tabs-widget-navigation, .sidebar .sidebar-heading, .sidebar .tabs-widget-navigation, .ac-popular-posts .position, .ac-twitter-widget-ul li.ac-twitter-tweet, select, table, th, td, pre, .posts-pagination span.dots, .comment-list li.pingback, .content-wrap #review-statistics .review-wrap-up .review-wu-right, .comments-area .user-comments-grades, .content-wrap #review-statistics .review-wrap-up, .content-wrap #review-statistics .review-wrap-up .cwpr-review-top, .content-wrap #review-statistics .review-wu-bars, .content-wrap #review-statistics .review-wrap-up .review-wu-left .review-wu-grade, .wrap .cwp-popular-review, .sh-large, .sh-large h2, .section-col-title, .section-col-nav, .section-col-nav li, .sc-large .sc-posts li, .sc-small .sc-posts li, .sc-medium .sc-entry, .sm-wrap .col, .sa-column, .section-title-2nd, .footer-widgets .ac-tabs-init, .container.builder.footer-widgets, .container.builder.b-bot, .container.builder.b-top, .b-top .col, .sc-small.b-top .col.threecol:nth-child(2), .footer-widgets .widget:first-child .sb-content .sidebar-heading', 'border-color', 'ac_border_color_content', '' );
			ac_generate_css( '.mini-sidebar, .sidebar, .mini-sidebar-bg', 'box-shadow', 'ac_border_color_content', '1px 0 0 ', '' );
			ac_generate_css( '.mini-sidebar, .sidebar, .mini-sidebar-bg', '-moz-box-shadow', 'ac_border_color_content', '1px 0 0 ', '' );
			ac_generate_css( '.mini-sidebar, .sidebar, .mini-sidebar-bg', '-webkit-box-shadow', 'ac_border_color_content', '1px 0 0 ', '' );
			ac_generate_css( '.sidebar', 'box-shadow', 'ac_border_color_content', '-1px 0 0 ', '' );
			ac_generate_css( '.sidebar', '-moz-box-shadow', 'ac_border_color_content', '-1px 0 0 ', '' );
			ac_generate_css( '.sidebar', '-webkit-box-shadow', 'ac_border_color_content', '-1px 0 0 ', '' );
			ac_generate_css( '.single-template-1 .featured-image-wrap', 'box-shadow', 'ac_border_color_content', '-8px 8px 0 ', '' );
			ac_generate_css( '.single-template-1 .featured-image-wrap', '-moz-box-shadow', 'ac_border_color_content', '-8px 8px 0 ', '' );
			ac_generate_css( '.single-template-1 .featured-image-wrap', '-webkit-box-shadow', 'ac_border_color_content', '-8px 8px 0 ', '' );
			ac_generate_css( '.content-wrap #review-statistics .review-wu-bars', 'box-shadow', 'ac_border_color_content', '1px 1px 0 ', '' );
			ac_generate_css( '.comments-area #cwp-slider-comment .comment-form-meta-option .comment_meta_slider', 'box-shadow', 'ac_border_color_content', 'inset 0px 0px 5px ', '' );
			ac_generate_css( '.comment-list .children:before', 'background-color', 'ac_border_color_content', '' );
		} 
		if(ac_checkdefault('ac_border_color_dd3333', '#dd3333')) { ac_generate_css( 'abbr[title], .back-to-top, .close-browse-by, .tagcloud a:hover, .comment-main .comment-reply-link, .sc-popular-position', 'border-color', 'ac_border_color_dd3333', '' ); }
		if(ac_checkdefault('ac_border_color_000000', '#000000')) { ac_generate_css( '.back-to-top:hover, .close-browse-by:hover, .comment-main a.comment-reply-link:hover, textarea:focus, input:focus, select:focus, li .comment-reply-title small:hover, textarea:hover:focus, input:hover:focus, select:hover:focus', 'border-color', 'ac_border_color_000000', '' ); }
		if(ac_checkdefault('ac_border_color_666666', '#666666')) { ac_generate_css( 'textarea:hover, input:hover, select:hover', 'border-color', 'ac_border_color_666666', '' ); }
		if(ac_checkdefault('ac_color_444', '#444444')) { ac_generate_css( 'body, .menu-main > li > a, .menu-wrap a.search-button, .menu-wrap a.browse-more, .comments-number, .comments-number:visited, .post-template-1 p, .single-template-1 .single-content, .post-template-1 .details .detail a, .single-template-1 .details .detail a, .post-template-1 .details .detail a:visited, .back-to-top:hover, .footer-credits .copyright, .close-browse-by:hover, .tagcloud a:hover, .post-navigation a.next-post:hover, .post-navigation a.prev-post:hover, .comment-main .vcard .fn, .comment-main .vcard a.comment-edit-link:hover, .menu-wrap .search-field, .content-wrap #review-statistics .review-wrap-up .review-wu-right ul li, .content-wrap #review-statistics .review-wu-bars h3, .content-wrap .review-wu-bars span, .content-wrap #review-statistics .review-wrap-up .cwpr-review-top .cwp-item-category a', 'color', 'ac_color_444', '' ); }
		if(ac_checkdefault('ac_color_000', '#000000')) { ac_generate_css( '.sidebar-heading, .ac-popular-posts .position, .posts-pagination a.selected, .page-links-wrap a.selected, .comments-pagination a.selected, a.back-to-top, .footer-credits .blog-title, .post-template-1 .details .p-share .contents .close-this-temp1, .tabs-widget-navigation ul li.selected a, .browse-by-title, a.close-browse-by, .menu-main > li.current_page_item > a, .menu-main > li.current_page_ancestor > a, .menu-main > li.current-menu-item > a, .menu-main > li.current-menu-ancestor > a, .menu-main .sub-menu .sf-sub-indicator i, .comment-main .vcard .fn a, .comment-main .vcard .fn a:visited, .comment-main .vcard a.comment-edit-link, .comment-main a.comment-reply-link, .menu-wrap .search-submit:hover, .section-col-title, .section-title-2nd', 'color', 'ac_color_000', '' ); }
		if(ac_checkdefault('ac_color_666', '#666666')) { ac_generate_css( '.normal-list .current_page_item a, .normal-list .current-menu-item a, .normal-list .current-post-parent a, .menu-wrap a.mobile-menu-button, .wp-caption, textarea, input, .main-page-title .page-title, blockquote cite, blockquote small, .sh-large h2', 'color', 'ac_color_666', '' ); }
		if(ac_checkdefault('ac_color_description', '#666666')) { ac_generate_css( '.logo .description', 'color', 'ac_color_description', '' ); }
		if(ac_checkdefault('ac_color_222', '#222222')) { ac_generate_css( '.slider-controls a.slide-btn, .slider .title a, .slider .title a:visited, .slider .com:hover, .post-template-1 .title a, .post-template-1 .title a:visited, .ac-recent-posts a.title, .ac-popular-posts a.title, .ac-featured-posts .thumbnail .details .title, legend, .single-template-1 .title, .single-content h1, .single-content h2, .single-content h3, .single-content h4, .single-content h5, .single-content h6, .comment-text h1, .comment-text h2, .comment-text h3, .comment-text h4, .comment-text h5, .comment-text h6, .widget[class*="ac_"] .category a:hover, .widget[class*="ac-"] .category a:hover, .sidebar #recentcomments li a, .sidebar #recentcomments a.url:hover, .tagcloud a, .tagcloud a:visited, .about-share .title, .post-navigation a.next-post, .post-navigation a.prev-post, label, .comment-reply-title, .page-404 h1, .main-page-title .page-title span, .section-title a, .section-title a:visited, .sc-popular-position, .sa-year a, .sa-year a:visited, .s-info a.com:hover', 'color', 'ac_color_222', '' ); } 
		if(ac_checkdefault('ac_color_333', '#333333')) { ac_generate_css( '.slider .title a:hover, .post-template-1 .title a:hover, .ac-recent-posts a.title:hover, .ac-popular-posts a.title:hover, .ac-featured-posts .thumbnail .details .title:hover, .footer-credits .theme-author a:hover, .sidebar #recentcomments li a, .comment-main .vcard .fn a:hover, .menu-wrap .search-submit, .section-title a:hover, .sa-year a:hover', 'color', 'ac_color_333', '' ); }
		if(ac_checkdefault('ac_color_bbb', '#bbbbbb')) { ac_generate_css( '.post-template-1 .details .detail, .single-template-1 .details .detail, .widget[class*="ac_"] .category a, .widget[class*="ac-"] .category a, .ac-twitter-tweet-time, .ac-featured-posts .thumbnail .details .category, .footer-credits .theme-author, .footer-credits .theme-author a, .footer-credits .theme-author a:visited, .post-template-1 .details .p-share .contents em, .sidebar #recentcomments, .sidebar #recentcomments a.url, .slider .date, .slider a.com, a.slide-btn:hover, .bsmall-title, .bsmall-title a, .bsmall-title a:hover, .bsmall-title a:visited, .sa-months a:hover, .s-info .com, .s-info .com:visited', 'color', 'ac_color_bbb', '' ); }
		if(ac_checkdefault('ac_color_aaa', '#aaaaaa')) { ac_generate_css( 'q, .single-content blockquote, .comment-text blockquote, .about-share .author, .post-navigation span, .comment-main .vcard a.comment-date, .not-found-header h2, .menu-wrap .search-submit:active, .sa-months a, .sa-months a:visited', 'color', 'ac_color_aaa', '' ); }
		if(ac_checkdefault('ac_background_color_fff', '#ffffff')) { 
					$abcf = get_theme_mod('ac_background_color_fff', '#ffffff');
		  			ac_generate_css( 'body, .post-content, .content-wrap, .slider-pagination a, .slide-btn, .slider .title, .slider .com, .container, .ac-ad-title-300px:before, .post-template-1 .details .post-small-button, #wp-calendar, textarea, input, select, .bsmall-title a, .comment-list .comment-avatar, .ac-featured-posts .thumbnail .details, .st-wrapped, .sh-large h2, .sc-title-hover .section-title, .sc-popular-position, .s-info .com', 'background-color', 'ac_background_color_fff', '' ); 
					ac_generate_css( '.comments-title:after', 'border-top-color', 'ac_background_color_fff', '' );
					ac_generate_css( '.comment-main:after', 'border-right-color', 'ac_background_color_fff', '' );
					// ac_generate_css( '.ss-nav-btn span', 'border-color', 'ac_background_color_fff', '' );
		  }
		if(ac_checkdefault('ac_background_color_e1e1e1', '#e1e1e1')) { ac_generate_css( '.mobile-menu .sub-menu li:before, .no-thumbnail, .featured-image-wrap, .add-some-widgets, a.slide-btn:active, .slider-pagination a span, .menu-wrap .search-submit:active', 'background-color', 'ac_background_color_e1e1e1', '' ); }
		if(ac_checkdefault('ac_background_color_f7f7f7', '#f7f7f7')) { ac_generate_css( 'ins, .slider-controls, .posts-pagination span.current, .page-links-wrap span, .posts-pagination span.current:hover, .page-links-wrap span:hover, .tabs-widget-navigation ul li.selected a, .menu-wrap .browse-more.activated, .tagcloud a:hover, .slide-btn:hover, .about-share .title, .post-navigation a, .post-navigation span, .comment-reply-title small, .menu-wrap .search-submit, .ac-popular-posts .position, pre, .comments-area #cwp-slider-comment .comment-form-meta-option .comment_meta_slider, .comments-area .user-comments-grades .comment-meta-grade-bar, #review-statistics .review-wu-bars ul li, .sh-large, .section-col-nav li a:hover, .sa-mainad', 'background-color', 'ac_background_color_f7f7f7', '' ); }
		if(ac_checkdefault('ac_background_color_f2f2f2', '#f2f2f2')) { ac_generate_css( 'mark, #wp-calendar tbody a, .tagcloud a, .post-navigation a:hover, .comment-reply-title small:hover, .menu-wrap .search-submit:hover, .bsmall-title:before, .banners-125-wrap ul:before', 'background-color', 'ac_background_color_f2f2f2', '' ); }
		if(ac_checkdefault('ac_background_color_000', '#000000')) { 
			ac_generate_css( '.slider .date, .s-info .date', 'background-color', 'ac_background_color_000', '' );
			ac_generate_css( 'span.post-format-icon:after', 'border-color', 'ac_background_color_000', '', ' transparent transparent transparent' );
			ac_generate_css( '.post-content .details a.post-format-icon:after', 'border-color', 'ac_background_color_000', ' transparent ', ' transparent transparent' );
		}
		if(ac_checkdefault('ac_background_color_333', '#333333')) { ac_generate_css( '.sp-popular-heading', 'background-color', 'ac_background_color_333', '' ); }
		if(ac_checkdefault('ac_background_color_dd3333', '#dd3333')) { ac_generate_css( '.ac-popular-posts .the-percentage, .slider .category, .post-thumbnail .sticky-badge, .post-format-icon, button, .contributor-posts-link, input[type="button"], input[type="reset"], input[type="submit"], .s-sd, .s-info .category', 'background-color', 'ac_background_color_dd3333', '' ); }
		if(ac_checkdefault('ac_background_color_top_menu', '#ffffff')) { ac_generate_css( '.menu-main .menu-main ul, .mobile-menu .sub-menu a, .menu-main, .menu-wrap, .menu-wrap .search-wrap, .menu-wrap .search-field, .menu-main li:hover .sub-menu', 'background-color', 'ac_background_color_top_menu', '' ); }
		if(ac_checkdefault('ac_color_top_menu_links', '#444444')) { ac_generate_css( '.menu-main > li > a, .menu-wrap a.search-button, .menu-wrap a.browse-more, .menu-wrap a.mobile-menu-button, .menu-wrap .search-field', 'color', 'ac_color_top_menu_links', '' ); }
		if(ac_checkdefault('ac_color_top_menu_submenu_links', '#dd3333')) { ac_generate_css( '.menu-main .sub-menu a', 'color', 'ac_color_top_menu_submenu_links', '' ); }
		if(ac_checkdefault('ac_color_top_menu_links_hover', '#000000')) { ac_generate_css( '.mobile-drop-down > a, .mobile-drop-down > a:visited, .menu-main > li.sfHover > a, .menu-main .sub-menu li.sfHover > a, .menu-main a:hover, .menu-main > li > a:hover, .menu-main > li.sfHover > a, .menu-main .sub-menu li.sfHover > a, .menu-wrap a.browse-more:hover, .menu-wrap a.mobile-menu-button:hover, .menu-wrap .search-button:hover, .menu-wrap .search-button:hover i', 'color', 'ac_color_top_menu_links_hover', '' ); }
		if(ac_checkdefault('ac_background_color_top_menu_bubble', '#c33c33')) { ac_generate_css( '.menu-main .menu-item-has-children li.bubble > a:before, .menu-main > li.bubble > a:after', 'background-color', 'ac_background_color_top_menu_bubble', '' ); }
		if(ac_checkdefault('ac_color_top_menu_bubble', '#ffffff')) { ac_generate_css( '.menu-main .menu-item-has-children li.bubble > a:before, .menu-main > li.bubble > a:after', 'color', 'ac_color_top_menu_bubble', '' ); }
		if(ac_checkdefault('ac_color_top_menu_links_active', '#000000')) { ac_generate_css( '.menu-wrap .search-button.activated, .menu-wrap a.browse-more.activated, .menu-wrap a.mobile-menu-button.activated, .menu-main > li.current_page_item > a, .menu-main > li.current_page_ancestor > a, .menu-main > li.current-menu-item > a, .menu-main > li.current-menu-ancestor > a', 'color', 'ac_color_top_menu_links_active', '' ); } ?>
		<?php if( get_theme_mod('ac_background_color_fff') != '#ffffff' && get_theme_mod('ac_background_color_fff') != '' ) { $abcf = get_theme_mod('ac_background_color_fff', '#ffffff'); ?>
		.ac-featured-posts .thumbnail .details { background: -moz-linear-gradient(left, rgba(<?php ac_hex2rgb($abcf); ?>,1) 0%, rgba(<?php ac_hex2rgb($abcf); ?>,1) 1%, rgba(<?php ac_hex2rgb($abcf); ?>,0.6) 100%); background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(<?php ac_hex2rgb($abcf); ?>,1)), color-stop(1%,rgba(<?php ac_hex2rgb($abcf); ?>,1)), color-stop(100%,rgba(<?php ac_hex2rgb($abcf); ?>,0.6))); background: -webkit-linear-gradient(left, rgba(<?php ac_hex2rgb($abcf); ?>,1) 0%,rgba(<?php ac_hex2rgb($abcf); ?>,1) 1%,rgba(<?php ac_hex2rgb($abcf); ?>,0.6) 100%);background: -o-linear-gradient(left, rgba(<?php ac_hex2rgb($abcf); ?>,1) 0%,rgba(<?php ac_hex2rgb($abcf); ?>,1) 1%,rgba(<?php ac_hex2rgb($abcf); ?>,0.6) 100%); background: -ms-linear-gradient(left, rgba(<?php ac_hex2rgb($abcf); ?>,1) 0%,rgba(<?php ac_hex2rgb($abcf); ?>,1) 1%,rgba(<?php ac_hex2rgb($abcf); ?>,0.6) 100%); background: linear-gradient(to right, rgba(<?php ac_hex2rgb($abcf); ?>,1) 0%,rgba(<?php ac_hex2rgb($abcf); ?>,1) 1%,rgba(<?php ac_hex2rgb($abcf); ?>,0.6) 100%); } .st-wrapped.st-large { <?php echo 'box-shadow: 0 5px 0 '.$abcf .', 0 -5px 0 '.$abcf .', 15px 0 0 '.$abcf .', -15px 0 0 '.$abcf .', 15px 5px 0 '.$abcf .', -15px -5px 0 '.$abcf .', -15px 5px 0 '.$abcf .', 15px -5px 0 '.$abcf . ';'; ?> } .st-wrapped.st-small { <?php echo 'box-shadow: 0 3px 0 '.$abcf .', 0 -3px 0 '.$abcf .', 10px 0 0 '.$abcf .', -10px 0 0 '.$abcf .', 10px 3px 0 '.$abcf .', -10px -3px 0 '.$abcf .', -10px 3px 0 '.$abcf .', 10px -3px 0 '.$abcf .';'; ?> } .sc-popular-position:before, .sc-popular-position:after { border-color: <?php echo $abcf; ?> transparent transparent transparent; }<?php } ?>
		<?php 
			// Mobile Menu Breaking point
			$bp_int = 1140;
			$breking_point = get_theme_mod('ac_top_menu_mobile_break', $bp_int);
			if( ac_checkdefault('ac_top_menu_mobile_break', $bp_int) && $breking_point > $bp_int ) { 
				echo '@media screen and (max-width: ' . absint( $breking_point ) . 'px) { .menu-main{display:none!important;} .mobile-menu .sub-menu,.mobile-menu .sub-menu ul{display:none!important;position:relative;visibility:inherit!important;top:0;width:100%;border:none;-webkit-box-shadow:none!important;-moz-box-shadow:none!important;box-shadow:none;} .mobile-menu li:hover .sub-menu .sub-menu,.mobile-menu.visible .menu-main li:hover .sub-menu .sub-menu{width:100%;top:0;left:0;} .menu-wrap.visible .mobile-menu{top:70px;} .mobile-menu{display:block;position:absolute;top:69px;left:-1px;width:50%;min-width:300px;height:auto;z-index:98;border-width:1px;border-style:solid;border-top:none;padding:15px 30px;} .mobile-menu, .search-wrap{-webkit-box-shadow:0 0 15px rgba(0,0,0,0.1);-moz-box-shadow:0 0 15px rgba(0,0,0,0.1);box-shadow:0 0 15px rgba(0,0,0,0.1);} .mobile-menu a,.mobile-menu .sub-menu a{display:block;padding:0;line-height:24px;border:none;z-index:2;position:relative;} .mobile-menu .sub-menu li{padding:10px 0;position:relative;} .mobile-menu .sub-menu > li.menu-item-object-category.ac-cc { padding: 10px 0 10px 10px; }.mobile-menu .sub-menu ul li:before{content:"";position:absolute;top:22px;left:0;height:2px;width:100%;z-index:1;} .mobile-menu .sub-menu li:last-child,.mobile-menu .sub-menu:last-child{padding-bottom:0;} .menu-visible .sf-sub-indicator i.fa-angle-down:before {content:"\f107";} .menu-visible-2 .sf-sub-indicator i.fa-angle-down:before {content:"\f107";} .mobile-menu .sf-sub-indicator{display:inline-block;float:right;margin-right:10px;border-width:2px;border-style:solid;line-height:20px;width:24px;text-align:center;font-size:14px;-webkit-border-radius:40px;-moz-border-radius:40px;border-radius:40px;} .mobile-menu > li{width:100%;clear:both;float:none;padding:15px 0;border-bottom-width:1px;border-bottom-style:solid;} .mobile-menu > li:before{display:none;} .mobile-menu > li:last-child{border:none;} .mobile-menu-button{display:block;} .menu-visible, .mobile-drop-down > .sub-menu, .mobile-drop-down > .sub-menu > .mobile-drop-down > .sub-menu{display:block!important;} .mobile-menu li:hover .sub-menu,.menu-wrap.visible .menu-main li:hover .sub-menu .sub-menu, .menu-wrap.visible .menu-main li:hover .sub-menu{top:0;left:0;} .mobile-menu .sub-menu ul li a,.mobile-menu .sub-menu li li{padding-left:10px;} }'; } 
		?>
		
		<?php
			// Output new css via filter
			if( has_filter( 'ac_customizer_new_css_output_filter' ) ) {
				echo apply_filters( 'ac_customizer_new_css_output_filter', $output_new_css );	
			}
		?>
	</style><!-- END Customizer - Saved Styles -->
	<?php
}
add_action( 'wp_head' , 'ac_header_output' );
?>