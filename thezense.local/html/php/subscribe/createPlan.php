<?php
// # Create Plan Sample
//
// This sample code demonstrate how you can create a billing plan, as documented here at:
// https://developer.paypal.com/docs/api/#create-a-plan
// API used: /v1/payments/billing-plans
require __DIR__  . './../PayPal-PHP-SDK/autoload.php';

use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;


$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'ARHUQbhkYoKD5UeOnDPqjFubJir1-ryQ6FHJ0EaiFqxpuhfebkXZnlqomUnmf5R6xGydTMlgBGzLpQA2',     // ClientID
        'EBXxxN8k37AbwgqCr6PXNwWRt5ulcFrPra08Xt0D9cKtQRCY9HAy6RGSNpyArCdtgBGAgSUOhIfRZOED'      // ClientSecret
    )
);

$addressInfo = json_decode($_POST['addressInfo']);
$productInfo = json_decode($_POST['productInfo']);


// Create a new instance of Plan object
$plan = new Plan();
// # Basic Information
// Fill up the basic information that is required for the plan
$plan->setName('Month Plan')
    ->setDescription('Template creation.')
    ->setType('INFINITE');
// # Payment definitions for this billing plan.
$paymentDefinition = new PaymentDefinition();
// The possible values for such setters are mentioned in the setter method documentation.
// Just open the class file. e.g. lib/PayPal/Api/PaymentDefinition.php and look for setFrequency method.
// You should be able to see the acceptable values in the comments.
$paymentDefinition->setName($productInfo->name)
    ->setType('REGULAR')
    ->setFrequency('Month')
    ->setFrequencyInterval("1")
    ->setCycles("0")
    ->setAmount(new Currency(array('value' => $productInfo->price, 'currency' => 'USD')));
// Charge Models
$chargeModel = new ChargeModel();
$chargeModel->setType('SHIPPING')
    ->setAmount(new Currency(array('value' => 0, 'currency' => 'USD')));
$paymentDefinition->setChargeModels(array($chargeModel));
$merchantPreferences = new MerchantPreferences();
// $baseUrl = getBaseUrl();
// ReturnURL and CancelURL are not required and used when creating billing agreement with payment_method as "credit_card".
// However, it is generally a good idea to set these values, in case you plan to create billing agreements which accepts "paypal" as payment_method.
// This will keep your plan compatible with both the possible scenarios on how it is being used in agreement.
$merchantPreferences->setReturnUrl("https://thezense.com")
    ->setCancelUrl("https://thezense.com")
    ->setAutoBillAmount("yes")
    ->setInitialFailAmountAction("CONTINUE")
    ->setMaxFailAttempts("0")
    ->setSetupFee(new Currency(array('value' => 0, 'currency' => 'USD')));
$plan->setPaymentDefinitions(array($paymentDefinition));
$plan->setMerchantPreferences($merchantPreferences);
// For Sample Purposes Only.
$request = clone $plan;
// ### Create Plan
try {
    $output = $plan->create($apiContext);

    // Activate plan
    try {
        $patch = new Patch();
        $value = new PayPalModel('{
               "state":"ACTIVE"
             }');
        $patch->setOp('replace')
            ->setPath('/')
            ->setValue($value);
        $patchRequest = new PatchRequest();
        $patchRequest->addPatch($patch);
        $output->update($patchRequest, $apiContext);
        $plan = Plan::get($output->getId(), $apiContext);

        echo $output;
    } catch (Exception $ex) {
        echo $ex;
        echo $ex->getCode();
        echo $ex->getData();
    }

} catch (Exception $ex) {
    echo $ex;
    echo $ex->getCode();
    // echo $ex->getData();
}