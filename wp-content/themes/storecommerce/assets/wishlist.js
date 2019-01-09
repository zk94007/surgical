(function (e) {
    "use strict";
    var n = window.AFTHEMES_JS || {};

        n.WishListActions = function () {

            e('.aft-product-buttons .yith-btn .yith-wcwl-add-button').on('click', function () {
                e(this).addClass('loading');
            });

            e('body').on('added_to_wishlist', function (event, el, el_wrap) {
                el_wrap.addClass('added').find('.yith-wcwl-add-button').removeClass('loading');
                n.UpdateWishlistCounter();
            });

            e('body').on('removed_from_wishlist', function () {
                n.UpdateWishlistCounter();
            });
        },


        n.UpdateWishlistCounter = function () {
            e.ajax({
                url: woocommerce_params.ajax_url,
                data: {
                    action: 'storecommerce_update_wishlist_count'
                },
                dataType: 'json',
                beforeSend: function () {
                },
                success: function (data) {
                    if (data.count) {
                        e('.aft-wishlist .aft-woo-counter').html(data.count);
                    }
                },
                complete: function () {
                }
            });
        },

        e(document).ready(function () {
            n.WishListActions(), n.UpdateWishlistCounter();
        })
})(jQuery);