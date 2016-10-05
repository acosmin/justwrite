<?php
/* ------------------------------------------------------------------------- *
 *	Mini sidebar template
 *	_____________________
 *
 *	This is the sidebar located on the left side. If you want to disable it
 *	don't delete it. Go in: 
 *	WordPress Customise Panel -> "Mini-Sidebar" Tab
 *	and click on "Disable Mini-Sidebar".
 *	_____________________
 *
 *	Notes: 
 *	This sidebar appears only when your screen resolution is above 1600px;
 *	If your screen resolution is lower a "Browse more" buttuon will be
 *	displayed in the menu bar.				
/* ------------------------------------------------------------------------- */
?>

<?php if ( !get_theme_mod( 'ac_disable_minisidebar' ) ) { // Disable or Enable Mini-Sidebar ?>
<section class="mini-sidebar">
	<?php do_action( 'ac_action_mini_sidebar_inside_top' ); // Mini sidebar inside top action ?>
	<header class="browse-by-wrap clearfix">
    	<h2 class="browse-by-title"><?php _e( 'Browse By', 'justwrite' ); ?></h2>
        <a href="#" class="close-browse-by"><i class="fa fa-times"></i></a>
    </header><!-- END .browse-by -->
    
    <?php if( has_nav_menu( 'mini-first' ) ) { ?>
	<aside class="side-box">
		<h3 class="sidebar-heading" id="mini-first-title"><?php echo esc_html( get_theme_mod( 'ac_mini_first_title' ) ); ?></h3>
		<nav class="sb-content clearfix">
        	<?php
				// First Menu
				if(is_home()) { $page_state = 'current_page_item'; } else { $page_state = ''; }
				wp_nav_menu( array( 'container' => '', 'theme_location' => 'mini-first', 'items_wrap' => '<ul class="normal-list"><li class="'. $page_state .'"><a href="'. esc_url( home_url() ) .'" title="'. __('Go Home', 'justwrite') .'">'. __('Main Page', 'justwrite') .'</a></li>%3$s</ul>' ) );
			?>
		</nav><!-- END .sb-content -->
	</aside><!-- END .sidebox -->
    <?php }; ?>
    
     <?php if( has_nav_menu( 'mini-second' ) ) { ?>
    <aside class="side-box">
		<h3 class="sidebar-heading" id="mini-second-title"><?php echo esc_html( get_theme_mod( 'ac_mini_second_title', 'Add a menu') ); ?></h3>
		<nav class="sb-content clearfix">
			<?php
				// Second Menu
				wp_nav_menu( array( 'container' => '', 'theme_location' => 'mini-second', 'items_wrap' => '<ul class="normal-list">%3$s</ul>' ) ); 
			?>
		</nav><!-- END .sb-content -->
	</aside><!-- END .sidebox -->
    <?php } ?>
        
	<aside class="side-box">
		<h3 class="sidebar-heading"><?php _e( 'Archives', 'justwrite' ); ?></h3>
		<nav class="sb-content clearfix">
			<ul class="normal-list">
				<?php wp_get_archives( array( 'type' => 'monthly', 'limit' => 12 ) ); ?>
			</ul>
		</nav><!-- END .sb-content -->
	</aside><!-- END .sidebox -->
    
    <div class="side-box larger">
    		<h3 class="sidebar-heading"><?php _e( 'Calendar', 'justwrite' ); ?></h3>
            <div class="sb-content clearfix">
            	<?php get_calendar(true); ?>
		</div><!-- END .sb-content -->
	</div><!-- END .sidebox -->
    
    <div class="wrap-over-1600">
    	<!-- 
        	 If you want to add something in this sidebar please place your code bellow. 
        	 It will show up only when your screen resolution is above 1600 pixels.	
		-->
		
        <?php
		$ad160_show 	= get_theme_mod( 'ac_enable_160px_ad', '' );
		$ad160_code 	= get_theme_mod( 'ac_enable_160px_code', '' );
		$ad160_title 	= get_theme_mod( 'ac_enable_160px_title', '' );
		$ad160_url 		= get_theme_mod( 'ac_enable_160px_link', '' );
		if ( $ad160_show && $ad160_code != '' ) : ?>
        <div class="b160-wrap">
        	<div class="d160">
            	<?php 
					if ( $ad160_title != '' ) {
						echo '<h5 class="bsmall-title"><a href="' . esc_url( $ad160_url ) . '" id="mini-ad-title">' . esc_html( $ad160_title ) . '</a></h5>';	
					}
					if ( $ad160_code != '' ) { 
						echo ac_sanitize_ads( $ad160_code ); 
					} 
				?>
            </div>
        </div>
        <?php endif; ?>
        
    </div><!-- END .wrap-over-1600 -->
    <?php do_action( 'ac_action_mini_sidebar_inside_bot' ); // Mini sidebar inside bottom action ?>
</section><!-- END .mini-sidebar -->

<div class="mini-sidebar-bg"></div>
<?php } ?>