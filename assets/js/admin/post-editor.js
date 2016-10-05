(function( $ ) {
 
    // Add Color Picker to all inputs that have 'ac-color-field' class
 	$('.ac-color-field').wpColorPicker();
	
	// Check which item is selected
	$(document).on('change', '#ac_post_layout_options', function (event) {
		event.preventDefault();
		
		var ac_overlay_options = $("#ac_overlay_options");

		if( $(this).val() == 'ac_post_layout_cover' || $(this).val() == 'ac_post_layout_cover_parallax' ) {
			ac_overlay_options.show();
		} else {
			ac_overlay_options.hide();
		}
	});
		
})( jQuery );