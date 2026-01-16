<?php

namespace App\Http\Controllers;

use App\Models\ReferenceRequest;
use Illuminate\Http\Request;
use PDF;
use App\Models\User;
use Spatie\Permission\Models\Role;
class ReferenceRequestController extends Controller
{
    public function index()
    {
        $requests = ReferenceRequest::latest()->get();

         $applicants = User::whereHas('roles', function ($query) {
            $query->where('name', 'applicant');
        })
        ->orderBy('last_name')    // Primary sort: last name A-Z
        ->orderBy('first_name')   // Secondary sort: first name A-Z
        ->get();  
        return view('hr.reference-form', compact('requests','applicants'));
    }

   public function store(Request $request)
    {
        $validated = $request->validate([
            'to_user_id'      => 'required|exists:users,id',
            'position'        => 'required|string|max:255',
            'home_address'    => 'nullable|string|max:500',
            'font_size'       => 'required|numeric|in:10.00,11.00,12.00',
        ]);

        // Fetch the selected applicant
        $applicant = User::findOrFail($validated['to_user_id']);

        // Use the direct column names (no splitting needed anymore)
        $ref = ReferenceRequest::create([
            'to_user_id'    => $validated['to_user_id'],
            'surname'       => $applicant->last_name,               // direct column
            'forename'      => trim($applicant->first_name . ' ' . ($applicant->middle_name ?? '')), // first + middle
            'position'      => $validated['position'],
            'home_address'  => $validated['home_address'] ?? null,
            'font_size'     => $validated['font_size'],
        ]);

        return redirect()->route('reference.download', $ref->id)
            ->with('success', 'Reference request saved and PDF generated!');
    }

    public function download($id)
    {
        // Eager-load applicant for live name in PDF
        $ref = ReferenceRequest::with('applicant')->findOrFail($id);

        $pdf = PDF::loadView('pdf.reference-request', [
            'ref'        => $ref,          // Pass full model
            'font_size'  => $ref->font_size,
            // Add any other variables your PDF view needs, e.g.:
            // 'logoBase64' => $this->getLogoBase64(),
            // 'wavesBase64' => $this->getWavesBase64(),
        ])
        ->setPaper('A4')
        ->setOptions([
            'defaultFont'          => 'Calibri',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled'      => true,
            'fontDir'              => storage_path('fonts'),
            'fontCache'            => storage_path('fonts'),
        ]);

        return $pdf->download('Reference-Request-' . ($ref->applicant->name ?? 'Unknown') . '.pdf');
    }
}