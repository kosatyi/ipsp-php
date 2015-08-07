# IPSP (PHP) SDK

## Payment service provider
A payment service provider (PSP) offers shops online services for accepting electronic payments by a variety of payment methods including credit card, bank-based payments such as direct debit, bank transfer, and real-time bank transfer based on online banking. Typically, they use a software as a service model and form a single payment gateway for their clients (merchants) to multiple payment methods. 
[read more](https://en.wikipedia.org/wiki/Payment_service_provider)

## API Documentation

https://www.oplata.com/info/api

## Quick Start

```php
 
<?php
require_once 'ipsp-php/autoload.php';
define('MERCHANT_ID' , '1000');
define('MERCHANT_PASSWORD' , 'test');
$client = new Ipsp_Client( MERCHANT_ID , MERCHANT_PASSWORD);
$ipsp   = new Ipsp_Api( $client );

```
## Generate Checkout

```php
 
<?php

$order_id = 'testproduct10002';
$ipsp->setParam('order_id',$order_id);
$ipsp->setParam('order_desc','Test Product');
$ipsp->setParam('currency',$ipsp::USD);
$ipsp->setParam('response_url',sprintf('http://shop.example.com/checkout/%s',$order_id));
$ipsp->setParam('amount',2000);

$data = $ipsp->call('Checkout')->getResponse();
// redirect to checkoutpage
header(sprintf('Location: %s',$data->checkout_url));

```

## Examples
Checkout ipsp examples project https://github.com/kosatyi/ipsp-php-examples.git
