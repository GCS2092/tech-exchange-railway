<?php
namespace App\Helpers;

class CurrencyHelper
{
    private static $rates = [
        'XOF' => 1,
        'EUR' => 0.0015,
        'USD' => 0.0017,
    ];

    private static $symbols = [
        'XOF' => 'FCFA',
        'EUR' => '€',
        'USD' => '$',
    ];

    private static $formats = [
        'XOF' => ['locale' => 'fr-FR', 'decimals' => 0],
        'EUR' => ['locale' => 'fr-FR', 'decimals' => 2],
        'USD' => ['locale' => 'en-US', 'decimals' => 2],
    ];

    public static function format($amount, $currency = 'XOF')
    {
        $converted = self::convert($amount, $currency);
        $format = self::$formats[$currency] ?? self::$formats['XOF'];
        $symbol = self::$symbols[$currency] ?? '';

        return number_format($converted, $format['decimals'], ',', ' ') . ' ' . $symbol;
    }

    public static function convert($amount, $toCurrency)
    {
        return $amount * (self::$rates[$toCurrency] ?? 1);
    }

    public static function getAvailableCurrencies()
    {
        return array_keys(self::$rates);
    }

    public static function getSymbol($currency)
    {
        return self::$symbols[$currency] ?? '';
    }

    public static function getRate($currency)
    {
        return self::$rates[$currency] ?? 1;
    }

    public static function updateRates($newRates)
    {
        foreach ($newRates as $currency => $rate) {
            if (isset(self::$rates[$currency])) {
                self::$rates[$currency] = $rate;
            }
        }
    }
}
