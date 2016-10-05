// Customizer JavaScript
jQuery.noConflict();

(function( $ ) {
	
	$(document).ready(function () {
		$('#customize-theme-controls > ul').prepend('<li class="accordion-section ac_btns-docs-upsell">');
			$('.ac_btns-docs-upsell').append('<a href="http://www.acosmin.com/theme/justwrite-pro/" class="button ac_btn-prov" target="_blank">JustWrite Pro</a>');
			$('.ac_btns-docs-upsell').append('<a href="http://www.acosmin.com/documentation/justwrite/" class="button ac_btn-docs" target="_blank">Documentation</a>');
		$('#customize-theme-controls > ul').prepend('</li>');
		
		// Disable some elemenets
		$('#customize-control-ac_slider_offset > label > input').attr('disabled', true);
		$('#customize-control-ac_enable_slider_cat > label > input').attr('disabled', true);
		$('#customize-control-ac_main_posts_layout').find('option[value=rthumb]').attr('disabled', true);
		$('#customize-control-ac_enable_posts_masonry > label > input').attr('disabled', true);
		$('#customize-control-ac_split_posts_masonry > label > input').attr('disabled', true);
		$('#customize-control-ac_enable_posts_masonry_excerpt > label > input').attr('disabled', true);
		$('#customize-control-ac_upsell_woocommerce > label > input').attr('disabled', true);
		$('#customize-control-ac_upsell_colorfulcats > label > input').attr('disabled', true);
		$('#customize-control-ac_single_post_layout_select').find('option[value=ac_post_layout_cover_parallax]').attr('disabled', true);
		
	});
	
})(jQuery);
