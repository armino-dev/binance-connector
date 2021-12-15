<?php

namespace Armino\BinanceConnector\Binance\Api\Spot;

use Armino\BinanceConnector\Binance\Api\Api;

class Wallet extends Api
{
    public function __construct()
    {
        $this->endpoint = self::_API_BASE_URL . '/sapi/v1/blvt';
    }
}
