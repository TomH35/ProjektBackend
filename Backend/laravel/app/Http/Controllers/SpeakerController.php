<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class SpeakerController extends Controller
{
    public function createSpeaker(Request $request)
    {
        try {
            // Get the request data
            $speakerData = json_decode($request->get('speaker'), true);
            $adminId = $request->get('admin_id');
            $image = $request->file('image');
    
            // Validate the request data here...
    
            // Store the image file and get its path
            if ($image) {
                $path = $image->store('public/images/speakers');
                $speakerData['image_path'] = str_replace('public/', '', $path);
            }
    
            // Add the admin_id to the speaker data
            $speakerData['admin_id'] = $adminId;
    
            // Map the Vue.js property names to the database column names
            $speakerData['short_description'] = $speakerData['shortDescription'];
            unset($speakerData['shortDescription']);
    
            $speakerData['long_description'] = $speakerData['longDescription'];
            unset($speakerData['longDescription']);
    
            $speakerData['social_links'] = $speakerData['socialLinks'];
            unset($speakerData['socialLinks']);
    
            // Create the speaker
            $speaker = Speaker::create($speakerData);
    
            return response()->json(['message' => 'Speaker has been created successfully!', 'speaker' => $speaker], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    

}