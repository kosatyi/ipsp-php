---
title: IPSP PHP SDK
description: Flexible SDK that covers e-commerce for businesses of all types and support popular CMS modules for fast integration in existing infrastructure.   
---

{% include github.buttons.html %}

# Payment Service Provider

<img src="/assets/images/brand.png" alt="Logo" class="image-left">

A payment service provider (PSP) offers shops online services for accepting electronic payments by 
a variety of payment methods including credit card, bank-based payments such as direct debit, bank 
transfer, and real-time bank transfer based on online banking. Typically, they use a software as a service 
model and form a single payment gateway for their clients (merchants) to multiple payment methods.
[read more](https://en.wikipedia.org/wiki/Payment_service_provider)

## How Does a Payment Service Provider Work?

Payment Service Providers partner with Acquiring Banks to offer Merchants the capability to accept payments. 
Payment Service Providers often offer services in addition to processing transactions. 
These services include Payment Card Industry Data Security Standard (PCI) compliance, 
fraud protection and the ability to process different currencies and translate different languages.

## [Blog](/blog/)

<div class="blog-list">
{% for post in site.posts limit: 3 %}
{% include blog.entry.html %}
{% endfor %}
</div>

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