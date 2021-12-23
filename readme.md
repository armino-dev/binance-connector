# Binance API connector for PHP

[![Build Status](https://app.travis-ci.com/armino-dev/binance-connector.svg?branch=master)](https://app.travis-ci.com/armino-dev/binance-connector)

## *** Work in progress ***
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
