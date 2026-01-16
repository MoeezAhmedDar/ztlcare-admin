@extends('layouts.app')

@section('title', 'Create Section')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">ZTL CARE Invite Portal</h1>
    
    <!-- FORM -->
    <div class="card mb-5">
        <div class="card-header bg-primary text-white"><strong>Create New Invite</strong></div>
        <div class="card-body">
            <form action="{{ route('invite.store') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-md-4">
                        <label>Date</label>
                        <input type="date" name="date" class="form-control" value="{{ old('date', '2025-11-04') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label for="to_user_id">To (Full Name)</label>
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
                        <label>Position</label>
                        <input type="text" name="position" class="form-control" value="{{ old('position') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label>Time</label>
                        <input type="time" name="time" class="form-control" value="{{ old('time', '14:30') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label>Interview Date</label>
                        <input type="date" name="interview_date" class="form-control" value="{{ old('interview_date') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label for="font_size" class="form-label"><strong>Font Size</strong></label>
                        <select name="font_size" id="font_size" class="form-select" required>
                            <option value="10.00" {{ old('font_size', 10.00) == 10.00 ? 'selected' : '' }}>10 pt (Standard)</option>
                            <option value="11.00" {{ old('font_size', 11.00) == 11.00 ? 'selected' : '' }}>11 pt</option>
                            <option value="12.00" {{ old('font_size', 12.00) == 12.00 ? 'selected' : '' }}>12 pt (Large)</option>
                        </select>
                    </div>

                    <div class="col-12 mt-3">
                        <label><strong>Custom Required Documents (optional)</strong></label>
                        <small class="text-muted d-block">Leave blank to use default list. One item per line.</small>
                        <textarea name="custom_documents" class="form-control" rows="6" placeholder="Evidence of your National Insurance Number&#10;Right to work documentation&#10;Either a passport, driving licence or other form of photographic identification">{{ old('custom_documents') }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mt-3">Save & Generate PDF</button>
            </form>
        </div>
    </div>

    <!-- TABLE OF ALL LETTERS -->
    <div class="card">
        <div class="card-header bg-dark text-white">Saved Letters ({{ $letters->count() }})</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>To</th>
                            <th>Position</th>
                            <th>Interview</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($letters as $letter)
                        <tr>
                            <td>{{ $letter->date }}</td>
                            <td>{{ $letter->to_name }}</td>
                            <td>{{ $letter->position }}</td>
                            <td>{{ $letter->time }} on {{ $letter->interview_date }}</td>
                            <td>
                                <a href="{{ route('invite.download', $letter->id) }}" 
                                   class="btn btn-primary btn-sm">Download PDF</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-4">No invites created yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection