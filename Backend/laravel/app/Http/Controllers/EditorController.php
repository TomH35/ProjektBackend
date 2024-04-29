<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Editor;

class EditorController extends Controller
{

    public function store(Request $request)
    {
        $content = $request->input('content');
        $files = $request->allFiles();
        foreach ($files as $file) {

            $path = $file->storeAs('public/images/editor', $file->getClientOriginalName());

        }

$editor = new Editor();
        $editor->content = $content;

        $editor->save();


        return response()->json(['message' => 'Content and images saved successfully']);
    }

    public function show($id = null)
{
    if ($id) {
        $editor = Editor::findOrFail($id);
        return response()->json(['content' => $editor->content]);
    } else {
        $editors = Editor::all();
        return response()->json(['content' => $editors]);
    }
}
}
