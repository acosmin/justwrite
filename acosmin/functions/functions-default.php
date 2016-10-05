<?php
/* ------------------------------------------------------------------------- *
 *  These are default functions used by the theme
/* ------------------------------------------------------------------------- */



/*  Output first category
/* ------------------------------------ */
function ac_output_first_category( $class = '', $span_wrap = false ) {
	global $post;
	$output_category = '';
	
	$gpt = get_post_type( get_the_ID() );

	if( has_filter( 'ac_output_first_category_class_filter' ) ) {
		$applied_class = apply_filters( 'ac_output_first_category_class_filter', $class );
		if( ! empty( $applied_class ) ) {
			$show_class = 'class="' . esc_attr( $applied_class ) . '" ';
		} else {
			$show_class = '';
		}
	} elseif ( ! empty( $class ) ) {
		$show_class = 'class="' . esc_attr( $class ) . '" ';
	} else {
		$show_class = '';
	}

	$category = get_the_category();
	if ( $category ) {
		$output_category = 
			'<a href="' . get_category_link( $category[0]->term_id ) . '" ' . $show_class . 'title="' . sprintf( __( "View all posts in %s", "justwrite" ), $category[0]->name ) . '" ' . '>' . $category[0]->name.'</a> ';
	}
	
	if( ! $span_wrap ) {
		if( $gpt != 'page' && ! empty( $category ) ) {
			echo $output_category;
		}
	} else {
		$output_category = '<span ' . $show_class . '>' . $category[0]->name .'</span> ';
		echo $output_category;
	}
}



/*  Output comments number
/* ------------------------------------ */
function ac_comments_number() {
	$num_comments = get_comments_number();
	$comments = '';
	
	if ( comments_open() ) {
		if ( $num_comments == 0 ) {
			$comments = __('0 Comments', 'justwrite');
		} elseif ( $num_comments > 1 ) {
			$comments = $num_comments . __(' Comments', 'justwrite');
		} else {
			$comments = __('1 Comment', 'justwrite');
		}
	}
	
	echo esc_html( $comments );
}



/*  Basic template hooks
/* ------------------------------------ */
function ac_after_body() {
	// After the <body> tag
	do_action( 'ac_after_body_hook' );
}

function ac_before_body_closed() {
	// Before the </body> tag
	do_action( 'ac_before_body_closed_hook' );
}

function ac_after_header() {
	// After the header - main <header> tag
	do_action( 'ac_after_header_hook' );
}

function ac_before_footer() {
	// Before the footer - main <footer> tag
	do_action( 'ac_before_footer_hook' );
}

function ac_bellow_wrap_class() {
	// Bellow .wrap class
	do_action( 'ac_bellow_wrap_class_hook' );
}

function ac_before_author_box() {
	// Before Author Box
	do_action( 'ac_before_author_box_hook' );
}

function ac_after_author_box() {
	// After Author Box
	do_action( 'ac_after_author_box_hook' );
}



/*  Check if page is paginated
/* ------------------------------------ */
function ac_check_paged() {
	global $wp_query, $page, $post;
	if( $page < 2) { return true; } else { return false; }
}



/*  Custom feed url
/* ------------------------------------ */
function ac_custom_rss_feed( $output, $feed ) {
    if ( strpos( $output, 'comments' ) )
        return $output;
	
	$custom_feed = get_theme_mod( 'ac_social_profile_rss', '' );

    return esc_url( $custom_feed );
}

if ( get_theme_mod( 'ac_social_profile_rss', '' ) != '' ) {
	add_action( 'feed_link', 'ac_custom_rss_feed', 10, 2 );
}



/*  Favicon
/* ------------------------------------ */
function ac_favicon() {
    $favicon_desktop = get_theme_mod( 'ac_favicon_image', '' );
	
	$output = '<link rel="shortcut icon" href="' . esc_url( $favicon_desktop ) . '">';
	
	if ( $favicon_desktop != '') {
		echo $output . "\n";
	} else {
		return;	
	}
}
add_action( 'wp_head', 'ac_favicon', 2);
?>