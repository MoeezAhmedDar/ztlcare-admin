<?php

namespace App\Http\Controllers;

use App\Models\RejectionLetter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Services\PdfFormGenerator;

class RejectionController extends Controller
{
    public function index()
    {
        $rejections = RejectionLetter::latest()->get();
        return view('hr/rejection-portal', compact('rejections'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required',
            'dear' => 'required',
            'position' => 'required',
        ]);

        $rejection = RejectionLetter::create($data);
        return redirect()->route('rejection.download', $rejection->id);
    }

    public function download($id)
    {
        $rejection = RejectionLetter::findOrFail($id);

        $pdf = Pdf::loadView('pdf.rejection-letter', $rejection->toArray())
                  ->setPaper('A4')
                  ->setOptions([
                      'defaultFont'          => 'Calibri',
                      'isHtml5ParserEnabled' => true,
                      'fontDir'              => storage_path('fonts'),
                      'fontCache'            => storage_path('fonts'),
                  ]);

        return $pdf->download('Rejection-'.$rejection->dear.'.pdf');
    }

    public function downloadref()
    {
        $data = [
            'surname' => 'Smith',
            'forename' => 'John',
            'position' => 'Care Assistant',
            // ... add all fields
        ];

        $pdf = Pdf::loadView('pdf.reference-request', $data)
                  ->setPaper('A4')
                  ->setOptions([
                      'defaultFont'          => 'Calibri',
                      'isHtml5ParserEnabled' => true,
                      'isRemoteEnabled'      => true,
                      'fontDir'              => storage_path('fonts'),
                      'fontCache'            => storage_path('fonts'),
                  ]);

        return $pdf->download('Reference-Request-Form.pdf');
    }
}
