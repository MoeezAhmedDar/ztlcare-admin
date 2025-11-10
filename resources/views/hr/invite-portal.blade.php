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
                <div class="row g-3">
                    <div class="col-md-4"><label>Date</label><input type="date" name="date" class="form-control" value="04 November 2025" required></div>
                    <div class="col-md-4"><label>To (Full Name)</label><input type="text" name="to_name" class="form-control" required></div>
                    <div class="col-md-4"><label>Dear</label><input type="text" name="dear" class="form-control" required></div>
                    <div class="col-md-4"><label>Position</label><input type="text" name="position" class="form-control" required></div>
                    <div class="col-md-4"><label>Time</label><input type="time" name="time" class="form-control" value="2:30 PM" required></div>
                    <div class="col-md-4"><label>Interview Date</label><input type="date" name="interview_date" class="form-control" required></div>
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
                        @foreach($letters as $letter)
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
