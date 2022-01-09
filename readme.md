[![Build Status](https://app.travis-ci.com/armino-dev/binance-connector.svg?branch=master)](https://app.travis-ci.com/armino-dev/binance-connector)

# Binance API connector for PHP

Before you begin, just bear in mind this is **work in progress**.

Binance API connector for PHP is a simple library that allows you to perform API requests to the Binance Exchange.

## Prerequisites

* `PHP` version >= 7.4
* `ext-curl` enabled
* `composer` installed and globally accessible

## Usage

Go to your project folder and type in a terminal:

```bash
composer require armino-dev/binance-connector
```

The following is an example php file that is dumping the binance exchange information.

```php
<?php

// uncomment and adjust to your path if needed
// require __DIR__ . "/../vendor/autoload.php";

use Armino\BinanceConnector\Binance\Connector;

$connector = Connector::init('your_api_key', 'your_api_secret');

$exchangeInformation = $connector->market->exchangeInformation();

var_dump($exchangeInformation);
```
