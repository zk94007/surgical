<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package StoreCommerce
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
$enable_preloader = storecommerce_get_option('enable_site_preloader');
if (1 == $enable_preloader):
    ?>
    <div id="af-preloader">

        <svg class="spinner-container" width="65px" height="65px" viewBox="0 0 52 52">
            <circle class="path" cx="26px" cy="26px" r="20px" fill="none" stroke-width="4px"/>
        </svg>
    </div>
<?php endif; ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'storecommerce'); ?></a>
    <section id="above-banner-section-wrapper" class="above-banner section">
        <?php
        storecommerce_get_block('above-top-header');
        ?>
    </section>

    <header id="masthead" class="site-header">
        <?php
        $show_top_header = storecommerce_get_option('show_top_header');
        $show_top_header_store_contacts = storecommerce_get_option('show_top_header_store_contacts');
        $show_top_header_social_contacts = storecommerce_get_option('show_top_header_social_contacts');

        if ($show_top_header):
            ?>
            <div class="top-header">
                <div class="container-wrapper">


                    <div class="top-bar-flex">
                        <?php
                        if ($show_top_header_store_contacts):


                            $store_contact_address = storecommerce_get_option('store_contact_address');
                            $store_contact_phone = storecommerce_get_option('store_contact_phone');
                            $store_contact_email = storecommerce_get_option('store_contact_email');
                            ?>
                            <div class="top-bar-left  inside-float col-2-5 float-l">
                                <ul class="top-bar-menu">
                                    <?php if(!empty($store_contact_address)): ?>
                                        <li>
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <span><?php echo esc_html($store_contact_address); ?></span>
                                        </li>
                                    <?php endif; ?>
                                    <?php if(!empty($store_contact_phone)): ?>
                                        <li>
                                            <i class="fa fa-phone-square" aria-hidden="true"></i>
                                            <a href="tel:<?php echo esc_html($store_contact_phone); ?>">
                                                <?php echo esc_html($store_contact_phone); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if(!empty($store_contact_email)): ?>
                                        <li>
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                            <a href="mailto:<?php echo esc_html($store_contact_email); ?>"><?php echo esc_html($store_contact_email); ?></a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <?php if ($show_top_header_social_contacts): ?>
                            <div class="top-bar-right inside-float col-3 float-l ">
                                <?php
                                wp_nav_menu(array(
                                    'theme_location' => 'aft-social-nav',
                                    'link_before' => '<span class="screen-reader-text">',
                                    'link_after' => '</span>',
                                    'menu_id' => 'social-menu',
                                    'container' => 'div',
                                    'container_class' => 'social-navigation'
                                ));
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php storecommerce_get_block('header'); ?>
    </header><!-- #masthead -->

    <?php if (is_front_page()): ?>
        <?php if (is_active_sidebar('above-banner-section')): ?>
            <section class="above-banner section">
                <?php

                dynamic_sidebar('above-banner-section');

                ?>
            </section>
        <?php endif; ?>
        <?php
        $show_main_banner_section = storecommerce_get_option('show_main_news_section');
        if ($show_main_banner_section):
            ?>
            <section class="banner-slider">
                <?php storecommerce_get_block('slider-page'); ?>
            </section>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    $container_class = (is_page_template('tmpl-front-page.php')) ? '' : 'container-wrapper';
    ?>

    <div id="content" class="site-content <?php echo esc_attr($container_class); ?>">

        <?php echo do_action('storecommerce_before_main_content'); ?>

