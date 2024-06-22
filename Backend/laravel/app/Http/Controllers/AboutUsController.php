<?php
namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function index()
    {
        return AboutUs::all();
    }

    public function show($id)
    {
        $aboutUs = AboutUs::find($id);

        if (!$aboutUs) {
            return response()->json(['error' => 'Entry not found'], 404);
        }

        if ($aboutUs && $aboutUs->image_path) {
            $aboutUs->image_path = asset('storage/' . $aboutUs->image_path);
        }

        return response()->json($aboutUs);
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'short_description' => 'required|string',
            'text' => 'required|string',
            'image' => 'required|image',
        ]);

        $path = $request->file('image')->store('images/about_us', 'public');

        $aboutUs = new AboutUs();
        $aboutUs->name = $request->name;
        $aboutUs->short_description = $request->short_description;
        $aboutUs->text = $request->text;
        $aboutUs->image_path = $path;
        $aboutUs->save();

        return response()->json($aboutUs, 201);
    }


    public function update(Request $request, $id)
    {
        $aboutUs = AboutUs::find($id);

        $request->validate([
            'name' => 'required|string',
            'short_description' => 'required|string',
            'text' => 'required|string',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($aboutUs->image_path) {
                Storage::disk('public')->delete($aboutUs->image_path);
            }
            // Store new image
            $path = $request->file('image')->store('images/about_us', 'public');
            $aboutUs->image_path = $path;
        }

        $aboutUs->name = $request->name;
        $aboutUs->short_description = $request->short_description;
        $aboutUs->text = $request->text;
        $aboutUs->save();

        return response()->json($aboutUs, 200);
    }

    public function destroy($id)
    {
        $aboutUs = AboutUs::find($id);
        if ($aboutUs->image_path) {
            Storage::disk('public')->delete($aboutUs->image_path);
        }
        $aboutUs->delete();

        return response()->json(null, 204);
    }
}
