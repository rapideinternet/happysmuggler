<?php
/**
 * Created by PhpStorm.
 * User: heppi_000
 * Date: 21-10-2014
 * Time: 12:08
 */

class CartValidator
{
    private $errors;
    public function __construct()
    {
        $errors = array();
        if (isset($_POST['cart']['firstname']) && strlen($_POST['cart']['firstname']) == 0) {
            $errors['firstname'] = "Dit veld is verplicht";
        }

        if (isset($_POST['cart']['lastname']) && strlen($_POST['cart']['lastname']) == 0) {
            $errors['lastname'] = "Dit veld is verplicht";
        }

        if (isset($_POST['cart']['email']) && strlen($_POST['cart']['email']) == 0) {
            $errors['email'] = "Dit veld is verplicht";
        }

        if (isset($_POST['cart']['street']) && strlen($_POST['cart']['street']) == 0) {
            $errors['street'] = "Dit veld is verplicht";
        }

        if (isset($_POST['cart']['postalcode']) && strlen($_POST['cart']['postalcode']) == 0) {
            $errors['postalcode'] = "Dit veld is verplicht";
        }

        if (isset($_POST['cart']['city']) && strlen($_POST['cart']['city']) == 0) {
            $errors['city'] = "Dit veld is verplicht";
        }

        if (!isset($errors['email']) && !filter_var($_POST['cart']['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Dit is geen geldig e-mailadres";
        }

        $this->errors = $errors;
    }

    public function validate()
    {
        if (count($this->errors) > 0) {
            return false;
        }
        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
