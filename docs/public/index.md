# Payment service provider
A payment service provider (PSP) offers shops online services for accepting electronic payments by a variety of payment methods including credit card, bank-based payments such as direct debit, bank transfer, and real-time bank transfer based on online banking. Typically, they use a software as a service model and form a single payment gateway for their clients (merchants) to multiple payment methods.
[read more](https://en.wikipedia.org/wiki/Payment_service_provider)


## Installation

Clone from GitHub:

```cmd
git clone git@github.com:kosatyi/ipsp-php.git
```

If you’re using Composer, you can run the following command:

```cmd
composer require kosatyi/ipsp-php
```

## Quick Start

```php
<?php
require_once 'ipsp-php/autoload.php';
define('MERCHANT_ID' , 'your_merchant_id');
define('MERCHANT_PASSWORD' , 'test');
define('IPSP_GATEWAY' , 'your_ipsp_gateway');
$client = new Ipsp_Client( MERCHANT_ID , MERCHANT_PASSWORD, IPSP_GATEWAY );
$ipsp   = new Ipsp_Api( $client );
```

## Generate Signature

```php
<?php
function getSignature( $merchant_id , $password , $params = array() ){
 $params['merchant_id'] = $merchant_id;
 $params = array_filter($params,'strlen');
 ksort($params);
 $params = array_values($params);
 array_unshift( $params , $password );
 $params = join('|',$params);
 return(sha1($params));
}
```

## Generate Checkout

```php
<?php
$order_id = 'testproduct10002';
$data = $ipsp->call('checkout',array(
  'order_id'    => 'orderid-111222333',
  'order_desc'  => 'Simple checkout page',
  'currency'    => $ipsp::USD ,
  'amount'      => 2000, // 20 USD
  'response_url'=> sprintf('http://shop.example.com/checkout/result')
))->getResponse();
// redirect to checkoutpage
header(sprintf('Location: %s',$data->checkout_url));
```

## API Methods
### Accept purchase (hosted payment page)
```php
<?php
$data = $ipsp->call('checkout',array(
  'order_id'    => 'orderid-111222333',
  'order_desc'  => 'Simple checkout page',
  'currency'    => $ipsp::USD ,
  'amount'      => 2000, // 20 USD
  'response_url'=> sprintf('http://shop.example.com/checkout/result')
));
```
### Accept purchase (merchant payment page)
```php
<?php
$data = $ipsp->call('pcidss',array(
  'order_id'    => 'orderid-222333444',
  'order_desc'  => 'PCIDSS Secure checkout page',
  'currency'    => $ipsp::USD ,
  'amount'      => 2000, // 20 USD
  'response_url'=> sprintf('http://shop.example.com/checkout/result'),
  'card_number' => 4444555566661111, // 16-19 digits card number
  'expiry_date' => '1240', // date (MMYY) format
  'cvv2'        => 111
));
```
### Purchase using card token
```php
<?php
$data = $ipsp->call('recurring',array(
  'order_id'    => 'orderid-111222333',
  'order_desc'  => 'Simple checkout page',
  'currency'    => $ipsp::USD ,
  'amount'      => 2000, // 20 USD
  'response_url'=> sprintf('http://shop.example.com/checkout/result')
  'required_rectoken'=>'y'
));

header(sprintf('Location: %s',$data->checkout_url));
```
```php
<?php
// On result page save rectoken POST param
$data = $ipsp->call('recurring',array(
  'order_id'    => 'orderid-111222333',
  'order_desc'  => 'Simple checkout page',
  'currency'    => $ipsp::USD ,
  'amount'      => 2000, // 20 USD
  'response_url'=> sprintf('http://shop.example.com/checkout/recurring'),
  'rectoken'    => RECTOKEN
));

$result = $data->getResponse();

```
### Payment report
```php
<?php
// Get report for 2 past days
$date_from = new DateTime('-2 days');
$date_to = new DateTime('now');
$data = $ipsp->call('reports',array(
  'date_from'=>$date_from->format('d.m.Y'),
  'date_to'  =>$date_to->format('d.m.Y')
));
$result = $data->getResponse();
```
### Order Refund
```php
<?php
$data = $ipsp->call('reverse',array(
  'order_id'    => 'orderid-111222333',
  'amount'      => 2000 ,
  'currency'    => $ipsp::USD
));
$result = $data->getResponse();
```
### Check payment status
```php
<?php
$data = $ipsp->call('status',array(
  'order_id'    => 'orderid-111222333',
));
```
### Card verification
```php
<?php
$data = $ipsp->call('verification',array(
  'order_id'    => 'orderid-111222333',
  'order_desc'  => 'Simple checkout page',
  'currency'    => $ipsp::USD ,
  'amount'      => 100, // 1 USD
  'response_url'=> sprintf('http://shop.example.com/checkout/recurring'),
));
```
### Order capture
```php
<?php
$data = $ipsp->call('capture',array(

));
```
### P2P card credit
```php
<?php
$data = $ipsp->call('p2pcredit',array(

));
```

## Examples

Checkout ipsp examples https://github.com/kosatyi/ipsp-php-examples.git
