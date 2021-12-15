<?php

declare(strict_types=1);

namespace Armino\BinanceConnector\Binance\Api\Spot;

use Armino\BinanceConnector\Binance\Api\Api;
use Armino\BinanceConnector\Binance\Api\Signable;
use Armino\BinanceConnector\Binance\Api\Signature;

final class LeverageToken extends Api implements Signature
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

    public function leverageTokenInfo(?string $tokenName = null): string
    {
        $url = $this->endpoint . '/tokenInfo';

        $data = [];

        if (!empty($tokenName)) {
            $data['tokenName'] = $tokenName;
            $url .= '?' . http_build_query($data);
        }
        
        return $this->get($url);
    }

    public function userLimitInfo(?string $tokenName = null): string
    {
        $data = [
            'timestamp' => self::makeMillisecondsTimestamp(),
        ];

        if (!empty($tokenName)) {
            $data['tokenName'] = $tokenName;
        }

        $data['signature'] = $this->sign(http_build_query($data));

        $url = $this->endpoint . "/userLimit?" . http_build_query($data);

        return $this->get($url);
    }

    public function querySubscriptionRecord(): string
    {
        $data = [
            'timestamp' => self::makeMillisecondsTimestamp(),
        ];

        if (!empty($tokenName)) {
            $data['tokenName'] = $tokenName;
        }

        $data['signature'] = $this->sign(http_build_query($data));

        $url = $this->endpoint . "/subscribe/record?" . http_build_query($data);
        
        return $this->get($url);
    }

    public function queryRedemptionRecord(): string
    {
        $data = [
            'timestamp' => self::makeMillisecondsTimestamp(),
        ];

        if (!empty($tokenName)) {
            $data['tokenName'] = $tokenName;
        }

        $data['signature'] = $this->sign(http_build_query($data));

        $url = $this->endpoint . "/redeem/record?" . http_build_query($data);

        return $this->get($url);
    }

    public function subscribeLeverageToken(string $tokenName, float $cost): string
    {
        $data = [
            'timestamp' => self::makeMillisecondsTimestamp(),
            'tokenName' => $tokenName,
            'cost' => $cost,
        ];

        $data['signature'] = $this->sign(http_build_query($data));

        $url = $this->endpoint . "/subscribe?" . http_build_query($data);

        return $this->post($url);
    }

    public function redeemLeverageToken(string $tokenName, float $amount): string
    {
        $data = [
            'timestamp' => self::makeMillisecondsTimestamp(),
            'tokenName' => $tokenName,
            'amount' => $amount,
        ];

        $data['signature'] = $this->sign(http_build_query($data));

        $url = $this->endpoint . "/redeem?" . http_build_query($data);

        return $this->post($url);
    }
}
