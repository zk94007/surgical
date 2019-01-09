<?php

// Adds home link to navigation menus
if ( ! function_exists( 'antreas_nav_menu_args' ) ) {
	add_filter( 'wp_page_menu_args', 'antreas_nav_menu_args' );
	function antreas_nav_menu_args( $args ) {
		$args['show_home'] = true;
		return $args;
	}
}

//Remove tag stripping for menu descriptions
//TODO: Deactivated. Causes page content to be copied onto description
//remove_filter('nav_menu_description', 'strip_tags');
//add_filter('wp_setup_nav_menu_item', 'antreas_menu_description_filter');
function antreas_menu_description_filter( $menu_item ) {
	if ( isset( $menu_item->post_content ) && isset( $menu_item->description ) ) {
		$menu_item->description = apply_filters( 'nav_menu_description', $menu_item->post_content );
	}
	return $menu_item;
}


//Change content width variable according to current template
add_filter( 'template_redirect', 'antreas_content_width_size' );
function antreas_content_width_size( $size ) {
	if ( is_page_template( 'template-full.php' ) || is_page_template( 'template-blank.php' ) ) {
		global $content_width;
		$content_width = 980;
	}
}


//Turn off inline styles for gallery shortcode
add_filter( 'use_default_gallery_style', '__return_false' );

//Turn off styles in Recent Comments widget
if ( ! function_exists( 'antreas_remove_recent_comments_style' ) ) {
	add_action( 'widgets_init', 'antreas_remove_recent_comments_style' );
	function antreas_remove_recent_comments_style() {
		add_filter( 'show_recent_comments_widget_style', '__return_false' );
	}
}

if ( ! function_exists( 'antreas_gallery_lightbox' ) ) {
	add_filter( 'wp_get_attachment_link', 'antreas_gallery_lightbox', 10, 4 );
	function antreas_gallery_lightbox( $link, $id, $size, $permalink ) {
		global $post;
		wp_enqueue_style( 'antreas-magnific' );
		wp_enqueue_script( 'antreas-magnific' );
		if ( ! $permalink ) {
			$link = str_replace( '<a ', '<a data-gallery="gallery" ', $link );
		}
		return $link;
	}
}


//Displays an ellipsis on automatic excerpts
add_filter( 'excerpt_more', 'antreas_excerpt_more' );
if ( ! function_exists( 'antreas_excerpt_more' ) ) {
	function antreas_excerpt_more( $more ) {
		$output = '&hellip;';
		return $output;
	}
}


// Limits excerpt length to a certain size
add_filter( 'excerpt_length', 'antreas_excerpt_length' );
if ( ! function_exists( 'antreas_excerpt_length' ) ) {
	function antreas_excerpt_length( $length ) {
		return 80;
	}
}

add_filter( 'post_class', 'antreas_has_post_thumbnail' );
if ( ! function_exists( 'antreas_has_post_thumbnail' ) ) {
	function antreas_has_post_thumbnail( $classes ) {
		global $post;
		if ( has_post_thumbnail( $post->ID ) ) {
			$classes[] = 'post-has-thumbnail';
		}
		return $classes;
	}
}

//Add portfolio thumbnail size to WordPress admin
add_action( 'admin_init', 'antreas_thumbnail_settings' );
if ( ! function_exists( 'antreas_thumbnail_settings' ) ) {
	function antreas_thumbnail_settings() {
		$option_values  = get_option( 'antreas_thumbnail' );
		$default_values = array(
			'width'  => ANTREAS_THUMBNAIL_WIDTH,
			'height' => ANTREAS_THUMBNAIL_HEIGHT,
		);
		$data           = shortcode_atts( $default_values, $option_values );
		register_setting( 'media', 'antreas_thumbnail' );
		add_settings_field( 'antreas_portfolio_thumbnails', __( 'Portfolio Size', 'antreas' ), 'antreas_thumbnail_fields', 'media', 'default', $data );
	}
}


//Print fields for managing thumbnail sizes
if ( ! function_exists( 'antreas_thumbnail_fields' ) ) {
	function antreas_thumbnail_fields( $args ) {
		?>
		<legend class="screen-reader-text"><span><?php _e( 'Portfolio size', 'antreas' ); ?></span></legend>
		<label for="antreas_portfolio_width"><?php _e( 'Max Width', 'antreas' ); ?></label>
		<input name="antreas_thumbnail[width]" type="number" step="1" min="0" id="antreas_portfolio_width" value="<?php echo $args['width']; ?>" class="small-text" />
		<label for="antreas_portfolio_height"><?php _e( 'Max Height', 'antreas' ); ?></label>
		<input name="antreas_thumbnail[height]" type="number" step="1" min="0" id="antreas_portfolio_height" value="<?php echo $args['height']; ?>" class="small-text" />
		<?php
	}
}


//Add portfolio thumbnail size to WordPress admin
add_filter( 'image_size_names_choose', 'antreas_add_thumbnail' );
if ( ! function_exists( 'antreas_add_thumbnail' ) ) {
	function antreas_add_thumbnail( $sizes ) {
		return array_merge( $sizes, array( 'portfolio' => __( 'Portfolio Size', 'antreas' ) ) );
	}
}


//Add a wrapper to embeds so they become responsive
add_filter( 'embed_oembed_html', 'antreas_embed_wrapper', 10, 3 );
add_filter( 'video_embed_html', 'antreas_embed_wrapper' );
function antreas_embed_wrapper( $html ) {
	if ( strstr( $html, 'youtube.com' ) != false || strstr( $html, 'vimeo.com' ) != false || strstr( $html, 'wordpress.tv' ) != false ) {
		return '<div class="video">' . $html . '</div>';
	} else {
		return $html;
	}
}