<?php
if(!isset($_POST['name'])) {
    die();
}

require(__DIR__ . '/Validator.php');
require(__DIR__ . '/Mailer.php');

$validator = new Validator();

if(!$validator->validate()) {
    echo json_encode(array('success' => 'false', 'errors' => $validator->getErrors()));
    die();
}

$mail = new Mailer();
$mail->addAddress("info@happysmugglers.com");
$msg = "
Hallo,<br /><br />

Het contactformulier op uw website is ingevuld. Hieronder staan de ingevoerde gegevens:<br /><br />

<table>";
if(isset($_POST['message'])) {
    $_POST['message'] = nl2br($_POST['message']);
}

foreach($_POST as $key => $value):
    if(is_array($value)) {
        $value = implode(", ", $value);
    }

$msg .= "<tr>
    <td>" . $key . "</td>
    <td>" . $value . "</td>
</tr>";

endforeach;

$msg .= "</table><br />";

$mail->setHTMLBody($msg);

if($mail->send()) {
    echo json_encode(array('success' => true));
    exit;
}

echo json_encode(array('success' => false));
