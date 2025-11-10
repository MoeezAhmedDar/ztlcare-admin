<?php

namespace App\Http\Controllers;
use App\Models\InviteLetter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Services\PdfFormGenerator;

class InviteController extends Controller
{
    // 1. Show portal
    public function index()
    {
        $letters = InviteLetter::latest()->get();
        return view('hr/invite-portal', compact('letters'));
    }

    // 2. Save to DB
    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required',
            'to_name' => 'required',
            'dear' => 'required',
            'position' => 'required',
            'time' => 'required',
            'interview_date' => 'required',
        ]);

        $letter = InviteLetter::create($data);

        return redirect()->route('invite.download', $letter->id)
                         ->with('success', 'Saved! Downloading...');
    }

    // 3. Download PDF
    public function download($id)
    {
        // $letter = InviteLetter::findOrFail($id);

        // // In InviteController.php → download() method
        // $pdf = Pdf::loadView('pdf.invite-letter', $letter->toArray())
        //   ->setPaper('A4')
        //   ->setOptions([
        //       'defaultFont'     => 'calibri',
        //       'isRemoteEnabled' => true,
        //       'fontDir'         => storage_path('fonts'),
        //       'fontCache'       => storage_path('fonts'),
        //   ]);

        // return $pdf->download('Invite-'.$letter->to_name.'.pdf');

        // return view ('pdf/invite-letter',$letter);

    //     $data = [
    //     'date' => '15 November 2025',
    //     'to' => 'Mr John Smith',
    //     'dear' => 'John',
    //     'position' => 'Care Assistant',
    //     'time' => '10:00 AM',
    // ];

    // $generator = new PdfFormGenerator();
    // $pdfContent = $generator->generateInterviewInvite($data);

    // return response($pdfContent)
    //     ->header('Content-Type', 'application/pdf')
    //     ->header('Content-Disposition', 'attachment; filename="Interview-Invite-EDITABLE.pdf"');
    }
}
