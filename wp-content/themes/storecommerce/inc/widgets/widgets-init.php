<?php

// Load widget base.
require_once get_template_directory() . '/inc/widgets/widgets-base.php';

/* Theme Widget sidebars. */
require get_template_directory() . '/inc/widgets/widgets-register-sidebars.php';

/* Theme Widget sidebars. */
require get_template_directory() . '/inc/widgets/widgets-common-functions.php';

/* Theme Widgets*/
/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
    require get_template_directory() . '/inc/widgets/widget-product-grid.php';
    require get_template_directory() . '/inc/widgets/widget-product-carousel.php';
    require get_template_directory() . '/inc/widgets/widget-product-tabbed.php';
    require get_template_directory() . '/inc/widgets/widget-product-category-grid.php';

}


require get_template_directory() . '/inc/widgets/widget-posts-latest.php';
require get_template_directory() . '/inc/widgets/widget-store-author-info.php';
require get_template_directory() . '/inc/widgets/widget-store-call-to-action.php';
require get_template_directory() . '/inc/widgets/widget-store-features.php';
require get_template_directory() . '/inc/widgets/widget-store-offers.php';
require get_template_directory() . '/inc/widgets/widget-social-contacts.php';




/* Register site widgets */
if ( ! function_exists( 'storecommerce_widgets' ) ) :
    /**
     * Load widgets.
     *
     * @since 1.0.0
     */
    function storecommerce_widgets() {

        /**
         * Load WooCommerce compatibility file.
         */
        if ( class_exists( 'WooCommerce' ) ) {
            register_widget( 'StoreCommerce_Product_Grid' );
            register_widget( 'StoreCommerce_Product_Carousel' );
            register_widget( 'StoreCommerce_Products_Tabbed' );
            register_widget( 'StoreCommerce_Product_Category_Grid' );

        }
        register_widget( 'StoreCommerce_Posts_Latest' );
        register_widget( 'StoreCommerce_Store_Author_Info' );
        register_widget( 'StoreCommerce_Store_Call_to_Action' );
        register_widget( 'StoreCommerce_Store_Features' );
        register_widget( 'StoreCommerce_Store_Offers' );
        register_widget( 'StoreCommerce_Social_Contacts' );


    }
endif;
add_action( 'widgets_init', 'storecommerce_widgets' );
