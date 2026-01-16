@extends('layouts.app')

@section('title', 'Reference Request Portal')

@section('content')
<div class="container">
    <h1 class="text-center mb-4 text-primary">ZTL CARE Reference Request Portal</h1>

    <!-- FORM -->
    <div class="card mb-5">
        <div class="card-header bg-primary text-white h5">Create Reference Request</div>
        <div class="card-body">
            <form action="{{ route('reference.store') }}" method="POST">
                @csrf
                <div class="row g-3">
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
                    <div class="col-md-4"><label>Position</label><input type="text" name="position" class="form-control" required></div>
                    <div class="col-12"><label>Home Address</label><textarea name="home_address" class="form-control" rows="2"></textarea></div>
                    <!-- Add more fields as needed -->
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
                <button type="submit" class="btn btn-primary mt-4 px-5">Save & Download PDF</button>
            </form>
        </div>
    </div>

    <!-- DATATABLE -->
    <div class="card">
        <div class="card-header bg-dark text-white h5">All Reference Requests ({{ $requests->count() }})</div>
        <div class="card-body p-4">
            <table id="requestsTable" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Surname</th>
                        <th>Forename</th>
                        <th>Position</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $i => $req)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $req->surname }}</td>
                        <td>{{ $req->forename }}</td>
                        <td>{{ $req->position }}</td>
                        <td>{{ $req->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('reference.download', $req->id) }}" class="btn btn-success btn-sm">PDF</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#requestsTable').DataTable();
    });
</script>
@endpush
@endsection