<?php

/**
 * Logo Switcher
 *
 * @author Iversen - Carpe Noctem
 * @link https://wordpress.org/plugins/logo-switcher/
 *
 */

// Block direct access
if(!defined('ABSPATH'))exit;

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
  die;
}

$option_name = 'logo_switcher_settings';

delete_option($option_name);