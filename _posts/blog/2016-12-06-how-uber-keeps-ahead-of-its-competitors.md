---
title: How Uber keeps ahead of its competitors or, the ins and outs of payments and
  finances within the company
categories: blog e-commerce
description: The economic model which is known as the sharing economy, and which has
  made Uber one of the planet’s most successful startups, was made possible thanks
  not only to disruptive technological innovations but financial ones too.
headline: How Uber keeps ahead of its competitors
tagline: The economic model which is known as the sharing economy, and which has made
  Uber one of the planet’s most successful startups, was made possible thanks not
  only to disruptive technological innovations but financial ones too
---

## Finances and IT

The economic model which is known as the sharing economy, and which has made **Uber** one of the planet’s most successful 
startups, was made possible thanks not only to disruptive technological innovations but financial ones too. 
But whereas companies love to tell us about their technologies, when it comes to the financial side of things, they 
maintain a modest silence. What’s the big secret? Let’s have a look.

## Global expansion

Having launched in 2010 in San Francisco, like a virus **Uber** quickly spread, conquering new cities and countries in 
the process. But before long the company came up against a problem: how could it expand its financial model of settling 
accounts between passengers and drivers to all regions where the service is present? The main advantages of Uber’s 
payment infrastructure are fast in-app payments, the possibility to pay in every country in local currency and regular 
transfers of earnings to drivers’ personal accounts or cards.

Whenever **Uber** enters a new market there are two main payment-related issues to resolve: how to accept payments from 
customers and how to make payouts to drivers. In addressing such issues, Uber has two models to choose from: it can 
either integrate with local payment services in each new country or it can work with its usual partners. Some of the 
latter at the moment include Paypal, Braintree (a subsidiary of PayPal) and Adyen (a well-known international payment 
platform). Each model has pluses and minuses stemming from several factors.

## Accepting payments from passengers

Let’s have a look at how payments are received from passengers through use of their bank cards. If Uber, upon launching 
in a new country, has decided to integrate with a local payment platform or bank, then this risks throwing into doubt 
the timeline for the launch, in the event of delays in the integration process.

It’s worth explaining at this point that both the bank used by a merchant or online shop ( the “acquiring bank” or “acquirer”) 
and the bank of a person making a payment (the “issuing bank or “issuer”), when settling accounts within the **Visa**, 
MasterCard or American Express international payment systems, have to pay that payment system a commission (known as an interchange fee). 
This commission increases if the acquiring bank and the issuing bank are located in different countries.

Uber is an American company but the main financial institution which it uses is located in Netherlands. Things were set
 up this way in order to minimize tax, since Netherlands levies lower taxes on non-resident companies. As a result, 
 however, all payments from passengers located outside of Europe become for **Uber** cross-border transactions. Nonetheless, 
 when entering a new country Uber usually prefers to pay higher commissions for such cross-border payments and work 
 with its own international partners as opposed to taking upon itself the risk of working with a new partner in a new country.

One of the peculiarities of the Uber financial model is that the company wants to receive its revenues by accumulating 
them in its European financial institution in a certain currency (for example euros or dollars) but at the same time does want to inconvenience clients with unnecessary currency conversions. That being the case, PayPal, Braintree and Adyen allow Uber to work with local currencies in different countries and this also means that passengers will always see charges to their card in their usual currency. This technology, called Dynamic Currency Conversion (DCC), is supported by the majority of acquiring bank who are participants in the international payments system. Issuing banks supporting DCC also exist although they may take an extra commission for such transactions. The choice of which issuing bank to chose when taking out a new card has to be made by passengers themselves.

Usually, when Uber is launching in a new market it will, in parallel, also begin the process of direct integration with 
local payment systems. That, however, is only the case when the payment infrastructure in a given country is sufficiently developed and does not present risks in terms of the stability of payment processing or functionality of financial institutions. However, there are times when the integration process begins not because Uber wants it to, but because local laws and regulations mean it must. Such is the case in India, for example, where Uber was forced to work with payments system MobiKwik. This was due to the Reserve Bank of India’s mandatory requirement on online payments of two-factor authorisation and Uber’s stance, as a matter of principle, not to use 3D Secure technology so as not to complicate the payment process within its mobile app. Another case would be when Uber is compelled to integrate with local payment systems because there is a large proportion of local cards in use in a country which are not compatible with international payments (so-called “domestic cards”). In such cases, if Braintree and Adyen are not integrated with a local bank in the country, Uber takes on the integration process itself.

