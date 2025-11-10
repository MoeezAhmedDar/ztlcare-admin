<?php
namespace App\Http\Controllers;
use App\Models\OfferLetter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index()
    {
        $offers = OfferLetter::latest()->get();
        return view('hr/offer-portal', compact('offers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required',
            'dear' => 'required',
            'position' => 'required',
            'rate_per_hour' => 'required|numeric',
        ]);

        $offer = OfferLetter::create($data);
        return redirect()->route('offer.download', $offer->id);
    }

    public function download($id)
    {
        $offer = OfferLetter::findOrFail($id);

        $pdf = Pdf::loadView('pdf.offer-letter', $offer->toArray())
                  ->setPaper('A4')
                  ->setOptions([
                      'defaultFont' => 'Calibri',
                      'isRemoteEnabled' => true,
                      'fontDir' => storage_path('fonts'),
                      'fontCache' => storage_path('fonts'),
                  ]);

        return $pdf->download('Offer-'.$offer->dear.'.pdf');

        return view ('pdf/offer-letter',$offer);
    }
}