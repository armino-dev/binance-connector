<?php

declare(strict_types=1);

namespace Armino\BinanceConnector\Binance\Api\Spot;

use Armino\BinanceConnector\Binance\Api\Api;
use Armino\BinanceConnector\Binance\Api\Signable;
use Armino\BinanceConnector\Binance\Api\Signature;

final class Market extends Api implements Signature
{
    use Signable;

    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->endpoint = self::_API_BASE_URL . '/sapi/v1/c2c';
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->headers = [
            'Content-Type: application/json',
            'X-MBX-APIKEY: ' . $this->apiKey,
        ];
    }

    public function listUserOrderHistory(string $type = 'BUY'): string
    {
        //TODO: implement function
        return '';
    }
}
