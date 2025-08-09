@php
    use App\Services\StreakService;
    
    $userName = $user->name ?? 'there';
    $streakInfo = StreakService::getStreakInfo($user);
    $streakDays = $streakInfo['current_streak'];
    $isStreakAlive = $streakInfo['is_streak_alive'];
    $daysSinceLastTransaction = $streakInfo['days_since_last'] ?? 0;
    $missedDays = $streakInfo['missed_days'];
    
    // Monthly goal progress
    $monthlyGoal = $user->monthly_savings_goal ?? 1000;
    $currentSavings = $user->current_month_savings ?? 0;
    $goalProgress = $monthlyGoal > 0 ? min(($currentSavings / $monthlyGoal) * 100, 100) : 0;
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Financial Journey Awaits - Don't Break the Chain!</title>
</head>

<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); margin: 0; padding: 0;">
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" style="padding: 20px;">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); overflow: hidden;">
                    
                    <!-- Header with streak info -->
                    <tr>
                        <td style="background: linear-gradient(90deg, #2b6cb0 0%, #2f855a 100%); padding: 30px; text-align: center;">
                            @if($streakDays > 0)
                                <h1 style="color: #ffffff; margin: 0; font-size: 28px;">{{ $streakDays }}-Day Streak!</h1>
                                <p style="color: #e2e8f0; margin: 10px 0 0 0; font-size: 16px;">You're on fire, {{ $userName }}!</p>
                            @else
                                <h1 style="color: #ffffff; margin: 0; font-size: 28px;">Ready to Start Fresh?</h1>
                                <p style="color: #e2e8f0; margin: 10px 0 0 0; font-size: 16px;">Hi {{ $userName }}, let's build your wealth!</p>
                            @endif
                        </td>
                    </tr>

                    <!-- Progress Section -->
                    @if($goalProgress > 0)
                    <tr>
                        <td style="padding: 30px; background-color: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                            <h3 style="color: #2d3748; margin: 0 0 15px 0; text-align: center;">📈 Monthly Goal Progress</h3>
                            <div style="background-color: #e2e8f0; height: 12px; border-radius: 6px; overflow: hidden; margin-bottom: 10px;">
                                <div style="background: linear-gradient(90deg, #48bb78, #38a169); height: 100%; width: {{ $goalProgress }}%; transition: width 0.3s ease;"></div>
                            </div>
                            <p style="text-align: center; margin: 0; color: #4a5568; font-weight: 600;">
                                ${{ number_format($currentSavings) }} of ${{ number_format($monthlyGoal) }} ({{ round($goalProgress) }}%)
                            </p>
                        </td>
                    </tr>
                    @endif

                    <!-- Main Content -->
                    <tr>
                        <td style="padding: 40px;">
                            @if($missedDays > 1)
                                <!-- Re-engagement message -->
                                <div style="background-color: #fed7d7; border-left: 4px solid #f56565; padding: 20px; margin-bottom: 25px; border-radius: 0 8px 8px 0;">
                                    <h3 style="color: #c53030; margin: 0 0 10px 0;">You've been missed!</h3>
                                    <p style="color: #742a2a; margin: 0; font-size: 14px;">
                                        It's been {{ $missedDays }} days since your last transaction. Don't let your financial goals slip away!
                                    </p>
                                </div>
                            @endif

                            <div style="text-align: center; margin-bottom: 30px;">
                                <h2 style="color: #2d3748; margin: 0 0 15px 0; font-size: 24px;">
                                    @if($streakDays > 0)
                                        Keep Your Momentum Going! 
                                    @else
                                        Your Financial Freedom Starts Today! 
                                    @endif
                                </h2>
                                
                                <p style="color: #4a5568; font-size: 18px; line-height: 1.6; margin: 0;">
                                    @if($streakDays >= 7)
                                        Amazing! You're building an incredible habit. Studies show people who track daily are <strong>3x more likely</strong> to reach their financial goals.
                                    @elseif($streakDays > 0)
                                        You're doing great! Just {{ 7 - $streakDays }} more days to build a life-changing habit.
                                    @else
                                        Just 2 minutes today could change your financial future. Ready to take control?
                                    @endif
                                </p>
                            </div>

                            <!-- Benefits showcase -->
                            <div style="background-color: #edf2f7; padding: 25px; border-radius: 12px; margin-bottom: 30px;">
                                <h3 style="color: #2d3748; margin: 0 0 20px 0; text-align: center;"> Why Successful People Track Daily</h3>
                                <table width="100%" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="33%" style="text-align: center; padding: 10px;">
                                            <p style="margin: 0; color: #4a5568; font-size: 14px; font-weight: 600;">Spend 23% Less</p>
                                        </td>
                                        <td width="33%" style="text-align: center; padding: 10px;">
                                            <p style="margin: 0; color: #4a5568; font-size: 14px; font-weight: 600;">Save 40% More</p>
                                        </td>
                                        <td width="33%" style="text-align: center; padding: 10px;">
                                            <p style="margin: 0; color: #4a5568; font-size: 14px; font-weight: 600;">Reach Goals Faster</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <!-- CTA Section -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px;">
                            <div style="text-align: center;">
                                @if($streakDays > 0)
                                    <a href="{{ $url }}?utm_source=email&utm_medium=daily_reminder&utm_campaign=streak_{{ $streakDays }}"
                                        style="display: inline-block; background: linear-gradient(90deg, #2b6cb0, #2f855a); color: #ffffff; text-decoration: none; padding: 16px 32px; border-radius: 12px; font-size: 18px; font-weight: 600; box-shadow: 0 4px 15px rgba(43, 108, 176, 0.3); transition: transform 0.2s ease;">
                                        Continue {{ $streakDays }}-Day Streak
                                    </a>
                                @else
                                    <a href="{{ $url }}?utm_source=email&utm_medium=daily_reminder&utm_campaign=reactivation"
                                        style="display: inline-block; background: linear-gradient(90deg, #e53e3e, #c53030); color: #ffffff; text-decoration: none; padding: 16px 32px; border-radius: 12px; font-size: 18px; font-weight: 600; box-shadow: 0 4px 15px rgba(229, 62, 62, 0.3); transition: transform 0.2s ease;">
                                        Start Your Journey Now
                                    </a>
                                @endif
                                
                                <p style="margin: 15px 0 0 0; color: #718096; font-size: 14px;">
                                    Takes less than 2 minutes | Works on any device
                                </p>
                            </div>
                        </td>
                    </tr>

                    {{-- <!-- Social Proof -->
                    <tr>
                        <td style="background-color: #f7fafc; padding: 30px; text-align: center;">
                            <p style="color: #4a5568; margin: 0 0 15px 0; font-style: italic; font-size: 16px;">
                                "I saved $2,400 in 3 months just by tracking daily. Best habit I ever built!" 
                            </p>
                            <p style="color: #718096; margin: 0; font-size: 14px;">
                                - Sarah M., {{ config('app.name') }} User
                            </p>
                        </td>
                    </tr> --}}

                    <!-- Quick Actions -->
                    <tr>
                        <td style="padding: 20px 40px;">
                            <h4 style="color: #2d3748; margin: 0 0 15px 0; text-align: center;">Quick Actions</h4>
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr width="100%">
                                    <td width="50%" style="text-align: center; padding: 10px;">
                                        <a href="{{ $url }}?utm_source=email" 
                                            style="display: block; background-color: #4299e1; color: #ffffff; text-decoration: none; padding: 12px; border-radius: 8px; font-size: 14px;">
                                            Log Expense
                                        </a>
                                    </td>
                                    <td width="50%" style="text-align: center; padding: 10px;">
                                        <a href="{{ $url }}?utm_source=email" 
                                            style="display: block; background-color: #48bb78; color: #ffffff; text-decoration: none; padding: 12px; border-radius: 8px; font-size: 14px;">
                                            Log Income
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #2d3748; padding: 30px; text-align: center;">
                            <p style="color: #a0aec0; margin: 0 0 15px 0; font-size: 14px;">
                                Don't want daily reminders? 
                                <a href="{{ url('/account-settings') }}" style="color: #4299e1;">Adjust your settings</a>
                            </p>
                            <p style="color: #718096; margin: 0; font-size: 12px;">
                                &copy; {{ date('Y') }} {{ config('app.name') }}. Helping you build wealth, one day at a time.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>