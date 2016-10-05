<?php
/* ------------------------------------------------------------------------- *
 *  Basic
/* ------------------------------------------------------------------------- */


if( ! class_exists( 'AC_Section' ) ) {
	class AC_Section extends WP_Widget {
		
		// Output promo template for widgets
		public function ac_promo_info( $lines = array(), $protitle = '', $getpro = '', $submsg = '' ) {
			$output 	= '';
			$theme_info = wp_get_theme();
			
			if( $protitle == '' ) { $protitle = __( 'Pro Version', 'justwrite' ); }
			if( $getpro == '' ) { $getpro = __( 'Get Pro Version', 'justwrite' ); }
			if( $submsg == '' ) { $submsg = __( 'to enable them + many more', 'justwrite' ); }
			
			$output .= '<div class="ac-pro-widget widefat">';
				$output .= '<a href="#" class="ac-pro-title"><span class="ac-pt">' . esc_html( $protitle ) . '</span> <span class="dashicons dashicons-arrow-down-alt2"></span></a>';
				$output .= '<div class="ac-pro-content">';
					foreach( $lines as $line ) {
						$output .= '<p>' . $line . '</p>';
					}
					$output .= '<p class="ac-pro-buttons">';
						$output .= '<a href="' . esc_url( $theme_info->get( 'AuthorURI' ) ) . 'theme/justwrite-pro/" target="_blank" class="button button-primary">' . $getpro . '</a><br />';
						$output .= '<em>' . esc_html( $submsg ) . '</em>';
					$output .= '</p>';
				$output .= '</div>';
			$output .= '</div>';
			
			echo $output;
		}

	}
	
}
?>