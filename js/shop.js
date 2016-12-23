(function ($) {
    $.Shop = function (element) {
        this.$element = $(element);
        this.init();
    };

    $.Shop.prototype = {
        init: function () {

            // Properties

            this.cartPrefix = "smugglers-"; // Prefix string to be prepended to the cart's name in the session storage
            this.cartName = this.cartPrefix + "cart"; // Cart name in the session storage
            this.total = this.cartPrefix + "total"; // Total key in the session storage
            this.storage = sessionStorage; // shortcut to the sessionStorage object


            this.$formAddToCart = this.$element.find("form.add-to-cart"); // Forms for adding items to the cart
            this.$formCart = this.$element.find("#cart"); // Shopping cart forms
            this.$subTotal = this.$element.find("#subtotal"); // Element that displays the subtotal charges
            this.$shoppingCartActions = this.$element.find("#shopping-cart-actions"); // Cart actions links
            this.$emptyCartBtn = this.$shoppingCartActions.find("#empty-cart"); // Empty cart button


            this.currency = "&euro;"; // HTML entity of the currency to be displayed in the layout
            this.currencyString = "€"; // Currency symbol as textual string

            // Method invocation

            this.createCart();
            this.handleAddToCartForm();
            this.emptyCart();
            this.displayCart();
            this.updateProduct();
            this.deleteProduct();
            this.sendCart();

        },

        // Public methods

        // Creates the cart keys in the session storage

        createCart: function () {
            if (this.storage.getItem(this.cartName) == null) {

                var cart = {};
                cart.items = [];

                this.storage.setItem(this.cartName, this._toJSONString(cart));
                this.storage.setItem(this.total, "0");
            }
        },

        // Delete a product from the shopping cart

        deleteProduct: function () {
            var self = this;
            if (self.$formCart.length) {
                $(document).on("click", ".delete-item", function (e) {
                    e.preventDefault();
                    var cart = self._toJSONObject(self.storage.getItem(self.cartName))
                    var items = cart.items;
                    var productName = $(this).data("product");
                    var this_sku = $(this).data("sku");
                    var newItems = [];
                    for (var i = 0; i < items.length; ++i) {
                        var item = items[i];
                        var product = item.product;
                        var sku = item.sku;
                        if (sku == this_sku) {
                            items.splice(i, 1);
                        }
                    }
                    newItems = items;
                    var updatedCart = {};
                    updatedCart.items = newItems;

                    var updatedTotal = 0;
                    var totalQty = 0;
                    if (newItems.length == 0) {
                        updatedTotal = 0;
                        totalQty = 0;
                    } else {
                        for (var j = 0; j < newItems.length; ++j) {
                            var prod = newItems[j];
                            var sub = prod.price * prod.qty;
                            updatedTotal += sub;
                            totalQty += prod.qty;
                        }
                    }

                    self.storage.setItem(self.total, self._convertNumber(updatedTotal));

                    self.storage.setItem(self.cartName, self._toJSONString(updatedCart));
                    $(this).parents(".product").remove();
                    self.$subTotal[0].innerHTML = "Total " + " <span>" + self.currency + parseFloat(self.storage.getItem(self.total)).toFixed(2) + "</span>";
                    self.$formCart.find('.cart-amount').text(newItems.length);

                    if (newItems.length == 0) {
//                        var header = $('.header-scroll');
//                        header.toggleClass('active');
                        $('.cart').removeClass('active').delay(2000);
                    }

                });
            }
        },

        // Update a product in the shopping cart

        updateProduct: function () {
            var self = this;
            if (self.$formCart.length) {
                $(document).on("change", ".cart-product input[type=number]", function (e) {
                    // e.preventDefault();
                    var cart = self._toJSONObject(self.storage.getItem(self.cartName))
                    var items = cart.items;
                    var this_guid = $(this).closest('.cart-product').data("id");
                    check_quantity($(this),0,50);
                    var new_qty = $(this).val();
                    var newItems = [];
                    for (var i = 0; i < items.length; ++i) {
                        if (items[i].id == this_guid) {
                            if (new_qty == 0) {
                                items.splice(i, 1);
                                $(this).parents(".product").remove();
                            } else {
                                items[i].qty = new_qty;
                                $(this).attr('data-qty',$(this).val());
                            }
                        }
                    }
                    newItems = items;
                    var updatedCart = {};
                    updatedCart.items = newItems;

                    var updatedTotal = 0;
                    var totalQty = 0;
                    if (newItems.length == 0) {
                        updatedTotal = 0;
                        totalQty = 0;
                    } else {
                        for (var j = 0; j < newItems.length; ++j) {
                            var prod = newItems[j];
                            var sub = prod.price * prod.qty;
                            updatedTotal += sub;
                            totalQty += prod.qty;
                        }
                    }

                    self.storage.setItem(self.total, self._convertNumber(updatedTotal));

                    self.storage.setItem(self.cartName, self._toJSONString(updatedCart));
                    self.$subTotal[0].innerHTML = "Total " + " <span>" + self.currency + parseFloat(self.storage.getItem(self.total)).toFixed(2) + "</span>";
                    self.$formCart.find('.cart-amount').text(newItems.length);

                    if (newItems.length == 0) {
//                        var header = $('.header-scroll');
//                        header.toggleClass('active');
                        $('.cart').removeClass('active').delay(2000);
                    }

                });
            }
        },

        // Send the cart to the API

        sendCart: function () {
            var self = this;
            if (self.$formCart.length) {
                $(document).on("click", "a.checkout", function (e) {
                    e.preventDefault();

                    var items = self.storage.getItem(self.cartName);
                    $.ajax({
                        type: 'POST',
                        url: '/php/handleOrder.php',
                        data: items,
                        success: function(data) {
                            if(data.hasOwnProperty('error')) {
                                alert(data.error);
                            } else if(data.hasOwnProperty('redirectUrl')) {
                                self.emptyCart();
                                window.location.href = data.redirectUrl;
                                /*$('.fc--overlay').toggle();
                                $('.fc--container').toggle();
                                $('.fc--exit').css('display','none');
                                $('.fc--container').css('top',$(window).scrollTop());
                                document.getElementById('fc--frame').src = data.redirectUrl;
                                $('.cart').toggleClass('active');*/
                            }
                        },
                        contentType: "application/json",
                        dataType: 'json'
                    });
                    return false;
                });
            }
        },

        // Displays the shopping cart

        displayCart: function () {
            if (this.$formCart.length) {
                var cart = this._toJSONObject(this.storage.getItem(this.cartName));
                var items = cart.items;
                var $tableCart = this.$formCart.find(".foldout");
                var $tableCartBody = $tableCart.find(".products");

                this.$formCart.find('.cart-amount').text(items.length);

                if (items.length == 0) {
                    $tableCartBody.html("");
                } else {
                    for (var i = 0; i < items.length; ++i) {
                        var item = items[i];
                        var product = item.product;
                        var guid = item.id;
                        var sku = item.sku;
                        var pack = item.pack;
                        var price = this.currency + " " + item.price;
                        var qty = item.qty;
                        var sizes = item.size;
                        var html = "<div class=\"product cart-product\" data-id=\"" + guid + "\"><a class=\"delete-item\" data-sku=\"" + sku + "\" data-product=\"" + product + "\"><span class=\"icon icon-delete\"></span></a>";
                        html += "<div class=\"type\"><div class=\"title\">" + product + "<div class=\"total\">" + price + "</div></div><p class=\"subtitle\">" + pack
                        + " pack" + " (" + sizes + ")" + "</p><input type=\"number\" data-qty=\"" + qty + "\" value=\"" + qty +"\"></div>";
                        $tableCartBody.html($tableCartBody.html() + html);
                    }

                }

                if (items.length == 0) {
                    this.$subTotal[0].innerHTML = "Total " + " <span>" + this.currency + "0.00 </span>";
                } else {
                    var total = this.storage.getItem(this.total);
                    this.$subTotal[0].innerHTML = "Total " + " <span>" + this.currency + parseFloat(total).toFixed(2) + "</span>";
//                    var header = $('.header-scroll');
//                    header.addClass('active');
                }
            }
        },

        // Empties the cart by calling the _emptyCart() method
        // @see $.Shop._emptyCart()

        emptyCart: function () {
            var self = this;
            if (self.$emptyCartBtn.length) {
                self.$emptyCartBtn.on("click", function () {
                    self._emptyCart();
                });
            }
        },

        // Adds items to the shopping cart
        handleAddToCartForm: function () {
            var self = this;
            self.$formAddToCart.each(function () {

                var $form = $(this);
                var $product = $form.parent();
                var name = $product.data("name");

                $form.find(".order").on("click", function (e) {
                    e.preventDefault();
                    var $option = $form.find(".active");
                    var guid = self._guid();
                    var pack = $option.data("pack");
                    var sku = $option.data("sku");
                    var price = parseFloat($option.data("price")).toFixed(2);
                    var sizes = [];
                    sizes.push($form.find(".size1").val());
                    // Could be better but works for now
                    if (pack != "single")
                        sizes.push($form.find(".size2").val());
                    //
                    var qty = self._convertString($form.find(".qty").val());
                    var subTotal = qty * price;
                    var total = self._convertString(self.storage.getItem(self.total));
                    var sTotal = total + subTotal;
                    self.storage.setItem(self.total, sTotal);
                    self._addToCart({
                        id: guid,
                        sku: sku,
                        pack: pack,
                        product: name,
                        price: price,
                        qty: qty,
                        size: sizes
                    });

                    var $tableCart = self.$formCart.find(".foldout");
                    var $tableCartBody = $tableCart.find(".products");
                    var html = "<div class=\"product cart-product\" data-id=\"" + guid + "\"><a class=\"delete-item\" data-sku=\"" + sku + "\" data-product=\"" + name + "\"><span class=\"icon icon-delete\"></span></a>";
                    html += "<div class=\"type\"><div class=\"title\">" + name + "<div class=\"total\">" + self.currency + " " + price + "</div></div> <p class=\"subtitle\">" + pack + " pack" + " (" + sizes + ")" + "</p><input type=\"number\" data-qty=\"" + qty + "\" value=\"" + qty +"\"></div>";

                    $tableCartBody.html($tableCartBody.html() + html);

                    self.$subTotal[0].innerHTML = "Total " + " <span>" + self.currency + parseFloat(sTotal).toFixed(2) + "</span>";
                    self.$formCart.find('.cart-amount').text(self._toJSONObject(self.storage.getItem(self.cartName)).items.length);

                    var header = $('.header-scroll');
//                    if(header.is(":visible")) {
                        header.addClass('active');
//                    }
                    $('.cart').toggleClass('active');
                });
            });
        },

        // Private methods


        // Empties the session storage
        _emptyCart: function () {
            this.storage.clear();
        },

        /* Format a number by decimal places
         * @param num Number the number to be formatted
         * @param places Number the decimal places
         * @returns n Number the formatted number
         */
        _formatNumber: function (num, places) {
            var n = num.toFixed(places);
            return n;
        },

        /* Extract the numeric portion from a string
         * @param element Object the jQuery element that contains the relevant string
         * @returns price String the numeric string
         */
        _extractPrice: function (element) {
            var self = this;
            var text = element.text();
            var price = text.replace(self.currencyString, "").replace(" ", "");
            return price;
        },

        /* Converts a numeric string into a number
         * @param numStr String the numeric string to be converted
         * @returns num Number the number
         */
        _convertString: function (numStr) {
            var num;
            if (/^[-+]?[0-9]+\.[0-9]+$/.test(numStr)) {
                num = parseFloat(numStr);
            } else if (/^\d+$/.test(numStr)) {
                num = parseInt(numStr, 10);
            } else {
                num = Number(numStr);
            }

            if (!isNaN(num)) {
                return num;
            } else {
                console.warn(numStr + " cannot be converted into a number");
                return false;
            }
        },

        /* Converts a number to a string
         * @param n Number the number to be converted
         * @returns str String the string returned
         */
        _convertNumber: function (n) {
            var str = n.toString();
            return str;
        },

        /* Converts a JSON string to a JavaScript object
         * @param str String the JSON string
         * @returns obj Object the JavaScript object
         */
        _toJSONObject: function (str) {
            var obj = JSON.parse(str);
            return obj;
        },

        /* Converts a JavaScript object to a JSON string
         * @param obj Object the JavaScript object
         * @returns str String the JSON string
         */

        _toJSONString: function (obj) {
            var str = JSON.stringify(obj);
            return str;
        },
        
        /* Generate guid for basket items 
         *
         */
         
        _guid: function (obj) {
            return Math.floor((1 + Math.random()) * 0x10000)
            .toString(16)
            .substring(1);
        },

        /* Add an object to the cart as a JSON string
         * @param values Object the object to be added to the cart
         * @returns void
         */
        _addToCart: function (values) {
            var cart = this.storage.getItem(this.cartName);

            var cartObject = this._toJSONObject(cart);
            var cartCopy = cartObject;
            var items = cartCopy.items;

            items.push(values);
            this.storage.setItem(this.cartName, this._toJSONString(cartCopy));
        }
    };

    $(function () {
        if ($(".home").length != 0) {
            var shop = new $.Shop(".home");
        } else {
            var shop = new $.Shop(".checkout-page");
        }
    });

})(jQuery);

$(document).ready(function() {
    $('.types').on("click", function() {
        $(this).siblings('.types').removeClass('active');
        $(this).addClass('active');
        if ($(this).attr('data-pack')=='double')
            $('.second-size').css('display','block');
        else
            $('.second-size').css('display','none');
    });
    $('.second-size').css('display','none');
});
