# Binance API connector for PHP

## Usage

```bash
composer require armino-dev/binance-connector
```

```php
<?php

use Armino\BinanceConnector\Binance\Connector;

$connector = Connector::init('your_api_key', 'your_api_secret');

$exchangeInformation = $connector->market->exchangeInformation();

var_dump($exchangeInformation);

```
