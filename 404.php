<?php
/* ------------------------------------------------------------------------- *
 *  404 Template file
/* ------------------------------------------------------------------------- */
?>

<?php get_header(); ?>

<section class="container<?php ac_mini_disabled() ?> main-section clearfix">
	
    <div class="page-404">
    
    	<header class="not-found-header">
        	<h1><?php _e( '404', 'justwrite' ) ?></h1>
            <h2><?php _e( 'It looks like nothing was found at this location.', 'justwrite' ); ?><br /><a href="#" class="try-a-search"><?php ac_icon( 'search' ). ' ' . _e( 'Maybe try a search?', 'justwrite' ) ?></a></h2>
		</header>
        
    </div><!-- END .page-404 -->
    
</section><!-- END .container -->

<?php get_footer(); ?>