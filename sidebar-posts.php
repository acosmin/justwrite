<?php
/* ------------------------------------------------------------------------- *
 *	This sidebar appears only in single view (posts)				
/* ------------------------------------------------------------------------- */
?>

<section class="sidebar posts-sidebar clearfix"> 
	<?php
		// Posts sidebar inside top action
		do_action( 'ac_action_posts_sidebar_inside_top' );
		
		// Widgetized posts sidebar
		if ( is_active_sidebar( 'posts-sidebar' ) ) { 
			dynamic_sidebar( 'posts-sidebar' ); 
		} else {
			ac_return_inactive_widgets( 'sidebars' );
		}
		
		// Posts sidebar inside bottom action
		do_action( 'ac_action_posts_sidebar_inside_bot' ); 
	?><!-- END Sidebar Widgets -->
</section><!-- END .sidebar -->