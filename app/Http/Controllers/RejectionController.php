<?php

namespace App\Http\Controllers;

use App\Models\RejectionLetter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Services\PdfFormGenerator;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RejectionController extends Controller
{
    public function index()
    {
        $rejections = RejectionLetter::latest()->get();

        $applicants = User::whereHas('roles', function ($query) {
            $query->where('name', 'applicant');
        })
        ->orderBy('last_name')    // Primary sort: last name A-Z
        ->orderBy('first_name')   // Secondary sort: first name A-Z
        ->get(); 
        return view('hr/rejection-portal', compact('rejections', 'applicants'));
    }

  public function store(Request $request)
    {
        $validated = $request->validate([
            'date'                     => 'required|date',
            'to_user_id'               => 'required|exists:users,id', // Must be a valid applicant
            'position'                 => 'required|string|max:255',
            'custom_rejection_message' => 'nullable|string',
            'font_size'                => 'required|numeric|in:10.00,11.00,12.00',
        ]);

        // Fetch the selected applicant
        $applicant = User::findOrFail($validated['to_user_id']);

        // Use FULL NAME for "Dear" (you can change to first name if preferred)
        $fullName = $applicant->full_name ?? 'Applicant';

        // Create the rejection letter
        $rejection = RejectionLetter::create([
            'date'                     => $validated['date'],
            'to_user_id'               => $validated['to_user_id'],
            'to_name'                  => $applicant->full_name,
            'dear'                     => $fullName, // ← Full name stored here
            'position'                 => $validated['position'],
            'custom_rejection_message' => trim($validated['custom_rejection_message'] ?? ''),
            'font_size'                => $validated['font_size'],
        ]);

        // Redirect to download the PDF
        return redirect()->route('rejection.download', $rejection->id)
            ->with('success', 'Rejection letter created & downloading...');
    }

    public function download($id)
    {
        // Eager-load the applicant relationship
        $rejection = RejectionLetter::with('applicant')->findOrFail($id);

        // Prepare data for the PDF view
        $pdf = Pdf::loadView('pdf.rejection-letter', [
            'letter'     => $rejection, // pass the full model
            'date'       => $rejection->date,
            'position'   => $rejection->position,
            'font_size'  => $rejection->font_size,
        ])
        ->setPaper('A4')
        ->setOptions([
            'defaultFont'          => 'Calibri',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled'      => true,
            'fontDir'              => storage_path('fonts'),
            'fontCache'            => storage_path('fonts'),
        ]);

        return $pdf->download('ZTL-Rejection-Letter-' . $rejection->id . '.pdf');
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
