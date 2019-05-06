<?php

    $email = $_POST['email'];
    $name = $_POST['name'];
    $message = $_POST['message'];

    $to = $email;
    $subject = "Your order has been sent";
    $text =  $message;

    $headers = 'From: Thezense team <admin@thezense.com>' . "\r\n" .
    'Reply-To: admin@thezense.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    $sending = mail($to, $subject, $text, $headers);

    if($sending) echo "Email sent!";

?>