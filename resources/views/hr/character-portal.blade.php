@extends('layouts.app')

@section('title', 'Create Section')

@section('content')
<div class="container">
    <h1 class="text-center mb-4 text-primary">ZTL CARE Character Reference Portal</h1>

    <!-- FORM -->
    <div class="card mb-5">
        <div class="card-header bg-primary text-white h5">Create Character Reference Letter</div>
        <div class="card-body">
            <form action="{{ route('character.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4"><label>Date</label><input type="date" name="date" class="form-control" value="{{ now()->format('d F Y') }}" required></div>
                    <div class="col-md-4"><label>Dear (Referee)</label><input type="text" name="dear" class="form-control" required></div>
                    <div class="col-md-4"><label>Candidate Name</label><input type="text" name="candidate_name" class="form-control" required></div>
                    <div class="col-md-4"><label>Position</label><input type="text" name="position" class="form-control" required></div>
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
