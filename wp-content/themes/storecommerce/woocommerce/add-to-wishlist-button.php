<?php
/**
 * Add to wishlist button template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.8
 */

if ( ! defined( 'YITH_WCWL' ) ) {
    exit;
} // Exit if accessed directly

global $product;
$add_to_wishlist_icon = storecommerce_get_option('add_to_wishlist_icon', true);

$tooltip_start = '<div class="aft-tooltip" data-toggle="tooltip" data-placement="top" title="'.$label.'">';
$tooltip_end = '</div>';
?>

<a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product_id ) )?>" rel="nofollow" data-product-id="<?php echo $product_id ?>" data-product-type="<?php echo $product_type?>" class="<?php echo $link_classes ?>" >
    <?php
    if(!is_product()){
        if( $add_to_wishlist_icon ){
            echo $tooltip_start.'<i class="'.esc_attr($add_to_wishlist_icon).' aft-alt-icon"></i>'.$tooltip_end;
        }
    }else{
        if( $product->get_id() == get_queried_object_id() ){
            echo $icon;
            echo $label;
        }else{
            if( $add_to_wishlist_icon ){
                echo $tooltip_start.'<i class="'.esc_attr($add_to_wishlist_icon).' aft-alt-icon"></i>'.$tooltip_end;
            }
        }
    }
    ?>
</a>
<img src="<?php echo esc_url( YITH_WCWL_URL . 'assets/images/wpspin_light.gif' ) ?>" class="ajax-loading" alt="loading" width="16" height="16" style="visibility:hidden" />