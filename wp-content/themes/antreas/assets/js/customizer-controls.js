( function( api ) {
	var sections = [
		'antreas_layout_home',
		'antreas_layout_slider',
		'antreas_layout_features',
		'antreas_layout_about',
		'antreas_layout_portfolio',
		'antreas_layout_products',
		'antreas_layout_tagline',
		'antreas_layout_services',
		'antreas_layout_team',
		'antreas_layout_testimonials',
		'antreas_layout_clients',
		'antreas_layout_contact',
		'antreas_layout_shortcode',
		'antreas_layout_posts'
	];

    // Detect when the front page sections section is expanded (or closed) so we can adjust the preview accordingly.
    jQuery.each( sections, function ( index, section ){
        api.section( section, function( section ) {
            section.expanded.bind( function( isExpanding ) {

                // Value of isExpanding will = true if you're entering the section, false if you're leaving it.
                api.previewer.send( 'section-highlight', { expanded: isExpanding, section: section.id });
            } );
        } );
	});

})( wp.customize );