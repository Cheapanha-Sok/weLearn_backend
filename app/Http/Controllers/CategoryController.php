<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all());
    }
    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => "categories with id $id not found"], 404);
        }
        return response()->json($category);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'lowercase'],
        ]);
        $category = new Category();
        $category->name = $request->input('name');
        $category->save();
        return response()->json(['message' => 'category created successfully'], 201);
    }
    public function edit(Request $request, $id)
    {
        $category = Category::find($id);
        if ($category != null) {
            if ($request->input('name') != "") {
                $category->name = $request->input("name");
                $category->save();
                return response()->json(['message' => 'category updated successfully'], 200);
            }
        }
        return response()->json(['message' => "categories with id $id not found"], 404);

    }
    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category != null) {
            $category->delete();
            return response()->json(['message' => 'category delete successfully'], 204);
        }
        return response()->json(['message' => "categories with id $id not found"], 404);
    }
}
