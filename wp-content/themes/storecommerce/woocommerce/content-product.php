<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
    return;
}
?>
<li <?php post_class(); ?>>

    <?php $button_mode = storecommerce_get_option('aft_product_loop_button_display'); ?>
    <div class="product-wrapper <?php echo esc_attr($button_mode); ?>">
        <?php
        /**
         * woocommerce_before_shop_loop_item hook.
         *
         * @hooked woocommerce_template_loop_product_link_open - 10
         * //do_action( 'woocommerce_before_shop_loop_item' );
         *
         * /**
         * woocommerce_before_shop_loop_item_title hook.
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */

        global $post, $product;
        $url = storecommerce_get_featured_image($post->ID, 'storecommerce-thumbnail');
        $cat_display = storecommerce_get_option('aft_product_loop_category');
        ?>
        <div class="product-image-wrapper">
            <div class="horizontal">
            <?php
            if ($url): ?>
                <a href="<?php the_permalink(); ?>">
                <img src="<?php echo esc_attr($url); ?>">
                </a>
            <?php endif; ?>
            <?php //do_action('woocommerce_before_shop_loop_item_title'); ?>

            <ul class="product-item-meta">
                <li><?php do_action('storecommerce_woocommerce_template_loop_add_to_cart'); ?></li>
            </ul>
        </div>
            <?php if($product->get_average_rating()): ?>
                <div class="product-rating-wrapper">
                    <?php do_action('storecommerce_woocommerce_template_loop_rating'); ?>
                </div>
            <?php endif; ?>
            <ul class="product-item-meta verticle">
                <li><?php do_action('storecommerce_woocommerce_add_to_wishlist_button');?></li>
                <li><?php do_action('storecommerce_woocommerce_yith_quick_view_button');?></li>
                <li><?php do_action('storecommerce_woocommerce_yith_compare_button');?></li>
            </ul>

            <div class="badge-wrapper">
                <?php do_action('storecommerce_woocommerce_show_product_loop_sale_flash'); ?>
            </div>
        </div>
        <?php

        /**
         * woocommerce_shop_loop_item_title hook.
         *
         * @hooked woocommerce_template_loop_product_title - 10
         */
        //do_action( 'woocommerce_shop_loop_item_title' );

        /**
         * woocommerce_after_shop_loop_item_title hook.
         *
         * @hooked woocommerce_template_loop_rating - 5
         * @hooked woocommerce_template_loop_price - 10
         */
        //do_action( 'woocommerce_after_shop_loop_item_title' );

        /**
         * woocommerce_after_shop_loop_item hook.
         *
         * @hooked woocommerce_template_loop_product_link_close - 5
         * @hooked woocommerce_template_loop_add_to_cart - 10
         */
        //do_action( 'woocommerce_after_shop_loop_item' );
        ?>

        <div class="product-description ">

            <?php if($cat_display == 'yes'): ?>
                <span class="prodcut-catagory">
                <?php storecommerce_post_categories(); ?>
            </span>
            <?php endif; ?>
            <h4 class="product-title">
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h4>
            <span class="price">
  									<?php do_action('storecommerce_woocommerce_after_shop_loop_item_title'); ?>
  								</span>
        </div>
    </div>
</li>
