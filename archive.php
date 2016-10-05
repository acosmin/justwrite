<?php
/* ------------------------------------------------------------------------- *
 *	The template for displaying Archive pages.					
/* ------------------------------------------------------------------------- */
?>

<?php get_header(); ?>

<section class="container<?php ac_mini_disabled() ?> main-section clearfix">
	
    <?php get_sidebar( 'browse' ); ?>
    
    <div class="wrap-template-1 clearfix">
    
    <section class="content-wrap with-title" role="main">
    	<?php
			// Archives content wrap inside top action
			do_action( 'ac_action_archives_content_wrap_inside_top' );
		?>
    
    	<header class="main-page-title">
        	<h1 class="page-title">
            <?php
				if ( is_day() ) :
					printf( __( 'Daily Archives: <span>%s</span>', 'justwrite' ), get_the_date() ) . ac_icon( 'angle-down' );

				elseif ( is_month() ) :
					printf( __( 'Monthly Archives: <span>%s</span>', 'justwrite' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'justwrite' ) ) ) . ac_icon( 'angle-down' );

				elseif ( is_year() ) :
					printf( __( 'Yearly Archives: <span>%s</span>', 'justwrite' ), get_the_date( _x( 'Y', 'yearly archives date format', 'justwrite' ) ) ) . ac_icon( 'angle-down' );

				else :
					_e( 'Archives', 'justwrite' ) . ac_icon( 'angle-down' );

				endif;
			?>
			</h1>
        </header>
    
    	<div class="posts-wrap clearfix">
        
        <?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					get_template_part( 'post-templates/content', 'index' );
				endwhile;
			else :
				get_template_part( 'post-templates/content', 'no-articles' );
			endif;			
		?>
        
        </div><!-- END .posts-wrap -->
        
        <?php
			// Pagination
			ac_paginate();
			
			// Archives content wrap inside bottom action
			do_action( 'ac_action_archives_content_wrap_inside_bot' );
		?>
        
    </section><!-- END .content-wrap -->
    
    <?php get_sidebar(); ?>
    
    </div><!-- END .wrap-template-1 -->
    
</section><!-- END .container -->

<?php get_footer(); ?>