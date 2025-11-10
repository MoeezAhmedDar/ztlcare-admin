@extends('layouts.app')

@section('title', 'Create Section')

@section('content')
<div class="container">
    <h1 class="text-center mb-4 text-primary">ZTL CARE Rejection Portal</h1>

    <!-- FORM -->
    <div class="card mb-5">
        <div class="card-header bg-primary text-white h5">Create Rejection Letter</div>
        <div class="card-body">
            <form action="{{ route('rejection.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4"><label>Date</label><input type="text" name="date" class="form-control" value="{{ now()->format('d F Y') }}" required></div>
                    <div class="col-md-4"><label>Dear</label><input type="text" name="dear" class="form-control" required></div>
                    <div class="col-md-4"><label>Position</label><input type="text" name="position" class="form-control" required></div>
                </div>
                <button type="submit" class="btn btn-primary mt-4 px-5">Save & Download PDF</button>
            </form>
        </div>
    </div>

    <!-- DATATABLE -->
    <div class="card">
        <div class="card-header bg-dark text-white h5">All Rejection Letters ({{ $rejections->count() }})</div>
        <div class="card-body p-4">
            <table id="rejectionsTable" class="table table-striped" style="width:100%">
                <thead>
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
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $rejection->date }}</td>
                        <td>{{ $rejection->dear }}</td>
                        <td>{{ $rejection->position }}</td>
                        <td>{{ $rejection->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('rejection.download', $rejection->id) }}" class="btn btn-danger btn-sm">PDF</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
