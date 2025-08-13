<?php

namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait HandlesProfileImage
{
    public function uploadProfileImage(Request $request, $existingPath=null){
        if ($request->hasFile('profile')) {
            // Delete old file if it exists
            if ($existingPath && Storage::disk('public')->exists($existingPath)) {
                Storage::disk('public')->delete($existingPath);
            }
            // Save new image
            return $request->file('profile')->store('profiles', 'public');
        }
        return $existingPath; // if no new file uploaded, retain old one
    }
}
