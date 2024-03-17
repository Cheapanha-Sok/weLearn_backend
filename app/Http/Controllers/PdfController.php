<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ExamDate;
use App\Models\Pdf;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{
    public function show(string $examdate, string $category, string $type)
{
    $examDate = ExamDate::where('name', $examdate)->first();
    $category = Category::where('name', $category)->first();

    if (!$examDate || !$category) {
        return response(['message' => 'Exam date or category not found'], 404);
    }

    $pdf = DB::table('pdfs')
        ->join('categories', 'pdfs.category_id', '=', 'categories.id')
        ->join('exam_dates', 'pdfs.exam_date_id', '=', 'exam_dates.id')
        ->select('pdfs.id', 'pdfs.pdfUrl', 'pdfs.type', 'categories.name as categoryName', 'exam_dates.name as examDate')
        ->where('pdfs.exam_date_id', $examDate->id)
        ->where('pdfs.category_id', $category->id)
        ->where('pdfs.type', $type)
        ->first();

    if (!$pdf) {
        return response(['message' => 'PDF not found'], 404);
    }
    return response()->json($pdf);
}

    public function showToDelete(int $id)
    {
        $pdf = DB::table("pdfs")
            ->join("categories", "pdfs.category_id", "=", "categories.id")
            ->join("exam_dates", "pdfs.exam_date_id", "=", "exam_dates.id") // Corrected "pds" to "pdfs"
            ->select("pdfs.id", "pdfs.pdfUrl", "pdfs.type", 'categories.name as categoryName', 'exam_dates.name as examDate')
            ->where("pdfs.id", $id)
            ->first();
        if (!$pdf) {
            return response()->json(['message' => "pdf with id $id not found"], 404);
        }
        return response()->json($pdf);
    }


    public function index()
    {
        $pdfs = DB::table('pdfs')
            ->join('categories', 'pdfs.category_id', '=', 'categories.id')
            ->join('exam_dates', 'pdfs.exam_date_id', '=', 'exam_dates.id')
            ->select('pdfs.id', 'pdfs.pdfUrl', 'pdfs.type', 'categories.name as categoryName', 'exam_dates.name as examDate')
            ->get();

        return response()->json($pdfs);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pdfFile' => ['required', 'file'],
            'type' => ['required', 'lowercase'],
            'exam_date' => 'required',
            'categoryName' => ['required', 'string', 'lowercase']
        ]);

        $category = Category::where('name', $request->input('categoryName'))->first();
        $examDate = ExamDate::where('name', $request->input('exam_date'))->first();

        if ($examDate != null && $category != null) {
            $pdfFileName = cloudinary()->upload($request->file('pdfFile')->getRealPath(), [
                'folder' => "{$request->input('type')}/{$request->input('exam_date')}",
                'public_id' => pathinfo($request->input('categoryName'), PATHINFO_FILENAME),
                'overwrite' => true,
                'resource_type' => 'auto'
            ])->getSecurePath();

            $pdf = new Pdf();
            $pdf->pdfUrl = $pdfFileName;
            $pdf->type = $request->input('type');
            $pdf->exam_date_id = $examDate->id;
            $pdf->category_id = $category->id;
            $pdf->save();
            return response()->json(['message' => 'PDF stored successfully'], 201);
        }
        return response()->json(['error' => 'Invalid category or exam date'], 400);
    }

    public function destroy(int $id)
    {
        $pdfResponse = $this->showToDelete($id);

        if ($pdfResponse->status() === 404) {
            return $pdfResponse; 
        }
        $pdfData = $pdfResponse->original;
        $result = Cloudinary::destroy("$pdfData->type/$pdfData->examDate/$pdfData->categoryName");

        if ($result['result'] === 'ok') {
            $pdf = Pdf::findOrFail($id);
            $pdf->delete();
            return response()->json(['message' => "PDF with id $id has been removed successfully"], 200);
        } else {
            return response()->json(['error' => 'Failed to delete PDF from Cloudinary'], 500);
        }
    }
}
