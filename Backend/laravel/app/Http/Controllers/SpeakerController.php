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
            $speakerData = json_decode($request->get('speaker'), true);
            $adminId = $request->get('admin_id');
            $image = $request->file('image');

            if ($image) {
                $path = $image->store('public/images/speakers');
                $speakerData['image_path'] = str_replace('public/', '', $path);
            }

            $speakerData['admin_id'] = $adminId;

            $speakerData['short_description'] = $speakerData['shortDescription'];
            unset($speakerData['shortDescription']);

            $speakerData['long_description'] = $speakerData['longDescription'];
            unset($speakerData['longDescription']);

            $speakerData['social_links'] = $speakerData['socialLinks'];
            unset($speakerData['socialLinks']);

            $speaker = Speaker::create($speakerData);

            return response()->json(['message' => 'Speaker has been created successfully!', 'speaker' => $speaker], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getAllSpeakers()
    {
        try {
            $speakers = Speaker::all();

            foreach ($speakers as $speaker) {
                $speaker->image_path = './laravel/storage/app/public/' . $speaker->image_path;
            }
    
            return response()->json(['speakers' => $speakers], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteSpeaker($id)
    {
        try {
            $speaker = Speaker::findOrFail($id);

            $speaker->delete();

            return response()->json(['message' => 'Speaker has been deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateSpeaker(Request $request, $id)
{
    try {
        $speaker = Speaker::findOrFail($id);

        $speakerData = $request->all();

        if ($request->hasFile('image')) {

            if ($speaker->image_path) {
                Storage::delete('public/' . $speaker->image_path);
            }

            $path = $request->file('image')->store('public/images/speakers');
            $speakerData['image_path'] = str_replace('public/', '', $path);
        }

        $speakerData['short_description'] = $speakerData['short_description'];
        $speakerData['long_description'] = $speakerData['long_description'];
        $speakerData['social_links'] = $speakerData['social_links'];

        $speaker->update($speakerData);

        return response()->json(['message' => 'Speaker has been updated successfully!', 'speaker' => $speaker], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}



}
