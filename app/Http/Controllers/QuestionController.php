<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Level;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{

    public function index()
    {
        $questions = Question::with('choices', 'category', 'level')
            ->select('id', 'name', 'category_id', 'level_id')

            ->get();

        return response()->json($questions);
    }
    public function show($categoryId, $levelId)
    {
        $questions = Question::with('choices')
            ->select('id', 'name')
            ->where("questions.category_id", $categoryId)
            ->where('questions.level_id', $levelId)
            ->get();
        return response()->json($questions);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'category_id' => ['required', 'int'],
            'level_id' => ['required', 'int'],
            'choices' => ['required', 'array'],
            'choices.*.name' => ['required', 'string'],
        ]);

        $choice = Category::find($request->input('category_id'));
        $level = Level::find($request->input("level_id"));

        if ($choice && $level) {
            $question = Question::create([
                'name' => $request->input('name'),
                'category_id' => $choice->id,
                'level_id' => $level->id,
            ]);

            $choicesData = $request->input('choices');
            $choiceController = new ChoiceController(); // Instantiate ChoiceController

            foreach ($choicesData as $choiceData) {
                $choiceName = $choiceData['name'];

                $choiceController->store(new Request([
                    'name' => $choiceName,
                    'question_id' => $question->id,
                ]));
            }

            return response()->json(['message' => 'Question created successfully'], 201);
        }

        return response()->json(['message' => "Category or Level not found!"], 404);
    }


    public function edit(Request $request, $id)
    {
        $category = Question::find($id);
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
        $question = Question::find($id);
        if ($question != null) {
            $question->delete();
            return response()->json(['message' => 'category delete successfully'], 204);
        }
        return response()->json(['message' => "categories with id $id not found"], 404);
    }
}
