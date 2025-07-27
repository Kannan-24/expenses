<?php

namespace App\Helpers;

class CurrencyHelper
{
    public static function formatAmount($amount)
    {
        if ($amount >= 1000000000000) {
            return '₹' . round($amount / 1000000000000, 1) . 'T';
        } elseif ($amount >= 1000000000) {
            return '₹' . round($amount / 1000000000, 1) . 'B';
        } elseif ($amount >= 1000000) {
            return '₹' . round($amount / 1000000, 1) . 'M';
        } elseif ($amount >= 1000) {
            return '₹' . round($amount / 1000, 1) . 'K';
        } else {
            return '₹' . number_format($amount, 2);
        }
    }
}                                                                                   

// Usage Examples
// {{ \App\Helpers\CurrencyHelper::formatAmount($wallet->balance) }}
// {{ \App\Helpers\CurrencyHelper::formatAmount($wallets->sum('balance')) }}