<?php
/**
 * Defines default search form fields.
 *
 * @package IS
 */

class IS_Template {

	public static function get_default( $prop = '_is_includes' ) {
		if ( '_is_includes' == $prop ) {
			$template = self::includes();
		} else if ( '_is_excludes' == $prop ) {
			$template = self::excludes();
		} else if ( '_is_settings' == $prop ) {
			$template = self::settings();
		} else {
			$template = null;
		}

		return apply_filters( 'is_default_template', $template, $prop );
	}

	public static function includes() {
		$template = array(
			'post_type' => array(
					'post' => 'post',
					'page' => 'page'
				),
			'search_title'   => 1,
			'search_content' => 1,
			'search_excerpt' => 1,
		);

		return $template;
	}

	public static function excludes() {
		return '';
	}

	public static function settings() {
		return '';
	}
}