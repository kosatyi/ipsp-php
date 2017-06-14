<?php

require_once 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('MERCHANT_ID' , 1396424 );
define('MERCHANT_PASSWORD' , 'test' );
define('IPSP_GATEWAY' ,  'api.fondy.eu' );

$client = new Ipsp_Client( MERCHANT_ID , MERCHANT_PASSWORD, IPSP_GATEWAY );
$api    = new Ipsp_Api( $client );

$result = $api->call('result');

if( $result->validResponse() ){
    exit(sprintf('<pre>%s</pre>',$result->getResponse()));
}

$api->setParam('order_id', sprintf('order_%s',time()) );
$api->setParam('order_desc','IPSP PHP Order Description' );
$api->setParam('currency', $api::USD );
$api->setParam('amount', 2000 );
$api->setParam('response_url', $api->getCurrentUrl() );

$response = $api->call('checkout')->getResponse();

if($response->isFailure()){
    print $response->getErrorMessage();
} else {
    $response->redirectToCheckout();
}