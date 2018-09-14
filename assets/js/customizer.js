/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ($) {

	// Site title and description.
	wp.customize('blogname', function (value) {
		value.bind(function (to) {
			$('.site-title a').text(to);
		});
	});
	wp.customize('blogdescription', function (value) {
		value.bind(function (to) {
			$('.site-description').text(to);
		});
	});

	// Header text color.
	wp.customize('header_textcolor', function (value) {
		value.bind(function (to) {
			if ('blank' === to) {
				$('.site-title, .site-description').css({
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				});
			} else {
				$('.site-title, .site-description').css({
					'clip': 'auto',
					'position': 'relative'
				});
				$('.site-title a, .site-description').css({
					'color': to
				});
			}
		});
	});

	// Section Accent Color
	wp.customize('section_color', function (value) {
		value.bind(function (to) {
			if ('blank' === to) {
				$('.widget.emag_magazine_tabbed ul li.ui-state-active:last-child, .widget.emag_magazine_sidebar_category_tabs_posts ul li.ui-state-active:last-child').css({
					'border-bottom': '2px solid #fff'
				});
				$('button, input[type="submit"]').css({ 'background-color': '#fff000' });
			} else {
				$('.widget.emag_magazine_tabbed ul li.ui-state-active:last-child, .widget.emag_magazine_sidebar_category_tabs_posts ul li.ui-state-active:last-child').css({
					'border-bottom': '2px solid',
					'border-bottom-color': to
				});
				$('button, input[type="submit"]').css({ 'background-color': to });
			}
		});
	});

	// Accent Color
	/*	wp.customize('tag_hover_color', function (value) {
			value.bind(function (to) {
				if ('blank' === to) {
					$('#emag-tags a:hover').css({
						'background-color': '#fff'
					});
				} else {
					$('#emag-tags a:hover').css({
						'background-color': to
					});
				}
			});
		});
	*/
})(jQuery);
