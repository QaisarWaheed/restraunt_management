<?php
namespace App\Http\Controllers\API\Tenant;

use App\Models\TenantPdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TenantPdfUpload extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:10240',
        ]);

        $file = $request->file('pdf');
        $path = $file->store('pdfs', 'public');

        $pdf = TenantPdf::create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
        ]);

        $pdf->url = asset('storage/' . $pdf->path);

        return response()->json([
            'message' => 'PDF uploaded successfully',
            'pdf' => $pdf,
        ]);
    }

    public function list()
    {
        $pdfs = TenantPdf::latest()->get();
        return response()->json($pdfs);
    }










    public function delete($id)
    {
        $pdf = TenantPdf::findOrFail($id);

        if (\Storage::disk('public')->exists($pdf->path)) {
            \Storage::disk('public')->delete($pdf->path);
        }

        $pdf->delete();

        return response()->json(['message' => 'PDF deleted successfully']);
    }







}
