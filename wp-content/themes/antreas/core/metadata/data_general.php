<?php


if ( ! function_exists( 'antreas_metadata_color_scheme' ) ) {
	function antreas_metadata_color_scheme() {
		$schemes = array(
			'light' => __( 'Light Scheme', 'antreas' ),
			'dark'  => __( 'Dark Scheme', 'antreas' ),
		);

		return $schemes;
	}
}


if ( ! function_exists( 'antreas_metadata_layoutstyle' ) ) {
	function antreas_metadata_layoutstyle() {
		$data = array(
			'fixed' => __( 'Full Width', 'antreas' ),
			'boxed' => __( 'Boxed', 'antreas' ),
		);

		return $data;
	}
}

function antreas_metadata_sidebarposition() {

	$data = array(
		'right' => ANTREAS_ASSETS_IMG . 'backend/layouts/sidebar_position_right.gif',
		'none'  => ANTREAS_ASSETS_IMG . 'backend/layouts/sidebar_position_none.gif',
	);

	return $data;
}

function antreas_metadata_sidebarposition_text() {
	$sidebar_positions = array(
		'none'         => __( 'No sidebar', 'antreas' ),
		'right'        => __( 'Right sidebar', 'antreas' ),
	);

	return $sidebar_positions;
}

function antreas_metadata_sidebarposition_optional() {

	$sidebar_positions = array(
		'default'      => ANTREAS_ASSETS_IMG . 'backend/layouts/sidebar_position_default.gif',
		'none'         => ANTREAS_ASSETS_IMG . 'backend/layouts/sidebar_position_none.gif',
		'narrow'       => ANTREAS_ASSETS_IMG . 'backend/layouts/sidebar_position_narrow.gif',
		'right'        => ANTREAS_ASSETS_IMG . 'backend/layouts/sidebar_position_right.gif',
		'left'         => ANTREAS_ASSETS_IMG . 'backend/layouts/sidebar_position_left.gif',
		'double'       => ANTREAS_ASSETS_IMG . 'backend/layouts/sidebar_position_double.gif',
		'double-left'  => ANTREAS_ASSETS_IMG . 'backend/layouts/sidebar_position_dleft.gif',
		'double-right' => ANTREAS_ASSETS_IMG . 'backend/layouts/sidebar_position_dright.gif',
	);

	return $sidebar_positions;
}


function antreas_metadata_homepage_order() {
	$data = array();
	if ( defined( 'CPOTHEME_USE_PAGES' ) && CPOTHEME_USE_PAGES == true ) {
		$data['featured'] = __( 'Featured Posts', 'antreas' );
	}
	if ( defined( 'CPOTHEME_USE_SLIDES' ) && CPOTHEME_USE_SLIDES == true ) {
		$data['slider'] = __( 'Slider', 'antreas' );
	}
	if ( defined( 'CPOTHEME_USE_FEATURES' ) && CPOTHEME_USE_FEATURES == true ) {
		$data['features'] = __( 'Features', 'antreas' );
	}
	if ( defined( 'CPOTHEME_USE_PORTFOLIO' ) && CPOTHEME_USE_PORTFOLIO == true ) {
		$data['portfolio'] = __( 'Portfolio', 'antreas' );
	}
	if ( defined( 'CPOTHEME_USE_SERVICES' ) && CPOTHEME_USE_SERVICES == true ) {
		$data['services'] = __( 'Services', 'antreas' );
	}
	if ( defined( 'CPOTHEME_USE_ABOUT' ) && CPOTHEME_USE_ABOUT == true ) {
		$data['about'] = __( 'About', 'antreas' );
	}
	if ( defined( 'CPOTHEME_USE_CLIENTS' ) && CPOTHEME_USE_CLIENTS == true ) {
		$data['clients'] = __( 'Clients', 'antreas' );
	}
	if ( defined( 'CPOTHEME_USE_TEAM' ) && CPOTHEME_USE_TEAM == true ) {
		$data['team'] = __( 'Team Members', 'antreas' );
	}
	if ( defined( 'CPOTHEME_USE_TESTIMONIALS' ) && CPOTHEME_USE_TESTIMONIALS == true ) {
		$data['testimonials'] = __( 'Testimonials', 'antreas' );
	}
	if ( defined( 'CPOTHEME_USE_CONTACT' ) && CPOTHEME_USE_CONTACT == true ) {
		$data['contact'] = __( 'Contact', 'antreas' );
	}
	$data['tagline'] = __( 'Tagline', 'antreas' );
	$data['content'] = __( 'Page Contents', 'antreas' );

	return $data;
}

