<?php

declare(strict_types=1);

namespace Armino\BinanceConnector\Binance\Api;

trait Signable
{
    public function sign(string $query): string
    {
        return $this->signature = hash_hmac('sha256', $query, $this->apiSecret);
    }    
}
