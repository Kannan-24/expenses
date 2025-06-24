<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Currency;
use App\Models\ExpensePerson;
use App\Models\Onboarding;
use App\Models\UserPreference;
use App\Models\Wallet;
use App\Models\WalletType;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    /**
     * Display the onboarding view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $walletTypes = WalletType::all();
        $currencies = Currency::all();

        $timezones = DateTimeZone::listIdentifiers();

        return view('onboarding.index', compact('walletTypes', 'currencies', 'timezones'));
    }

    /**
     * Handle the completion of the onboarding process.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function complete(Request $request)
    {
        $request->validate([
            'wallet_type_id' => 'required|exists:wallet_types,id',
            'wallet_name' => 'required|string|max:255',
            'balance' => 'required|numeric|min:0',
            'currency_id' => 'required|exists:currencies,id',
            'category_name' => 'required|string|max:255',
            'expense_person_name' => 'required|string|max:255',
            'default_currency_id' => 'required|exists:currencies,id',
            'default_timezone' => 'required|in:' . implode(',', DateTimeZone::listIdentifiers()),
            'dark_mode' => 'boolean',
        ]);

        // Create the wallet
        $wallet = Wallet::create([
            'wallet_type_id' => $request->wallet_type_id,
            'name' => $request->wallet_name,
            'balance' => $request->balance,
            'currency_id' => $request->currency_id,
            'user_id' => Auth::id(),
        ]);

        // Create the category
        $category = Category::create([
            'name' => $request->category_name,
            'user_id' => Auth::id(),
        ]);

        // Create the expense person
        $expensePerson = ExpensePerson::create([
            'name' => $request->expense_person_name,
            'user_id' => Auth::id(),
        ]);

        // User Preferences
        $userPreferences = UserPreference::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'default_currency_id' => $request->default_currency_id,
                'default_wallet_id' => $wallet->id,
                'timezone' => $request->default_timezone,
                'dark_mode' => $request->dark_mode ?? false,
            ]
        );

        $onboardingSteps = config('app.onboarding.steps', [
            'wallets',
            'categories',
            'expense-people',
            'user-preferences',
        ]);

        foreach ($onboardingSteps as $step) {
            Onboarding::updateOrCreate(
                ['user_id' => Auth::id(), 'step_key' => $step],
                ['is_completed' => true, 'completed_at' => now()]
            );
        }

        return redirect()->route('dashboard')->with('success', 'Onboarding completed successfully!');
    }
}
