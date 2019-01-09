<?php
/**
 * Recommended plugins
 *
 * @package CoverNews
 */

if ( ! function_exists( 'storecommerce_recommended_plugins' ) ) :

    /**
     * Recommend plugins.
     *
     * @since 1.0.0
     */
    function storecommerce_recommended_plugins() {

        $plugins = array(
            array(
                'name'     => esc_html__( 'WooCommerce', 'storecommerce' ),
                'slug'     => 'woocommerce',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'Contact Form 7', 'storecommerce' ),
                'slug'     => 'contact-form-7',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'YITH WooCommerce Wishlist', 'storecommerce' ),
                'slug'     => 'yith-woocommerce-wishlist',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'YITH WooCommerce Quick View', 'storecommerce' ),
                'slug'     => 'yith-woocommerce-quick-view',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'YITH WooCommerce Compare', 'storecommerce' ),
                'slug'     => 'yith-woocommerce-compare',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'Woo Floating Minicart', 'storecommerce' ),
                'slug'     => 'woo-floating-minicart',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'Woo Total Sales', 'storecommerce' ),
                'slug'     => 'woo-total-sales',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'Woo Set Price Note', 'storecommerce' ),
                'slug'     => 'woo-set-price-note',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'WP Post Author', 'storecommerce' ),
                'slug'     => 'wp-post-author',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'One Click Demo Import', 'storecommerce' ),
                'slug'     => 'one-click-demo-import',
                'required' => false,
            ),
        );

        tgmpa( $plugins );

    }

endif;

add_action( 'tgmpa_register', 'storecommerce_recommended_plugins' );
