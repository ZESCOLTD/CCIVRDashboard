<?php

namespace App\Http\Controllers\Live;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AudioController extends Controller
{
    public function embedAudio(Request $request)
    {
        // Construct the file path
        $filePath = storage_path('app/public/' . $request->file . '.' . $request->extension);

        // Debugging: Check the generated file path
        // dd($filePath);

        // Check if the file exists
        if (!file_exists($filePath)) {
            return redirect()->back()->withErrors(["File doesn't exist"]);
        }

        // Return the file if it exists
        return response()->file($filePath);
    }
}
