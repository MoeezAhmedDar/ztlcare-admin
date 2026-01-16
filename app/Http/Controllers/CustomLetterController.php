<?php

namespace App\Http\Controllers;

use App\Models\CustomLetter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CustomLetterController extends Controller
{
    public function index()
    {
        $letters = CustomLetter::latest()->get();
        return view('hr.custom_letters', compact('letters'));
    }

   // app/Http/Controllers/CustomLetterController.php

    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            // 'show_date' => 'sometimes|boolean',
            'date'         => 'nullable|date',
            'greeting_type'=> 'required|in:dear,to_whom',
            'body_content' => 'required|string',
            'font_size'    => 'required|numeric|in:10.00,11.00,12.00',
        ];

        if ($request->greeting_type === 'dear') {
            $rules['dear_name'] = 'required|string|max:255';
        }

        // dd($rules);
        $request->validate($rules);  // ← you commented this out — uncomment it!
        $data = [
            'show_date'    => $request->has('show_date'),
            'date'         => $request->filled('date') ? $request->date : now(),
            'greeting_type' => $request->greeting_type,               // ← ADD THIS LINE!
            'dear_name'    => $request->greeting_type === 'dear' ? $request->dear_name : null,
            'body_content' => $request->body_content,
            'font_size'    => $request->font_size,
            // 'title' => $request->title ?? 'Untitled Letter',      // optional
        ];

        $letter = CustomLetter::create($data);

        return redirect()
            ->route('custom_letters.download', $letter->id)
            ->with('success', 'Letter saved & downloading...');
    }

    public function download($id)
    {
        $letter = CustomLetter::findOrFail($id);

        $data = [
            'letter'       => $letter,
            'logoBase64'   => $this->getBase64Logo(),
            'wavesBase64'  => $this->getBase64Waves(),
        ];

        $pdf = Pdf::loadView('pdf.custom-letter', $data)
                  ->setPaper('a4');

        return $pdf->download('ZTL-CARE-Letter-' . $id . '.pdf');
    }

    private function getBase64Logo()
    {
        $path = public_path('images/ztl-logo.png');
        return file_exists($path)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($path))
            : '';
    }

    private function getBase64Waves()
    {
        $path = public_path('storage/waves.png');
        return file_exists($path)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($path))
            : '';
    }
}