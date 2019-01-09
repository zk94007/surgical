<?php //Contains assorted functions and utilities for themes.

//Calculate sidebar class to load
function antreas_get_sidebar_position() {
	$current_id     = antreas_current_id();
	$sidebar_layout = '';
	if ( is_front_page() ) {
		$sidebar_layout = antreas_get_option( 'sidebar_position_home' );
	} elseif ( is_home() ) {
		$sidebar_layout = get_post_meta( get_option( 'page_for_posts' ), 'layout_sidebar', true );
	} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
		$sidebar_layout = get_post_meta( get_option( 'woocommerce_shop_page_id' ), 'layout_sidebar', true );
	} elseif ( is_tax() || is_category() || is_tag() ) {
		$sidebar_layout = antreas_tax_meta( $current_id, 'layout_sidebar' );
	} else {
		$sidebar_layout = get_post_meta( $current_id, 'layout_sidebar', true );
	}

	//Sanitize
	if ( $sidebar_layout != '' && $sidebar_layout != 'default' ) {
		$sidebar_class = $sidebar_layout;
	} else {
		$sidebar_class = antreas_get_option( 'sidebar_position' );
	}

	return $sidebar_class;
}


//Abstracted function for retrieving specific options inside option arrays
if ( ! function_exists( 'antreas_get_option' ) ) {
	function antreas_get_option( $option_name = '', $option_array = 'antreas_settings' ) {

		$option_value = '';

		//Check against option array and see if it is multilingual
		$options = antreas_metadata_customizer();
		if ( isset( $options[ $option_name ]['multilingual'] ) && $options[ $option_name ]['multilingual'] == true ) {
			//Determines whether to grab current language, or original language's option
			$option_array = $option_array . antreas_wpml_current_language();
		}

		//If options exists and is not empty, get value
		$option_list = get_option( $option_array, false );
		if ( $option_list && isset( $option_list[ $option_name ] ) && ( is_bool( $option_list[ $option_name ] ) === true || $option_list[ $option_name ] !== '' ) ) {
			$option_value = $option_list[ $option_name ];
		}

		//If option is empty, check whether it needs a default value
		if ( $option_value === '' || ! isset( $option_list[ $option_name ] ) ) {
			$options = antreas_metadata_customizer();
			//If option cannot be empty, use default value
			if ( ! isset( $options[ $option_name ]['empty'] ) ) {
				if ( isset( $options[ $option_name ]['default'] ) ) {
					$option_value = $options[ $option_name ]['default'];
				}
				//If it can be empty but not set, use default value
			} elseif ( ! isset( $option_list[ $option_name ] ) ) {
				if ( isset( $options[ $option_name ]['default'] ) ) {
					$option_value = $options[ $option_name ]['default'];
				}
			}
		}
		return $option_value;
	}
}

//Abstracted function for updating specific options inside arrays
if ( ! function_exists( 'antreas_update_option' ) ) {
	function antreas_update_option( $option_name, $option_value, $option_array = 'antreas_settings' ) {

		//Check against option array and see if it is multilingual
		$options = antreas_metadata_customizer();
		if ( isset( $options[ $option_name ]['multilingual'] ) && $options[ $option_name ]['multilingual'] == true ) {
			//Determines whether to grab current language, or original language's option
			$option_array = $option_array . antreas_wpml_current_language();
		}

		$option_list = get_option( $option_array, false );
		if ( ! $option_list ) {
			$option_list = array();
		}
		$option_list[ $option_name ] = $option_value;
		if ( update_option( $option_array, $option_list ) ) {
			return true;
		} else {
			return false;
		}
	}
}

//Abstracted function for deleting specific options inside arrays
if ( ! function_exists( 'antreas_delete_option' ) ) {
	function antreas_delete_option( $option_name, $option_array = 'antreas_settings' ) {

		//Check against option array and see if it is multilingual
		$options = antreas_metadata_customizer();
		if ( isset( $options[ $option_name ]['multilingual'] ) && $options[ $option_name ]['multilingual'] == true ) {
			//Determines whether to grab current language, or original language's option
			$option_array = $option_array . antreas_wpml_current_language();
		}

		$option_list = get_option( $option_array, false );
		unset( $option_list[ $option_name ] );
		update_option( $option_array, $option_list );
	}
}

//Returns the current language's code in the event that WPML is active
if ( ! function_exists( 'antreas_wpml_current_language' ) ) {
	function antreas_wpml_current_language() {
		$language_code = '';
		if ( antreas_wpml_active() ) {
			$default_language = antreas_wpml_default_language();
			$active_language  = ICL_LANGUAGE_CODE;
			if ( $active_language != $default_language ) {
				$language_code = '_' . $active_language;
			}
		} elseif ( function_exists( 'pll_current_language' ) && function_exists( 'pll_default_language' ) ) {
			$default_language = pll_default_language();
			$active_language  = pll_current_language();
			if ( $active_language != $default_language ) {
				$language_code = '_' . $active_language;
			}
		}
		return $language_code;
	}
}

