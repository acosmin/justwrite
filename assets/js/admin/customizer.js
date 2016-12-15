// Customizer JavaScript
jQuery.noConflict();

(function( $, api ) {

	api.sectionConstructor['ac-upsell-section'] = api.Section.extend( {
		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

	$(document).ready(function () {

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

})( jQuery, wp.customize );
