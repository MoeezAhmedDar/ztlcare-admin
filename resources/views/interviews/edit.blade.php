@extends('layouts.app')

@section('title', 'Edit Interview - ' . $interview->candidate_name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-gray-800">Edit Interview: {{ $interview->candidate_name }}</h1>
    <a href="{{ route('interviews.show', $interview) }}" class="btn btn-outline-secondary">View</a>
</div>

@if($statusHistory->isNotEmpty())
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h2 class="h6 mb-0">Status History</h2>
    </div>
    <div class="card-body">
        <div class="list-group list-group-flush">
            @foreach($statusHistory as $history)
                <div class="list-group-item px-0">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="badge badge-info">{{ ucfirst($history->status) }}</span>
                            @if($history->comment)
                                <p class="mb-0 mt-2 text-muted small">{{ $history->comment }}</p>
                            @endif
                        </div>
                        <small class="text-muted">{{ $history->created_at->format('d M Y H:i') }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<form action="{{ route('interviews.update', $interview) }}" method="POST">
    @csrf
    @method('PUT')
    @include('interviews.partials.form')
</form>
@endsection
