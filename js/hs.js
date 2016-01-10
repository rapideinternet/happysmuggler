$(function () {
  var $window = $(window);
  var $cart = $('.cart');
  var prevScrollTop = 0;

  function disableScrolling () {
    $('body').css({
      overflow: 'hidden'
    });
  }

  function enableScrolling () {
    $('body').css({
      overflow: 'visible'
    });
    $window.scrollTop(prevScrollTop);
  }

  /*
  * Header scroll
  */

  var $headerScroll = $('.header-scroll');

  $window.on('scroll', function (event) {
    // Prevent header from hiding when cart is active
    if (!$cart.hasClass('active')) {
      var scrollTop = $window.scrollTop();
      if (scrollTop > prevScrollTop) {
        $headerScroll.removeClass('active'); // Down
      } else {
        $headerScroll.addClass('active'); // Up
      }
    }
    prevScrollTop = scrollTop;
  });

  /*
  * Scroll to Target
  */

  $('[data-scrollto]').on('click', function (event) {
    event.preventDefault();
    var scrollTo = $(this).data('scrollto') || 0;
    $window.scrollTo(scrollTo, 500);
  });

  /*
  * Cart Toggle
  */

  $cart.find('> .button').on('click', function (event) {
    event.preventDefault();
    $cart.toggleClass('active');
  });

  $cart.find('> .overlay').on('click', function (event) {
    event.preventDefault();
    $cart.removeClass('active');
  });

  /*
  * Product Details
  */

  var $products = $('.product');

  $products.on('click', '.image a, .more-info', function (event) {
    event.preventDefault();
    var $product = $(this).closest('.product');

    if ($product.hasClass('active')) {
      enableScrolling();
      $product.removeClass('active');
    } else {
      disableScrolling();
      $product.addClass('active');
    }
  });
});
