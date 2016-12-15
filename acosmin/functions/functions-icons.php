<?php
/* ------------------------------------------------------------------------- *
 *  Icons API
/* ------------------------------------------------------------------------- */



/*  Echo or return an icon.
/*	You only need the icon's name witout "fa-" prefix.
/*	Example ac_icon( "play" );
/*	Set the second parameter to false to return the icon.
/*	Example ac_icon( "play", false );
/* ------------------------------------------------------------------------- */
function ac_icon( $icon = '', $output = true ) {
	if($icon != '') {
		if( $output ) {
			echo '<i class="fa fa-' . esc_attr( $icon ) . '"></i> ';
		} else {
			return '<i class="fa fa-' . esc_attr( $icon ) . '"></i> ';
		}
	}
	return;
}



/*  In case we're working with loops
/* ------------------------------------ */
function ac_icon_output( $icon = '' ) {
	global $post;
	$icon_info = get_post_meta( $post->ID, $icon, true );
	if($icon_info != '') {
		echo '<i class="fa fa-' . esc_attr( $icon_info ) .'"></i> ';
	}
	return;
}
