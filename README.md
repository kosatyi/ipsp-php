### This project is no longer maintained

# IPSP PHP SDK

Flexible software development kit that covers e-commerce for businesses of all types and support
popular CMS modules for fast integration in existing infrastructure.

<a href="https://packagist.org/packages/kosatyi/ipsp-php"><img src="https://img.shields.io/packagist/v/kosatyi/ipsp-php.svg" /></a>
<a href="https://travis-ci.org/kosatyi/ipsp-php"><img src="https://img.shields.io/travis/kosatyi/ipsp-php.svg" /></a>
<a href="https://coveralls.io/github/kosatyi/ipsp-php"><img src="https://img.shields.io/coveralls/kosatyi/ipsp-php/master.svg" /></a>
<a href="https://packagist.org/packages/kosatyi/ipsp-php"><img src="https://img.shields.io/packagist/dt/kosatyi/ipsp-php.svg"/></a>
<a href="https://packagist.org/packages/kosatyi/ipsp-php"><img src="https://img.shields.io/github/license/kosatyi/ipsp-php.svg" /></a>

## Installation

### System Requirements

PHP 5.2 and later.

### Dependencies

SDK require the following extension in order to work properly:

- [`curl`](https://secure.php.net/manual/en/book.curl.php)
- [`json`](https://secure.php.net/manual/en/book.json.php)

### Manual Installation

If you do not use Composer, you can download the
[latest release](https://github.com/kosatyi/ipsp-php/releases).
Or clone from GitHub the latest developer version
```cmd
git clone git@github.com:kosatyi/ipsp-php.git
```

Then include autoload file in your project.

```php
<?php
require_once('/path/to/ipsp-php/autoload.php');
```

### Composer

If you’re using [Composer](https://getcomposer.org/), you can run the following command:

```cmd
composer require kosatyi/ipsp-php
```

Or add dependency manually in `composer.json`

```json
{
  "require": {
    "kosatyi/ipsp-php":"^1.1"
  }
}

```


## Quick Start

Import library to your project file.

```php
<?php
// Manually installed project
require_once 'ipsp-php/autoload.php';
// If you are install SDK with composer
require_once 'vendor/autoload.php';
```

Define constants in project file or import from custom location.

```php
<?php
define('MERCHANT_ID' , 'your_merchant_id');
define('MERCHANT_PASSWORD' , 'password');
define('IPSP_GATEWAY' , 'your_ipsp_gateway');
```

Create `Ipsp_Client` instance by passing configuration properties:

- `MERCHANT_ID` - Checkout Merchant ID from provider admin panel.
- `MERCHANT_PASSWORD` - Merchant password
- `IPSP_GATEWAY` - Choose provider gateway.

```php
<?php
$client = new Ipsp_Client( MERCHANT_ID , MERCHANT_PASSWORD, IPSP_GATEWAY );
```

Create `Ipsp_Api` instance by passing `Ipsp_Client` instance:

```php
<?php
$ipsp   = new Ipsp_Api( $client );
```

Finally create bootstrap file `init.php` with content below:

```php
<?php
require_once 'vendor/autoload.php';
define('MERCHANT_ID' , 'YOUR_MERCHANT_ID');
define('MERCHANT_PASSWORD' , 'PAYMENT_KEY' );
define('IPSP_GATEWAY' , 'api.fondy.eu');
$client = new Ipsp_Client( MERCHANT_ID , MERCHANT_PASSWORD, IPSP_GATEWAY );
$ipsp   = new Ipsp_Api( $client );
```

## Basic Usage Example

```php
<?php
require_once('path/to/init.php');
$data = $ipsp->call('checkout',array(
  'order_id'    => 'orderid-111222333',
  'order_desc'  => 'Simple checkout page',
  'currency'    => $ipsp::USD ,
  'amount'      => 2000, // 20 USD
  'response_url'=> sprintf('http://shop.example.com/result.php')
))->getResponse();
// redirect to checkout page
$data->redirectToCheckout();
```

## Handling response

Create page `result.php` with code below:

```php
<?php
require_once('path/to/init.php');
$result = $api->call('result');
if( $result->validResponse() ){
    exit(sprintf('<pre>%s</pre>',$result->getResponse()));
}
```

## Follow project on:

- Facebook [/ipsp.sdk](https://facebook.com/ipsp.sdk/)
- Twitter [@ipspsdk](https://twitter.com/ipspsdk)

## Author

Stepan Kosatyi, stepan@kosatyi.com

[![Stepan Kosatyi](https://img.shields.io/badge/stepan-kosatyi-purple.svg)](https://kosatyi.com/)
