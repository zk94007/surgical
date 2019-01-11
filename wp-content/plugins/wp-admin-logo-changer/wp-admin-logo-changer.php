<?php
/*
  Plugin Name: WP Admin Logo Changer
  Plugin URI: https://aftabmuni.wordpress.com/
  Description: This plugin is useful when you need to change wordpress admin panel default logo. The default logo will be replaced by the uploaded new logo.
  Author: Aftab Muni
  Version: 1.0
  Author URI: https://aftabmuni.wordpress.com/
 */

/*
  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.
 */

if (!defined('ABSPATH')) {
    exit;
}

include 'functions.php';

define('AMM_WPALC_VERSION', '1.0');
define('AMM_WPALC_PLUGIN_URL', plugin_dir_url(__FILE__));
define('AMM_WPALC_PLUGIN_DIR', plugin_dir_path(__FILE__));


add_action('admin_enqueue_scripts', 'wp_admin_logo_changer_admin_style_script');

function wp_admin_logo_changer_admin_style_script() {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');
}

add_action('admin_menu', 'wp_admin_logo_changer_menu');

function wp_admin_logo_changer_menu() {
    add_options_page(
            'WP Admin Logo Changer', 'WP Admin Logo Changer', 'manage_options', 'wp_admin_logo_changer_dashboard', 'wp_admin_logo_changer_class'
    );
}

add_action('login_enqueue_scripts', 'wp_admin_logo_changer_login_logo');

function wp_admin_logo_changer_login_logo() {
    ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url('<?php echo esc_html(get_option('wp_admin_logo_changer_image')); ?>');
            -webkit-background-size: <?php echo esc_html(get_option('wp_admin_logo_changer_image')); ?>px;
            background-size: auto 100%;
        }
    </style>
<?php }
?>