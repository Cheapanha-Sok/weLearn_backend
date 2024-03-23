<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index()
    {
        return response()->json(Level::all());
    }
    public function show($id)
    {
        $level = Level::find($id);
        if (!$level) {
            return response()->json(['message' => "level with id $id not found"], 404);
        }
        return response()->json($level);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'lowercase'],
        ]);
        $level = new Level();
        $level->name = $request->input('name');
        $level->save();
        return response()->json(['message' => 'level created successfully'], 201);
    }
    public function edit(Request $request, $id)
    {
        $level = Level::find($id);
        if ($level != null) {
            if ($request->input('name') != "") {
                $level->name = $request->input("name");
                $level->save();
                return response()->json(['message' => 'category updated successfully'], 200);
            }
        }
        return response()->json(['message' => "categories with id $id not found"], 404);

    }
    public function destroy($id)
    {
        $level = Level::find($id);
        if ($level != null) {
            $level->delete();
            return response()->json(['message' => 'category delete successfully'], 204);
        }
        return response()->json(['message' => "categories with id $id not found"], 404);
    }
}
