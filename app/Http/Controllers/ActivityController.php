<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $activities = auth()->user()
            ->activities()
            ->when($request->type, function ($query, $type) {
                return $query->where('activity_type', $type);
            })
            ->paginate(20);

        return view('profile.activity', compact('activities'));
    }
}