---
title: IPSP PHP SDK
description: Flexible SDK that covers e-commerce for businesses of all types and support popular CMS modules for fast integration in existing infrastructure.   
---

{% include github.buttons.html %}

<img src="/assets/images/brand.png" width="201" height="193" alt="Logo" class="image-left">

# IPSP PHP SDK

Is a free and open-source software development kit written in PHP and distributed under the MIT License. 
This SDK is a wrapper of Fondy payment protocol REST API, uses object-oriented programming (OOP) techniques and 
several design pattern: Command, Chain of Responsibility, Proxy. SDK covers e-commerce for businesses of all types and 
support popular CMS modules for fast integration in existing software architecture.

## How Does it Work?

Payment Service Providers partner with Acquiring Banks to offer Merchants the capability to accept payments. 
Payment Service Providers often offer services in addition to processing transactions. 

These services include Payment Card Industry and Data Security Standard (PCI) compliance, fraud protection and the 
ability to process different currencies and translate different languages.


> ### Payment Service Provider
A payment service provider (PSP) offers shops online services for accepting electronic payments by 
a variety of payment methods including credit card, bank-based payments such as direct debit, bank 
transfer, and real-time bank transfer based on online banking. Typically, they use a software as a service 
model and form a single payment gateway for their clients (merchants) to multiple payment methods.
[read more](https://en.wikipedia.org/wiki/Payment_service_provider){:target="_blank"}

## How make a quick checkout URL for a specific product?

```php
<?php
require_once 'vendor/autoload.php';
define('MERCHANT_ID' , 1396424 );
define('MERCHANT_PASSWORD' , 'test' );
define('IPSP_GATEWAY' ,  'api.fondy.eu' );
$client = new Ipsp_Client( MERCHANT_ID , MERCHANT_PASSWORD, IPSP_GATEWAY );
$ipsp   = new Ipsp_Api( $client );
$data = $ipsp->call('checkout',array(
  'order_id'    => sprintf('ipsp-php-order-%s',rand(1,9999999)),
  'order_desc'  => 'Product description',
  'currency'    => $ipsp::USD ,
  'amount'      => 2000, // 20 USD
  'response_url'=> sprintf('http://shop.example.com/checkout/result')
));
$data->redirectToCheckout();
```


## Key features

* Quick installation
* Client side instruction and best practicies
* Host-to-host and vendor side checkout page
* Multiple payment methods credit card, internet banking.
* Multiple data formats (JSON, XML, form-urlencoded)
* Payment details for testing scope
* Hidden server callback for sign responses
* Integration with CMS modules.

---

## [Blog](/blog/)

<div class="blog-list">
{% for post in site.posts limit: 3 %}
{% include blog.entry.html %}
{% endfor %}
</div>

---

## Project Sections

<nav class="cards section">
{% include navigation.html base_url="/" max_depth=2 %}
</nav>

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Organization",
  "url": "https://ipsp-php.com/",
  "logo": "https://ipsp-php.com/assets/images/brand.png",
  "contactPoint": [
    { 
      "@type": "ContactPoint",
      "telephone": "+38-093-925-7212",
      "contactType": "technical support"
    }
  ]
}
</script>

<script type="application/ld+json">
{
  "@context":"http://schema.org",
  "@type":"ItemList",
  "itemListElement":[{% for post in site.posts limit: 3 %}
    {
      "@type":"ListItem",
      "position":{{forloop.index}},
      "url":"{{ post.url | prepend: site.url }}"
    }{% if forloop.last %}{% else %},{% endif %}{% endfor %}
  ]
}
</script>