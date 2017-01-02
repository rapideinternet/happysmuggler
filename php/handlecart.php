<?php

session_start();

function getProducts()
{
    $products = array();

    if (isset($_SESSION['shoppingcart'])) {
        $products = json_decode($_SESSION['shoppingcart']);
    }

    return $products;
}

function getTotalAmount()
{
    $total = 0;
    if (isset($_SESSION['shoppingcart'])) {
        $products = json_decode($_SESSION['shoppingcart']);
        foreach ($products as $product) {
            $total += $product->price * $product->qty;
        }
    }

    return $total;
}

function getTotalTaxRate()
{
    $total = 0;
    if (isset($_SESSION['shoppingcart'])) {
        $products = json_decode($_SESSION['shoppingcart']);
        foreach ($products as $product) {
            $tax = '0.' . $product->taxRate;
            $total += ($product->price * $product->qty) * $tax;
        }
    }

    return $total;
}

function formatSize($size)
{
    $size = str_replace("Sizes:", "", $size);
    $size = str_replace("Size:", "", $size);
    $size = str_replace("Boxer: ", "", $size);
    $size = str_replace("Tanktop: ", "", $size);

    return $size;
}

$products     = getProducts();
$totalAmount  = getTotalAmount();
$totalTaxRate = getTotalTaxRate();

$errors = array();
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
}

$cartsfields = array();
if (isset($_SESSION['cartfields'])) {
    $cartsfields = $_SESSION['cartfields'];
}
