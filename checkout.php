<?php
require_once __DIR__ . '/php/handlecart.php';
require_once __DIR__ . '/php/fastr/Countries.php';

if (count($products) < 1) {
    header("Location: /");
}
?>

<!DOCTYPE html>
<html class="checkout-page">

<head>
	<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Happy Smugglers | Checkout!</title>
	<meta name="keywords" content="Happy Smugglers, Festival, boxershort, happy, smuggling, hiddenpocket, secret pocket, smiley, gunther, gunter, happy smugglers, smugglers, smuggler, underwear, confetti, perfect gift, gift, amsterdam, boxer, party, fest, drugs, drugs smokkelen, smokkelen, awesome">
	<meta name="description" content="Happy Smugglers, the #1 Festival boxershort! Underwear with a hiddenpocket. Be festival ready! - From Amsterdam with love! ">
	<meta name="robots" content="all">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, shrink-to-fit=no">
	<meta name="format-detection" content="telephone=no">
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	<link href="css/style.css" rel="stylesheet">
</head>

<body id="top">
	<!-- Google Tag Manager -->
	<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-P3RR5F"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-P3RR5F');</script>
	<!-- End Google Tag Manager -->

	<div class="header-scroll active">
		<a class="logo" href="index.html"></a>
		<div id="cart" class="cart">
			<div class="overlay"></div>
			<div class="button">
				<span class="icon icon-cart"></span>
				<span class="cart-amount">0</span>
			</div>
			<div class="foldout">
				<div class="foldout-inner">
                    <div class="products"></div>
					<div id="subtotal" class="totals"></div>
					<a class="checkout" href="#">Update checkout</a>
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
		<div class="checkout">
			<form method="post" action="/php/handlecheckout.php">
			<div class="wrapper">
				<h1>Cart</h1>
									<p align="left" style="font-family: oswald; font-size: 20px; font-weight: 500;">This is the final step to make your life complete.</p>
				
				<p align="left" style="font-family: oswald; font-size: 20px; font-weight: 100">Expected delivery date: tomorrow.<br />
				&#10003; 100% through the cue!<br />
				&#10003; Free shipping world wide<br />
				&#10003; 5 star underwear quality<br /></p>
				<div class="data">
					<h2>Billing</h2>

						<div class="field doublefield">
							<input <?php if (isset($errors) && isset($errors['firstname'])) {echo "class='error'";}?> <?php if (isset($cartsfields['firstname'])) {echo "value='{$cartsfields['firstname']}'";}?> type="text" name="cart[firstname]" required="" placeholder="First name:">
							<input <?php if (isset($errors) && isset($errors['lastname'])) {echo "class='error'";}?> <?php if (isset($cartsfields['lastname'])) {echo "value='{$cartsfields['lastname']}'";}?> type="text" name="cart[lastname]" required="" placeholder="Last name:">
						</div>
						<div class="field">
							<input <?php if (isset($cartsfields['company'])) {echo "value='{$cartsfields['company']}'";}?> type="text" name="cart[company]" placeholder="Company: (optional)">
						</div>
						<div class="field doublefield">
							<input <?php if (isset($errors) && isset($errors['email'])) {echo "class='error'";}?> <?php if (isset($cartsfields['email'])) {echo "value='{$cartsfields['email']}'";}?> type="text" name="cart[email]" required="" placeholder="Email address:">
							<input <?php if (isset($cartsfields['phone'])) {echo "value='{$cartsfields['phone']}'";}?> type="text" name="cart[phone]" placeholder="Phone: (optional)">
						</div>
						<br/>
						<h2>Shipping</h2>
						<div class="field">
							<select required="" name="cart[country]">
								<option>Select country:</option>
								<?php foreach ($countries as $country) {
    if (isset($cartsfields['country']) && $cartsfields['country'] == $country) {
        echo "<option selected='selected'>{$country}</option>";
    } else if (!isset($cartsfields['country']) && $country == "Netherlands") {
        echo "<option selected='selected'>{$country}</option>";
    } else {
        echo "<option>{$country}</option>";
    }
}?>
							</select>
						</div>
						<div class="field address">
							<input <?php if (isset($errors) && isset($errors['street'])) {echo "class='error'";}?> <?php if (isset($cartsfields['street'])) {echo "value='{$cartsfields['street']}'";}?> type="text" name="cart[street]" required=""  placeholder="Street address:">
							<input  type="text" name="cart[streetextra]" <?php if (isset($cartsfields['streetextra'])) {echo "value='{$cartsfields['streetextra']}'";}?> placeholder="Apartment, suite, unit etc. (optional)">
						</div>
						<div class="field doublefield">
							<input <?php if (isset($errors) && isset($errors['postalcode'])) {echo "class='error'";}?> <?php if (isset($cartsfields['postalcode'])) {echo "value='{$cartsfields['postalcode']}'";}?> type="text" name="cart[postalcode]" required="" placeholder="Zip / postcode:">
							<input <?php if (isset($errors) && isset($errors['city'])) {echo "class='error'";}?> <?php if (isset($cartsfields['city'])) {echo "value='{$cartsfields['city']}'";}?> type="text" name="cart[city]" required="" placeholder="Town / city:">
						</div>
						<div class="field">
							<textarea name="cart[comments]" placeholder="Notes about your order, e.g. special notes for delivery:"><?php if (isset($cartsfields['comments'])) {echo "{$cartsfields['comments']}";}?></textarea>
							</div>

							<br/>
							<button type="submit" class="order">
								Order now
								<span class="icon icon-cart"></span>
								</button>

					<!--<h2>Payment</h2>

						<div class="field radiocheck">
							<label><input type="radio">SOFORT Banking<span class="image"><img src="img/sofort.png"></span></label>
							<label>
								<input type="radio">iDeal<span class="image"><img src="img/ideal.png"></span>
								<select>
									<option>Select your bank:</option>
									<option>ING</option>
									<option>ABN etc.</option>
								</select>
							</label>
							<label><input type="radio">Bancontact / Mister Cash<span class="image"><img src="img/mistercash.png"></span></label>
							<label><input type="radio">Belfius Direct Net<span class="image"><img src="img/belfius.png"></span></label>
						</div>
	-->
				</div>
				<div class="summary">
					<?php
foreach ($products as $product) {
    echo '
	<div class="item">
		<div class="type">
			<div class="title">' . $product->item->name . '<div class="total">&euro; ' . number_format($product->price * $product->qty, "2", ",", "") . '</div></div>
			<p class="subtitle">' . $product->qty . 'x ' . $product->item->sku . ' pack</p>
			<span class="sizes">' . formatSize($product->comment) . '</span>
		</div>
	</div>
	';
}
?>

					<div class="totals">Total<span>&euro; <?php echo number_format($totalAmount, "2", ",", "") ?></span></div>
					<span class="vat">includes &euro;<?php echo number_format($totalTaxRate, "2", ",", "") ?> VAT</span>
					<button type="submit" class="checkout">Place order</button>
				</div>
				</form>
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
</body>
</html>
