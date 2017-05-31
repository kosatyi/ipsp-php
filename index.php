<?php

require_once 'vendor/autoload.php';

define('MERCHANT_ID' , 1000);
define('MERCHANT_PASSWORD' , 'test');
define('IPSP_GATEWAY' ,  'api.fondy.eu');

$client = new Ipsp_Client( MERCHANT_ID , MERCHANT_PASSWORD, IPSP_GATEWAY );
$ipsp   = new Ipsp_Api( $client );
