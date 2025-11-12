<?php

namespace App\Http\Controllers;

use App\Models\ReferenceRequest;
use Illuminate\Http\Request;
use PDF;

class ReferenceRequestController extends Controller
{
    public function index()
    {
        $requests = ReferenceRequest::latest()->get();
        return view('hr.reference-form', compact('requests'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'surname' => 'required',
            'forename' => 'required',
            'position' => 'required',
            'home_address' => 'nullable',
            // ... add all fields
        ]);

        $ref = ReferenceRequest::create($data);

        return redirect()->route('reference.download', $ref->id)
            ->with('success', 'Reference request saved and PDF generated!');
    }

    public function download($id)
    {
        $ref = ReferenceRequest::findOrFail($id);

        $pdf = PDF::loadView('pdf.reference-request', compact('ref'));
        return $pdf->download('Reference-Request-' . $ref->surname . '.pdf');
    }
}