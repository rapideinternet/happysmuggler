<?php
session_start();
unset($_SESSION['cartfields']);
unset($_SESSION['shoppingcart']);
?>
<!DOCTYPE html>
<html class="thanks-page">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Happy Smugglers | You are now part of the movement!</title>
	<meta name="keywords" content="Happy Smugglers">
	<meta name="description" content="With the Happy Smugglers underwear you will never lose what matters to you most.">
	<meta name="robots" content="all">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	<link href="css/style.css" type="text/css" rel="stylesheet">
</head>

<body>
	<!-- Google Tag Manager -->
	<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-P3RR5F"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-P3RR5F');</script>
	<!-- End Google Tag Manager -->

	<div class="header-scroll">
		<a class="logo" href="index.html"></a>
		<div class="cart">
			<div class="overlay"></div>
			<div class="button" href="#">
				<span class="icon icon-cart"></span>
				<span class="cart-amount">0</span>
			</div>
			<div class="foldout">
				<div class="foldout-inner">

					<div class="product">
						<div class="type">
							<div class="title">Festival boxer<div class="total">&euro; 19,00</div></div>
							<p class="subtitle">Single pack</p>
							<input type="number" value="1">
						</div>
					</div>
					<div class="product">
						<div class="type">
							<div class="title">Festival boxer<div class="total">&euro; 35,00</div></div>
							<p class="subtitle">Weekender double pack</p>
							<input type="number" value="2">
						</div>
					</div>
					<div class="product">
						<div class="type">
							<div class="title">Festival tanktop<div class="total">&euro; 17,50</div></div>
							<p class="subtitle">Single pack</p>
							<input type="number" value="1">
						</div>
					</div>
					<div class="totals">Total<span>&euro; 106.50</span></div>
					<a class="checkout" href="checkout.html">To checkout</a>

				</div>
			</div>
		</div>
		<ul class="nav">
			<li><a href="index.html">Home</a></li>
			<li><a href="index.html#shop">Shop</a></li>
			<li><a href="index.html#movement">The Movement</a></li>
			<li><a href="index.html#contact">Contact</a></li>
		</ul>
		<button type="button" role="button" aria-label="Toggle Navigation" class="mobile-nav-btn">
			<span class="lines"></span>
		</button>
	</div>
	<div class="content">
		<div class="thanks">
			<div class="wrapper">
				<h1>You are awesome!</h1>
				<p>

You are now part of the smugglers movement! Thank you for your support and awesome order! <br/>
We smuggled you an e-mail with your details. <br/>
<br/>
If you have any questions of if you want some advice on how you can be the best smuggler, don't hesitate to contact us!<br/>
<br/>
And while you are waiting for the postman to deliver you happiness, tune in on our social channels pictured below.<br/>
</p>
			</div>
		</div>
		<div class="bottom-bg">
			<div class="overlay">
				<div class="logo-happysmugglers-light"></div>
				<p>&copy; Amsterdam Since 2015</p>
				<ul>
					<li>Herengracht 440</li>
					<li>1017BZ Amsterdam</li>
					<li>+31 (0) 20 76 700 35</li>
					<li>&nbsp;</li>
					<li>KVK: 63676834</li>
					<li>IBAN: NL17INGB0006925417</li>
					<li>BTW: NL855348732B01</li>
				</ul>
				<div class="socials">
					<a href="https://www.facebook.com/happysmugglers" class="social facebook" target="_blank"><span class="icon icon-facebook"></span></a>
					<a href="https://twitter.com/happysmuggler" class="social twitter" target="_blank"><span class="icon icon-twitter"></span></a>
					<a href="https://www.instagram.com/happy_smugglers/" class="social insta" target="_blank"><span class="icon icon-instagram"></span></a>
					<a href="https://www.youtube.com/channel/UCh2q09ojqLppowMcku98f7g" class="social youtube" target="_blank"><span class="icon icon-youtube"></span></a>
					<a href="https://vimeo.com/blackbirdsamsterdam" class="social vimeo" target="_blank"><span class="icon icon-vimeo"></span></a>
					<a href="https://plus.google.com/101731974155106989366/posts" class="social googleplus" target="_blank"><span class="icon icon-googleplus"></span></a>
				</div>
			</div>
			<div class="divider top"><img src="img/bg-white-left-bottom.svg"></div>
		</div>
	</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://f.vimeocdn.com/js/froogaloop2.min.js"></script>
    <script src="js/shop.js"></script>
	<script src="js/jquery.scrollTo.min.js"></script>
	<script src="js/jquery.placeholder.min.js"></script>
	<script src="js/jquery.flexslider-min.js"></script>
	<script src="js/hs.js"></script>
	<script src="js/form.js"></script>

	<script>
	(function ($) {
		var shop = new $.Shop(".home");
		shop._emptyCart();
	})(jQuery);

	</script>
</body>
</html>
