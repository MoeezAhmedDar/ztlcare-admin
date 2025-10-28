@extends('layouts.app')

@section('title', 'Interview - ' . $interview->candidate_name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-gray-800">Interview: {{ $interview->candidate_name }}</h1>
    <div>
        <a href="{{ route('interviews.export-pdf', $interview) }}" class="btn btn-success">
            <i class="fas fa-file-pdf mr-1"></i> Export PDF
        </a>
        <a href="{{ route('interviews.edit', $interview) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('interviews.index') }}" class="btn btn-outline-secondary">Back to List</a>
    </div>
</div>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h2 class="h6 mb-0"><i class="fas fa-link mr-2"></i> Candidate Questionnaire Link</h2>
    </div>
    <div class="card-body">
        @if($interview->is_questionnaire_complete)
            <div class="alert alert-success mb-3">
                <i class="fas fa-check-circle mr-2"></i> Questionnaire completed on {{ $interview->questionnaire_submitted_at->format('d M Y, H:i') }}
            </div>
        @else
            <div class="alert alert-warning mb-3">
                <i class="fas fa-clock mr-2"></i> Waiting for candidate to complete questionnaire
            </div>
        @endif
        
        <div class="input-group">
            <input type="text" class="form-control" id="publicLink" value="{{ $interview->public_url }}" readonly>
            <div class="input-group-append">
                <button class="btn btn-primary" type="button" onclick="copyLink()">
                    <i class="fas fa-copy mr-1"></i> Copy Link
                </button>
                <a href="{{ $interview->public_url }}" target="_blank" class="btn btn-outline-primary">
                    <i class="fas fa-external-link-alt mr-1"></i> Open
                </a>
            </div>
        </div>
        <small class="text-muted">Share this link with the candidate to complete the interview questionnaire.</small>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Interview Details</h2>
        <div>
            <span class="badge badge-info text-uppercase mr-2">{{ $statusOptions[$interview->status] ?? ucfirst($interview->status) }}</span>
            <span class="badge badge-{{ $interview->outcome === 'offer' ? 'success' : ($interview->outcome === 'reject' ? 'danger' : 'secondary') }} text-uppercase">{{ $outcomeOptions[$interview->outcome] ?? ucfirst($interview->outcome) }}</span>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-2"><strong>Candidate Name:</strong> {{ $interview->candidate_name }}</p>
                <p class="mb-2"><strong>Recruiter:</strong> {{ $interview->recruiter_name ?? '—' }}</p>
                <p class="mb-2"><strong>Location/Branch:</strong> {{ $interview->location ?? '—' }}</p>
            </div>
            <div class="col-md-6">
                <p class="mb-2"><strong>Interview Date:</strong> {{ optional($interview->interview_date)->format('d M Y') ?? '—' }}</p>
                <p class="mb-2"><strong>Position Offered:</strong> {{ $interview->position_offered ?? '—' }}</p>
                <p class="mb-2"><strong>Total Score:</strong> {{ $interview->total_score ?? '—' }}</p>
            </div>
        </div>
        @if($interview->notes)
            <div class="mb-3">
                <strong>Notes to interviewer:</strong>
                <p class="text-muted mb-0">{{ $interview->notes }}</p>
            </div>
        @endif
        @if($interview->overall_feedback)
            <div class="mb-3">
                <strong>Overall Assessment / Feedback:</strong>
                <p class="text-muted mb-0">{{ $interview->overall_feedback }}</p>
            </div>
        @endif
        @if($interview->recruitment_authorization)
            <div class="mb-3">
                <strong>Recruitment Authorization:</strong>
                <p class="text-muted mb-0">{{ $interview->recruitment_authorization }}</p>
            </div>
        @endif
        @if($interview->interviewer_signature_name || $interview->interviewer_signed_at)
            <div class="mb-3">
                <strong>Signed By:</strong> {{ $interview->interviewer_signature_name ?? '—' }}
                @if($interview->interviewer_signed_at)
                    <span class="text-muted">on {{ $interview->interviewer_signed_at->format('d M Y H:i') }}</span>
                @endif
            </div>
        @endif
    </div>
</div>

@if($interview->statusHistories->isNotEmpty())
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h2 class="h6 mb-0">Status History</h2>
    </div>
    <div class="card-body">
        <div class="list-group list-group-flush">
            @foreach($interview->statusHistories as $history)
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

<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h2 class="h5 mb-0">Interview Responses</h2>
    </div>
    <div class="card-body">
        @foreach($sections as $section)
            <div class="mb-4">
                <h3 class="h6 text-primary border-bottom pb-2">{{ $section->name }}</h3>
                @foreach($section->questions as $question)
                    @php
                        $response = $responses->get($question->id);
                    @endphp
                    <div class="mb-3 pl-3">
                        <p class="font-weight-bold mb-1">{{ $question->prompt }}</p>
                        @if($response && $response->answer)
                            <p class="text-muted mb-0">{{ $response->answer }}</p>
                        @else
                            <p class="text-muted mb-0 font-italic">No answer provided</p>
                        @endif
                        @if($question->has_score)
                            <p class="mb-0 mt-1">
                                <span class="badge badge-{{ $response && $response->score !== null ? 'primary' : 'secondary' }}">
                                    Score: {{ $response && $response->score !== null ? $response->score : 'N/A' }}
                                </span>
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>

<div class="d-flex justify-content-between">
    <form action="{{ route('interviews.destroy', $interview) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this interview?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Interview</button>
    </form>
    <a href="{{ route('interviews.index') }}" class="btn btn-outline-secondary">Back to List</a>
</div>
@endsection

@push('scripts')
<script>
function copyLink() {
    const linkInput = document.getElementById('publicLink');
    linkInput.select();
    linkInput.setSelectionRange(0, 99999); // For mobile devices
    
    navigator.clipboard.writeText(linkInput.value).then(function() {
        // Show success message
        const btn = event.target.closest('button');
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check mr-1"></i> Copied!';
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-success');
        
        setTimeout(function() {
            btn.innerHTML = originalHTML;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-primary');
        }, 2000);
    });
}
</script>
@endpush
