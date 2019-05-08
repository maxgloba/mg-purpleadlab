<?php

    $phone_Model = $_POST['phone_Model'];
    $phone_Problem = $_POST['phone_Problem'];
    $phone_Diagnosis = $_POST['phone_Diagnosis'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $store = $_POST['store'];
    $captcha = $_POST['captcha'];

    $to = "onyx18121990@gmail.com";
    $subject = "Your info has been sent";
    $text = 'Phone model: '.$phone_Model."\r\n";
    $text .= 'Phone problem: '.$phone_Problem."\r\n";
    $text .= 'Diagnosis answer: '.$phone_Diagnosis."\r\n";
    $text .= 'Name: '.$name."\r\n";
    $text .= 'Email: '.$email."\r\n";
    $text .= 'Phone: '.$phone."\r\n";
    $text .= 'Date: '.$date."\r\n";
    $text .= 'Store: '.$store."\r\n";

    $headers = 'From: Fone King Team <onyx18121990@gmail.com>' . "\r\n" .
    'Reply-To: '. $email . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    $sending = mail($to, $subject, $text, $headers);

    if($sending) echo "Email sent!";

?>