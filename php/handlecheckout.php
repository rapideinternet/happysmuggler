<?php
if (!isset($_POST['cart'])) {
    die();
}

require __DIR__ . '/handlecart.php';
require __DIR__ . '/CartValidator.php';
require __DIR__ . '/Mailer.php';

require __DIR__ . '/Mollie/initialize.php';

$validator = new CartValidator();

unset($_SESSION['errors']);
$_SESSION['cartfields'] = $_POST['cart'];

if (!$validator->validate()) {
    $_SESSION['errors'] = $validator->getErrors();
    return header("Location: /checkout.php");
}

// Create Mollie payment
try
{
/*
 * Generate a unique order id for this example. It is important to include this unique attribute
 * in the redirectUrl (below) so a proper return page can be shown to the customer.
 */
    $order_id = time();

/*
 * Determine the url parts to these example files.
 */
    $protocol = isset($_SERVER['HTTPS']) && strcasecmp('off', $_SERVER['HTTPS']) !== 0 ? "https" : "http";
    $hostname = $_SERVER['HTTP_HOST'];
    $path     = str_replace("/php", "", dirname(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF']));

/*
 * Payment parameters:
 *   amount        Amount in EUROs. This example creates a € 10,- payment.
 *   description   Description of the payment.
 *   redirectUrl   Redirect location. The customer will be redirected there after the payment.
 *   webhookUrl    Webhook location, used to report when the payment changes state.
 *   metadata      Custom metadata that is stored with the payment.
 */
    $payment = $mollie->payments->create(array(
        "amount"      => getTotalAmount(),
        "description" => "Bestelling Happysmugglers.com - " . $order_id,
        "redirectUrl" => "{$protocol}://{$hostname}{$path}/thanks.php",
        //"webhookUrl"  => "{$protocol}://{$hostname}{$path}/verification.php",
        "metadata"    => array(
            "order_id" => $order_id,
        ),
    ));

    $mail = new Mailer();
    $mail->addAddress("team@happysmugglers.com");
    $msg = "
    Er is een nieuwe bestelling binnengekomen met onderstaande gegevens;<br/><br/>
<table style='width:600px;'>
<tr>
	<td valign='top'>
		<b>Billing</b> <br/>
		{$_POST['cart']['firstname']} {$_POST['cart']['lastname']}  <br/>
		{$_POST['cart']['company']} <br/>
		{$_POST['cart']['email']} <br/>
		{$_POST['cart']['phone']} <br/>
	</td>
	<td style='text-align:right;' valign='top'>
		<b>Shipping</b><br/>
		{$_POST['cart']['street']} {$_POST['cart']['streetextra']} <br/>
		{$_POST['cart']['postalcode']} {$_POST['cart']['city']} <br/>
		{$_POST['cart']['country']}
	</td>
</tr>
</table>
<br/>
<table style='width:600px;'>
<tr><th style='text-align:left'>Product</th><th style='text-align:left'>Size</th><th style='text-align:right'>Quantity</th><th style='text-align:right'>Price</th></tr>
";

    foreach ($products as $product) {
        $msg .= "
    <tr>
    	<td valign='top'>{$product->item->name} <br/> {$product->item->sku} pack</td>
    	<td valign='top'>" . formatSize($product->comment) . "</td>
    	<td valign='top' style='text-align:right'>{$product->qty} x</td>
    	<td valign='top' style='text-align:right'>&euro; " . number_format($product->price * $product->qty, '2', ',', '') . "</td>
    	</tr>
    ";
    }
    $msg .= "<tr><td colspan='3' style='text-align:right'><b>Subtotal:</b></td><td style='text-align:right'><b>&euro; " . number_format($totalAmount, '2', ',', '') . "<b/></td></tr>";
    $msg .= "<tr><td colspan='3' style='text-align:right'><b>Shipping:</b></td><td style='text-align:right'><b>&euro; 0,00<b/></td></tr>";
    $msg .= "<tr><td colspan='3' style='text-align:right'><b>Total:</b></td><td style='text-align:right'><b>&euro; " . number_format($totalAmount, '2', ',', '') . "<b/></td></tr>";
    $msg .= "<tr><td colspan='3' style='text-align:right'><b>VAT (21%):</b></td><td style='text-align:right'><b>&euro; " . number_format($totalTaxRate, '2', ',', '') . "<b/></td></tr>";

    $msg .= "</table><br /><br/>Extra informatie: {$_POST['cart']['comments']}";

    $mail->setHTMLBody($msg);
    $mail->setSubject('Bestelling - ' . $order_id . ' | Happysmugglers.com');
    $mail->send();

    sendCustomerMail($order_id, $products, $totalAmount, $totalTaxRate);

/*
 * Send the customer off to complete the payment.
 */
    header("Location: " . $payment->getPaymentUrl());
} catch (Mollie_API_Exception $e) {
    echo "API call failed: " . htmlspecialchars($e->getMessage());
    exit;
}

function sendCustomerMail($order_id, $products, $totalAmount, $totalTaxRate)
{
    $mail = new Mailer();
    $mail->addAddress($_POST["cart"]["email"]);

    $msg = '<center>
    <div style="background: #f8f7f5;width: 600px; display:inline-block;text-align: left; ">
        <!-- Header logo -->
        <div style="height: 100px; width: 100%;text-align:center;">
            <img src="http://www.happysmugglers.com/img/mail/logo.png" style="height: 60px; padding-top: 20px;padding-bottom: 20px;">
        </div>
        <div style="height: 225px; ">
            <img src="http://www.happysmugglers.com/img/mail//header.jpg" style="height: 225px; ">
        </div>
        <div style="padding: 0px 100px;">
            <h2 style="text-align:left; font-family: Arial; font-size: 18px; line-height:18px; color: 1b1b1b;">
               Your order is successfully processed!
            </h2>
            <p style="text-align:left; font-family: Arial; font-size: 14px; line-height:19px; color: #000;">
You rock! Very soon you will be holding the best piece of underwear in the world. Straight from Amsterdam, created for all the happy people, just like you!<br/>
                <br/>
                <strong>Your order - ' . $order_id . '</strong>
<br/><br/>';
    $msg .= "<table style='width:100%;font-family: Arial; font-size: 12px;'>
<tr><th style='text-align:left'>Product</th><th style='text-align:left'>Size</th><th style='text-align:right'>Quantity</th><th style='text-align:right'>Price</th></tr>
";

    foreach ($products as $product) {
        $msg .= "
    <tr>
        <td valign='top'>{$product->item->name} <br/> {$product->item->sku} pack</td>
        <td valign='top'>" . formatSize($product->comment) . "</td>
        <td valign='top' style='text-align:right'>{$product->qty} x</td>
        <td valign='top' style='text-align:right'>&euro; " . number_format($product->price * $product->qty, '2', ',', '') . "</td>
        </tr>
    ";
    }
    $msg .= "<tr><td colspan='3' style='text-align:right'><b>Subtotal:</b></td><td style='text-align:right'><b>&euro; " . number_format($totalAmount, '2', ',', '') . "<b/></td></tr>";
    $msg .= "<tr><td colspan='3' style='text-align:right'><b>Shipping:</b></td><td style='text-align:right'><b>&euro; 0,00<b/></td></tr>";
    $msg .= "<tr><td colspan='3' style='text-align:right'><b>Total:</b></td><td style='text-align:right'><b>&euro; " . number_format($totalAmount, '2', ',', '') . "<b/></td></tr>";
    $msg .= "<tr><td colspan='3' style='text-align:right'><b>VAT (21%):</b></td><td style='text-align:right'><b>&euro; " . number_format($totalTaxRate, '2', ',', '') . "<b/></td></tr>";

    $msg .= "</table><br />Extra informatie: {$_POST['cart']['comments']}";

    $msg .= '<br/><br/>
<strong>Shipping Details</strong><br/>
Free Shipping <br/>
Delivery to: <br/>
' . $_POST["cart"]["firstname"] . ' ' . $_POST["cart"]["lastname"] . ' <br/>
' . $_POST["cart"]["street"] . ' ' . $_POST["cart"]["streetextra"] . ' <br/>
' . $_POST["cart"]["postalcode"] . ' ' . $_POST["cart"]["city"] . ' <br/>
' . $_POST["cart"]["country"] . '

<br/><br/>

<strong>Billed to:</strong> <br/>
' . $_POST["cart"]["firstname"] . ' ' . $_POST["cart"]["lastname"] . ' <br/>
' . $_POST["cart"]["street"] . ' ' . $_POST["cart"]["streetextra"] . ' <br/>
' . $_POST["cart"]["postalcode"] . ' ' . $_POST["cart"]["city"] . ' <br/>
' . $_POST["cart"]["country"] . '<br /><br />

<strong>Contact us</strong><br />
Herengracht 440 | 1017BZ Amsterdam | +31 (0) 20 76 700 35 | happy@happysmugglers.com

            </p>
        </div>
    </div>
    </center>';

    /*

    foreach ($products as $product) {
    $msg .= "
    <tr>
    <td valign='top'>{$product->item->name} <br/> {$product->item->sku} pack</td>
    <td valign='top'>" . formatSize($product->comment) . "</td>
    <td valign='top' style='text-align:right'>{$product->qty} x</td>
    <td valign='top' style='text-align:right'>&euro; " . number_format($product->price * $product->qty, '2', ',', '') . "</td>
    </tr>
    ";
    }
    $msg .= "<tr><td colspan='3' style='text-align:right'><b>Subtotal:</b></td><td style='text-align:right'><b>&euro; " . number_format($totalAmount, '2', ',', '') . "<b/></td></tr>";
    $msg .= "<tr><td colspan='3' style='text-align:right'><b>Shipping:</b></td><td style='text-align:right'><b>&euro; 0,00<b/></td></tr>";
    $msg .= "<tr><td colspan='3' style='text-align:right'><b>Total:</b></td><td style='text-align:right'><b>&euro; " . number_format($totalAmount, '2', ',', '') . "<b/></td></tr>";
    $msg .= "<tr><td colspan='3' style='text-align:right'><b>VAT (21%):</b></td><td style='text-align:right'><b>&euro; " . number_format($totalTaxRate, '2', ',', '') . "<b/></td></tr>";

    $msg .= "</table><br /><br/>Extra informatie: {$_POST['cart']['comments']}";*/

    $mail->setHTMLBody($msg);
    $mail->setSubject('Bestelling - ' . $order_id . ' | Happysmugglers.com');
    $mail->send();

}
