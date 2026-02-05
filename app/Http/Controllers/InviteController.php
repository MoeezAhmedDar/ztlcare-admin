<?php

namespace App\Http\Controllers;
use App\Models\InviteLetter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Services\PdfFormGenerator;
use App\Models\User;
use Spatie\Permission\Models\Role;

class InviteController extends Controller
{   
    public function index()
    {
        $letters = InviteLetter::latest()->get();

        $applicants = User::whereHas('roles', function ($query) {
            $query->where('name', 'applicant');
        })
        ->orderBy('last_name')    // Primary sort: last name A-Z
        ->orderBy('first_name')   // Secondary sort: first name A-Z
        ->get(); 

        return view('hr.invite-portal', compact('letters', 'applicants'));
    }

    public function previewStatic()
    {
        // Fake/example data – matches your Blade fallbacks
        $letter = new \stdClass();  // or use your model if you prefer, but no save needed

        $letter->id              = 'PREVIEW';
        $letter->date            = now()->format('Y-m-d');
        $letter->to_name         = 'Example Applicant';
        $letter->position        = 'Care Support Worker';
        $letter->time            = '14:00';
        $letter->interview_date  = now()->addDays(10)->format('Y-m-d');
        $letter->font_size       = 10.00;
        $letter->custom_documents = null;  // → will trigger default documents list
        $letter->applicant       = (object) ['full_name' => 'Example Applicant'];

        // Same logo handling as in download()
        $logoPath = public_path('images/logo.png');
        $logoBase64 = file_exists($logoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        // If you also have waves in your real template, add it the same way
        $wavesPath = public_path('images/waves.png'); // adjust filename/path
        $wavesBase64 = file_exists($wavesPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($wavesPath))
            : null;

        $pdf = PDF::loadView('pdf.interview-invitation-example', compact('letter'));

        // Optional: same paper/margin settings as your real letters (if configured globally, skip)
        $pdf->setPaper('A4', 'portrait');
        // $pdf->setOptions(['dpi' => 96, 'defaultFont' => 'Arial']); // if needed

        // Stream inline (preview) instead of forcing download
        return $pdf->download('Interview-Invite-Example.pdf');
    }

   public function store(Request $request)
    {
        $data = $request->validate([
            'date'             => 'required|date',
            'to_user_id'       => 'required|exists:users,id', // must be a valid user ID
            'position'         => 'required|string|max:255',
            'time'             => 'required|date_format:H:i', // better validation for time
            'interview_date'   => 'required|date',
            'custom_documents' => 'nullable|string',
            'font_size'        => 'required|numeric|in:10.00,11.00,12.00',
        ]);

        // Fetch the selected user to get their name (for PDF/display)
        $applicant = User::findOrFail($data['to_user_id']);

        // Create the letter with user ID and computed name
        $letter = InviteLetter::create([
            'date'             => $data['date'],
            'to_user_id'       => $data['to_user_id'],
            'to_name'          => $applicant->full_name, // still store name for PDF/display
            'dear'             => 'Dear ' . $applicant->first_name, // e.g., "Dear John"
            'position'         => $data['position'],
            'time'             => $data['time'],
            'interview_date'   => $data['interview_date'],
            'custom_documents' => $data['custom_documents'],
            'font_size'        => $data['font_size'],
        ]);

        return redirect()->route('invite.download', $letter->id)
            ->with('success', 'Interview invite created & downloading...');
    }

    public function download($id){
        $letter = InviteLetter::findOrFail($id);
        
        $logoPath = public_path('images/logo.png'); 
        $logoBase64 = file_exists($logoPath) 
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) 
            : null;
        $pdf = PDF::loadView('pdf.invite-letter', compact('letter'));
         return $pdf->download('Interview-Invite-' . $letter->to_name . '.pdf');
    }
}
