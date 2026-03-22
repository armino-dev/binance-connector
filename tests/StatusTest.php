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

        $this->status->setRequestHandler(function (string $method, string $url): string {
            $this->assertEquals('GET', $method);

            if (strpos($url, '/sapi/v1/system/status') !== false) {
                return json_encode([
                    'status' => 0,
                    'msg' => 'normal',
                ]);
            }

            if (strpos($url, '/api/v3/ping') !== false) {
                return json_encode([]);
            }

            if (strpos($url, '/api/v3/time') !== false) {
                return json_encode([
                    'serverTime' => 1700000000000,
                ]);
            }

            return json_encode([]);
        });
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

        $this->assertIsArray($result);

        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('msg', $result);

        $this->assertEquals(0, $result['status']);
        $this->assertEquals("normal", $result['msg']);
    }

    public function testCanPing()
    {
        $result = json_decode($this->status->ping(), true);

        $this->assertIsArray($result);

        $this->assertEmpty($result);
    }

    public function testCanGetServerTime()
    {
        $result = json_decode($this->status->serverTime(), true);

        $this->assertIsArray($result);

        $this->assertArrayHasKey('serverTime', $result);
        $this->assertGreaterThan(0, $result['serverTime']);
    }
}
