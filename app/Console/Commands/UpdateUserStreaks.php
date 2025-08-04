<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\StreakService;
use Carbon\Carbon;

class UpdateUserStreaks extends Command
{
    protected $signature = 'streaks:update';
    protected $description = 'Update user streaks daily';

    public function handle()
    {
        $users = User::whereNotNull('last_transaction_date')->get();
        
        foreach ($users as $user) {
            $streakInfo = StreakService::getStreakInfo($user);
            
            if (!$streakInfo['is_streak_alive'] && $user->streak_days > 0) {
                $user->update(['streak_days' => 0]);
                $this->info("Reset streak for user {$user->id}");
            }
        }
        
        $this->info('Streak update completed');
    }
}