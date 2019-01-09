<?php
/**
 * Block Header .
 *
 * @package StoreCommerce
 */
?>

<div class="header-style-3">
    <div class="desktop-header clearfix">
        <?php
        $class = '';
        $background = '';
        if (has_header_image()) {
            $class = 'data-bg';
            $background = get_header_image();
        }

        ?>
        <div class="aft-header-background  <?php echo esc_attr($class); ?>" data-background="<?php echo esc_attr($background); ?>">
        <div class="container-wrapper">

            <div class="header-left-part">
                <div class="logo-brand">
                    <div class="site-branding">
                        <?php
                        the_custom_logo();
                        if (is_front_page() && is_home()) :
                            ?>
                            <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                                      rel="home"><?php bloginfo('name'); ?></a></h1>
                        <?php
                        else :
                            ?>
                            <h3 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                                      rel="home"><?php bloginfo('name'); ?></a></h3>
                        <?php
                        endif;
                        $storecommerce_description = get_bloginfo('description', 'display');
                        if ($storecommerce_description || is_customize_preview()) :
                            ?>
                            <p class="site-description"><?php echo $storecommerce_description; /* WPCS: xss ok. */ ?></p>
                        <?php endif; ?>
                    </div><!-- .site-branding -->
                </div>
                <div class="search">
                    <?php storecommerce_product_search_form(); ?>
                </div>
                <?php if (class_exists('WooCommerce')): ?>
                <div class="account-user">
                    <?php


                    if (is_user_logged_in()) {
                        $current_user = wp_get_current_user();
                        //$account_texts = __('My Account', 'storecommerce');
                        $account_texts = $current_user->display_name;
                    } else {
                        $account_texts = __('Login', 'storecommerce');
                        if (get_option('users_can_register')) {
                            $account_texts = __('Login/Register', 'storecommerce');
                        }
                    }

                    ?>

                    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>">
                        <!--  my account --> <i class="fa fa-user-circle-o"></i>
                        <?php echo esc_html($account_texts); ?>
                    </a>
                </div>
                <?php endif; ?>
                <?php
                $show_offcanvas = true;
                if (is_active_sidebar('express-off-canvas-panel')): ?>
                    <div class="express-off-canvas-panel">
                                <span class="offcanvas">
                                     <a href="#offcanvasCollapse" class="offcanvas-nav">
                                          <i class="fa fa-th"></i>
                                       </a>
                                </span>
                    </div>
                <?php endif; ?>

            </div>
        </div>
        </div>
        <div id="site-primary-navigation" class="navigation-section-wrapper clearfix">
            <div class="container-wrapper">
                <div class="header-middle-part">
                    <div class="navigation-container">

                        <nav id="site-navigation" class="main-navigation">
                            <span class="toggle-menu" aria-controls="primary-menu" aria-expanded="false">
                                <span class="screen-reader-text">
                                    <?php esc_html_e('Primary Menu', 'storecommerce'); ?></span>
                                 <i class="ham"></i>
                            </span>     
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'aft-primary-nav',
                                'menu_id' => 'primary-menu',
                                'container' => 'div',
                                'container_class' => 'menu main-menu'
                            ));
                            ?>
                        </nav><!-- #site-navigation -->

                    </div>
                </div>
                <div class="header-right-part">

                    <div class="search aft-show-on-mobile">
                        <div id="myOverlay" class="overlay">
                            <span class="close-serach-form" title="Close Overlay">x</span>
                            <div class="overlay-content">
                                <?php storecommerce_product_search_form(); ?>
                            </div>
                        </div>
                        <button class="open-search-form"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="account-user aft-show-on-mobile">
                        <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>">
                            <!--  my account --> <i class="fa fa-user-circle-o"></i>
                        </a>
                    </div>


                    <?php if (function_exists('YITH_WCWL')): ?>
                        <div class="wishlist-shop">
                            <span class="wishlist-icon">
                                <?php storecommerce_woocommerce_header_wishlist(); ?>
                            </span>
                        </div>
                    <?php endif; ?>
                    <?php if (class_exists('WooCommerce')): ?>

                        <div class="cart-shop">

                            <div class="af-cart-wrapper dropdown">
                                <?php storecommerce_woocommerce_header_cart(); ?>
                            </div>

                        </div>
                    <?php endif; ?>

                    <?php
                    $show_offcanvas = true;
                    if (is_active_sidebar('express-off-canvas-panel')): ?>
                        <div class="express-off-canvas-panel aft-show-on-mobile">
                                <span class="offcanvas">
                                     <a href="#offcanvasCollapse" class="offcanvas-nav">
                                          <i class="fa fa-th"></i>
                                       </a>
                                </span>
                        </div>
                    <?php endif; ?>


                </div>
            </div>
        </div>
    </div>
</div>