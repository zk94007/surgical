<?php
/**
 * OCDI support.
 *
 * @package StoreCommerce
 */

// Disable PT branding.
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

/**
 * OCDI after import.
 *
 * @since 1.0.0
 */
function storecommerce_ocdi_after_import() {

    // Assign front page and posts page (blog page).
    $front_page_id = null;
    $blog_page_id  = null;
    $shop_page_id  = null;
    $cart_page_id  = null;
    $checkout_page_id  = null;
    $myaccount_page_id  = null;
    $wishlist_page_id  = null;

    $front_page = get_page_by_title( 'Home' );

    if ( $front_page ) {
        if ( is_array( $front_page ) ) {
            $first_page = array_shift( $front_page );
            $front_page_id = $first_page->ID;
        } else {
            $front_page_id = $front_page->ID;
        }
    }

    $blog_page = get_page_by_title( 'Blog' );

    if ( $blog_page ) {
        if ( is_array( $blog_page ) ) {
            $first_page = array_shift( $blog_page );
            $blog_page_id = $first_page->ID;
        } else {
            $blog_page_id = $blog_page->ID;
        }
    }

    $shop_page = get_page_by_title( 'Shop' );

    if ( $shop_page ) {
        if ( is_array( $shop_page ) ) {
            $first_page = array_shift( $shop_page );
            $shop_page_id = $first_page->ID;
        } else {
            $shop_page_id = $shop_page->ID;
        }
    }

    $cart_page = get_page_by_title( 'Cart' );

    if ( $cart_page ) {
        if ( is_array( $cart_page ) ) {
            $first_page = array_shift( $cart_page );
            $cart_page_id = $first_page->ID;
        } else {
            $cart_page_id = $cart_page->ID;
        }
    }

    $checkout_page = get_page_by_title( 'Checkout' );

    if ( $checkout_page ) {
        if ( is_array( $checkout_page ) ) {
            $first_page = array_shift( $checkout_page );
            $checkout_page_id = $first_page->ID;
        } else {
            $checkout_page_id = $checkout_page->ID;
        }
    }

    $myaccount_page = get_page_by_title( 'My Account' );

    if ( $myaccount_page ) {
        if ( is_array( $myaccount_page ) ) {
            $first_page = array_shift( $myaccount_page );
            $myaccount_page_id = $first_page->ID;
        } else {
            $myaccount_page_id = $myaccount_page->ID;
        }
    }

    $wishlist_page = get_page_by_title( 'Wishlist' );

    if ( $wishlist_page ) {
        if ( is_array( $wishlist_page ) ) {
            $first_page = array_shift( $wishlist_page );
            $wishlist_page_id = $first_page->ID;
        } else {
            $wishlist_page_id = $wishlist_page->ID;
        }
    }

    if ( $front_page_id && $blog_page_id ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front_page_id );
        update_option( 'page_for_posts', $blog_page_id );
    }

    if($shop_page){
        update_option( 'woocommerce_shop_page_id', $shop_page_id );
    }

    if($cart_page){
        update_option( 'woocommerce_cart_page_id', $cart_page_id );
    }

    if($checkout_page){
        update_option( 'woocommerce_checkout_page_id', $checkout_page_id );
    }

    if($myaccount_page){
        update_option( 'woocommerce_myaccount_page_id', $myaccount_page_id );
    }

    if($wishlist_page){
        update_option( 'yith_wcwl_wishlist_page_id', $wishlist_page_id );
    }



    // Assign navigation menu locations.
    $menu_location_details = array(
        'aft-primary-nav'     => 'main-menu-items',
        'aft-footer-nav'      => 'footer-menu-items',
        'aft-social-nav'      => 'social-menu-items',
    );

    if ( ! empty( $menu_location_details ) ) {
        $navigation_settings = array();
        $current_navigation_menus = wp_get_nav_menus();
        if ( ! empty( $current_navigation_menus ) && ! is_wp_error( $current_navigation_menus ) ) {
            foreach ( $current_navigation_menus as $menu ) {
                foreach ( $menu_location_details as $location => $menu_slug ) {
                    if ( $menu->slug === $menu_slug ) {
                        $navigation_settings[ $location ] = $menu->term_id;
                    }
                }
            }
        }

        set_theme_mod( 'nav_menu_locations', $navigation_settings );
    }
}
add_action( 'pt-ocdi/after_import', 'storecommerce_ocdi_after_import' );