## Payouts to drivers

When it comes to payouts of earnings to drivers things are set up a little bit differently. Since Uber accumulates all 
incoming revenues in its accounts in Holland in euros or another European currency, in order to pay out earnings to 
drivers in the local currency of their particular country, Uber has use cross-border transfers. For this purpose there 
exist the following financial instruments (only international and US systems are listed):

- **Wire transfer or SWIFT transfer**. This is the most universally-available method of international transfers and works in the majority of countries. Within the EU the cost of transfers is low, however when it comes to cross-border transfers service charges increase significantly. Working in an offline regime, funds can be in transit for 2-5 days.
- **Money Transfer** and **MoneySend** are online transfer platforms backed, respectively, by Visa and Mastercard. They allow for online payments to accounts usually within the space of a few minutes. Service charges are reasonable although services are only available in certain countries. The US, for example, is not on the list.
- **Merchandize return** is not so much a technology as a method of making a transfer to a Visa or MasterCard. This is done offline, with funds reaching their destination in 2-5 days. It is not officially provided by acquiring banks and is something akin to a “life hack” as it was initially developed as a means to issue card refunds on purchases. But it is possible to use it to pay out funds to any card. It is the cheapest of all the methods listed here.
- **Quasi-cash**. Similar to the previous entry on the list, this is an offline method of card transfer though is works only to make a transfer to the same card which was originally used to make a payment. In other words, unsuitable for Uber.
- **ACH** offers offline debit card transactions within the US. Processing times are 3-4 days.
- **Western Union**, **Transferwise** and **Moneygramm** are all international transfer systems. They operate only in certain countries and are relatively expensive.

All other international payment transfer platforms are add-ons to, or derivatives of, the underlying systems and methods listed above.

There is no publicly available information regarding which methods Uber uses to make payouts to drivers. But, knowing 
as we do the main underlying technologies and using information which is openly available, we can draw the conclusion 
that Uber effectively combines the necessary systems, methods and payment partners in each country in such as way as to 
minimize the amount it pays in commission on transfers and speed up the arrival of funds into drivers’ accounts. 
For example, In the US Uber has launched Instant Pay which offers instant payouts of earnings to drivers’ debit cards. 
In essence this is a domestic transfer via the ACH system to Visa debit cards issued by GoBank. But since ACH is an offline 
system which takes 3-4 days for processing, what is in fact happening is that GoBank is more or less instantly advancing 
the money to drivers via a card transfer in the expectation that it will receive the real funds from Uber soon after.

Since commission to payment systems and banks for cross-border transfers of small sums of money could eat up all of 
Uber’s revenues, in order to optimize its costs the company does not transfer payouts to every driver directly to their 
accounts. Instead it aggregates revenues in the accounts of intermediaries; these are local financial institutions 
located in the same countries as the drivers. After accounting for its commission (20-25%), Uber once a week transfers 
the proceeds from all passenger trips to the accounts of these, its numerous intermediaries, with the intermediaries, 
in turn, making payouts to the cards and bank accounts of drivers. As a rule, for this “last mile” of mass payouts to 
in-country drivers Uber uses bank partners who have an API for the crediting of cards and accounts.

## It’s not rocket science

As we see from the the above analysis, Uber does not possess any kind of exclusive payment technology or enjoy 
preferential advantages in the financial markets. It is simply that, for the moment at least, payment technologies 
have reached the point where they are accessible not only to world leaders like Uber, Airbnb and Blablacar, but also 
to any small- or medium-sized business anywhere in the world. Uber’s success comes down to the fact that it uses these 
technologies correctly and combines them to create an effective financial model.

---

Author: [Maxim Kozenko](https://ua.linkedin.com/in/maximkozenko)

Source: [How Uber keeps ahead of its competitors or, the ins and outs of payments and finances within the company](https://fondy.eu/en/blog/e-commerce/how-payments-and-finance-work-in-uber/)

