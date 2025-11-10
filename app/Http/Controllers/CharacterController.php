<?php
namespace App\Http\Controllers;
use App\Models\CharacterReference;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function index()
    {
        $references = CharacterReference::latest()->get();
        return view('hr/character-portal', compact('references'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required',
            'dear' => 'required',
            'candidate_name' => 'required',
            'position' => 'required',
        ]);

        $reference = CharacterReference::create($data);
        return redirect()->route('character.download', $reference->id);
    }

    public function download($id)
    {
        $reference = CharacterReference::findOrFail($id);

        $pdf = Pdf::loadView('pdf.character-reference', $reference->toArray())
                  ->setPaper('A4')
                  ->setOptions([
                      'defaultFont'          => 'Calibri',
                      'isHtml5ParserEnabled' => true,
                      'fontDir'              => storage_path('fonts'),
                      'fontCache'            => storage_path('fonts'),
                  ]);

        return $pdf->download('Character-'.$reference->candidate_name.'.pdf');
    }
}