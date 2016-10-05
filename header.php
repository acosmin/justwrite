<?php
/* ------------------------------------------------------------------------- *
 *	Header template					
/* ------------------------------------------------------------------------- */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ac_html_tag_classes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'ac_action_body_start' ); // <body> start action ?>

<header id="main-header" class="header-wrap">
<?php do_action( 'ac_action_header_wrap_before' ); // Before header wrap action ?>

<div class="wrap">

	<div class="top<?php ac_mini_disabled(); ac_logo_class(); ?> clearfix">
    
    	<div class="logo<?php ac_logo_class(); ?>">
        	<a href="<?php echo esc_url( home_url() ); ?>" title="<?php bloginfo( 'name' ); ?>" class="logo-contents<?php ac_logo_class(); ?>"><?php ac_get_logo(); ?></a>
            <?php
				// Ads variables - Options Panel
				$show_description = get_theme_mod( 'ac_show_description', true );
				$ad728_show = get_theme_mod( 'ac_enable_728px_ad', '' );
				$ad728_code = get_theme_mod( 'ac_enable_728px_code', '' );
				$logocentered = get_theme_mod( 'ac_logo_centered', false );
				
				if ( $show_description ) :
					if( $ad728_show == '' ) :
			?>
            <h2 class="description"><?php bloginfo( 'description' ); ?></h2>
            <?php endif; endif; ?>
        </div><!-- END .logo -->
        
        <?php 
		if ( $ad728_show && $ad728_code != '' && ! $logocentered ) : ?>
        <div class="advertising728">
        	<?php if ( $ad728_code != '' ) { echo ac_sanitize_ads( $ad728_code ); } ?>
        </div><!-- END .advertising728 -->
        <?php endif; ?>
        
    </div><!-- END .top -->
    
    <?php do_action( 'ac_action_menu_wrap_before' ); // Before main wrap action ?>

    <nav class="menu-wrap<?php ac_mini_disabled(); if ( get_theme_mod( 'ac_disable_stickymenu' ) ) { echo ' sticky-disabled'; } ?>" role="navigation">
		<?php
			do_action( 'ac_action_main_menu_before' ); // Before main menu action
			
			// Main menu
			if( has_nav_menu( 'main' ) ) {
				wp_nav_menu( array( 'container' => '', 'theme_location' => 'main', 'items_wrap' => '<ul class="menu-main mobile-menu superfish">%3$s</ul>' ) );
			} else {
				echo '<ul class="menu-main mobile-menu superfish"><li class="current_page_item"><a href="#">' . __( 'Add a menu', 'justwrite' )  . '</a></li><li><a href="#">' . __( 'Main Menu Location', 'justwrite' )  . '</a></li></ul>';
			}
		?>
        
        <a href="#" class="mobile-menu-button"><?php ac_icon( 'navicon' ) ?></a>
        <?php do_action( 'ac_action_main_menu_after' ); // After main menu action ?>
        <?php if ( !get_theme_mod( 'ac_disable_minisidebar' ) ) { ?>
        <a href="#" class="browse-more" id="browse-more"><?php echo ac_icon('ellipsis-v', false) // . __( 'Browse', 'justwrite' ) ?></a>
        <?php } ?>
        <?php do_action( 'ac_action_search_btn_before' ); // Before search button action ?>
        <a href="#" class="search-button"><?php ac_icon( 'search' ) ?></a>
        <?php do_action( 'ac_action_search_btn_after' ); // After search button action ?>
        
        
        
        <div class="search-wrap nobs">
        	<form role="search" id="header-search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            	<input type="submit" class="search-submit" value="<?php _e( 'Search', 'justwrite' ); ?>" />
            	<div class="field-wrap">
					<input type="search" class="search-field" placeholder="<?php _e( 'type your keywords ...', 'justwrite' ); ?>" value="<?php get_search_query(); ?>" name="s" title="<?php _e( 'Search for:', 'justwrite' ); ?>" />
				</div>
			</form>
        </div><!-- END .search-wrap -->
        
    </nav><!-- END .menu-wrap -->
    
    <?php do_action( 'ac_action_menu_wrap_after' ); // After menu wrap action ?>
    
</div><!-- END .wrap -->
<?php do_action( 'ac_action_header_wrap_after' ); // After header wrap action ?>
</header><!-- END .header-wrap -->

<?php do_action( 'ac_action_header_main_tag_after' ); // After main </header> tag action ?>

<div class="wrap<?php ac_mini_disabled() ?>" id="content-wrap">

<?php do_action( 'ac_action_wrap_main_inside_top' ); // Main .wrap class inside top ?>