# GP Webpay PHP SDK
[![Build Status](https://travis-ci.org/newPOPE/gp-webpay-php-sdk.svg?branch=master)](https://travis-ci.org/newPOPE/gp-webpay-php-sdk)

Full featured PHP SDK for [GP Webpay payments](http://www.gpwebpay.cz).

## Installation

The best way to install GP Webpay PHP SDK is using  [Composer](http://getcomposer.org/):

```sh
$ composer require Glami/webpay-php dev-master
```

## Setup

```php
$signer = new \Glami\GpWebpay\Signer(
  $privateKeyFilepath,    // Path of private key.
  $privateKeyPassword,    // Password for private key.
  $publicKeyFilepath      // Path of public key.
);
    
$api = new \Glami\GpWebpay\Api(
  $merchantNumber,    // Merchant number.
  $webpayUrl,         // URL of webpay.
  $signer             // instance of \Glami\GpWebpay\Signer.
);

```

## Create payment

### Create payment url

 ```php
 use \Glami\GpWebpay\PaymentRequest;
 
 $request = new PaymentRequest(...);
 
 $url = $api->createPaymentRequestUrl($request); // $api instance of \Glami\GpWebpay\Api
 
 // use $url as you want. In most cases for redirecting to GP Webpay.
 
 ```
 
### Verify payment response
 
```php
use \Glami\GpWebpay\PaymentResponse;
use \Glami\GpWebpay\Exception;
 
$response = new PaymentResponse(...); // fill response with response parameters (from request).
 
try {
  $api->verifyPaymentResponse($response);
} 
catch (PaymentResponseException $e) {
  // PaymentResponseException has $prCode, $srCode for properties for logging GP Webpay response error codes.
}
catch (Exception $e) {
  // Digest is not correct.
}

```
 
 
 
 
