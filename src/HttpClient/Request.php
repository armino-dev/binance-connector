<?php

declare(strict_types=1);

namespace Armino\BinanceConnector\HttpClient;

use Armino\BinanceConnector\HttpClient\Exceptions\RequestException;

class Request
{
    public const _USER_AGENT = 'Binance_Connector_PHP';

    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_DELETE = 'DELETE';

    private string $method = self::METHOD_GET;
    private string $url;
    private array $headers = [];
    private string $payload;

    public function __construct(string $method, string $url, array $headers = [], string $payload = '')
    {
        $this->method = strtoupper($method);
        $this->url = $url;
        $this->headers = $headers;
        $this->payload = $payload;
    }

    public function send(): string
    {
        $curl = curl_init($this->url);

        if ($curl === false) {
            throw new RequestException('Unable to initialize cURL request.');
        }

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_USERAGENT, self::_USER_AGENT);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);

        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2TLS);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);

        if (!empty($this->payload)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->payload);
        }

        $headers = $this->headers;

        if (!empty($this->payload)) {
            $headers[] = 'Content-length: ' . strlen($this->payload);
        }

        if (!empty($headers)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        $response = curl_exec($curl);

        if ($response === false) {
            $errorNumber = curl_errno($curl);
            $errorMessage = curl_error($curl);

            curl_close($curl);

            throw new RequestException(
                sprintf('HTTP request failed with cURL error %d: %s', $errorNumber, $errorMessage),
                $errorNumber
            );
        }

        curl_close($curl);

        return $response;
    }
}