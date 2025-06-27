<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HelperController extends Controller
{
    /**
     * Upload image to the server.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        // Private storage path
        $image->storeAs('uploads', $imageName, 'public');

        // Return the image URL
        return response()->json([
            'location' => Storage::url('uploads/' . $imageName),
        ]);
    }
}
