<?php

declare(strict_types=1);

namespace Armino\BinanceConnector\Binance\Api;

use Armino\BinanceConnector\HttpClient\Exceptions\HttpClientException;
use Armino\BinanceConnector\HttpClient\Request;
use Closure;
use Throwable;

abstract class Api {
    public const _API_BASE_URL = "https://api.binance.com";
    
    protected string $endpoint;
    protected ?string $timestamp = null;
    protected ?string $apiKey = null;
    protected ?string $apiSecret = null;
    protected ?string $signature = null;

    protected array $headers;
    protected ?Closure $requestHandler = null;

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function getTimestamp(): ?string
    {
        return $this->timestamp;
    }

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public static function makeMillisecondsTimestamp(): float
    {
        return round(microtime(true) * 1000);
    }

    public function setRequestHandler(callable $handler): void
    {
        $this->requestHandler = Closure::fromCallable($handler);
    }

    protected function get(string $url, array $headers = []): string
    {
        return $this->send(Request::METHOD_GET, $url, $headers);
    }

    protected function post(string $url, array $headers = []): string
    {
        return $this->send(Request::METHOD_POST, $url, $headers);
    }

    /**
     * Sends the request.
     *
     * @param Request $request
     * @return string
     */
    protected function send(string $method, string $url, array $headers = [], string $payload = ''): string
    {
        $headers = array_merge($this->headers, $headers ?? []);

        if ($this->requestHandler !== null) {
            $response = ($this->requestHandler)($method, $url, $headers, $payload);

            if (!is_string($response)) {
                throw new HttpClientException('Mocked request handler must return a string response.');
            }

            return $response;
        }

        $request = new Request($method, $url, $headers, $payload);

        try {
            return $request->send();
        } catch (HttpClientException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new HttpClientException('Request cannot be completed', 0, $e);
        }
    }
}
