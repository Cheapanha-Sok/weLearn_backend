<?php

namespace App\Http\Controllers;

use App\Models\ExamDate;
use Illuminate\Http\Request;

class ExamDateController extends Controller
{
    public function index()
    {
        return response()->json(ExamDate::all());
    }
    public function store(Request $request): void
    {
        $request->validate([
            "name" => ["required", "string"],
        ]);
        $examDate = new ExamDate();
        $examDate->name = $request->input('name');
        $examDate->save();
    }
    public function show(int $id)
    {
        $examDate = ExamDate::find($id);
        if ($examDate != null) {
            return response()->json($examDate);
        }
        return response()->json(['message' => "exam_date with id $id not found"], 404);
    }
    public function destroy(int $id)
    {
        $examDate = ExamDate::find($id);
        if ($examDate != null) {
            $examDate->delete();
            return response()->json(['message' => 'remove exam_date successfully'], 204);
        }
        return response()->json(['message' => "exam_date with id $id not found"], 404);
    }
    public function edit(int $id, Request $request)
    {
        $examDate = ExamDate::find($id);
        if ($examDate != null) {
            if ($request->input('name') != null) {
                $examDate->exam_date = $request->input('name');
                $examDate->save();
                return response()->json(['message' => 'exam_date updated successfully'], 200);
            }
        }
        return response()->json(['message' => "exam_date with id $id not found"], 404);
    }
}
