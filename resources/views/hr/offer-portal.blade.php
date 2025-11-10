@extends('layouts.app')

@section('title', 'Create Section')

@section('content')

<div class="container">
    <h1 class="text-center mb-4">ZTL CARE Offer Portal</h1>

    <!-- FORM -->
    <div class="card mb-5">
        <div class="card-header bg-primary text-white h5">Create Offer Letter</div>
        <div class="card-body">
            <form action="{{ route('offer.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4"><label>Date</label><input type="date" name="date" class="form-control" value="{{ now()->format('d F Y') }}" required></div>
                    <div class="col-md-4"><label>Dear</label><input type="text" name="dear" class="form-control" required></div>
                    <div class="col-md-4"><label>Position</label><input type="text" name="position" class="form-control" required></div>
                    <div class="col-md-4"><label>Rate per Hour (£)</label><input type="text" name="rate_per_hour" class="form-control" placeholder="12.50" required></div>
                </div>
                <button type="submit" class="btn btn-success mt-4 px-5">Save & Download PDF</button>
            </form>
        </div>
    </div>

    <!-- DATATABLE -->
    <div class="card">
        <div class="card-header bg-dark text-white h5">All Offer Letters ({{ $offers->count() }})</div>
        <div class="card-body p-4">
            <table id="offersTable" class="table table-striped" style="width:100%">
                <thead>
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
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $offer->date }}</td>
                        <td>{{ $offer->dear }}</td>
                        <td>{{ $offer->position }}</td>
                        <td>£{{ $offer->rate_per_hour }}/hr</td>
                        <td>{{ $offer->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('offer.download', $offer->id) }}" class="btn btn-primary btn-sm">Download PDF</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
