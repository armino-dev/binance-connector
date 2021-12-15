<?php

declare(strict_types=1);

namespace Armino\BinanceConnector\Binance\Api\Spot;

use Armino\BinanceConnector\Binance\Api\Api;
use Armino\BinanceConnector\Binance\Api\Signable;
use Armino\BinanceConnector\Binance\Api\Signature;

final class Swap extends Api implements Signature
{
    use Signable;

    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->endpoint = self::_API_BASE_URL . '/sapi/v1/blvt';
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->headers = [
            'Content-Type: application/json',
            'X-MBX-APIKEY: ' . $this->apiKey,
        ];
    }

    public function pools(): string
    {
        //TODO: implement function
        return '';
    }

    public function liquidity(?int $poolId = null): string
    {
        //TODO: implement function
        return '';
    }

    public function liquidityOperationRecords(): string
    {
        //TODO: implement function
        return '';
    }

    public function requestQuote(string $quoteAsset, string $baseAsset, float $quantity): string
    {
        //TODO: implement function
        return '';
    }

    public function swapHistory(): string
    {
        //TODO: implement function
        return '';
    }

    public function poolConfigure(?int $poolId = null): string
    {
        //TODO: implement function
        return '';
    }

    public function addLiquidityPreview(int $poolId, string $type, string $quoteAsset, float $quantity): string
    {
        //TODO: implement function
        return '';
    }

    public function removeLiquidityPreview(int $poolId, string $type, string $quoteAsset, float $quantity): string
    {
        //TODO: implement function
        return '';
    }

    public function addLiquidity(int $poolId, string $asset, float $quantity): string
    {
        //TODO: implement function
        return '';
    }

    public function removeLiquidity(int $poolId, string $asset, float $quantity): string
    {
        //TODO: implement function
        return '';
    }

    public function swap(int $quoteAsset, string $baseAsset, float $quantity): string
    {
        //TODO: implement function
        return '';
    }
}
