<?php

declare(strict_types=1);

namespace Armino\BinanceConnector\Tests;

use Armino\BinanceConnector\Binance\Api\Spot\LeverageToken;
use Armino\BinanceConnector\Binance\Api\Spot\Market;
use Armino\BinanceConnector\Binance\Api\Spot\Wallet;
use Armino\BinanceConnector\Binance\Api\System\Status;
use Armino\BinanceConnector\Binance\Connector;
use PHPUnit\Framework\TestCase;

final class ConnectorTest extends TestCase
{
    private $connector;

    protected function setUp(): void
    {
        $this->connector = Connector::init('key', 'secret');        
    }

    public function testConnectorIsCorrectlyInstantiated()
    {
        $this->assertInstanceOf(Connector::class, $this->connector);
    }

    public function testConnectorHasLeverageToken()
    {
        $this->assertInstanceOf(LeverageToken::class, $this->connector->leverageToken);
    }

    public function testConnectorHasMarket()
    {
        $this->assertInstanceOf(Market::class, $this->connector->market);
    }

    public function testConnectorHasWallet()
    {
        $this->assertInstanceOf(Wallet::class, $this->connector->wallet);
    }

    public function testConnectorHasStatus()
    {
        $this->assertInstanceOf(Status::class, $this->connector->status);
    }

    public function testConnectorIsSingleton()
    {
        $anotherConnector = Connector::init('key2', 'secret2');

        $this->assertEquals(
            $this->connector,
            $anotherConnector
        );
    }
}
