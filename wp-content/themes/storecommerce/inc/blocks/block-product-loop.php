<?php
/**
 * Block Product Carousel support.
 *
 * @package StoreCommerce
 */
?>
<?php $button_mode = storecommerce_get_option('aft_product_loop_button_display'); ?>
<div class="product-wrapper <?php echo esc_attr($button_mode); ?>" >
    <?php
    global $post, $product;
    $url = storecommerce_get_featured_image($post->ID, 'storecommerce-thumbnail');

    $cat_display = storecommerce_get_option('aft_product_loop_category');
    ?>
    <div class="product-image-wrapper">
    <?php
    if ($url): ?>
        <a href="<?php the_permalink(); ?>">
        <img src="<?php echo esc_attr($url); ?>">
        </a>
    <?php endif; ?>
   <div class="horizontal">
    <ul class="product-item-meta">
        <li><?php do_action('storecommerce_woocommerce_template_loop_add_to_cart');?></li>
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
    <div class="product-description">
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
