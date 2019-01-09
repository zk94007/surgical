<?php

//Print HTML for an icon
//TODO: Icon value should be in the format 'fontawesome-\f001'
if ( ! function_exists( 'antreas_icon' ) ) {
	function antreas_icon( $value, $wrapper = '', $echo = true ) {
		if ( $value === '0' || $value === 0 || $value === '' ) {
			return;
		}

		if ( strpos( $value, '-' ) === false ) {
			$font_library = 'fontawesome';
			$font_value   = $value;
		} else {
			$icon_data    = explode( '-', $value );
			$font_library = $icon_data[0];
			$font_value   = $icon_data[1];
		}

		$output = '';
		if ( $wrapper != '' ) {
			$output .= '<div class="' . $wrapper . '">';
		}
		$output .= antreas_get_icon( $font_library, html_entity_decode( $font_value ) );
		if ( $wrapper != '' ) {
			$output .= '</div>';
		}

		if ( $echo == false ) {
			return $output;
		} else {
			echo $output;
		}
	}
}

//Retrieve the correct library
function antreas_get_icon( $library, $value ) {
	$result = '';
	switch ( $library ) {
		case 'fontawesome':
			$result = antreas_icon_library_fontawesome( $value );
			break;
		default:
			$result = antreas_icon_library_fontawesome( $value );
			break;
	}
	return $result;
}


//Icon library for fontawesome
function antreas_icon_library_fontawesome( $value ) {
	wp_enqueue_style( 'antreas-fontawesome' );
	return '<span style="font-family:\'fontawesome\'">' . $value . '</span>';
}