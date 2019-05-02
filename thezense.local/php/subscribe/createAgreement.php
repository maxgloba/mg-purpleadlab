<?php

require __DIR__  . './../PayPal-PHP-SDK/autoload.php';

use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;
use PayPal\Api\ShippingAddress;

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'ARHUQbhkYoKD5UeOnDPqjFubJir1-ryQ6FHJ0EaiFqxpuhfebkXZnlqomUnmf5R6xGydTMlgBGzLpQA2',     // ClientID
        'EBXxxN8k37AbwgqCr6PXNwWRt5ulcFrPra08Xt0D9cKtQRCY9HAy6RGSNpyArCdtgBGAgSUOhIfRZOED'      // ClientSecret
    )
);

$nextDay = time() + (2 * 60);
$newData = date("Y-m-d\TH:i:s\Z", $nextDay);


$planId = $_POST['planId'];
$addressInfo = json_decode($_POST['addressInfo']);
$productInfo = json_decode($_POST['productInfo']);


$agreement = new Agreement();
$agreement->setName('Base Agreement')
    ->setDescription('Basic Agreement')
    ->setStartDate($newData);

// Add Plan ID
// Please note that the plan Id should be only set in this case.
// echo $createdPlan;
$plan = new Plan();

$plan->setId($planId);
$agreement->setPlan($plan);
// echo $agreement;
// Add Payer
$payer = new Payer();
$payer->setPaymentMethod('paypal');
$agreement->setPayer($payer);
// Add Shipping Address
$shippingAddress = new ShippingAddress();
$shippingAddress->setLine1($addressInfo->line1)
    ->setCity($addressInfo->city)
    ->setState($addressInfo->state)
    ->setPostalCode($addressInfo->zip)
    ->setCountryCode($addressInfo->country);
$agreement->setShippingAddress($shippingAddress);
// For Sample Purposes Only.
$request = clone $agreement;
// ### Create Agreement
try {
    // Please note that as the agreement has not yet activated, we wont be receiving the ID just yet.
    $agreement = $agreement->create($apiContext);
    // ### Get redirect url
    // The API response provides the url that you must redirect
    // the buyer to. Retrieve the url from the $agreement->getApprovalLink()
    // method
    $approvalUrl = $agreement->getApprovalLink();
} catch (Exception $ex) {
    echo $ex;
    echo $ex->getCode();
    echo $ex->getData();
}
// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
//  ResultPrinter::printResult("Created Billing Agreement. Please visit the URL to Approve.", "Agreement", "<a href='$approvalUrl' >$approvalUrl</a>", $request, $agreement);
echo $approvalUrl;
