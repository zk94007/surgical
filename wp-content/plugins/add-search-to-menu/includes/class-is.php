<?php
/**
 * The class is the core plugin responsible for including and
 * instantiating all of the code that composes the plugin.
 *
 * The class includes an instance to the plugin
 * Loader which is responsible for coordinating the hooks that exist within the
 * plugin.
 *
 * @since    1.0.0
 * @package IS
 */

class IS_Loader {

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
	 * Instantiates the plugin by setting up the core properties and loading
	 * all necessary dependencies and defining the hooks.
	 *
	 * The constructor uses internal functions to import all the
	 * plugin dependencies, and will leverage the Ivory_Search for
	 * registering the hooks and the callback functions used throughout the plugin.
	 */
	public function __construct( $is_opt = null ) {

		if ( null !== $is_opt ) {
			$this->opt = $is_opt;
		} else {
			$this->opt = Ivory_Search::load_options();
		}
	}

	/**
	 * Gets the instance of this class.
	 *
	 * @return self
	 */
	public static function getInstance( $is_opt = null ) {
		if ( ! ( self::$_instance instanceof self ) ) {
			self::$_instance = new self( $is_opt );
		}

		return self::$_instance;
	}

	/**
	 * Loads plugin functionality.
	 */
	function load() {
		$this->set_locale();

		$this->admin_public_hooks();

		if ( is_admin() ) {
			$this->admin_hooks();
		} else {
			$this->public_hooks();
		}
	}

	/**
	 * Defines the locale for this plugin for internationalization.
	 *
	 * Uses the IS_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$is_i18n = IS_I18n::getInstance();
		add_action( 'init', array( $is_i18n, 'load_is_textdomain' ) );
	}

	/**
	 * Defines the hooks and callback functions which are executed both in admin and front end areas.
	 *
	 * @access    private
	 */
	private function admin_public_hooks() {
		$admin_public = IS_Admin_Public::getInstance();
		add_action( 'init', array( $admin_public, 'init' ) );
		add_action( 'widgets_init', array( $admin_public, 'widgets_init' ) );
	}

	/**
	 * Defines the hooks and callback functions that are used for setting up the plugin's admin options.
	 *
	 * @access    private
	 */
	private function admin_hooks() {
		$admin = IS_Admin::getInstance();

		add_action( 'all_admin_notices', array( $admin, 'all_admin_notices' ) );
		add_action( 'admin_footer', array( $admin, 'admin_footer' ), 100 );

		add_action( 'plugin_action_links', array( $admin, 'plugin_action_links' ), 10, 2 );
		add_action( 'admin_menu', array( $admin, 'admin_menu' ) );
		add_action( 'wp_ajax_nopriv_display_posts', array( $admin, 'display_posts' ) );
		add_action( 'wp_ajax_display_posts', array( $admin, 'display_posts' ) );
		add_action( 'admin_enqueue_scripts', array( $admin, 'admin_enqueue_scripts' ) );
		add_action( 'admin_init', array( $admin, 'admin_init' ) );
		add_action( 'is_admin_notices', array( $admin, 'admin_updated_message' ) );
		add_filter( 'map_meta_cap', array( $admin, 'map_meta_cap' ), 10, 4 );
	}

	/**
	 * Defines the hooks and callback functions that are used for executing plugin functionality
	 * in the front end of site.
	 *
	 * @access    private
	 */
	private function public_hooks() {

		$public = IS_Public::getInstance();

		add_action( 'init', array( $public, 'init' ) );
		add_filter( 'get_search_form', array( $public, 'get_search_form' ), 99 );

		if ( isset( $this->opt['disable'] ) ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', array( $public, 'wp_enqueue_scripts' ) );
		add_filter( 'query_vars', array( $public, 'query_vars' ) );

		$header_menu_search = isset( $this->opt['add_search_to_menu_display_in_header'] ) ? $this->opt['add_search_to_menu_display_in_header'] : 0;
		$header_menu_search = isset( $this->opt['header_menu_search'] ) ? $this->opt['header_menu_search'] : $header_menu_search;
		$site_cache = isset( $this->opt['astm_site_uses_cache'] ) ? $this->opt['astm_site_uses_cache'] : 0;
		$site_cache = isset( $this->opt['site_uses_cache'] ) ? $this->opt['site_uses_cache'] : $site_cache;
		$display_in_mobile_menu = $header_menu_search && wp_is_mobile() ? true : false;

		if ( $display_in_mobile_menu || $site_cache ) {
			add_filter( 'wp_head', array( $public, 'header_menu_search' ), 99 );
		}

		if ( ! $display_in_mobile_menu || $site_cache ) {
			add_filter( 'wp_nav_menu_items', array( $public, 'wp_nav_menu_items' ), 99, 2 );
		}

		add_filter( 'posts_distinct_request', array( $public, 'posts_distinct_request' ) );
		add_filter( 'posts_join' , array( $public, 'posts_join' ) );
		add_filter( 'posts_search', array( $public, 'posts_search' ), 501, 2 );
		add_action( 'pre_get_posts', array( $public, 'pre_get_posts' ) );
		add_action( 'wp_footer', array( $public, 'wp_footer' ) );
		add_action( 'wp_head', array( $public, 'wp_head' ) );
	}
}
