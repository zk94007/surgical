<?php
/**
 * Defines the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    IS
 * @subpackage IS/includes
 * @author     Ivory Search <admin@ivorysearch.com>
 */

class IS_I18n {

	/**
	 * Core singleton class
	 * @var self
	 */
	private static $_instance;

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
	 * Loads the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_is_textdomain( $locale = null ) {
		global $l10n;

		$domain = 'ivory-search';

		do_action( 'is_before_load_textdomain' );

		if ( get_locale() == $locale ) {
			$locale = null;
		}

		if ( empty( $locale ) ) {
			if ( is_textdomain_loaded( $domain ) ) {
				return true;
			} else {
				return load_plugin_textdomain( 'ivory-search', false, dirname( dirname( plugin_basename( IS_PLUGIN_FILE ) ) ) . '/languages/' );
			}
		} else {
			$mo_orig = $l10n[$domain];
			unload_textdomain( $domain );

			$mofile = $domain . '-' . $locale . '.mo';
			$path = dirname( dirname( plugin_basename( IS_PLUGIN_FILE ) ) ) . '/languages/';

			if ( $loaded = load_textdomain( $domain, $path . '/'. $mofile ) ) {
				return $loaded;
			} else {
				$mofile = WP_LANG_DIR . '/plugins/' . $mofile;
				return load_textdomain( $domain, $mofile );
			}

			$l10n[$domain] = $mo_orig;
		}

		do_action( 'is_after_load_textdomain' );

		return false;
	}
}
