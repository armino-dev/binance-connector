<?php

declare(strict_types=1);

namespace Armino\BinanceConnector\Tests\Integration;

use Armino\BinanceConnector\Binance\Api\Spot\Market;
use Armino\BinanceConnector\Binance\Api\System\Status;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[Group('integration')]
final class BinanceSmokeTest extends TestCase
{
    private function decodeOrSkip(string $response, string $endpoint): array
    {
        $decoded = json_decode($response, true);

        if (!is_array($decoded)) {
            $this->markTestSkipped(sprintf('Binance endpoint unavailable (%s): non-JSON response', $endpoint));
        }

        if (isset($decoded['code'])) {
            $message = $decoded['msg'] ?? 'unknown error';
            $this->markTestSkipped(sprintf('Binance endpoint unavailable (%s): [%s] %s', $endpoint, (string) $decoded['code'], $message));
        }

        return $decoded;
    }

    public function testMarketExchangeInformationSmoke(): void
    {
        $market = new Market();
        $payload = $this->decodeOrSkip($market->exchangeInformation(), 'exchangeInfo');

        $this->assertArrayHasKey('timezone', $payload);
        $this->assertArrayHasKey('serverTime', $payload);
    }

    public function testStatusServerTimeSmoke(): void
    {
        $status = new Status();
        $payload = $this->decodeOrSkip($status->serverTime(), 'time');

        $this->assertArrayHasKey('serverTime', $payload);
        $this->assertGreaterThan(0, $payload['serverTime']);
    }
}