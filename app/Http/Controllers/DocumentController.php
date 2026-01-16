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
            [
                'name' => 'Character Certificate',
                'pdf'  => 'character_certificate.pdf',
                'word' => 'character_certificate.docx',
            ],
            [
                'name' => 'Equal Opportunities Form',
                'pdf'  => 'equal_opportunities_form.pdf',
                'word' => 'equal_opportunities_form.docx',
            ],
            [
                'name' => 'Reference Request Form',
                'pdf'  => 'reference_request_form.pdf',
                'word' => 'reference_request_form.docx',
            ],
            [
                'name' => 'Invite Letter',
                'pdf'  => 'invite_letter.pdf',
                'word' => 'invite_letter.docx',
            ],
            [
                'name' => 'Offer Letter',
                'pdf'  => 'offer_letter.pdf',
                'word' => 'offer_letter.docx',
            ],
            [
                'name' => 'Rejection Letter',
                'pdf'  => 'rejection_letter.pdf',
                'word' => 'rejection_letter.docx',
            ],
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
