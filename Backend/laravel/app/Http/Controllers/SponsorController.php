<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Sponsor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SponsorController extends Controller
{
    public function createSponsor(Request $request)
    {
        $sponsorData = json_decode($request->get('sponsor'), true);

        if (Sponsor::where('name', $sponsorData['name'])->exists()) {
            return Response::json(['error' => 'A sponsor with this name already exists'], 400);
        }

        DB::beginTransaction();

        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = Storage::putFile('public/images/sponsors', $file);
                $url = Storage::url($path);
                $sponsorData['image_path'] = $url;
            }

            $sponsor = Sponsor::create($sponsorData);

            DB::commit();

            return Response::json($sponsor);
        } catch (\Exception $e) {
            DB::rollBack();

            return Response::json(['error' => 'An error occurred while creating the sponsor'], 500);
        }
    }

    public function readSponsor()
    {
        $sponsors = Sponsor::all();
        return response()->json(['sponsors' => $sponsors]);
    }


}
