<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';

define('MERCHANT_ID' , 900002 );
define('MERCHANT_PASSWORD' , 'test');
define('IPSP_GATEWAY' ,  'api.dev.fondy.eu');


$client = new Ipsp_Client( MERCHANT_ID , MERCHANT_PASSWORD, IPSP_GATEWAY );

$api   = new Ipsp_Api( $client );


$result = $api->call('result');

//print_r($result->getResponse());

$api->setParam('order_id',sprintf('order_%s',time()));
$api->setParam('order_desc','Test Order Description');
$api->setParam('currency', $api::UAH );
$api->setParam('amount', 2000 );
$api->setParam('response_url',$api->getCurrentUrl());

$api->call('checkout')->redirectToCheckout();

//print $api->getCurrentUrl();