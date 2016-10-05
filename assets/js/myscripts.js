// JustWrite Scripts
;( function( $, window, document, undefined ) {

	'use strict';

	// Selectors
	var $window			= $( window ),
		$body			= $( 'body' ),
		$document		= $( document ),
		$html_body		= $( 'html, body' ),
		ac_activated	= 'activated',
		ac_selected		= 'selected',
		ac_opened		= 'opened',
		ac_visible		= 'visible';



	// Menu Drop-Down
	var ac_menu_args = {
		delay:				300,
		speed:				'fast',
		animation:			{opacity:'show',height:'show'},
		dropShadows:		false,
		cssArrows:			false,
		autoArrows:			true
	}
	$('.superfish').superfish(ac_menu_args);

	$document.on( 'customize-preview-menu-refreshed', function( e, params, ac_menu_args ) {
		if ( params.oldContainer.hasClass( 'superfish' ) ) {
			params.newContainer.superfish( ac_menu_args );
		}
	});



	// Mobile menus
	var ac_mobileMenuBtn 	= '.mobile-menu-button',
		ac_mobileMenuBtn2	= '.mobile-menu-button-2',
		ac_menuMain			= $('.menu-main'),
		ac_mobileMenu		= $('.mobile-menu'),
		ac_mobileMenu2		= $('.mobile-menu-2'),
		ac_menuVisible		= 'menu-visible',
		ac_mobileDropDown	= 'mobile-drop-down',
		ac_mobileSubArrow	= 'fa fa-angle-right',
		ac_mobileOnOff		= 'fa-navicon fa-times';

	$document.on('click', ac_mobileMenuBtn, function(e) {
		$(ac_mobileMenuBtn).toggleClass(ac_activated).find('i').toggleClass(ac_mobileOnOff);
		ac_menuMain.toggleClass(ac_menuVisible);
		ac_mobileMenu.find('li.'+ac_mobileDropDown).removeClass(ac_mobileDropDown);
		ac_mobileMenu.find('i').removeAttr('class').addClass(ac_mobileSubArrow);
		ac_close_mini_sidebar();
		ac_close_search_box();

		e.preventDefault();
	});

	$document.on('click', '.mobile-menu .sf-sub-indicator', function(e) {
		$(this).parent().parent().toggleClass(ac_mobileDropDown)
		.children().find('.'+ac_mobileDropDown)
		.removeClass(ac_mobileDropDown)
		.find('i').toggleClass('fa-angle-down fa-angle-right');

		$(this).find('i').toggleClass('fa-angle-right fa-angle-down')

		e.preventDefault();
	});

	$document.on('click', ac_mobileMenuBtn2, function(e) {
		$(ac_mobileMenuBtn2).toggleClass(ac_activated).find('i').toggleClass(ac_mobileOnOff);
		$('.second-menu').toggleClass('menu-visible-2');
		ac_mobileMenu2.find('li.'+ac_mobileDropDown).removeClass(ac_mobileDropDown);
		ac_mobileMenu2.find('i').removeAttr('class').addClass(ac_mobileSubArrow);
		ac_close_mini_sidebar();
		ac_close_search_box();
		ac_close_mobile_menu();

		e.preventDefault();
	});

	$document.on('click', '.mobile-menu-2 .sf-sub-indicator', function(e) {
		$(this).parent().parent().toggleClass(ac_mobileDropDown)
		.children().find('.'+ac_mobileDropDown)
		.removeClass(ac_mobileDropDown)
		.find('i').toggleClass('fa-angle-down fa-angle-right');

		$(this).find('i').toggleClass('fa-angle-right fa-angle-down')

		e.preventDefault();
	});

	var ac_close_mobile_menu = function() {
		$(ac_mobileMenuBtn).removeClass(ac_activated).find('i').removeClass().addClass('fa fa-navicon');
		ac_menuMain.removeClass(ac_menuVisible);
		ac_mobileMenu.find('li.'+ac_mobileDropDown).removeClass(ac_mobileDropDown);
		ac_mobileMenu.find('i').removeAttr('class').addClass(ac_mobileSubArrow);
	}



	// Search Button
	var ac_searchBtn 		= '.search-button',
		ac_searchBtnSel		= $(ac_searchBtn),
		ac_searchVisible	= 'search-visible',
		ac_searchWrap		= $('.search-wrap'),
		ac_searchField		= $('#header-search .search-field');

	$document.on('click', ac_searchBtn + ', .try-a-search', function(e) {
		ac_searchBtnSel.toggleClass(ac_activated).find('i').toggleClass('fa-search fa-times');
		ac_searchWrap.toggleClass(ac_searchVisible);
		ac_searchField.val('').focus();
		ac_close_mini_sidebar();
		ac_close_mobile_menu();
		e.preventDefault();
	});

	var ac_close_search_box = function() {
		ac_searchBtnSel.removeClass(ac_activated);
		ac_searchBtnSel.find('i').removeClass().addClass('fa fa-search');
		ac_searchWrap.removeClass(ac_searchVisible);
		ac_searchField.blur();
	}



	// Browse
	var ac_browseID 	= '#browse-more',
		ac_browseSel 	= $(ac_browseID),
		ac_miniSidebar	= $('.mini-sidebar'),
		ac_browseOpened = 'browse-window-opened';

	$document.on('click', ac_browseID, function(e) {
		var cwp = $('.container.main-section').position();
		var cwp_total = cwp.top - parseInt(ac_miniSidebar.css('padding-top')) + parseInt($('.container.main-section').css('border-top-width')) + 1;
		$(this).toggleClass(ac_activated);
		ac_miniSidebar.toggleClass(ac_browseOpened);
		ac_miniSidebar.css({
			'display': 'block',
			'position':	'absolute'
		});
		if (ac_miniSidebar.hasClass(ac_browseOpened)) {
			$html_body.animate({scrollTop: cwp_total}, 300);
		} else {
			ac_miniSidebar.removeAttr('style');
		}
		ac_close_search_box();
		ac_close_mobile_menu();
		e.preventDefault();
	});

	var ac_close_mini_sidebar = function() {
		ac_miniSidebar.removeClass(ac_browseOpened);
		ac_browseSel.removeClass(ac_activated);
		ac_miniSidebar.removeAttr('style');
	}

	$document.on('click', '.close-browse-by', function(e) {
		ac_close_mini_sidebar();
		ac_close_mobile_menu();
		e.preventDefault();
	});



	// Responsive Videos
	$('.single-content, .sidebar').fitVids();



	// Back To Top
	$('.back-to-top').click(function() {
		$html_body.animate({scrollTop: 0}, 600);
	});



	// Remove Tag Style (widget)
	$('.tagcloud a').removeAttr('style');



	// Tabs Widget
	var ac_tabsContainer 	= '.ac-tabs-init',
		ac_tabsBtn 			= ac_tabsContainer + ' a',
		ac_tabsTab			= '.tabs-widget-tab';

	var ac_init_tabs = function() {
		var tabs = $( ac_tabsContainer + '-wrap');
		if( ! tabs.length ) return;
		tabs.each( function( index, element ) {
			var tab_id = $( '#' + element.id );
			tab_id.find(ac_tabsBtn).parent('li').first().addClass(ac_selected);
			tab_id.find(ac_tabsTab).first().css('display', 'block');
		});
	}
	ac_init_tabs();

	$(ac_tabsBtn).click(function(e) {
		e.preventDefault();
		var $this 		= $(this),
			tabs_id		= '#' + $this.parents(ac_tabsContainer + '-wrap').attr('id'),
			get_tab_id 	= $this.attr('href');

		$(tabs_id + ' ' + ac_tabsBtn).parent().addClass(ac_selected);
		$this.parent().siblings().removeClass(ac_selected);
		$(tabs_id + ' ' + ac_tabsTab).not(get_tab_id).css('display', 'none');
		$(get_tab_id).fadeIn();
	});



	// Posts - Template 1 - Share Article
	$document.on('click', '.post-share-temp1', function(e) {
		var share_id = $(this).attr('id'),
			share_wrap_width = $('.post-template-1 .details').width() - 50;

		$(this).css('display', 'none');
		$('#' + share_id + '-rm').css('margin-right', 48);
		$('#' + share_id + '-wrap').addClass(ac_opened).css('height', 50).animate({
			'width': '92%'
			}, 500, function() {
				$('#' + share_id + '-wrap .contents').css('display','block').animate({
					'opacity': 1,
				}, 300);
		});
		e.preventDefault();
	});

	$document.on('click', '.close-this-temp1', function(e) {
		var share_href = $(this).attr('href'),
			share_href_wrap = $(this).attr('href') + '-wrap';

		$(share_href_wrap + ' .contents').animate({
			'opacity': 0
			}, 300, function(){
				$(this).css('display','none')
				$(share_href_wrap).animate({
					'width': 48,
					'height': 'auto'
				}, 300, function(){
					$(share_href_wrap).removeClass(ac_opened)
					$(share_href + '-rm').css('margin-right', 0);
					$(share_href).css('display', 'block');
				});
			});
		e.preventDefault();
	});



	// Sticky Menu
	var ac_sticky_menu = function() {
		var nav 			= $('.menu-wrap'),
			nav_scrolled 	= false,
			spo_scrooled 	= false,
			header_social	= $('.header-social-icons');

		if( !nav.hasClass('sticky-disabled') ) {
			if( $window.width() > 1140 ) {
				$window.scroll(function() {
					if (220 <= $window.scrollTop() && !nav_scrolled && $window.width() > 1140) {
						if( $body.hasClass('admin-bar') ) {
							nav.removeAttr('style').addClass(ac_visible).css('top', 28);
						} else {
							nav.removeAttr('style').addClass(ac_visible)
						}
						nav_scrolled = true;
					}
					if (220 >= $window.scrollTop() && nav_scrolled) {
						if( $body.hasClass('admin-bar') ) {
							nav.removeClass(ac_visible).css('top', 0);
						} else {
							nav.removeClass(ac_visible);
						}
						nav_scrolled = false;
					}
					if (320 <= $window.scrollTop() && !spo_scrooled) {
						if( ! header_social.hasClass('show') ) {
							header_social.css('display', 'block').animate({'marginRight': 0}, 100);
						}
						spo_scrooled = true;
					}
					if (320 >= $window.scrollTop() && spo_scrooled) {
						if( ! header_social.hasClass('show') ) {
							header_social.animate({
								'marginRight': 20
							}, 100, function() {
								header_social.hide().css({
									'marginRight': 0
								});
							}).show();
						}
						spo_scrooled = false;
					}
				});
			} else {
				nav.removeClass(ac_visible),
				nav_scrolled = false,
				header_social.removeAttr('style'),
				spo_scrooled = false;
			}
		}


	}
	ac_sticky_menu();

	if( $body.hasClass('admin-bar') ) { $('.menu-wrap' + ac_visible).css('top', 100); }



	// On Window Resize
	$window.resize(function() {
		if( $window.width() >= 1600 ) {
			ac_miniSidebar.removeClass(ac_browseOpened);
			$(ac_browseID).removeClass(ac_activated);
			ac_miniSidebar.removeAttr('style');
		}
		ac_sticky_menu();
	});



	// On Window Load
	$window.load(function(){
		$('#ac-preloader').fadeOut('slow',function(){$(this).remove();});
	});



})( jQuery, window, document );
