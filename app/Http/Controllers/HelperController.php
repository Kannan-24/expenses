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
        Storage::disk('local')->putFileAs('uploads', $image, $imageName);

        // Return the image URL
        return response()->json([
            'url' => Storage::url('uploads/' . $imageName),
        ]);
    }
}
