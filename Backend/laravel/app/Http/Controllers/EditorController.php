<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Editor;
use Illuminate\Support\Facades\Storage;

class EditorController extends Controller
{
    public function store(Request $request)
    {
        $content = $request->input('content');
        $name = $request->input('name');
        $files = $request->allFiles();
        $location = $request->input('location'); // 'navbar', 'footer', 'both'


        foreach ($files as $file) {
            $path = $file->storeAs('public/images/editor', $file->getClientOriginalName());
        }


        $filename = uniqid() . '.txt';
        $filePath = 'public/websites/' . $filename;


        Storage::put($filePath, $content);


        $editor = new Editor();
        $editor->content = $filePath;
        $editor->name = $name;

        if ($location) {
            $editor->location = $location;
        }

        $editor->save();

        return response()->json(['message' => 'Content, name, and images saved successfully']);
    }

    public function show($id = null)
    {
        if ($id) {
            $editor = Editor::findOrFail($id);
            $content = Storage::get($editor->content);
            return response()->json([
                'id' => $editor->id,
                'content' => $content,
                'name' => $editor->name,
                'location' => $editor->location
            ]);
        } else {
            $editors = Editor::all();
            $allContent = $editors->map(function ($editor) {
                $content = Storage::get($editor->content);
                return [
                    'id' => $editor->id,
                    'content' => $content,
                    'name' => $editor->name,
                    'location' => $editor->location,
                ];
            });
            return response()->json(['content' => $allContent]);
        }
    }


    public function editorDelete($id)
    {
        $editor = Editor::findOrFail($id);


        if (Storage::exists($editor->content)) {
            Storage::delete($editor->content);
        }


        $editor->delete();

        return response()->json(['message' => 'Editor content deleted successfully']);
    }
}
