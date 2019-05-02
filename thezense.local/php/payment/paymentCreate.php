<?php
// 1. Autoload the SDK Package. This will include all the files and classes to your autoloader
// Use below for direct download installation
require __DIR__  . '/../PayPal-PHP-SDK/autoload.php';

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\ShippingAddress; 


// After Step 1
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'ARHUQbhkYoKD5UeOnDPqjFubJir1-ryQ6FHJ0EaiFqxpuhfebkXZnlqomUnmf5R6xGydTMlgBGzLpQA2',     // ClientID
        'EBXxxN8k37AbwgqCr6PXNwWRt5ulcFrPra08Xt0D9cKtQRCY9HAy6RGSNpyArCdtgBGAgSUOhIfRZOED'      // ClientSecret
    )
);
// income info
$productId = $_POST['productId'];
$addressInfo = json_decode($_POST['addressInfo']);
$productInfo = json_decode($_POST['productInfo']);


// ### Payer
// A resource representing a Payer that funds a payment
// For paypal account payments, set payment method
// to 'paypal'.
$payer = new Payer();
$payer->setPaymentMethod("paypal");
// ### Itemized information
// (Optional) Lets you specify item wise
// information
$item1 = new Item();
$item1->setName($productInfo->name)
    ->setCurrency('USD')
    ->setQuantity(1)
    ->setSku($productId) // Similar to `item_number` in Classic API
    ->setPrice($productInfo->price);
// $item2 = new Item();
// $item2->setName('Granola bars')
//     ->setCurrency('USD')
//     ->setQuantity(5)
//     ->setSku("321321") // Similar to `item_number` in Classic API
//     ->setPrice(2);

$shipping = new ShippingAddress();
$shipping->setCity($addressInfo->city)
        ->setState($addressInfo->state)
        ->setCountryCode($addressInfo->country)
        ->setPostalCode($addressInfo->zip)
        ->setLine1($addressInfo->line1)
        ->setLine2($addressInfo->line2);


$itemList = new ItemList();
$itemList->setItems(array($item1/* , $item2 */))
        ->setShippingAddress($shipping);

// ### Additional payment details
// Use this optional field to set additional
// payment information such as tax, shipping
// charges etc.
$details = new Details();
$details->setShipping($productInfo->shipping)
    // ->setTax(1.3)
    ->setSubtotal($productInfo->price); // amount (all products in list)
// ### Amount
// Lets you specify a payment amount.
// You can also specify additional details
// such as shipping, tax.
$amount = new Amount();
$amount->setCurrency("USD")
    ->setTotal($productInfo->total)
    ->setDetails($details);
// ### Transaction
// A transaction defines the contract of a
// payment - what is the payment for and who
// is fulfilling it. 
$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setItemList($itemList)
    ->setDescription($productInfo->name)
    ->setInvoiceNumber(uniqid());
// ### Redirect urls
// Set the urls that the buyer must be redirected to after 
// payment approval/ cancellation.
// $baseUrl = getBaseUrl();
$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl("https://thezense.com/offer/01_html/") 
    ->setCancelUrl("https://thezense.com/offer/01_html/");
// ### Payment
// A Payment Resource; create one using
// the above types and intent set to 'sale'
$payment = new Payment();
$payment->setIntent("sale")
    ->setPayer($payer)
    ->setRedirectUrls($redirectUrls)
    ->setTransactions(array($transaction));
// For Sample Purposes Only.
$request = clone $payment;
// ### Create Payment
// Create a payment by calling the 'create' method
// passing it a valid apiContext.
// (See bootstrap.php for more on `ApiContext`)
// The return object contains the state and the
// url to which the buyer must be redirected to
// for payment approval

try {
    $payment->create($apiContext);
} catch (Exception $ex) {
    echo $ex;
    echo $ex->getCode();
    echo $ex->getData();
}
// ### Get redirect url
// The API response provides the url that you must redirect
// the buyer to. Retrieve the url from the $payment->getApprovalLink()
// method
$approvalUrl = $payment->getApprovalLink();
echo $payment;