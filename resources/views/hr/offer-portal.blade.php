@extends('layouts.app')

@section('title', 'Create Offer Letter')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">ZTL CARE Offer Portal</h1>

    <!-- CREATE OFFER FORM -->
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-primary text-white h5">Create Offer Letter</div>
        <div class="card-body">
            <form action="{{ route('offer.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="date" class="form-label"><strong>Date</strong></label>
                        <input type="date" name="date" id="date" class="form-control" 
                               value="{{ old('date', now()->format('Y-m-d')) }}" required>
                    </div>

                     <div class="col-md-4">
                        <label for="to_user_id">Dear (Candidate Name)</label>
                        <br>
                        <select name="to_user_id" id="to_user_id" class="form-select @error('to_user_id') is-invalid @enderror" required>
                            <option value="" disabled {{ old('to_user_id') ? '' : 'selected' }}>Select Applicant</option>
                            @foreach($applicants as $applicant)
                                <option value="{{ $applicant->id }}" {{ old('to_user_id') == $applicant->id ? 'selected' : '' }}>
                                    {{ $applicant->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('to_user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="position" class="form-label"><strong>Position</strong></label>
                        <input type="text" name="position" id="position" class="form-control" 
                               value="{{ old('position') }}" placeholder="Senior Carer" required>
                    </div>

                    <div class="col-md-4">
                        <label for="rate_per_hour" class="form-label"><strong>Rate per Hour (£)</strong></label>
                        <input type="number" step="0.01" name="rate_per_hour" id="rate_per_hour" 
                               class="form-control" value="{{ old('rate_per_hour') }}" 
                               placeholder="12.50" required>
                    </div>
                    <div class="col-md-4">
                        <label for="font_size" class="form-label"><strong>Font Size</strong></label>
                        <br>
                        <select name="font_size" id="font_size" class="form-select" required>
                            <option value="10.00" {{ old('font_size', $letter->font_size ?? 10.00) == 10.00 ? 'selected' : '' }}>10 pt (Standard)</option>
                            <option value="11.00" {{ old('font_size', $letter->font_size ?? 10.00) == 11.00 ? 'selected' : '' }}>11 pt</option>
                            <option value="12.00" {{ old('font_size', $letter->font_size ?? 10.00) == 12.00 ? 'selected' : '' }}>12 pt (Large)</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">

                <!-- NEW: Custom Offer Details (Rich Text) -->
                <div class="mb-4">
                    <label for="custom_offer_details" class="form-label">
                        <strong>Custom Offer Details (Optional)</strong>
                    </label>
                    <p class="text-muted small mb-2">
                        If you fill this in, it will <strong>replace</strong> the standard paragraphs about holidays, conditions, questionnaire, etc.<br>
                        Leave empty to use the default standard text.
                    </p>
                   <textarea name="custom_offer_details" 
          id="custom_offer_details" 
          rows="16" 
          class="form-control"
          placeholder="=== EXAMPLE: Custom Details for a Specific Role ===
This is a permanent full-time position working 39 hours per week on a rotating shift pattern including days, nights and weekends.

You will be based primarily at our Motherwell location, with occasional requirement to cover shifts in nearby branches.

A full uniform and comprehensive induction training will be provided.

Probationary period: 6 months.">{{ old('custom_offer_details') }}</textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success btn-lg px-5">
                        Save & Download PDF
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- DATATABLE: All Offer Letters -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white h5">
            All Offer Letters ({{ $offers->count() }})
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="offersTable" class="table table-striped table-hover" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Dear</th>
                            <th>Position</th>
                            <th>Rate</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($offers as $i => $offer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($offer->date)->format('d F Y') }}</td>
                            <td>{{ $offer->dear }}</td>
                            <td>{{ $offer->position }}</td>
                            <td>£{{ number_format($offer->rate_per_hour, 2) }}/hr</td>
                            <td>{{ $offer->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('offer.download', $offer->id) }}" 
                                   class="btn btn-primary btn-sm" target="_blank">
                                    <i class="fas fa-download"></i> Download PDF
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Initialize DataTables for better UX -->
@section('scripts')
<script>
    $(document).ready(function() {
        $('#offersTable').DataTable({
            order: [[5, 'desc']], // Sort by created_at descending
            pageLength: 25,
            responsive: true
        });
    });
</script>
@endsection
@endsection