<?php

declare(strict_types=1);

namespace Armino\BinanceConnector\HttpClient;

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

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_USERAGENT, self::_USER_AGENT);

        //curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);

        if (!empty($this->payload)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->payload);
        }

        $this->headers[] = 'Content-length: ' . strlen($this->payload);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
}