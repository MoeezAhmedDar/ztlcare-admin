<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use setasign\Fpdi\Fpdi;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = [
            ['name' => 'Character Certificate', 'file' => 'character_certificate.pdf'],
            ['name' => 'Equal Opportunities Form', 'file' => 'equal_opportunities_form.pdf'],
            ['name' => 'Invite Letter', 'file' => 'invite_letter.pdf'],
            ['name' => 'Offer Letter', 'file' => 'offer_letter.pdf'],
            ['name' => 'Rejection Letter', 'file' => 'rejection_letter.pdf'],
        ];

        return view('documents.index', compact('documents'));
    }

    public function generate(Request $request)
    {
        $data = [
        'date' => '04/11/2025',
        'to' => 'Sarah Johnson',
        'dear' => 'Ms. Johnson',
        'position' => 'Senior Carer',
        'time' => '2:30 PM',
        'interview_date' => '12/11/2025',
        ];

        $pdf = Pdf::loadView('pdf.invite-letter', $data)
              ->setPaper('A4')
              ->setOptions(['isRemoteEnabled' => true, 'defaultFont' => 'DejaVu Sans']);

        return $pdf->stream('invite.pdf');

    }
}
