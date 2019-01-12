<?php
/**
 * This class defines all plugin functionality for the dashboard of the plugin and site front end.
 *
 * @package IS
 * @since    4.0
 */

class IS_Admin_Public {

	/**
	 * Stores plugin options.
	 */
	public $opt;

	/**
	 * Core singleton class
	 * @var self
	 */
	private static $_instance;

	/**
	 * Initializes this class and stores the plugin options.
	 */
	public function __construct() {
		$is = Ivory_Search::getInstance();

		if ( null !== $is ) {
			$this->opt = $is->opt;
		} else {
			$this->opt = Ivory_Search::load_options();
		}
	}

	/**
	 * Gets the instance of this class.
	 *
	 * @return self
	 */
	public static function getInstance() {
		if ( ! ( self::$_instance instanceof self ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Registers Widgets.
	 */
	function widgets_init() {
		register_widget( 'IS_Widget' );
	}

	/**
	 * Executes actions on initialization.
	 */
	function init() {
		/* Registers post types */
		if ( class_exists( 'IS_Search_Form' ) ) {
			IS_Search_Form::register_post_type();
		}
	}

	/**
	 * Formats attributes.
	 */
	public static function format_atts( $atts ) {
		$html = '';

		$prioritized_atts = array( 'type', 'name', 'value' );

		foreach ( $prioritized_atts as $att ) {
			if ( isset( $atts[$att] ) ) {
				$value = trim( $atts[$att] );
				$html .= sprintf( ' %s="%s"', $att, esc_attr( $value ) );
				unset( $atts[$att] );
			}
		}

		foreach ( $atts as $key => $value ) {
			$key = strtolower( trim( $key ) );

			if ( ! preg_match( '/^[a-z_:][a-z_:.0-9-]*$/', $key ) ) {
				continue;
			}

			$value = trim( $value );

			if ( '' !== $value ) {
				$html .= sprintf( ' %s="%s"', $key, esc_attr( $value ) );
			}
		}

		$html = trim( $html );

		return $html;
	}
}