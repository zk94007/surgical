<?php
/**
 * Load libraries.
 */
require_once  get_template_directory()  . '/lib/tgm/class-tgm-plugin-activation.php';

/**
 * Load widgets.
 */
require get_template_directory() . '/inc/widgets/widgets-init.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/tgmpa-functions.php';


/**
 * Load info.
 */
if ( is_admin() ) {
    require get_template_directory().'/lib/info/class.info.php';
    require get_template_directory().'/lib/info/info.php';
}