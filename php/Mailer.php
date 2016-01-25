<?php
require("../vendor/phpmailer/phpmailer/PHPMailerAutoload.php");
/**
 * Created by PhpStorm.
 * User: heppi_000
 * Date: 21-10-2014
 * Time: 12:32
 */

class Mailer {
    private $mailer;

    public function __construct() {
        $mailer = new PHPMailer();
        $mailer->isSMTP();
        $mailer->Host = "localhost";
        $mailer->Port = 587;

        $mailer->From = "noreply@happysmugglers.com";
        $mailer->FromName = "Website HappySmugglers";
        $mailer->isHTML(true);

        $mailer->Subject = "Contactformulier website";

        $this->mailer = $mailer;
    }

    public function addAddress($email, $name = null) {
        $this->mailer->addAddress($email, $name);
    }

    public function send() {
        if(!$this->mailer->send()) {
            return false;
        }
        return true;
    }

    public function setHTMLBody($html) {
        $this->mailer->Body = $html;
        $this->mailer->altBody = strip_tags($html);
    }

    public function setSubject($subject) {
        $this->mailer->subject = $subject;
    }
}
