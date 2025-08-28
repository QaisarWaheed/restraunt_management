<?php
// app/Http/Controllers/PdfController.php
namespace App\Http\Controllers;

use App\Models\Pdf;
use Illuminate\Http\Request;

class TenantPdfUpload extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:10240', // max 10MB
        ]);

        $file = $request->file('pdf');

        // Create a unique file name
        $filename = time() . '_' . $file->getClientOriginalName();

        // Store in public/pdf folder
        $file->move(public_path('pdfs'), $filename);

        // Save in DB
        $pdf = Pdf::create([
            'name' => $file->getClientOriginalName(),
            'path' => 'pdfs/' . $filename, // relative path from public
        ]);

        return response()->json([
            'message' => 'PDF uploaded successfully',
            'pdf' => $pdf
        ]);
    }

    public function list()
    {
        $pdfs = Pdf::latest()->get();
        return response()->json($pdfs);
    }
}
