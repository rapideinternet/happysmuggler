$(function () {
  var $window = $(window);

  /*
  * Header scroll
  */

  var $headerScroll = $('.header-scroll');
  var prevScrollTop = 0;

  $window.on('scroll', function (event) {
    var scrollTop = $window.scrollTop();
    if (scrollTop > prevScrollTop) {
      $headerScroll.removeClass('active'); // Down
    } else {
      $headerScroll.addClass('active'); // Up
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

  var $cart = $('.cart');

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
    $(this).closest('.product').toggleClass('active');
  });
});
