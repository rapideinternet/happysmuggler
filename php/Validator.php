<?php
/**
 * Created by PhpStorm.
 * User: heppi_000
 * Date: 21-10-2014
 * Time: 12:08
 */

class Validator {
    private $errors;
    public function __construct() {
        $errors = array();
        if(isset($_POST['name']) && strlen($_POST['name']) == 0) {
            $errors['name'] = "Dit veld is verplicht";
        }

        if(isset($_POST['email']) && strlen($_POST['email']) == 0) {
            $errors['email'] = "Dit veld is verplicht";
        }

        if(!isset($errors['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Dit is geen geldig e-mailadres";
        }

        if(isset($_POST['message']) && strlen($_POST['message']) == 0) {
            $errors['message'] = "Dit veld is verplicht";
        }

        $this->errors = $errors;
    }

    public function validate() {
        if(count($this->errors) > 0) {
            return false;
        }
        return true;
    }

    public function getErrors() {
        return $this->errors;
    }
} 
