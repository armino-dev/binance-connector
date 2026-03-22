<?php

declare(strict_types=1);

namespace Armino\BinanceConnector\Tests;

use Armino\BinanceConnector\Binance\Api\Spot\Market;
use PHPUnit\Framework\TestCase;

final class MarketTest extends TestCase
{
    private $market;

    protected function setUp(): void
    {
        $this->market = new Market();

        $this->market->setRequestHandler(function (string $method, string $url): string {
            $this->assertEquals('GET', $method);

            if (strpos($url, '/exchangeInfo') !== false) {
                return json_encode([
                    'timezone' => 'UTC',
                    'serverTime' => 1700000000000,
                    'rateLimits' => [],
                    'symbols' => [],
                ]);
            }

            if (strpos($url, '/depth?') !== false) {
                return json_encode([
                    'lastUpdateId' => 123,
                    'bids' => [['100.0', '1.0']],
                ]);
            }

            if (strpos($url, '/trades?') !== false) {
                return json_encode([
                    ['id' => 1, 'price' => '100.0'],
                ]);
            }

            return json_encode([]);
        });
    }

    public function testMarketIsCorrectlyInstantiated()
    {
        $this->assertInstanceOf(Market::class, $this->market);

        $this->assertEquals($this->market->getEndpoint(), 'https://api.binance.com/api/v3');

        $this->assertNull($this->market->getTimestamp());
        $this->assertNull($this->market->getSignature());
    }

    public function testMarketCanGetExchangeInformation()
    {
        $info = json_decode($this->market->exchangeInformation(), true);

        $this->assertIsArray($info);

        $this->assertArrayHasKey("timezone", $info);
        $this->assertArrayHasKey("serverTime", $info);
        $this->assertArrayHasKey("rateLimits", $info);
        $this->assertArrayHasKey("symbols", $info);
    }

    public function testMarketCanGetOrderBook()
    {
        $book = json_decode($this->market->orderBook(), true);

        $this->assertIsArray($book);

        $this->assertArrayHasKey("lastUpdateId", $book);
        $this->assertArrayHasKey("bids", $book);
    }

    public function testMarketCanGetRecentTradesList()
    {
        $trades = json_decode($this->market->recentTradesList(), true);

        $this->assertIsArray($trades);
        $this->assertNotEmpty($trades);
        $this->assertIsArray($trades[0]);
        $this->assertArrayHasKey("id", $trades[0]);
        $this->assertArrayHasKey("price", $trades[0]);
    }
}