function antreas_metadata_homepage_order_default() {
	$data = 'tagline';
	if ( defined( 'CPOTHEME_USE_PAGES' ) && CPOTHEME_USE_PAGES == true ) {
		$data .= ',featured';
	}
	if ( defined( 'CPOTHEME_USE_SLIDES' ) && CPOTHEME_USE_SLIDES == true ) {
		$data .= ',slider';
	}
	if ( defined( 'CPOTHEME_USE_FEATURES' ) && CPOTHEME_USE_FEATURES == true ) {
		$data .= ',features';
	}
	if ( defined( 'CPOTHEME_USE_PORTFOLIO' ) && CPOTHEME_USE_PORTFOLIO == true ) {
		$data .= ',portfolio';
	}
	if ( defined( 'CPOTHEME_USE_SERVICES' ) && CPOTHEME_USE_SERVICES == true ) {
		$data .= ',services';
	}
	if ( defined( 'CPOTHEME_USE_ABOUT' ) && CPOTHEME_USE_ABOUT == true ) {
		$data .= ',about';
	}
	if ( defined( 'CPOTHEME_USE_CLIENTS' ) && CPOTHEME_USE_CLIENTS == true ) {
		$data .= ',clients';
	}
	if ( defined( 'CPOTHEME_USE_TEAM' ) && CPOTHEME_USE_TEAM == true ) {
		$data .= ',team';
	}
	if ( defined( 'CPOTHEME_USE_TESTIMONIALS' ) && CPOTHEME_USE_TESTIMONIALS == true ) {
		$data .= ',testimonials';
	}
	if ( defined( 'CPOTHEME_USE_CONTACT' ) && CPOTHEME_USE_CONTACT == true ) {
		$data .= ',contact';
	}
	return apply_filters( 'antreas_metadata_homepage_order', $data );
}


function antreas_metadata_featured_page() {
	$data = array(
		'none'     => __( 'None', 'antreas' ),
		'slider'   => __( 'In The Slider', 'antreas' ),
		'features' => __( 'In The Featured Boxes', 'antreas' ),
	);

	return apply_filters( 'antreas_metadata_featured_page', $data );
}


function antreas_metadata_sidebar_columns_text() {
	$columns = array(
		2 => __( 'Two Columns', 'antreas' ),
		3 => __( 'Three Columns', 'antreas' ),
		4 => __( 'Four Columns', 'antreas' ),
		5 => __( 'Five Columns', 'antreas' ),
	);

	return $columns;
}


function antreas_metadata_sidebar_columns() {
	$core_path = get_template_directory_uri() . '/core/';
	if ( defined( 'ANTREAS_URL' ) ) {
		$core_path = ANTREAS_URL;
	}
	$sidebars = array(
		2 => $core_path . '/images/admin/sidebars_2.gif',
		3 => $core_path . '/images/admin/sidebars_3.gif',
		4 => $core_path . '/images/admin/sidebars_4.gif',
		5 => $core_path . '/images/admin/sidebars_5.gif',
	);

	return $sidebars;
}


function antreas_metadata_columns() {
	$columns = array(
		1 => __( 'One Column', 'antreas' ),
		2 => __( 'Two Columns', 'antreas' ),
		3 => __( 'Three Columns', 'antreas' ),
		4 => __( 'Four Columns', 'antreas' ),
		5 => __( 'Five Columns', 'antreas' ),
	);

	return $columns;
}

function antreas_metadata_media() {
	$media_type = array(
		'image'     => __( 'Featured image', 'antreas' ),
		'gallery'   => __( 'Gallery of attached images', 'antreas' ),
		'slideshow' => __( 'Slideshow of attached images', 'antreas' ),
		'none'      => __( 'None', 'antreas' ),
	);

	return $media_type;
}


if ( ! function_exists( 'antreas_metadata_menu_style' ) ) {
	function antreas_metadata_menu_style() {
		$menu = array(
			'normal'    => __( 'Normal', 'antreas' ),
			'highlight' => __( 'Highlighted', 'antreas' ),
			'disabled'  => __( 'Disabled', 'antreas' ),
		);

		return $menu;
	}
}


if ( ! function_exists( 'antreas_metadata_post_preview' ) ) {
	function antreas_metadata_post_preview() {
		$post_preview = array(
			'excerpt' => __( 'Show Excerpt', 'antreas' ),
			'full'    => __( 'Show Full Content', 'antreas' ),
			'none'    => __( 'Do Not Show', 'antreas' ),
		);

		return $post_preview;
	}
}


