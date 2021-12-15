<?php

declare(strict_types=1);

namespace Armino\BinanceConnector\Tests;

use Armino\BinanceConnector\Binance\Api\System\Status;
use PHPUnit\Framework\TestCase;

final class StatusTest extends TestCase
{
    private $status;

    protected function setUp(): void
    {
        $this->status = new Status();
    }

    public function testStatusIsCorrectlyInstantiated()
    {
        $this->assertInstanceOf(Status::class, $this->status);

        $this->assertEquals($this->status->getEndpoint(), 'https://api.binance.com/sapi/v1/system');
        
        $this->assertNull($this->status->getTimestamp());
        $this->assertNull($this->status->getSignature());
    }

    public function testCanGetStatus()
    {
        $result = json_decode($this->status->status(), true);
        
        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('msg', $result);
        
        $this->assertEquals(0, $result['status']);
        $this->assertEquals("normal", $result['msg']);
    }

    public function testCanPing()
    {
        $result = json_decode($this->status->ping(), true);
        
        $this->assertEmpty($result);
    }

    public function testCanGetServerTime()
    {
        $result = json_decode($this->status->serverTime(), true);

        $this->assertArrayHasKey('serverTime', $result);
        $this->assertGreaterThan(0, $result['serverTime']);
    }
}
