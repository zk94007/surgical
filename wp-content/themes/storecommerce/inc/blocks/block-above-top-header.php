<?php

if (('' != storecommerce_get_option('banner_advertisement_section'))) { ?>
    <div class="banner-promotions-wrapper">
        <?php if (('' != storecommerce_get_option('banner_advertisement_section'))):

            $storecommerce_banner_advertisement = storecommerce_get_option('banner_advertisement_section');
            $storecommerce_banner_advertisement = absint($storecommerce_banner_advertisement);
            $storecommerce_banner_advertisement = wp_get_attachment_image($storecommerce_banner_advertisement, 'full');
            $storecommerce_banner_advertisement_url = storecommerce_get_option('banner_advertisement_section_url');
            $storecommerce_banner_advertisement_url = isset($storecommerce_banner_advertisement_url) ? esc_url($storecommerce_banner_advertisement_url) : '#';

            ?>
            <div class="promotion-section">
                <a href="<?php echo esc_url($storecommerce_banner_advertisement_url); ?>" >
                    <?php echo $storecommerce_banner_advertisement; ?>
                </a>
            </div>
        <?php endif; ?>

    </div>
    <!-- Trending line END -->
    <?php
}