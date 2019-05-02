<?php
// #Execute Agreement
// This is the second part of CreateAgreement Sample.
// Use this call to execute an agreement after the buyer approves it
require __DIR__  . './../PayPal-PHP-SDK/autoload.php';

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'ARHUQbhkYoKD5UeOnDPqjFubJir1-ryQ6FHJ0EaiFqxpuhfebkXZnlqomUnmf5R6xGydTMlgBGzLpQA2',     // ClientID
        'EBXxxN8k37AbwgqCr6PXNwWRt5ulcFrPra08Xt0D9cKtQRCY9HAy6RGSNpyArCdtgBGAgSUOhIfRZOED'      // ClientSecret
    )
);
// ## Approval Status
// Determine if the user accepted or denied the request
// if (isset($_GET['success']) && $_GET['success'] == 'true') {
$token = $_POST['token'];
$agreement = new \PayPal\Api\Agreement();
try {
    // ## Execute Agreement
    // Execute the agreement by passing in the token
    $agreement->execute($token, $apiContext);
} catch (Exception $ex) {
    echo $ex;
    echo $ex->getCode();
    echo $ex->getData();
}

try {
    $agreement = \PayPal\Api\Agreement::get($agreement->getId(), $apiContext);
} catch (Exception $ex) {
    echo $ex;
    echo $ex->getCode();
    // echo $ex->getData();
}
// } else {
    
// }

echo $agreement;