@extends('layouts.app')

@section('title', 'Create Section')

@section('content')
<div class="container">
    <h1 class="text-center mb-4 text-primary">ZTL CARE Character Reference Portal</h1>
    <div class="text-center mb-4">
        <a href="{{ route('character.preview-static') }}" 
           class="btn btn-lg btn-outline-info">
            Preview character Letter (Example Layout)
        </a>
    </div>
    <!-- FORM -->
    <div class="card mb-5">
        <div class="card-header bg-primary text-white h5">Create Character Reference Letter</div>
        <div class="card-body">
            <form action="{{ route('character.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4"><label>Date</label><input type="date" name="date" class="form-control" value="{{ now()->format('d F Y') }}" required></div>
                    <div class="col-md-4"><label>Dear (Referee)</label><input type="text" name="dear" class="form-control" required></div>
                    <div class="col-md-4">
                        <label for="to_user_id">Candidate Name</label>
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
                    <div class="col-md-4"><label>Position</label><input type="text" name="position" class="form-control" required></div>
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
                <div class="mb-4">
    <label for="custom_body" class="form-label">
        <strong>Custom Body Text (Optional)</strong>
    </label>
    <p class="text-muted small mb-2">
        If filled, this will replace the standard paragraph block after "Re: Reference Request for ...".<br>
        Leave empty to use the default text.
    </p>
    <textarea name="custom_body" id="custom_body" rows="12" class="form-control"
              placeholder="You can write completely custom content here...">{{ old('custom_body', $letter->custom_body ?? '') }}</textarea>
</div>
                <button type="submit" class="btn btn-primary mt-4 px-5">Save & Download PDF</button>
            </form>
        </div>
    </div>

    <!-- DATATABLE -->
    <div class="card">
        <div class="card-header bg-dark text-white h5">All Character References ({{ $references->count() }})</div>
        <div class="card-body p-4">
            <table id="referencesTable" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Dear</th>
                        <th>Candidate</th>
                        <th>Position</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($references as $i => $ref)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $ref->date }}</td>
                        <td>{{ $ref->dear }}</td>
                        <td>{{ $ref->candidate_name }}</td>
                        <td>{{ $ref->position }}</td>
                        <td>{{ $ref->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('character.download', $ref->id) }}" class="btn btn-primary btn-sm">PDF</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
