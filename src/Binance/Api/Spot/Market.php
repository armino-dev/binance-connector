<?php

declare(strict_types=1);

namespace Armino\BinanceConnector\Binance\Api\Spot;

use Armino\BinanceConnector\Binance\Api\Api;

final class Market extends Api
{
    public function __construct()
    {
        $this->endpoint = self::_API_BASE_URL . '/api/v3';
        $this->headers = [
            'Content-Type: application/json',
        ];
    }

    public function exchangeInformation(?array $symbols = null): string
    {
        $data = [];

        $count = empty($symbols) ? 0 : count($symbols);

        if ($count === 1) {
            $data['symbol'] = $symbols[0];
        }

        if ($count > 1) {
            $temp = array_map(function ($symbol) {
                return '"' . $symbol . '"';
            }, $symbols);
            $data['symbols'] = '[' . implode(',', $temp) . ']';
        }

        $query = empty($data) ? '' : '?' . http_build_query($data);
        
        $url = $this->endpoint . '/exchangeInfo' . $query;

        return $this->get($url);
    }

    public function orderBook(string $symbol = 'BTCUSDT', int $limit = 100): string
    {
        $validLimits = [5, 10, 20, 50, 100, 500, 1000, 5000];
        
        $data = [
            'symbol' => $symbol,
            'limit' => in_array($limit, $validLimits) ? $limit : 100,
        ];

        $url = $this->endpoint . '/depth?' . http_build_query($data);

        return $this->get($url);
    }

    public function recentTradesList(string $symbol = 'BTCUSDT', int $limit = 500): string
    {
        $data = [
            'symbol' => $symbol,
            'limit' => ($limit >= 500 && $limit <= 1000) ? $limit : 500,
        ];

        $url = $this->endpoint . '/trades?' . http_build_query($data);

        return $this->get($url);
    }

    public function oldTradeLookup(string $symbol = 'BTCUSDT', int $limit = 500): string
    {
        //TODO: implement function
        return '';
    }

    public function aggregatedTrades(string $symbol = 'BTCUSDT', int $limit = 500): string
    {
        //TODO: implement function
        return '';
    }

    public function klines(string $symbol = 'BTCUSDT', int $limit = 500, string $interval = '1m'): string
    {
        //TODO: implement function
        return '';
    }

    public function averagePrice(string $symbol = 'BTCUSDT'): string
    {
        //TODO: implement function
        return '';
    }

    public function ticker24Hours(?string $symbol = null): string
    {
        //TODO: implement function
        return '';
    }

    public function tickerPrice(?string $symbol = null): string
    {
        //TODO: implement function
        return '';
    }

    public function tickerOrderBook(?string $symbol = null): string
    {
        //TODO: implement function
        return '';
    }
}
