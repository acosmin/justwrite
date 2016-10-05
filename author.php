<?php
/* ------------------------------------------------------------------------- *
 *	The template for displaying Author archive pages.					
/* ------------------------------------------------------------------------- */

// Variables
$disable_about = get_theme_mod( 'ac_disable_about_box', false );
?>

<?php get_header(); ?>

<section class="container<?php ac_mini_disabled() ?> main-section clearfix">
	
    <?php get_sidebar( 'browse' ); ?>
    
    <div class="wrap-template-1 clearfix">
    
    <section class="content-wrap with-title" role="main">
    	<?php
			// Author content wrap inside top action
			do_action( 'ac_action_author_content_wrap_inside_top' );
		?>
    
    	<?php if ( have_posts() ) : ?>
    	<header class="main-page-title">
        
        	<h1 class="page-title"><?php the_post(); printf( __( 'All posts by %s', 'justwrite' ), '<span>' . get_the_author() . '</span>' ) . ac_icon( 'angle-down' ) ?></h1>
            
            <?php if( ! $disable_about ) : ?>
            <aside class="about-share clearfix">
                <div class="as-wrap clearfix">
                
					<?php 
                        // Variables
                        $author_id			= get_the_author_meta( 'ID' );
                        $display_name		= get_the_author_meta( 'display_name', $author_id );
                        $user_url			= get_the_author_meta( 'user_url', $author_id );
                    ?>	
                    <div class="about-the-author clearfix">
                        <h2 class="title"><?php _e('About the author','justwrite'); ?> <span class="author"><?php echo esc_html( $display_name ); ?></span></h2>
                        <div class="ata-wrap clearfix">
                            <figure class="avatar-wrap">
                                <?php echo get_avatar( $author_id, 58 ); ?>
                                <?php if( $user_url ) { ?>
                                <figcaption class="links">
                                    <a href="<?php echo esc_url( $user_url ) ?>" class="author-link" title="<?php _e("Author's Link", 'justwrite'); ?>"><?php ac_icon('link');?></a>
                                </figcaption>
                                <?php } ?>
                            </figure>
                            <div class="info">
                                <?php echo esc_html( get_the_author_meta( 'description', $author_id ) ); ?>
                            </div>
                        </div>
                        
                        <div class="clear-border"></div>
                    </div><!-- END .about-the-author -->
                
                </div><!-- END .as-wrap -->
            </aside><!-- END .about-share -->
            <?php endif; ?>
            
        </header>
    	<?php endif; ?>
        
    	<div class="posts-wrap clearfix">
        
        <?php
			rewind_posts();
		
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
			
			// Author content wrap inside bottom action
			do_action( 'ac_action_author_content_wrap_inside_bot' );
		?>
        
    </section><!-- END .content-wrap -->
    
    <?php get_sidebar(); ?>
    
    </div><!-- END .wrap-template-1 -->
    
</section><!-- END .container -->

<?php get_footer(); ?>