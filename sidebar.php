<?php
/* ------------------------------------------------------------------------- *
 *	Sidebar template				
/* ------------------------------------------------------------------------- */
?>

<section class="sidebar clearfix">
	<?php
		// Main sidebar inside top action
		do_action( 'ac_action_main_sidebar_inside_top' );
		
		// Widgetized sidebar
		if ( is_active_sidebar( 'main-sidebar' ) ) { 
			dynamic_sidebar( 'main-sidebar' ); 
		} else {
			ac_return_inactive_widgets( 'sidebars' );
		}
		
		// Main sidebar inside bottom action
		do_action( 'ac_action_main_sidebar_inside_bot' ); 
	?><!-- END Sidebar Widgets -->
</section><!-- END .sidebar -->