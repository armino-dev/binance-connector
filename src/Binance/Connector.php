<?php

declare(strict_types=1);

namespace Armino\BinanceConnector\Binance;

use Armino\BinanceConnector\Binance\Api\Spot\LeverageToken;
use Armino\BinanceConnector\Binance\Api\Spot\Market;
use Armino\BinanceConnector\Binance\Api\Spot\Wallet;
use Armino\BinanceConnector\Binance\Api\System\Status;

final class Connector
{
    /**
     * Array used for storing the api's.
     * For api requiring key and secret use className => ['apiKey', 'apiSecret'].
     * For other api's use className => null.
     *
     * @var array
     */
    private static $apiConnectors = [
        LeverageToken::class => ['apiKey', 'apiSecret'],
        Wallet::class => null,
        Market::class => null,
        Status::class => null,
    ];

    private static $instance = null;
    private static $apiKey;
    private static $apiSecret;
    
    private function __construct()
    {
        // Disabled constructor
    }

    public static function init(string $apiKey, string $apiSecret): self
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }

        self::$apiKey = $apiKey;
        self::$apiSecret = $apiSecret;
        self::$instance = new self;

        foreach (self::$apiConnectors as $connector => $initializers) {
            $variable = lcfirst(basename(str_replace('\\', '/', $connector)));
            
            if (is_array($initializers)) {
                $variables = array_map(function ($initializer) {
                    return self::$$initializer; 
                }, $initializers);
                
                self::$instance->$variable = new $connector(...$variables);
            } else {
                self::$instance->$variable = new $connector();
            }
        }

        return self::$instance;
    }

    public static function getInstance(): self
    {
        return self::$instance;
    }
}
