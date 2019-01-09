<?php
/**
 * Block Product Carousel support.
 *
 * @package StoreCommerce
 */
?>
<?php

$page_ids = array();
$caption_class = array();
$button_text = array();
$button_link = array();
$slider_page_1 = storecommerce_get_option('slider_page_1');
if(!empty($slider_page_1)){
    $page_ids[] = $slider_page_1;
    $caption_class[] = storecommerce_get_option('page_caption_position_1');
    $button_text[] = storecommerce_get_option('button_text_1');
    $button_link[] = storecommerce_get_option('button_link_1');
}

$slider_page_2 = storecommerce_get_option('slider_page_2');
if(!empty($slider_page_2)){
    $page_ids[] = $slider_page_2;
    $caption_class[] = storecommerce_get_option('page_caption_position_2');
    $button_text[] = storecommerce_get_option('button_text_2');
    $button_link[] = storecommerce_get_option('button_link_2');
}
$slider_page_3 = storecommerce_get_option('slider_page_3');
if(!empty($slider_page_3)){
    $page_ids[] = $slider_page_3;
    $caption_class[] = storecommerce_get_option('page_caption_position_3');
    $button_text[] = storecommerce_get_option('button_text_3');
    $button_link[] = storecommerce_get_option('button_link_3');
}


if($page_ids):

$query_args = array(
    'post_status' => 'publish',
    'post_type' => 'page',
    'post__in' => $page_ids,
    'no_found_rows' => 1,
    'ignore_sticky_posts' => true,
    'order' => 'DESC',
    'orderby' => 'post__in',

);

$all_posts = new WP_Query( $query_args);




?>
<?php if ($all_posts->have_posts()): ?>
    <div class="main-banner-slider owl-carousel owl-theme">
        <?php
        $count = 0;
        while ($all_posts->have_posts()): $all_posts->the_post();

            $url = storecommerce_get_featured_image(get_the_ID(), 'storecommerce-slider-full');

            ?>
            <div class="item">
                <div class="item-single data-bg data-bg-hover data-bg-slide"
                     data-background="<?php echo esc_url($url); ?>">
                    <div class="container pos-rel">
                        <div class="content-caption on-<?php echo esc_attr($caption_class[$count]);?>">
                            <div class="caption-heading">
                                <h3 class="cap-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                            </div>
                            <div class="content-desc">
                                <?php the_content(); ?>
                            </div>

                            <?php if ($button_link[$count]): ?>
                                <div class="aft-btn-warpper btn-style1">
                                    <a href="<?php echo esc_url($button_link[$count]); ?>"><?php echo esc_html($button_text[$count]); ?></a>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        <?php
        $count++;
        endwhile;

        ?>
    </div>
<?php endif; ?>
<?php endif; ?>