@extends('layouts.app')

@section('title', 'Create Rejection Letter')

@section('content')
<div class="container">
    <h1 class="text-center mb-4 text-primary">ZTL CARE Rejection Portal</h1>

    <!-- CREATE REJECTION FORM -->
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-primary text-white h5">Create Rejection Letter</div>
        <div class="card-body">
            <form action="{{ route('rejection.store') }}" method="POST">
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

                <!-- NEW: Custom Rejection Message (Optional) -->
                <div class="mb-4">
                    <label for="custom_rejection_message" class="form-label">
                        <strong>Custom Rejection Message (Optional)</strong>
                    </label>
                    <p class="text-muted small mb-2">
                        If you fill this in, it will <strong>replace</strong> the standard rejection paragraph.<br>
                        Leave empty to use the default short rejection text.
                    </p>
                    <textarea name="custom_rejection_message" 
                              id="custom_rejection_message" 
                              rows="12" 
                              class="form-control"
                              placeholder="Example for a positive rejection after interview:
Thank you again for taking the time to interview with us for the [Position] role.

We were very impressed with your experience and the enthusiasm you showed during our discussion.

After careful consideration, we have decided to move forward with another candidate whose background more closely matches our current requirements.

We genuinely appreciated meeting you and would like to keep your details on file — please let us know if you'd be open to us contacting you about future suitable vacancies.

We wish you every success in your job search.">{{ old('custom_rejection_message') }}</textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        Save & Download PDF
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- DATATABLE: All Rejection Letters -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white h5">
            All Rejection Letters ({{ $rejections->count() }})
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="rejectionsTable" class="table table-striped table-hover" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Dear</th>
                            <th>Position</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rejections as $i => $rejection)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($rejection->date)->format('d F Y') }}</td>
                            <td>{{ $rejection->dear }}</td>
                            <td>{{ $rejection->position }}</td>
                            <td>{{ $rejection->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('rejection.download', $rejection->id) }}" 
                                   class="btn btn-danger btn-sm" target="_blank">
                                    <i class="fas fa-file-pdf"></i> PDF
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

@endsection