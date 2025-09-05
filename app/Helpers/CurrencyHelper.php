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

    /**
     * Formate un montant en francs CFA avec le format français
     */
    public static function formatXOF($amount, $decimals = 0)
    {
        return number_format($amount, $decimals, ',', ' ') . ' FCFA';
    }

    /**
     * Formate un montant avec le symbole de la devise
     */
    public static function format($amount, $currency = 'XOF', $decimals = 0)
    {
        $symbols = [
            'XOF' => 'FCFA',
            'EUR' => '€',
            'USD' => '$',
            'GBP' => '£',
            'JPY' => '¥'
        ];

        $symbol = $symbols[$currency] ?? $currency;
        
        if ($currency === 'XOF') {
            return number_format($amount, $decimals, ',', ' ') . ' ' . $symbol;
        }
        
        return $symbol . number_format($amount, $decimals, '.', ',');
    }

    /**
     * Formate un pourcentage
     */
    public static function formatPercent($value, $decimals = 1)
    {
        return number_format($value, $decimals, ',', ' ') . '%';
    }

    /**
     * Formate une réduction (montant économisé)
     */
    public static function formatDiscount($originalPrice, $discountedPrice)
    {
        $saved = $originalPrice - $discountedPrice;
        return self::formatXOF($saved);
    }

    /**
     * Formate un pourcentage de réduction
     */
    public static function formatDiscountPercent($originalPrice, $discountedPrice)
    {
        if ($originalPrice <= 0) return '0%';
        
        $percent = (($originalPrice - $discountedPrice) / $originalPrice) * 100;
        return self::formatPercent($percent);
    }

    /**
     * Formate un montant pour l'affichage dans les listes
     */
    public static function formatCompact($amount, $currency = 'XOF')
    {
        if ($amount >= 1000000) {
            return self::format($amount / 1000000, $currency, 1) . 'M';
        } elseif ($amount >= 1000) {
            return self::format($amount / 1000, $currency, 1) . 'k';
        }
        
        return self::format($amount, $currency);
    }

    /**
     * Formate un montant pour les tableaux de bord
     */
    public static function formatDashboard($amount, $currency = 'XOF')
    {
        return [
            'formatted' => self::format($amount, $currency),
            'compact' => self::formatCompact($amount, $currency),
            'raw' => $amount,
            'currency' => $currency
        ];
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
