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
$data = $ipsp->call('checkout',array(
 'order_id'    => $order_id,
 'order_desc'  => 'Short Order Description',
 'currency'    => $ipsp::USD ,
 'amount'      => 2000, // 20 USD
 'response_url'=> sprintf('http://shop.example.com/checkout/%s',$order_id)
))->getResponse();
// redirect to checkoutpage
header(sprintf('Location: %s',$data->checkout_url));
```

## Api Methods
### Accept purchase (hosted payment page)
```php
$data = $ipsp->call('checkout',array());
```
### Accept purchase (merchant payment page)
```php
$data = $ipsp->call('pcidss',array());
```
### Purchase using card token
```php
$data = $ipsp->call('recurring',array());
```
### Payment report
```php
$data = $ipsp->call('reports',array());
```
### Order Refund
```php
$data = $ipsp->call('reverse',array());
```
### Check payment status
```php
$data = $ipsp->call('status',array());
```
### Card verification
```php
$data = $ipsp->call('verification',array());
```
### P2P card credit
```php
$data = $ipsp->call('p2pcredit',array());
```

## Examples

Checkout ipsp examples https://github.com/kosatyi/ipsp-php-examples.git
