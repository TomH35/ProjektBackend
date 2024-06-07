<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Gallery;
use App\Models\Image;
use Illuminate\Support\Facades\Log;

class GalleryController extends Controller
{
    public function readGalleries()
    {
        $galleries = Gallery::with('images')->get();
        return response()->json($galleries);
    }

    public function createGallery(Request $request)
    {
        try {
            Log::info('Store method called', ['request' => $request->all()]);

            $year = $request->input('year');
            $category = $request->input('category');

            Log::info('Received data', ['year' => $year, 'category' => $category]);

            if (!$year || !$category) {
                return Response::json(['error' => 'Year and category are required'], 400);
            }

            if (Gallery::where('category', $category)->exists()) {
                return Response::json(['error' => 'A gallery with this category already exists'], 400);
            }

            DB::beginTransaction();

            $gallery = Gallery::create([
                'year' => $year,
                'category' => $category
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    Log::info('Processing image', ['file' => $file]);
                    $path = Storage::putFile('public/images/gallery', $file);
                    $url = Storage::url($path);

                    Image::create([
                        'gallery_id' => $gallery->id,
                        'file_path' => $url
                    ]);
                }
            }

            DB::commit();

            return Response::json($gallery);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('An error occurred while creating the gallery', ['exception' => $e->getMessage()]);
            return Response::json(['error' => 'An error occurred while creating the gallery'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::find($id);

        if (!$gallery) {
            return response()->json(['error' => 'Gallery not found'], 404);
        }

        DB::beginTransaction();

        try {
            $gallery->year = $request->input('year');
            $gallery->category = $request->input('category');
            $gallery->save();

            // Handle existing images
            if ($request->has('existing_images')) {
                $existingImages = $request->input('existing_images');
                $gallery->images()->whereNotIn('id', $existingImages)->delete();
            } else {
                $gallery->images()->delete();
            }

            // Handle new images
            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $newImage) {
                    $path = $newImage->store('public/images');
                    $url = Storage::url($path);
                    $gallery->images()->create(['file_path' => $url]);
                }
            }

            DB::commit();

            return response()->json($gallery);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while updating the gallery'], 500);
        }
    }





    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->delete();

        return response()->json(['message' => 'Gallery deleted successfully!']);
    }

    public function show($id)
    {
        try {
            $gallery = Gallery::with('images')->findOrFail($id);
            return response()->json($gallery, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gallery not found or server error'], 500);
        }
    }

}
