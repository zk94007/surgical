<?php
/**
 * Plugin Name: Ivory Search
 * Plugin URI:  https://ivorysearch.com
 * Description: The WordPress Search plugin to power your WordPress site custom search. Helping you build a better search. Includes WooCommerce Search support!
 * Version:     4.1.5
 * Author:      Ivory Search
 * Author URI:  https://ivorysearch.com/
 * License:     GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 * Text Domain: ivory-search
 *
 * @fs_premium_only /includes/class-is-stemmer.php
 * 
 * WC tested up to: 3.5.3
 *
 * Ivory Search is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Ivory Search is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Ivory Search. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */


/**
 * Includes necessary dependencies and starts the plugin.
 *
 * @package IS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exits if accessed directly.
}

/**
 * Main Ivory Search Class.
 *
 * @class Ivory_Search
 */
final class Ivory_Search {

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
	 * Ivory Search Constructor.
	 */
	public function __construct() {
		$this->opt = self::load_options();

		$this->define_constants();
		$this->includes();
		$this->init_hooks();
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
	 * Loads plugin options.
	 *
	 */
	public static function load_options() {
		$old_opt = get_option( 'add_search_to_menu', array() );
		$new_opt = (array)get_option( 'ivory_search', array() );
		$temp = array_merge( $old_opt, $new_opt );
		$is_menu_search = get_option( 'is_menu_search', array() );
		$temp2 = array_merge( $temp, (array)$is_menu_search );
		$is_settings = get_option( 'is_settings', array() );
		$temp3 = array_merge( $temp2, (array)$is_settings );
		$is_notices = get_option( 'is_notices', array() );
		return array_merge( $temp3, (array)$is_notices );
	}

	/**
	 * Defines Ivory Search Constants.
	 */
	private function define_constants() {
		define( 'IS_VERSION', '4.1.4' );
		define( 'IS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		define( 'IS_PLUGIN_FILE', __FILE__ );

		if ( ! defined( 'IS_ADMIN_READ_CAPABILITY' ) ) {
			define( 'IS_ADMIN_READ_CAPABILITY', 'edit_posts' );
		}

		if ( ! defined( 'IS_ADMIN_READ_WRITE_CAPABILITY' ) ) {
			define( 'IS_ADMIN_READ_WRITE_CAPABILITY', 'publish_pages' );
		}
	}

	/**
	 * Includes required core files used in admin and on the frontend.
	 */
	public function includes() {

		foreach( glob( IS_PLUGIN_DIR.'includes/' . "*.php" ) as $file ) {
			require_once $file;
		}

		if ( is_admin() ) {
			foreach( glob( IS_PLUGIN_DIR.'admin/' . "*.php" ) as $file ) {
				require_once $file;
			}
		} else {
			foreach( glob( IS_PLUGIN_DIR.'public/' . "*.php" ) as $file ) {
				require_once $file;
			}
		}
	}

	/**
	 * Hooks into initialization actions and filters.
	 */
	private function init_hooks() {
		// Executes necessary actions on plugin activation and deactivation.
		register_activation_hook( IS_PLUGIN_FILE, array( 'IS_Activator', 'activate' ) );
		register_deactivation_hook( IS_PLUGIN_FILE, array( 'IS_Deactivator', 'deactivate' ) );
	}

	/**
	 * Starts plugin execution.
	 */
	function start() {
		$is_loader = IS_Loader::getInstance( $this->opt );
		$is_loader->load();		
	}
}

/**
 * Starts plugin execution.
 */
$is = Ivory_Search::getInstance();
$is->start();
