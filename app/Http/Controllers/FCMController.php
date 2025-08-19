<?php

namespace App\Http\Controllers;

use App\Models\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class FCMController extends Controller
{
    public function storeToken(Request $request)
    {
        $user = Auth::user();
        $token = $request->input('token') ?? '';

        if (!$token) {
            return response()->json(['error' => 'Token is required'], 400);
        }

        UserToken::create([
            'user_id' => $user->id,
            'token' => $token,
        ]);

        return response()->json(['message' => 'Token stored successfully.']);
    }

    public function sendNotification(Request $request)
    {
        $SERVER_API_KEY = 'YOUR_FIREBASE_SERVER_KEY'; // from Firebase project settings > Cloud Messaging

        $data = [
            "to" => $request->token, // single device
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
                "icon" => "/icon.png"
            ]
        ];

        $response = Http::withHeaders([
            "Authorization" => "key=$SERVER_API_KEY",
            "Content-Type" => "application/json"
        ])->post("https://fcm.googleapis.com/fcm/send", $data);

        return $response->json();
    }
}