if ( ! function_exists( 'antreas_metadata_post_layout' ) ) {
	function antreas_metadata_post_layout() {
		$post_layout = array(
			'vertical'   => __( 'Vertical', 'antreas' ),
			'horizontal' => __( 'Horizontal', 'antreas' ),
		);

		return $post_layout;
	}
}


//Social network mapping to icons
if ( ! function_exists( 'antreas_metadata_social_networks' ) ) {
	function antreas_metadata_social_networks() {
		$social_networks = array(
			'facebook.com'       => array(
				'name' => 'Facebook',
				'icon' => '&#xf09a',
			),
			'twitter.com'        => array(
				'name' => 'Twitter',
				'icon' => '&#xf099',
			),
			'plus.google.com'    => array(
				'name' => 'Google+',
				'icon' => '&#xf0d5',
			),
			'youtube.com'        => array(
				'name' => 'YouTube',
				'icon' => '&#xf167',
			),
			'vimeo.com'          => array(
				'name' => 'Vimeo',
				'icon' => '&#xf194',
			),
			'linkedin.com'       => array(
				'name' => 'LinkedIn',
				'icon' => '&#xf0e1',
			),
			'pinterest.com'      => array(
				'name' => 'Pinterest',
				'icon' => '&#xf0d2',
			),
			'medium.com'         => array(
				'name' => 'Medium',
				'icon' => '&#xf23a',
			),
			'instagram.com'      => array(
				'name' => 'Instagram',
				'icon' => '&#xf16d',
			),
			'flickr.com'         => array(
				'name' => 'Flickr',
				'icon' => '&#xf16e',
			),
			'tumblr.com'         => array(
				'name' => 'Tumblr',
				'icon' => '&#xf173',
			),
			'dribbble.com'       => array(
				'name' => 'Dribbble',
				'icon' => '&#xf17d',
			),
			'skype.com'          => array(
				'name' => 'Skype',
				'icon' => '&#xf17e',
			),
			'spotify.com'        => array(
				'name' => 'Spotify',
				'icon' => '&#xf1bc',
			),
			'soundcloud.com'     => array(
				'name' => 'SoundCloud',
				'icon' => '&#xf1be',
			),
			'slideshare.com'     => array(
				'name' => 'SlideShare',
				'icon' => '&#xf1e7',
			),
			'deviantart.com'     => array(
				'name' => 'DeviantArt',
				'icon' => '&#xf1bd',
			),
			'foursquare.com'     => array(
				'name' => 'Foursquare',
				'icon' => '&#xf180',
			),
			'vine.co'            => array(
				'name' => 'Vine',
				'icon' => '&#xf1ca',
			),
			'github.com'         => array(
				'name' => 'GitHub',
				'icon' => '&#xf09b',
			),
			'maxcdn.com'         => array(
				'name' => 'MaxCDN',
				'icon' => '&#xf136',
			),
			'xing.com'           => array(
				'name' => 'Xing',
				'icon' => '&#xf168',
			),
			'stackexchange.com'  => array(
				'name' => 'Stack Exchange',
				'icon' => '&#xf16c',
			),
			'bitbucket.org'      => array(
				'name' => 'BitBucket',
				'icon' => '&#xf171',
			),
			'trello.com'         => array(
				'name' => 'Trello',
				'icon' => '&#xf181',
			),
			'vk.com'             => array(
				'name' => 'VKontakte',
				'icon' => '&#xf189',
			),
			'weibo.com'          => array(
				'name' => 'Weibo',
				'icon' => '&#xf18a',
			),
			'renren.com'         => array(
				'name' => 'Renren',
				'icon' => '&#xf18b',
			),
			'reddit.com'         => array(
				'name' => 'Reddit',
				'icon' => '&#xf1a1',
			),
			'steamcommunity.com' => array(
				'name' => 'Steam',
				'icon' => '&#xf1b6',
			),
			'tel:'               => array(
				'name' => 'Phone',
				'icon' => '&#xf095',
			),
			'mailto:'            => array(
				'name' => 'Email',
				'icon' => '&#xf003',
			),
			'/feed'              => array(
				'name' => 'RSS',
				'icon' => '&#xf09e',
			),
		);

		return apply_filters( 'antreas_metadata_social_networks', $social_networks );
	}
}
