<?php
namespace App\Http\Controllers;
use App\Models\OfferLetter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class OfferController extends Controller
{
    public function index()
    {
        $offers = OfferLetter::latest()->get();

        $applicants = User::whereHas('roles', function ($query) {
            $query->where('name', 'applicant');
        })
        ->orderBy('last_name')    // Primary sort: last name A-Z
        ->orderBy('first_name')   // Secondary sort: first name A-Z
        ->get(); 

        return view('hr/offer-portal', compact('offers', 'applicants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date'                  => 'required|date',
            'to_user_id'            => 'required|exists:users,id', // Must be a valid applicant
            'position'              => 'required|string|max:255',
            'rate_per_hour'         => 'required|numeric|min:0',
            'custom_offer_details'  => 'nullable|string',
            'font_size'             => 'required|numeric|in:10.00,11.00,12.00',
        ]);

        // Fetch the selected applicant
        $applicant = User::findOrFail($validated['to_user_id']);

        // Create the offer letter
        $offer = OfferLetter::create([
            'date'                  => $validated['date'],
            'to_user_id'            => $validated['to_user_id'],
            'to_name'               => $applicant->full_name, // Store full name for PDF/display
            'dear'                  => 'Dear ' . $applicant->first_name,
            'position'              => $validated['position'],
            'rate_per_hour'         => $validated['rate_per_hour'],
            'custom_offer_details'  => trim($validated['custom_offer_details'] ?? ''),
            'font_size'             => $validated['font_size'],
        ]);

        // Redirect to download the PDF
        return redirect()->route('offer.download', $offer->id)
            ->with('success', 'Offer letter created & downloading...');
    }

    // In your controller (e.g., OfferController.php)
    public function download($id)
    {
        $offer = OfferLetter::with('applicant') // ← Load the relationship
            ->findOrFail($id);

        // Your PDF generation code (e.g., using dompdf or similar)
        $pdf = PDF::loadView('pdf.offer-letter', [
            'letter' => $offer,
            'date' => $offer->date,
            'position' => $offer->position,
            'rate_per_hour' => $offer->rate_per_hour,
            'custom_offer_details' => $offer->custom_offer_details,
            'font_size' => $offer->font_size,
            // Add any other variables like $logoBase64, $wavesBase64
        ]);

        return $pdf->download('offer-letter-' . $offer->id . '.pdf');
    }
}