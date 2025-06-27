<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = config('app.currencies');
        foreach ($currencies as $code => $currency) {
            Currency::updateOrCreate(
                ['code' => $code],
                [
                    'name' => $currency['name'],
                    'symbol' => $currency['symbol'],
                ]
            );
        }
    }
}
