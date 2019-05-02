<?php
// 1. Autoload the SDK Package. This will include all the files and classes to your autoloader
// Use below for direct download installation
require __DIR__  . '/../PayPal-PHP-SDK/autoload.php';

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;


// // After Step 1
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'ARHUQbhkYoKD5UeOnDPqjFubJir1-ryQ6FHJ0EaiFqxpuhfebkXZnlqomUnmf5R6xGydTMlgBGzLpQA2',     // ClientID
        'EBXxxN8k37AbwgqCr6PXNwWRt5ulcFrPra08Xt0D9cKtQRCY9HAy6RGSNpyArCdtgBGAgSUOhIfRZOED'      // ClientSecret
    )
);



$paymentId = $_POST['paymentId'];
$addressInfo = json_decode($_POST['addressInfo']);
$productInfo = json_decode($_POST['productInfo']);

// ### Approval Status
// Determine if the user approved the payment or not
// if (isset($_GET['success']) && $_GET['success'] == 'true') {
    // Get the payment Object by passing paymentId
    // payment id was previously stored in session in
    // CreatePaymentUsingPayPal.php
    
    $payment = Payment::get($paymentId, $apiContext);
    // ### Payment Execute
    // PaymentExecution object includes information necessary
    // to execute a PayPal account payment.
    // The payer_id is added to the request query parameters
    // when the user is redirected from paypal back to your site
    $execution = new PaymentExecution();
    $execution->setPayerId($_POST['PayerID']);
    // ### Optional Changes to Amount
    // If you wish to update the amount that you wish to charge the customer,
    // based on the shipping address or any other reason, you could
    // do that by passing the transaction object with just `amount` field in it.
    // Here is the example on how we changed the shipping to $1 more than before.
    $transaction = new Transaction();
    $amount = new Amount();
    $details = new Details();
    $details->setShipping($productInfo->shipping)
        // ->setTax(1.3)
        ->setSubtotal($productInfo->price);
    $amount->setCurrency('USD');
    $amount->setTotal($productInfo->total);
    $amount->setDetails($details);
    $transaction->setAmount($amount);
    // Add the above transaction object inside our Execution object.
    $execution->addTransaction($transaction);
    
    try {
        // Execute the payment
        $result = $payment->execute($execution, $apiContext);
        
        try {
            $payment = Payment::get($paymentId, $apiContext);
        } catch (Exception $ex) {
            echo $ex;
            echo $ex->getCode();
            echo $ex->getData();
        }
        echo $payment;
    } catch (Exception $ex) {
        echo $ex;
        echo $ex->getCode();
        echo $ex->getData();
    }



