<?php

declare(strict_types=1);

namespace Armino\BinanceConnector\Binance\Api\System;

use Armino\BinanceConnector\Binance\Api\Api;

final class Status extends Api
{
    public function __construct()
    {
        $this->endpoint = self::_API_BASE_URL . '/sapi/v1/system';
        $this->headers = [
            'Content-Type: application/json',
        ];
    }

    public function status(): string
    {
        $url = $this->endpoint . '/status';

        return $this->get($url);
    }

    public function ping(): string
    {
        $url = self::_API_BASE_URL . '/api/v3/ping';
        
        return $this->get($url);
    }

    public function serverTime(): string
    {
        $url = self::_API_BASE_URL . '/api/v3/time';

        return $this->get($url);
    }
}