//Check if WPML is active
if ( ! function_exists( 'antreas_wpml_active' ) ) {
	function antreas_wpml_active() {
		if ( defined( 'ICL_LANGUAGE_CODE' ) && defined( 'ICL_SITEPRESS_VERSION' ) ) {
			return true;
		} else {
			return false;
		}
	}
}

//Retrieve languages from WPML
if ( ! function_exists( 'antreas_wpml_languages' ) ) {
	function antreas_wpml_languages() {
		if ( antreas_wpml_active() ) {
			global $sitepress;
			return $sitepress->get_active_languages();
		}
	}
}

//Retrieve default WPML language
if ( ! function_exists( 'antreas_wpml_default_language' ) ) {
	function antreas_wpml_default_language() {
		if ( antreas_wpml_active() ) {
			global $sitepress;
			return $sitepress->get_default_language();
		}
	}
}


//Searches for a link inside a string. Used for post formats
if ( ! function_exists( 'antreas_find_link' ) ) {
	function antreas_find_link( $content, $fallback ) {

		$link_url     = '';
		$link_pattern = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
		$post_content = $content;
		if ( preg_match( $link_pattern, $post_content, $link_url ) ) {
			return $link_url[0];
		} else {
			return $fallback;
		}
	}
}


//Retrieve page number for the current post or page
if ( ! function_exists( 'antreas_current_page' ) ) {
	function antreas_current_page() {
		$current_page = 1;
		if ( is_front_page() ) {
			if ( get_query_var( 'page' ) ) {
				$current_page = get_query_var( 'page' );
			} else {
				$current_page = 1;
			}
		} else {
			if ( get_query_var( 'paged' ) ) {
				$current_page = get_query_var( 'paged' );
			} else {
				$current_page = 1;
			}
		}
		return $current_page;
	}
}


//Retrieve current post or taxonomy id
if ( ! function_exists( 'antreas_current_id' ) ) {
	function antreas_current_id() {
		$current_id = false;
		if ( is_tax() || is_category() || is_tag() ) {
			$current_id = get_queried_object()->term_id;
		} else {
			global $post;
			if ( isset( $post->ID ) ) {
				$current_id = $post->ID;
			} else {
				$current_id = false;
			}
		}
		return $current_id;
	}
}


//Return true if posts should be displayed on homepage
function antreas_show_posts() {
	$display = false;
	if ( ! is_front_page() || antreas_get_option( 'home_posts' ) === true ) {
		$display = true;
	}
	return $display;
}


//Return true if page title should be displayed
function antreas_show_title() {
	$display = false;
	if ( ! is_front_page() ) {
		$display = true;
	}
	return $display;
}


//Add shortcode functionality to text widgets
add_filter( 'widget_text', 'do_shortcode' );


//Custom function to do some cleanup on nested shortcodes
//Used for columns and layout-related shortcodes
if ( ! function_exists( 'antreas_do_shortcode' ) ) {
	function antreas_do_shortcode( $content ) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		$content = preg_replace( '#^<\/p>|^<br\s?\/?>|<p>$|<p>\s*(&nbsp;)?\s*<\/p>#', '', $content );
		return $content;
	}
}

//Changes the brighness of a HEX color
if ( ! function_exists( 'antreas_alter_brightness' ) ) {
	function antreas_alter_brightness( $colourstr, $steps ) {
		$colourstr = str_replace( '#', '', $colourstr );
		$rhex      = substr( $colourstr, 0, 2 );
		$ghex      = substr( $colourstr, 2, 2 );
		$bhex      = substr( $colourstr, 4, 2 );

		$r = hexdec( $rhex );
		$g = hexdec( $ghex );
		$b = hexdec( $bhex );

		$r = max( 0, min( 255, $r + $steps ) );
		$g = max( 0, min( 255, $g + $steps ) );
		$b = max( 0, min( 255, $b + $steps ) );

		$r = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
		$g = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
		$b = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );
		return '#' . $r . $g . $b;
	}
}


add_action( 'after_switch_theme', 'antreas_rewrite_flush' );
function antreas_rewrite_flush() {
	flush_rewrite_rules();
}


//Sanitize boolean values
function antreas_sanitize_bool( $data ) {
	if ( $data === true ) {
		return true;
	}
	return false;
}

//Return the URL to the premium theme page
function antreas_upgrade_link( $medium = 'customizer' ) {
	$url  = esc_url_raw( ANTREAS_PREMIUM_URL . '?utm_source=antreas&utm_medium=' . $medium . '&utm_campaign=upsell' );
	return $url;
}


// Gets attachment url by slug from media library.
function antreas_get_attachment_url_by_slug( $slug ) {
	$args = array(
		'post_type' => 'attachment',
		'name' => sanitize_title( $slug ),
		'posts_per_page' => 1,
		'post_status' => 'inherit',
	);
	$_header = get_posts( $args );
	$header = $_header ? array_pop( $_header ) : null;
	return $header ? wp_get_attachment_url( $header->ID ) : '';
}