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
## Examples
Checkout ipsp examples projects https://github.com/kosatyi/ipsp-php-examples
