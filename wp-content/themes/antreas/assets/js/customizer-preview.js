( function( $ ) {

	var headerHeight = $('#header').innerHeight();

	// overwrite default link functionality in the customizer preview for the edit links.
	$( 'a.post-edit-link' ).on( 'click', function(e) {
		e.preventDefault();
		window.open( $( this ).attr('href'), '_blank' );
	});

	wp.customize.bind('preview-ready', function () {

	 	wp.customize.preview.bind( 'section-highlight', function( data ) {
			var selectors = {
				'antreas_layout_slider' : '#slider',
				'antreas_layout_features' : '#features',
				'antreas_layout_about' : '#about',
				'antreas_layout_portfolio' : '#portfolio',
				'antreas_layout_products' : '#products',
				'antreas_layout_tagline' : '#tagline',
				'antreas_layout_services' : '#services',
				'antreas_layout_team' : '#team',
				'antreas_layout_testimonials' : '#testimonials',
				'antreas_layout_clients' : '#clients',
				'antreas_layout_posts' : '#main',
				'antreas_layout_contact' : '#contact',
				'antreas_layout_shortcode' : '#shortcode'
			};

			// Only on the front page.
			if ( ! $( selectors[ data.section ] ).length ) {
				return;
			}

			// When the section is expanded, show and scroll to the content placeholders, exposing the edit links.
			if ( true === data.expanded && $( selectors[ data.section ] ).length > 0 ) {
				var offset = $(window).scrollTop() === 0 ? -headerHeight*2 : -headerHeight;
				$( 'html, body' ).animate( { scrollTop: $( selectors[ data.section ] ).offset().top + offset  }, 1000, 'swing' );
			}
		});

	});

} )( jQuery );