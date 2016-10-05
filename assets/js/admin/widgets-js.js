// Widgets JavaScript
jQuery.noConflict();

(function( $ ) {
	
	$(document).ready(function () {

		// Select type	
		$(document).on('change', '.ac-select-type', function (event) {
			event.preventDefault();
			
			var $ac_widgetID = $(this).parents('.widget').attr('id');
	
			if( $(this).val() == 'category' ) {
				$('#' + $ac_widgetID + ' .ac-display-category-field').show();	
			} else {
				$('#' + $ac_widgetID + ' .ac-display-category-field').hide();
			}
		});
		
		// Toggle promo
		$(document).on('click', 'div.widget[id*=ac-widget] .ac-pro-title', function () {
			event.preventDefault();
			
			var $ac_widgetID = $(this).parents('.widget').attr('id');
			
			if($(this).find('.dashicons').hasClass('dashicons-arrow-down-alt2')) {
				$(this).find('.dashicons').removeClass('dashicons-arrow-down-alt2').addClass('dashicons-arrow-up-alt2');
			} else {
				$(this).find('.dashicons').removeClass('dashicons-arrow-up-alt2').addClass('dashicons-arrow-down-alt2')	
			}
			
			$('#' + $ac_widgetID + ' .ac-pro-content').slideToggle('fast');
		});
		
		// Init widget
		$(document).on('click', 'div.widget[id*=ac-widget] .widget-title, div.widget[id*=ac-widget] .widget-title-action', function () {
			event.preventDefault();
			
			var $ac_widgetID = $(this).parents('.widget').attr('id');
			var $ac_widgetSS = $(this).parents('.widget').find('select.ac-select-type').val();
			
			if( $ac_widgetSS == 'category' ) { 
				$('#' + $ac_widgetID + ' .ac-display-category-field').show();
			} else {
				$('#' + $ac_widgetID + ' .ac-display-category-field').hide();
			}
			
			$(this).parents('.widget[id*=ac-widget]').find('.ac-pro-content').hide();
			$(this).parents('.widget[id*=ac-widget]').find('.ac-pro-title .dashicons').removeClass('dashicons-arrow-up-alt2').addClass('dashicons-arrow-down-alt2');
		});
		
	});
	
})(jQuery);