<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StreakService
{
    public static function updateUserStreak(User $user, Carbon $transactionDate = null): array
    {
        $transactionDate = $transactionDate ?? Carbon::today();
        $lastTransactionDate = $user->last_transaction_date ? Carbon::parse($user->last_transaction_date) : null;
        
        // If no previous transaction, start new streak
        if (!$lastTransactionDate) {
            return self::startNewStreak($user, $transactionDate);
        }

        // If transaction is on the same day, don't change streak
        if ($lastTransactionDate->isSameDay($transactionDate)) {
            return [
                'streak_days' => $user->streak_days,
                'message' => 'Already logged today',
                'streak_status' => 'maintained'
            ];
        }

        // If transaction is next day, continue streak
        if ($lastTransactionDate->addDay()->isSameDay($transactionDate)) {
            return self::continueStreak($user, $transactionDate);
        }

        // If transaction is after a gap, check if streak is broken
        if ($transactionDate->greaterThan($lastTransactionDate->addDay())) {
            $daysMissed = $lastTransactionDate->diffInDays($transactionDate) - 1;
            
            if ($daysMissed > 0) {
                // Streak is broken, start new one
                return self::startNewStreak($user, $transactionDate, $daysMissed);
            }
        }

        // Default case - start new streak
        return self::startNewStreak($user, $transactionDate);
    }

    private static function startNewStreak(User $user, Carbon $date, int $daysMissed = 0): array
    {
        $user->update([
            'streak_days' => 1,
            'last_transaction_date' => $date->toDateString(),
            'streak_start_date' => $date->toDateString(),
            'longest_streak' => max($user->longest_streak, 1),
        ]);

        return [
            'streak_days' => 1,
            'message' => $daysMissed > 0 ? "Streak reset after missing {$daysMissed} days. New streak started!" : 'New streak started!',
            'streak_status' => 'new',
            'days_missed' => $daysMissed
        ];
    }

    private static function continueStreak(User $user, Carbon $date): array
    {
        $newStreak = $user->streak_days + 1;
        
        $user->update([
            'streak_days' => $newStreak,
            'last_transaction_date' => $date->toDateString(),
            'longest_streak' => max($user->longest_streak, $newStreak),
        ]);

        return [
            'streak_days' => $newStreak,
            'message' => "Great! You're on a {$newStreak}-day streak!",
            'streak_status' => 'continued'
        ];
    }

    public static function getStreakInfo(User $user): array
    {
        $today = Carbon::today();
        $lastTransactionDate = $user->last_transaction_date ? Carbon::parse($user->last_transaction_date) : null;
        
        if (!$lastTransactionDate) {
            return [
                'current_streak' => 0,
                'longest_streak' => $user->longest_streak,
                'days_since_last' => null,
                'streak_status' => 'none',
                'is_streak_alive' => false,
                'missed_days' => 0
            ];
        }

        $daysSinceLastTransaction = $lastTransactionDate->diffInDays($today);
        $isStreakAlive = $daysSinceLastTransaction <= 1;

        // If more than 1 day gap, streak is broken
        if ($daysSinceLastTransaction > 1 && $user->streak_days > 0) {
            $user->update(['streak_days' => 0]);
        }

        $missedDays = $daysSinceLastTransaction > 1 ? $daysSinceLastTransaction - 1 : 0;

        return [
            'current_streak' => $isStreakAlive ? $user->streak_days : 0,
            'longest_streak' => $user->longest_streak,
            'days_since_last' => $daysSinceLastTransaction,
            'streak_status' => $isStreakAlive ? 'alive' : 'broken',
            'is_streak_alive' => $isStreakAlive,
            'last_transaction_date' => $lastTransactionDate->toDateString(),
            'missed_days' => $missedDays
        ];
    }
}