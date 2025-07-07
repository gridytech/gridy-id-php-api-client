# gridy-id-php-api-client

Gridy ID is a Multi-Factor authentication (MFA) API service & Authenticator application for Android, IOS, Windows, MacOS, Linux & Web .

Use Gridy to replace your existing username/password authentication or Integrate Gridy ID into your adaptive authentication workflow in minutes using our API service and clients


## Installation & Usage

### Requirements

PHP 7.4 and later.
Should also work with PHP 8.0.

### Composer

To install the bindings via [Composer](https://getcomposer.org/), add the following to `composer.json`:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/gridytech/gridy-id-php-api-client.git"
    }
  ],
  "require": {
    "gridytech/gridy-id-php-api-client": "*@dev"
  }
}
```

Then run `composer install`

### Manual Installation

Download the files and include `autoload.php`:

```php
<?php
require_once('/path/to/gridy-id-php-client/vendor/autoload.php');
```

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php

<?php

require_once(__DIR__ . '/vendor/autoload.php');

// Configure Your Gridy API User ID
$config = GridyAPI\Client\Configuration::getDefaultConfiguration()->setApiUser( 'YOUR_API_USER_ID');

// Configure Your Gridy API Secret Key
$config = GridyAPI\Client\Configuration::getDefaultConfiguration()->setApiUser( 'YOUR_API_SECRET_KEY');


$apiInstance = new GridyAPI\Client\Service\GridyIDServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$api_request = { 
 "id":< Your own reference >,
 "utctime": <UTC Timestamp>,
 "apiUser":< Your Api User ID >,
 "type":150,
 "body":{
   "gridyUser":<User Email Address>,
   "challengeType":<"UserKeyAndPattern"|"UserKeyPatternAndPin"|"UserKeyAndUserPin"|"UserKeyAndUserFace"|"UserKeyAndUserVoice" >,
   "challengeExpiry":<"ThreeMins"|"FiveMins"|"TenMins"|"FifteenMins"|"ThirtyMins"|"SixtyMins">,
   "enableQRCode":<true|false>,
   "enableAutoVerify":<true|false>,
   "profile":"<Your Assigned User Profile Reference>",
   "status":"NEW"
 }
}; // \GridyAPI\Client\Model\ApiRequest | The JSON body of the request. Contains the Gridy ID challenge request.

try {
    $result = $apiInstance->challenge($api_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GridyIDServiceApi->challenge: ', $e->getMessage(), PHP_EOL;
}

```

## API Endpoints

All URIs are relative to *https://api.gridy.io/prod*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
[*GridyIDServiceApi*] | [**challenge**](https://support.gridy.io/docs/api/challenge.html) | **POST** /v1/svc/challenge | Send or Cancel a Gridy ID MFA challenge request.
[*GridyIDServiceApi*] | [**status**](https://support.gridy.io/docs/api/status.html) | **POST** /v1/svc/status | Check a Gridy ID MFA challenge status
[*GridyIDServiceApi*] | [**time**](https://support.gridy.io/docs/api/time.html) | **GET** /v1/svc/time | Get current UTC time
[*GridyIDServiceApi*] | [**verify**](https://support.gridy.io/docs/api/verify.html) | **POST** /v1/svc/verify | Verify a Gridy ID authentication code
[*GridyIDServiceApi*] | [**blocked**](https://support.gridy.io/docs/api/blocked.html) | **POST** /v1/svc/blocked | Check IPv4 & User Blocked Rules.



## Models

- [ApiRequest](docs/Model/ApiRequest.md)
- [ApiResponse](docs/Model/ApiResponse.md)

## Authorization

## Documentation For Authorization


[Authentication](https://support.gridy.io/docs/api/security.html) schemes defined for the API:


<a id="x-gridy-apiuser"></a>
### x-gridy-apiuser
- **Type**: GRIDY-HMAC
- **Parameter name**: x-gridy-apiuser
- **Location**: HTTP header

<a id="x-gridy-cnonce"></a>
### x-gridy-cnonce

- **Type**: GRIDY-HMAC
- **Parameter name**: x-gridy-cnonce
- **Location**: HTTP header

<a id="x-gridy-utctime"></a>
### x-gridy-utctime

- **Type**: GRIDY-HMAC
- **Parameter name**: x-gridy-utctime
- **Location**: HTTP header

<a id="Authorization"></a>
### Authorization

- **Type**: GRIDY-HMAC
- **Parameter name**: Authorization
- **Location**: HTTP header


## Author gridy.io
