<?php
/* ------------------------------------------------------------------------- *
 *	Index template					
/* ------------------------------------------------------------------------- */
?>
<?php get_header(); ?>

<?php
	// Sections output (Main Page - Before posts)  
	if ( is_active_sidebar( 'main-page-before' ) && ! is_paged() ) { dynamic_sidebar( 'main-page-before' ); } else { ac_return_inactive_widgets('front-page-before'); };
?>

<?php if ( ! get_theme_mod( 'ac_disable_index_posts', false ) ) { ?> 

<section class="container<?php ac_mini_disabled() ?> main-section clearfix">
	
    <?php get_sidebar( 'browse' ); ?>
    
    <div class="wrap-template-1 clearfix">
    
    <section class="content-wrap" role="main">
    	
        <?php
			// Index content wrap inside top action
			do_action( 'ac_action_index_content_wrap_inside_top' );
			
			// Main slider
			if ( get_theme_mod( 'ac_enable_slider', false ) && is_front_page() && !is_paged() && ac_featured_posts_count() > 2 ) {
				get_template_part( 'featured-content' );
			}
		?>

    	<div class="posts-wrap clearfix">
        
        <?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					get_template_part( 'post-templates/content' );
				endwhile;
			else :
				get_template_part( 'post-templates/content', 'no-articles' );
			endif;			
		?>
        
        </div><!-- END .posts-wrap -->
        
        <?php
			// Pagination 
			ac_paginate(); 
			
			// Index content wrap inside bottom action
			do_action( 'ac_action_index_content_wrap_inside_bot' );
		?>
        
    </section><!-- END .content-wrap -->
    
    <?php get_sidebar(); ?>
    
    </div><!-- END .wrap-template-1 -->
    
</section><!-- END .container -->

<?php } // ac_disable_index_posts ?>

<?php 
	// Sections output (Main Page - After posts)
	if ( is_active_sidebar( 'main-page-after' ) && ! is_paged() ) { dynamic_sidebar( 'main-page-after' ); } 
?> 

<?php get_footer(); ?>