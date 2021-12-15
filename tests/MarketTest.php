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
        
        $this->assertArrayHasKey("timezone", $info);
        $this->assertArrayHasKey("serverTime", $info);
        $this->assertArrayHasKey("rateLimits", $info);
        $this->assertArrayHasKey("symbols", $info);
    }

    public function testMarketCanGetOrderBook()
    {
        $book = json_decode($this->market->orderBook(), true);
        
        $this->assertArrayHasKey("lastUpdateId", $book);
        $this->assertArrayHasKey("bids", $book);
    }

    public function testMarketCanGetRecentTradesList()
    {
        $trades = json_decode($this->market->recentTradesList(), true);

        $this->assertIsArray($trades);
        $this->assertArrayHasKey("id", $trades[0]);
        $this->assertArrayHasKey("price", $trades[0]);
    }
}