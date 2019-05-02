/* global pysOptions */

!function ($) {

    var Pinterest = function (options) {

        var Utils = window.pys.Utils;
        var initialized = false;

        function fireEvent(name, data) {

            var params = {};
            Utils.copyProperties(data, params);

            Utils.copyProperties(options.commonEventParams, params);
            Utils.copyProperties(Utils.getRequestParams(), params);

            if (options.debug) {
                console.log('[Pinterest] ' + name, params);
            }

            pintrk('track', name, params);

        }

        /**
         * Public API
         */
        return {

            isEnabled: function () {
                return options.hasOwnProperty('pinterest');
            },

            disable: function () {
                initialized = false;
            },

            /**
             * Load pixel's JS
             *
             * @link: https://developers.pinterest.com/docs/ad-tools/enhanced-match/
             */
            loadPixel: function () {

                if (initialized || !this.isEnabled() || !Utils.consentGiven('pinterest')) {
                    return;
                }

                !function (e) {
                    if (!window.pintrk) {
                        window.pintrk = function () {
                            window.pintrk.queue.push(Array.prototype.slice.call(arguments))
                        };
                        var n = window.pintrk;
                        n.queue = [], n.version = "3.0";
                        var t = document.createElement("script");
                        t.async = !0, t.src = e;
                        var r = document.getElementsByTagName("script")[0];
                        r.parentNode.insertBefore(t, r)
                    }
                }("https://s.pinimg.com/ct/core.js");

                // initialize pixel
                options.pinterest.pixelIds.forEach(function (pixelId) {
                    pintrk('load', pixelId, {em: options.pinterest.advancedMatching.em, np: 'pixelyoursite'});
                    pintrk('page');
                });

                initialized = true;

                Utils.fireStaticEvents('pinterest');

            },

            fireEvent: function (name, data) {

                if (!initialized || !this.isEnabled()) {
                    return false;
                }

                data.delay = data.delay || 0;
                data.params = data.params || {};

                if (data.delay === 0) {

                    fireEvent(name, data.params);

                } else {

                    setTimeout(function (name, params) {
                        fireEvent(name, params);
                    }, data.delay * 1000, name, data.params);

                }

                return true;

            },

            onAdSenseEvent: function () {

                if (initialized && this.isEnabled() && options.pinterest.adSenseEventEnabled) {
                    this.fireEvent('AdSense', {
                        params: Utils.copyProperties(options.pinterest.contentParams, {})
                    });
                }

            },

            onClickEvent: function (params) {

                if (initialized && this.isEnabled() && options.pinterest.clickEventEnabled) {
                    this.fireEvent('ClickEvent', {
                        params: Utils.copyProperties(options.pinterest.contentParams, params)
                    });
                }

            },

            onWatchVideo: function (params) {

                if (initialized && this.isEnabled() && options.pinterest.watchVideoEnabled) {
                    this.fireEvent('WatchVideo', {
                        params: Utils.copyProperties(options.pinterest.contentParams, params)
                    });
                }

            },

            onCommentEvent: function () {

                if (initialized && this.isEnabled() && options.pinterest.commentEventEnabled) {

                    this.fireEvent('Comment', {
                        params: Utils.copyProperties(options.pinterest.contentParams, {})
                    });

                }

            },

            onFormEvent: function (params) {

                if (initialized && this.isEnabled() && options.pinterest.formEventEnabled) {

                    this.fireEvent('Form', {
                        params: Utils.copyProperties(options.pinterest.contentParams, params)
                    });

                }

            },

            onDownloadEvent: function (params) {

                if (initialized && this.isEnabled() && options.pinterest.downloadEnabled) {

                    this.fireEvent('Download', {
                        params: Utils.copyProperties(options.pinterest.contentParams, params)
                    });

                }

            },

            onWooAddToCartOnButtonEvent: function (product_id) {

                if (window.pysWooProductData.hasOwnProperty(product_id)) {
                    if (window.pysWooProductData[product_id].hasOwnProperty('pinterest')) {

                        this.fireEvent('AddToCart', {
                            params: Utils.copyProperties(window.pysWooProductData[product_id]['pinterest'], {})
                        });

                    }
                }

            },

            onWooAddToCartOnSingleEvent: function (product_id, qty, is_variable, is_external, $form) {

                window.pys_woo_product_data = window.pys_woo_product_data || [];

                if (is_variable) {
                    product_id = parseInt($form.find('input[name="variation_id"]').val());
                }

                if (window.pysWooProductData.hasOwnProperty(product_id)) {
                    if (window.pysWooProductData[product_id].hasOwnProperty('pinterest')) {

                        var params = Utils.copyProperties(window.pysWooProductData[product_id]['pinterest'], {});

                        // maybe customize value option
                        if (options.woo.addToCartOnButtonValueEnabled && options.woo.addToCartOnButtonValueOption !== 'global') {
                            params.value = params.value * qty;
                        }

                        params.product_quantity = qty;

                        var event_name = is_external ? options.woo.affiliateEventName : 'AddToCart';

                        this.fireEvent(event_name, {
                            params: params
                        });

                    }
                }

            },

            onWooRemoveFromCartEvent: function (cart_item_hash) {

                window.pysWooRemoveFromCartData = window.pysWooRemoveFromCartData || [];

                if (window.pysWooRemoveFromCartData[cart_item_hash].hasOwnProperty('pinterest')) {

                    this.fireEvent('RemoveFromCart', {
                        params: Utils.copyProperties(window.pysWooRemoveFromCartData[cart_item_hash]['pinterest'], {})
                    });

                }

            },

            onWooAffiliateEvent: function (product_id) {

                if (window.pysWooProductData.hasOwnProperty(product_id)) {
                    if (window.pysWooProductData[product_id].hasOwnProperty('pinterest')) {

                        this.fireEvent(options.woo.affiliateEventName, {
                            params: Utils.copyProperties(window.pysWooProductData[product_id]['pinterest'], {})
                        });

                    }
                }

            },

            onWooPayPalEvent: function () {

                window.pysWooPayPalData = window.pysWooPayPalData || [];

                if (window.pysWooPayPalData.hasOwnProperty('pinterest')) {
                    this.fireEvent(options.woo.paypalEventName, {
                        params: Utils.copyProperties(window.pysWooPayPalData['pinterest'], options.pinterest.contentParams)
                    });
                }

            },

            onEddAddToCartOnButtonEvent: function (download_id, price_index, qty) {

                if (window.pysEddProductData.hasOwnProperty(download_id)) {

                    var index;

                    if (price_index) {
                        index = download_id + '_' + price_index;
                    } else {
                        index = download_id;
                    }

                    if (window.pysEddProductData[download_id].hasOwnProperty(index)) {
                        if (window.pysEddProductData[download_id][index].hasOwnProperty('pinterest')) {

                            var params = Utils.copyProperties(window.pysEddProductData[download_id][index]['pinterest'], {});

                            // maybe customize value option
                            if (options.edd.addToCartOnButtonValueEnabled && options.edd.addToCartOnButtonValueOption !== 'global') {
                                params.value = params.value * qty;
                            }

                            params.product_quantity = qty;

                            this.fireEvent('AddToCart', {
                                params: params
                            });

                        }
                    }

                }

            },

            onEddRemoveFromCartEvent: function (item) {

                if (item.hasOwnProperty('pinterest')) {

                    this.fireEvent('RemoveFromCart', {
                        params: Utils.copyProperties(item['pinterest'], {})
                    });

                }

            }

        };

    }(window.pysOptions);

    window.pys = window.pys || {};
    window.pys.Pinterest = Pinterest;

}(jQuery);