<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $totalTracked = Transaction::sum('amount');
        
        // Format the number to show in K, M, B, T
        if ($totalTracked >= 1e12) {
            $totalTracked = number_format($totalTracked / 1e12, 1) . 'T';
        } elseif ($totalTracked >= 1e9) {
            $totalTracked = number_format($totalTracked / 1e9, 1) . 'B';
        } elseif ($totalTracked >= 1e6) {
            $totalTracked = number_format($totalTracked / 1e6, 1) . 'M';
        } elseif ($totalTracked >= 1e3) {
            $totalTracked = number_format($totalTracked / 1e3, 1) . 'K';
        }

        return view('welcome', compact('totalTracked'));
    }
}
