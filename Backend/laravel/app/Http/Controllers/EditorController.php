<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Editor;

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


        $editor = new Editor();
        $editor->content = $content;
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
            return response()->json(['content' => $editor->content, 'name' => $editor->name, 'location' => $editor->location]);
        } else {
            $editors = Editor::all();
            return response()->json(['content' => $editors]);
        }
    }

    public function editorDelete($id)
    {
        $editor = Editor::findOrFail($id);
        $editor->delete();

        return response()->json(['message' => 'Editor content deleted successfully']);
    }
}
