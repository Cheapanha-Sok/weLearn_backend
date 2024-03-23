<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use Illuminate\Http\Request;

class ChoiceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'lowercase'],
            'question_id' => ['required', 'int'],
        ]);

        $choice = new Choice();
        $choice->name = $request->input('name');
        $choice->question_id = $request->input('question_id');
        $choice->save();

        return response()->json(['message' => 'Choice created successfully'], 201);
    }
}
