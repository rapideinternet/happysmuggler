<?php
session_start();
/*
 * NEEDS REFACTORING BEFORE WE EVER EVER RELEASE THIS.
 */

require_once __DIR__ . '/products/Couple.php';
require_once __DIR__ . '/products/DoubleBoxer.php';
require_once __DIR__ . '/products/SingleBoxer.php';
require_once __DIR__ . '/products/TankTop.php';
require_once __DIR__ . '/shipping-options/FreeShipping.php';
/*require_once __DIR__ . '/fastr/Client.php';
require_once __DIR__ . '/fastr/ClientException.php';*/

/*
 * Fetch the input.
 */
$input = json_decode(file_get_contents('php://input'), true);

/*
 * Set the shipping option.
 */
$shippingOptions = [new FreeShipping];
$items           = [];

/*
 * Validate.
 */
if (!isset($input['items']) || !is_array($input['items']) || count($input['items']) === 0) {
    die(json_encode(array('error' => 'Invalid products specified')));
}

/*
 * Loop through items.
 */
foreach ($input['items'] as $item) {
    /*
     * Check if each item is valid.
     */
    if (!is_array($item) || !isset($item['pack']) || !isset($item['qty'])) {
        die(json_encode(array('error' => 'Invalid products specified')));
    }

    /*
     * Get the product specifications for the pack.
     */
    switch ($item['pack']) {
        case 'couple':
            $items[] = new Couple($item['qty'], "Boxer: {$item['size'][0]} / Tanktop: {$item['size'][1]}");
            break;
        case 'double':
            $items[] = new DoubleBoxer($item['qty'], "Sizes: " . implode(", ", $item['size']));
            break;
        case 'single':
            $items[] = new SingleBoxer($item['qty'], "Size: " . $item['size'][0]);
            break;
        case 'tank-top':
            $items[] = new TankTop($item['qty'], "Size: " . $item['size'][0]);
            break;
    }
}

/*
 * Do we have any items?
 */
if (count($items) < 1) {
    die(json_encode(array('error' => 'No products specified')));
}

try {
    /*  $client = new Client('d73ee38be6aa9e7991ead5b00eb0d5fa');
    echo json_encode(array('redirectUrl' => $client->newOrder($items, $shippingOptions)));*/
    $_SESSION['shoppingcart'] = json_encode($items);
    echo json_encode(array('redirectUrl' => '/checkout.php'));
} catch (ClientException $e) {
    //  die(json_encode(array('error' => $e->getMessage())));
}
