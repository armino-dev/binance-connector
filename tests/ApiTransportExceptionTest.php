<?php

declare(strict_types=1);

namespace Armino\BinanceConnector\Tests;

use Armino\BinanceConnector\Binance\Api\Api;
use Armino\BinanceConnector\HttpClient\Exceptions\HttpClientException;
use PHPUnit\Framework\TestCase;

final class ApiTransportExceptionTest extends TestCase
{
    public function testApiSurfacesHttpClientExceptionOnTransportFailure(): void
    {
        $api = new class extends Api {
            public function __construct()
            {
                $this->endpoint = self::_API_BASE_URL;
                $this->headers = [];
            }

            public function forceTransportFailure(): string
            {
                return $this->get('://invalid-url');
            }
        };

        $this->expectException(HttpClientException::class);

        $api->forceTransportFailure();
    }
}