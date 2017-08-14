---
title: About
description: IPSP PHP SDK is a free and open-source software development kit written in PHP and distributed under the MIT License
header: breadcrumbs
---

# About

[**IPSP PHP SDK**]({{site.url}}) is a free and open-source software development kit written in PHP and distributed under the MIT License. 

[**IPSP PHP SDK**]({{site.url}}) is a wrapper of Fondy payment protocol REST API, uses object-oriented programming (OOP) 
techniques and several design pattern: Command , Chain of Responsibility, Proxy. SDK covers e-commerce 
for businesses of all types and support popular CMS modules for fast integration in existing software architecture.


## How Does it Work?

Payment Service Providers partner with Acquiring Banks to offer Merchants the capability to 
accept payments. Payment Service Providers often offer services in addition to processing 
transactions. These services include Payment Card Industry and Data Security Standard (PCI) 
compliance, fraud protection and the ability to process different currencies and translate different languages.

## Brief history

Project started on 5 August 2015 as GitHub project. After almost 2 years, the project has its own website. 
The development of new releases and bug fixes started after code coverage with unit tests. In the future, 
support will be added for new versions of PHP and PSR-2 coding style guide and PSR-4 autoloader specification.

## Key features

- Quick installation
- Client side instruction and best practicies
- Host-to-host and vendor side checkout page
- Multiple payment methods credit card, internet banking.
- Multiple data formats (JSON, XML, form-urlencoded)
- Payment details for testing scope
- Hidden server callback for sign responses
- Integration with CMS modules.

## API methods

All API methods executes in the same way. Use $ipsp (Ipsp_Api instance) 
method call() and pass two parameters: method name and parameters as associative array.

```php
<?php
$data = $ipsp->call('method name',array(
  ...
  'param'    => 'value',
  ...
));
?>
```

<div class="row">
    <div class="col-sm-6">
    <h2>General API methods</h2>
    <nav class="cards section">
    <ul class="cards">
        <li><a href="/docs/api-methods/1.accept-purchase-hosted-payment-page.html">checkout</a></li>
        <li><a href="/docs/api-methods/3.purchase-using-card-token.html">recurring</a></li>
        <li><a href="/docs/api-methods/5.order-refund.html">reverse</a></li>
        <li><a href="/docs/api-methods/7.card-verification.html">verification</a></li>
        <li><a href="/docs/api-methods/8.order-capture.html">capture</a></li>
        <li><a href="/docs/api-methods/6.check-payment-status.html">status</a></li>
        <li><a href="/docs/api-methods/4.payment-report.html">reports</a></li>
    </ul>
    </nav>
    </div>
    <div class="col-sm-6">
        <h2>PCI compliance API methods</h2>
        <nav class="cards section">
        <ul>
            <li><a href="/docs/api-methods/2.accept-purchase-merchant-payment-page.html">pcidss</a></li>
            <li><a href="/docs/api-methods/9.p2p-card-credit.html">p2pcredit</a></li>
        </ul>
        </nav>
    </div>
</div>

## Client side integration

To provide more flexibility for developers, server-side code must deliver secure information 
(commonly token like UUID) to front-end application, and handle signed responses from payment gateway 
for payment completion. All other things covered by client-side developers and UX designers.

### Embedded checkout page

To load checkout page on merchant site using **IPSP.JS** API, developer should first receive this url using checkout api method. 
Then using example below just replace variable CHECKOUT_URL with api response variable checkout_url.

```html
<div id="checkout"></div>
<script src="https://api.fondy.eu/static_common/v1/checkout/ipsp.js"></script>
<script>
 $ipsp.get('checkout').config({'wrapper':'#checkout'}).scope(function(){
     this.loadUrl(CHECKOUT_URL);
 });
</script>
```

### Styling checkout page

**IPSP.JS** support embedded css rules to override the default checkout page design (hide general shop info section, style form controls etc.)

```html
<script>
 $ipsp.get('checkout').config({
     'wrapper': '#frameholder' ,
     'styles' : {
         'body':{
            'overflow':'hidden'
         },
         '.page-section-shopinfo':{
             display:'none'
         },
         '.page-section-footer':{
             display:'none'
         }
     }
 })
</script>
```

### Donate button

Online donation on web-site is an important thing in open source project or non-commercial organization. 
In this case payment service providers bring to their clients features like:

- [Donate button](https://en.wikipedia.org/wiki/Click-to-donate_site)
- [Invoicing](https://en.wikipedia.org/wiki/Electronic_invoicing)


This payment type is less secure for using in e-commerce project, but ideal for Personal web page, open source project or Nonprofit organization. 

Example:

```html
<script src="https://api.fondy.eu/static_common/v1/checkout/ipsp.js"></script>
<script>
function getCheckoutUrl(amount,order_desc) {
    var button = $ipsp.get('button');
    button.setMerchantId(1396424);
    button.setAmount(amount,'USD');
    button.setResponseUrl('http://example.com/result/');
    button.setHost('api.fondy.eu');
    button.addField({
        label: 'Payment Description',
        name: 'order_desc',
        value: order_desc,
        readonly:true
    });
    return button.getUrl();
};
</script>
<button onclick="location.href=getCheckoutUrl('','Open source project support')">
Donate an arbitrary amount
</button>
<button onclick="location.href=getCheckoutUrl(10,'10$ Donation')">
Donate $10
</button>
```

## See also

- [Fondy Documentation](http://bit.ly/fondy-docs)
