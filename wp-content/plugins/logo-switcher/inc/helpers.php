<?php

/**
 * Logo Switcher
 *
 * @author Iversen - Carpe Noctem
 *
 */

// Block direct access
if(!defined('ABSPATH'))exit;

/**
 * Get the logo url
 *
 * 
 * @return string
 */
function logo_switcher_url() {
  return Logo_Switcher::get_logo_url();
}

/**
 * Print logo url
 * 
 * @param string $path the url target
 * @param string $description the logo image description
 *
 */
function logo_switcher_print($path = null, $description = null) {
  Logo_Switcher::print_link_tag($path, $description);
}

function logo_switcher_link_tag() {
	logo_switcher_print();
}

function logo_switcher_image_tag($classes = array()) {
	Logo_Switcher::print_image_tag($classes);
}