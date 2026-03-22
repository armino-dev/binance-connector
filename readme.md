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

## Error handling

Network and transport errors throw typed exceptions from the HTTP client layer.

```php
<?php

use Armino\BinanceConnector\Binance\Connector;
use Armino\BinanceConnector\HttpClient\Exceptions\HttpClientException;

try {
	$connector = Connector::init('your_api_key', 'your_api_secret');
	$result = $connector->status->serverTime();
} catch (HttpClientException $exception) {
	echo $exception->getMessage();

	if ($exception->getPrevious() !== null) {
		echo $exception->getPrevious()->getMessage();
	}
}
```
