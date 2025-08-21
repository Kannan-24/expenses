<?php
namespace App\Http\Controllers;

use App\Models\TrustedDevice;
use App\Services\TotpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TwoFactorController extends Controller
{
    public function settings()
    {
        $user = Auth::user();
        $pendingSecret = session('2fa_pending_secret');
        $qrUrl = $pendingSecret ? TotpService::getOtpAuthUrl($pendingSecret, $user->email, config('app.name')) : null;
        $trustedDeviceCookie = request()->cookie('trusted_device_'.$user->id);
        $isCurrentTrusted = false;
        if($trustedDeviceCookie){
            $isCurrentTrusted = $user->trustedDevices()->where('device_key',$trustedDeviceCookie)->exists();
        }
        return view('security.two-factor', compact('user','pendingSecret','qrUrl','isCurrentTrusted'));
    }

    public function startEnable(Request $request)
    {
        $request->validate(['password'=>'required']);
        $user = Auth::user();
        if(!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password'=>'Password incorrect']);
        }
        $secret = TotpService::generateSecret();
        session(['2fa_pending_secret'=>$secret]);
        return redirect()->route('security.2fa');
    }

    public function confirmEnable(Request $request)
    {
        $request->validate(['otp'=>'required|digits:6']);
        $user = Auth::user();
        $secret = session('2fa_pending_secret');
        if(!$secret) return back()->withErrors(['otp'=>'No pending secret']);
        if(!\App\Services\TotpService::verify($secret, $request->otp)) {
            return back()->withErrors(['otp'=>'Invalid code']);
        }
        $user->two_factor_secret = $secret;
        $user->two_factor_enabled = true;
        $user->save();
        session()->forget('2fa_pending_secret');
        return redirect()->route('security.2fa')->with('success','Two-factor authentication enabled');
    }

    public function disable(Request $request)
    {
        $request->validate(['password'=>'required','otp'=>'required|digits:6']);
        $user = Auth::user();
        if(!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password'=>'Password incorrect']);
        }
        if(!$user->two_factor_enabled || !TotpService::verify($user->two_factor_secret, $request->otp)) {
            return back()->withErrors(['otp'=>'Invalid code']);
        }
        $user->forceFill(['two_factor_secret'=>null,'two_factor_enabled'=>false])->save();
        return redirect()->route('security.2fa')->with('success','Two-factor disabled');
    }

    public function challengeForm()
    {
        if(!session()->has('2fa:user:id')) return redirect()->route('login');
        return view('auth.two-factor-challenge');
    }

    public function challenge(Request $request)
    {
        $request->validate(['otp'=>'required|digits:6','remember_device'=>'nullable|boolean']);
        $userId = session('2fa:user:id');
        $remember = $request->boolean('remember_device');
        $user = \App\Models\User::findOrFail($userId);
        if(!TotpService::verify($user->two_factor_secret, $request->otp)) {
            return back()->withErrors(['otp'=>'Invalid code']);
        }
        session()->forget('2fa:user:id');
        Auth::login($user); // finalize
        if($remember) {
            $deviceKey = Str::random(40);
            $tmp = new TrustedDevice([ 'user_agent' => $request->userAgent() ]);
            $display = $tmp->display_name;
            TrustedDevice::create([
                'user_id'=>$user->id,
                'device_key'=>$deviceKey,
                'device_name'=> substr($display,0,120),
                'ip'=>$request->ip(),
                'user_agent'=>$request->userAgent(),
                'last_used_at'=>now(),
            ]);
            cookie()->queue(cookie('trusted_device_'.$user->id, $deviceKey, 60*24*60)); // 60 days
        }
        // update login meta
        $user->update(['last_login_at'=>now(),'last_login_ip'=>$request->ip(),'last_login_user_agent'=>$request->userAgent()]);
        // TODO: dispatch notification email
        return redirect()->intended(route('dashboard', absolute:false));
    }

    public function removeDevice(TrustedDevice $device)
    {
    // Only allow owner to remove their trusted device
    abort_unless($device->user_id === Auth::id(), 403);
        $device->delete();
        return back()->with('success','Device removed');
    }

    public function trustCurrent(Request $request)
    {
        $user = Auth::user();
        if(!$user->two_factor_enabled) {
            return back()->withErrors(['otp'=>'Enable 2FA first.']);
        }
        $request->validate(['otp'=>'required|digits:6']);
        if(!TotpService::verify($user->two_factor_secret, $request->otp)) {
            return back()->withErrors(['otp'=>'Invalid code']);
        }
        // Avoid duplicating if already trusted
        $trustedDeviceCookie = $request->cookie('trusted_device_'.$user->id);
        if($trustedDeviceCookie && $user->trustedDevices()->where('device_key',$trustedDeviceCookie)->exists()){
            return back()->with('success','This device is already trusted');
        }
        $deviceKey = Str::random(40);
        $tmp = new TrustedDevice([ 'user_agent' => $request->userAgent() ]);
        $display = $tmp->display_name;
        TrustedDevice::create([
            'user_id'=>$user->id,
            'device_key'=>$deviceKey,
            'device_name'=> substr($display,0,120),
            'ip'=>$request->ip(),
            'user_agent'=>$request->userAgent(),
            'last_used_at'=>now(),
        ]);
        cookie()->queue(cookie('trusted_device_'.$user->id, $deviceKey, 60*24*60));
        return back()->with('success','Current device has been trusted and will skip future OTP prompts.');
    }

    public function showDevice(TrustedDevice $device)
    {
        // If someone navigates directly via GET to the device resource, just redirect back to 2FA settings
        if($device->user_id !== Auth::id()) abort(403);
        return redirect()->route('security.2fa');
    }
}
