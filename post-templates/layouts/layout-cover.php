<?php
/* ------------------------------------------------------------------------- *
 *  Cover layout
/* ------------------------------------------------------------------------- */
?>
<section class="post-layout-cover<?php ac_single_post_billboard_parallax_class(); ?> container builder"<?php ac_single_post_billboard_img(); ?>>
	<div class="pl-overlay"<?php ac_single_post_overlay_options(); ?>>
    	
        <div class="pl-info">
        	<?php 
				the_title( '<h2 class="title">', '</h2>' );
				ac_single_post_details(); 
			?>
        </div>
        
    </div>
</section>