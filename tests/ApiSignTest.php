<?php

declare(strict_types=1);

namespace Armino\BinanceConnector\Tests;

use Armino\BinanceConnector\Binance\Api\Spot\LeverageToken;
use PHPUnit\Framework\TestCase;

final class ApiSignTest extends TestCase
{
    private LeverageToken $leverageToken;

    protected function setUp(): void
    {
        $this->leverageToken = new LeverageToken('some_key', 'some_secret');
    }

    public function testApiCanSign()
    {
        $this->assertNull($this->leverageToken->getSignature());

        $signature = $this->leverageToken->sign("param=test");

        $this->assertNotEmpty($signature);
        $this->assertEquals(64, strlen($signature));
    }
}
