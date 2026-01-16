<?php
namespace App\Http\Controllers;
use App\Models\CharacterReference;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class CharacterController extends Controller
{
    public function index()
    {
        $references = CharacterReference::latest()->get();

        $applicants = User::whereHas('roles', function ($query) {
            $query->where('name', 'applicant');
        })
        ->orderBy('last_name')    // Primary sort: last name A-Z
        ->orderBy('first_name')   // Secondary sort: first name A-Z
        ->get(); 
        return view('hr/character-portal', compact('references','applicants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date'                     => 'required|date',
            'dear' => 'required',
            'to_user_id'               => 'required|exists:users,id', // Required: select an applicant
            'position'                 => 'required|string|max:255',
            'custom_body'              => 'nullable|string',
            'font_size'                => 'required|numeric|in:10.00,11.00,12.00',
        ]);

        // Fetch the selected applicant
        $applicant = User::findOrFail($validated['to_user_id']);

        // Use full name for candidate_name and dear
        $fullName = $applicant->full_name ?? 'Applicant';

        $reference = CharacterReference::create([
            'date'          => $validated['date'],
            'to_user_id'    => $validated['to_user_id'],
            'candidate_name' => $fullName,
            'dear'          => $validated['dear'], // or "Dear {$fullName}" if preferred
            'position'      => $validated['position'],
            'custom_body'   => trim($validated['custom_body'] ?? ''),
            'font_size'     => $validated['font_size'],
        ]);

        return redirect()->route('character.download', $reference->id)
            ->with('success', 'Character reference created & downloading...');
    }

   public function download($id)
    {
        // Eager-load applicant relationship for live name
        $reference = CharacterReference::with('applicant')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.character-reference', [
            'letter'     => $reference, // pass full model
            'date'       => $reference->date,
            'position'   => $reference->position,
            'font_size'  => $reference->font_size,
        ])
        ->setPaper('A4')
        ->setOptions([
            'defaultFont'          => 'Calibri',
            'isHtml5ParserEnabled' => true,
            'fontDir'              => storage_path('fonts'),
            'fontCache'            => storage_path('fonts'),
        ]);

        return $pdf->download('Character-' . ($reference->candidate_name ?? 'Unknown') . '.pdf');
    }
}