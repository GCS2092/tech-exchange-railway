<?php

namespace App\Http\Controllers;

use App\Helpers\CurrencyHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CurrencyController extends Controller
{
    public function change(Request $request)
    {
        $request->validate([
            'currency' => ['required', 'string', 'in:' . implode(',', CurrencyHelper::getAvailableCurrencies())]
        ]);

        $currency = $request->input('currency');
        Session::put('currency', $currency);

        return response()->json([
            'success' => true,
            'message' => 'Devise mise à jour avec succès',
            'currency' => $currency,
            'symbol' => CurrencyHelper::getSymbol($currency)
        ]);
    }

    public function getRates()
    {
        $rates = [];
        foreach (CurrencyHelper::getAvailableCurrencies() as $currency) {
            $rates[$currency] = CurrencyHelper::getRate($currency);
        }

        return response()->json([
            'success' => true,
            'rates' => $rates,
            'current_currency' => Session::get('currency', 'XOF')
        ]);
    }

    public function convert(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'in:' . implode(',', CurrencyHelper::getAvailableCurrencies())]
        ]);

        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $converted = CurrencyHelper::convert($amount, $currency);
        $formatted = CurrencyHelper::format($amount, $currency);

        return response()->json([
            'success' => true,
            'amount' => $converted,
            'formatted' => $formatted
        ]);
    }
} 