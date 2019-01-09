<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package StoreCommerce
 */

if ( ! is_active_sidebar( 'shop-sidebar-widgets' ) ) {
	return;
}

$global_layout = storecommerce_get_option('store_global_alignment');
$page_layout = $global_layout;

if ($page_layout == 'full-width-content') {
    return;
}

?>

<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'shop-sidebar-widgets' ); ?>
</aside><!-- #secondary -->
