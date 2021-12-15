<?php

declare(strict_types=1);

namespace Armino\BinanceConnector\Binance\Api;

/**
 * Classes that are using authentication must implement signature.
 */
interface Signature
{
    /**
     * Generates signature for requests.
     *
     * @param string $query
     * @return string
     */
    public function sign(string $query): string;
}
