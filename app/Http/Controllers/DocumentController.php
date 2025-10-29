<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
