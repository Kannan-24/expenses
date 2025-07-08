<?php

namespace App\Http\Controllers;

use App\Models\UserActivity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $activities = UserActivity::with('user')
            ->where('user_id', $request->user()->id)
            ->when($request->type, function ($query, $type) {
                return $query->where('activity_type', $type);
            })
            ->paginate(20);

        return view('profile.activity', compact('activities'));
    }
}
