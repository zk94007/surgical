<?php
/**
 * Add to wishlist template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.0
 */

if (!defined('YITH_WCWL')) {
    exit;
} // Exit if accessed directly

global $product;

$tooltip_start = '<div data-toggle="tooltip" data-placement="top" title="'.$browse_wishlist_text.'">';
$tooltip_end = '</div>';

$in_wishlist = $class = '';

$already_in_wishlist_icon = storecommerce_get_option('already_in_wishlist_icon', true);
if ($already_in_wishlist_icon) {
    $in_wishlist = '<a href="' . esc_url($wishlist_url) . '" rel="nofollow">';
    $in_wishlist .= $tooltip_start;
    $in_wishlist .= '<i class="' . esc_attr($already_in_wishlist_icon) . ' aft-alt-icon"></i>';
    $in_wishlist .= $tooltip_end;
    $in_wishlist .= '</a>';
}

if( $exists && !$available_multi_wishlist ){
    $class = ' added';
}
?>

<div class="yith-wcwl-add-to-wishlist add-to-wishlist-<?php echo $product_id ?> <?php echo esc_attr($class);?>">
    <?php if (!($disable_wishlist && !is_user_logged_in())): ?>
        <div class="yith-wcwl-add-button <?php echo ($exists && !$available_multi_wishlist) ? 'hide' : 'show' ?>"
             style="display:<?php echo ($exists && !$available_multi_wishlist) ? 'none' : 'block' ?>">
            <?php yith_wcwl_get_template('add-to-wishlist-' . $template_part . '.php', $atts); ?>
        </div>
        <div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;">
            <?php
            if (is_product()) {
                if( $product->get_id() == get_queried_object_id() ){
                    ?>
                    <span class="feedback"><?php echo $product_added_text ?></span>
                    <a href="<?php echo esc_url($wishlist_url) ?>" rel="nofollow">
                        <?php echo apply_filters('yith-wcwl-browse-wishlist-label', $browse_wishlist_text) ?>
                    </a>
                    <?php
                }else{
                    echo $in_wishlist;
                }
            } else {
                echo $in_wishlist;
            }
            ?>
        </div>
        <div class="yith-wcwl-wishlistexistsbrowse <?php echo ($exists && !$available_multi_wishlist) ? 'show' : 'hide' ?>"
             style="display:<?php echo ($exists && !$available_multi_wishlist) ? 'block' : 'none' ?>">
            <?php
            if (is_product()) {
                if( $product->get_id() == get_queried_object_id() ) {
                    ?>
                    <span class="feedback"><?php echo $already_in_wishslist_text ?></span>
                    <a href="<?php echo esc_url($wishlist_url) ?>" rel="nofollow">
                        <?php echo apply_filters('yith-wcwl-browse-wishlist-label', $browse_wishlist_text) ?>
                    </a>
                    <?php
                }else{
                    echo $in_wishlist;
                }
            } else {
                echo $in_wishlist;
            }
            ?>
        </div>
        <div style="clear:both"></div>
        <div class="yith-wcwl-wishlistaddresponse"></div>
    <?php else: ?>
        <a href="<?php echo esc_url(add_query_arg(array('wishlist_notice' => 'true', 'add_to_wishlist' => $product_id), get_permalink(wc_get_page_id('myaccount')))) ?>"
           rel="nofollow" class="<?php echo str_replace('add_to_wishlist', '', $link_classes) ?>">
            <?php echo $icon ?>
            <?php echo $label ?>
        </a>
    <?php endif; ?>
</div>
<div class="clear"></div>